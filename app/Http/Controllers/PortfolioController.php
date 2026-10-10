<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    /* ------------------------------------------------------------------
     |  Pages
     * -----------------------------------------------------------------*/

    public function home(): View
    {
        try {
            $portfolioCount = Portfolio::count();
        } catch (\Throwable $e) {
            $portfolioCount = 0; // never let the home page fail because the database is unreachable
        }

        return view('home', compact('portfolioCount'));
    }

    /** Manage Portfolio page: view / edit / delete */
    public function index(): View
    {
        return view('portfolios.index', [
            'portfolios' => Portfolio::latest()->get(),
        ]);
    }

    /** Portfolio Information page (create) */
    public function create(): View
    {
        return view('portfolios.form', [
            'portfolio' => new Portfolio(),
            'rows'      => $this->formRows(null),
        ]);
    }

    /** Portfolio Information page (edit) */
    public function edit(Portfolio $portfolio): View
    {
        $portfolio->load('certificates');

        return view('portfolios.form', [
            'portfolio' => $portfolio,
            'rows'      => $this->formRows($portfolio),
        ]);
    }

    /** Template Selection page */
    public function templates(Portfolio $portfolio): View
    {
        $portfolio->load(['educations', 'skills', 'projects', 'experiences', 'socialLinks']);

        return view('portfolios.templates', compact('portfolio'));
    }

    /** Portfolio Preview page (toolbar + the generated portfolio in a frame) */
    public function preview(Request $request, Portfolio $portfolio): View
    {
        $template = $this->resolveTemplate($request->query('template'), $portfolio);

        return view('portfolios.preview', compact('portfolio', 'template'));
    }

    /** The generated portfolio itself (standalone, shareable page) */
    public function show(Request $request, Portfolio $portfolio): View
    {
        $portfolio->load(['educations', 'skills', 'projects', 'experiences', 'socialLinks', 'certificates']);
        $template = $this->resolveTemplate($request->query('template'), $portfolio);

        return view('templates.' . $template, compact('portfolio'));
    }

    /**
     * Download the portfolio as a PDF (template = saved one, or ?template= from the preview page).
     * Uses dompdf when it is installed; otherwise opens the portfolio with the browser's own
     * "Save as PDF" print dialog so the button always produces a PDF.
     */
    public function pdf(Request $request, Portfolio $portfolio)
    {
        $template = $this->resolveTemplate($request->query('template'), $portfolio);

        if (! class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return redirect()->route('portfolios.show', [$portfolio, 'template' => $template, 'print' => 1]);
        }

        try {
            @set_time_limit(120);
            @ini_set('memory_limit', '512M');

            // dompdf keeps its font cache here; make sure the folder exists and is writable
            $fontDir = storage_path('fonts');
            if (! is_dir($fontDir)) {
                @mkdir($fontDir, 0775, true);
            }

            $portfolio->load(['educations', 'skills', 'projects', 'experiences', 'socialLinks', 'certificates']);

            // Certificates: smaller JPEGs (dompdf cannot read WebP), three per row
            $certImages = $portfolio->certificates
                ->map(fn ($c) => $this->pdfCertificate($c->image))
                ->filter()
                ->values()
                ->all();

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.portfolio', [
                'portfolio' => $portfolio,
                'certRows'  => array_chunk($certImages, 3),
                'template'  => $template,
                'photo'     => $this->pdfPhoto($portfolio->profile_picture),
            ])->setPaper('a4');

            return $pdf->download(Str::slug($portfolio->full_name ?: 'portfolio') . '-portfolio.pdf');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'The PDF could not be created'
                . (config('app.debug') ? ': ' . $e->getMessage() : '. Details were saved in storage/logs/laravel.log.'));
        }
    }

    /* ------------------------------------------------------------------
     |  Create / Update / Delete
     * -----------------------------------------------------------------*/

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateRequest($request);
        $this->guardCertificateCount($request, null);

        $portfolio = DB::transaction(function () use ($request, $data) {
            $portfolio = Portfolio::create($this->mainFields($data) + [
                'slug'            => Str::lower(Str::random(10)),
                'template'        => 'simple',
                'profile_picture' => $this->pictureFromRequest($request),
            ]);
            $this->syncChildren($portfolio, $data);
            $this->saveCertificates($portfolio, $request);

            return $portfolio;
        });

        return redirect()->route('portfolios.templates', $portfolio)
            ->with('success', 'Portfolio information saved to the online database. Now choose a template.');
    }

    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $data = $this->validateRequest($request);
        $this->guardCertificateCount($request, $portfolio);

        DB::transaction(function () use ($request, $data, $portfolio) {
            $fields = $this->mainFields($data);

            if ($request->hasFile('profile_picture')) {
                $fields['profile_picture'] = $this->pictureFromRequest($request);
            } elseif ($request->boolean('remove_picture')) {
                $fields['profile_picture'] = null;
            }

            $portfolio->update($fields);
            $this->syncChildren($portfolio, $data);
            $this->saveCertificates($portfolio, $request);
        });

        return redirect()->route('portfolios.preview', $portfolio)
            ->with('success', 'Portfolio updated successfully.');
    }

    public function selectTemplate(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $request->validate([
            'template' => ['required', Rule::in(array_keys(Portfolio::TEMPLATES))],
        ]);

        $portfolio->update(['template' => $request->input('template')]);

        return redirect()->route('portfolios.preview', $portfolio)
            ->with('success', 'Template "' . Portfolio::TEMPLATES[$portfolio->template]['name'] . '" selected. Your portfolio is generated! You can download it as a PDF from the toolbar.');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $name = $portfolio->full_name;
        $portfolio->delete(); // child rows are removed by ON DELETE CASCADE

        return redirect()->route('portfolios.index')
            ->with('success', "Portfolio of {$name} was deleted.");
    }

    /* ------------------------------------------------------------------
     |  Helpers
     * -----------------------------------------------------------------*/

    /** dompdf cannot read WebP, so the stored photo becomes a small square JPEG for the PDF. */
    private function pdfPhoto(?string $dataUri): ?string
    {
        if (! $dataUri || ! preg_match('#^data:(image/[a-z+]+);base64,(.+)$#s', $dataUri, $m)) {
            return null;
        }

        if (! function_exists('imagecreatefromstring')) {
            return in_array($m[1], ['image/jpeg', 'image/png'], true) ? $dataUri : null;
        }

        $img = @imagecreatefromstring(base64_decode($m[2]));
        if (! $img) {
            return null;
        }

        $w = imagesx($img);
        $h = imagesy($img);
        $side = min($w, $h);
        $crop = imagecreatetruecolor(320, 320);
        imagefill($crop, 0, 0, imagecolorallocate($crop, 255, 255, 255)); // flatten transparency on white
        imagecopyresampled($crop, $img, 0, 0, intdiv($w - $side, 2), intdiv($h - $side, 2), 320, 320, $side, $side);

        ob_start();
        imagejpeg($crop, null, 88);
        $jpeg = ob_get_clean();
        imagedestroy($img);
        imagedestroy($crop);

        return $jpeg ? 'data:image/jpeg;base64,' . base64_encode($jpeg) : null;
    }

    private function resolveTemplate(?string $requested, Portfolio $portfolio): string
    {
        if ($requested && array_key_exists($requested, Portfolio::TEMPLATES)) {
            return $requested;
        }

        return array_key_exists($portfolio->template, Portfolio::TEMPLATES) ? $portfolio->template : 'simple';
    }

    private function validateRequest(Request $request): array
    {
        // Drop completely empty repeater rows and add https:// to links typed without it.
        $this->cleanRows($request, 'education', ['school', 'degree', 'start_year', 'end_year', 'description']);
        $this->cleanRows($request, 'skills', ['name', 'level'], [], ['level']);
        $this->cleanRows($request, 'projects', ['title', 'description', 'tech', 'url'], ['url']);
        $this->cleanRows($request, 'experience', ['company', 'position', 'start_date', 'end_date', 'description']);
        $this->cleanRows($request, 'links', ['platform', 'url'], ['url'], ['platform']);

        $rules = [
            'full_name'       => ['required', 'string', 'max:150'],
            'job_title'       => ['nullable', 'string', 'max:150'],
            'email'           => ['required', 'email', 'max:150'],
            'phone'           => ['required', 'string', 'max:40'],
            'address'         => ['required', 'string', 'max:255'],
            'about'           => ['required', 'string', 'max:3000'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            'education'               => ['nullable', 'array', 'max:10'],
            'education.*.school'      => ['required', 'string', 'max:200'],
            'education.*.degree'      => ['required', 'string', 'max:200'],
            'education.*.start_year'  => ['nullable', 'string', 'max:10'],
            'education.*.end_year'    => ['nullable', 'string', 'max:10'],
            'education.*.description' => ['nullable', 'string', 'max:1000'],

            'skills'         => ['nullable', 'array', 'max:30'],
            'skills.*.name'  => ['required', 'string', 'max:100'],
            'skills.*.level' => ['required', Rule::in(array_keys(Portfolio::SKILL_LEVELS))],

            'projects'               => ['nullable', 'array', 'max:12'],
            'projects.*.title'       => ['required', 'string', 'max:200'],
            'projects.*.description' => ['nullable', 'string', 'max:1500'],
            'projects.*.tech'        => ['nullable', 'string', 'max:200'],
            'projects.*.url'         => ['nullable', 'url:http,https', 'max:255'],

            'experience'               => ['nullable', 'array', 'max:10'],
            'experience.*.company'     => ['required', 'string', 'max:200'],
            'experience.*.position'    => ['required', 'string', 'max:200'],
            'experience.*.start_date'  => ['nullable', 'string', 'max:30'],
            'experience.*.end_date'    => ['nullable', 'string', 'max:30'],
            'experience.*.description' => ['nullable', 'string', 'max:1500'],

            'certificates'     => ['nullable', 'array', 'max:10'],
            'certificates.*'   => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'keep_certificates'   => ['nullable', 'array'],
            'keep_certificates.*' => ['integer'],

            'links'            => ['nullable', 'array', 'max:10'],
            'links.*.platform' => ['required', 'string', 'max:50'],
            'links.*.url'      => ['required', 'url:http,https', 'max:255'],
        ];

        $attributes = [
            'education.*.school' => 'school', 'education.*.degree' => 'degree / course',
            'skills.*.name' => 'skill name', 'skills.*.level' => 'skill level',
            'projects.*.title' => 'project title', 'projects.*.url' => 'project link',
            'experience.*.company' => 'company', 'experience.*.position' => 'position',
            'links.*.platform' => 'link platform', 'links.*.url' => 'link URL',
            'about' => 'About Me', 'profile_picture' => 'profile picture', 'certificates.*' => 'certificate photo',
        ];

        return $request->validate($rules, [], $attributes);
    }

    /**
     * @param array $fields  columns to keep for each row
     * @param array $urlFields  columns that get "https://" prepended when no scheme is typed
     * @param array $ignore  columns with defaults that must not count when deciding a row is empty
     */
    private function cleanRows(Request $request, string $key, array $fields, array $urlFields = [], array $ignore = []): void
    {
        $rows = [];

        foreach ((array) $request->input($key, []) as $row) {
            if (! is_array($row)) {
                continue;
            }

            $clean = [];
            $hasContent = false;

            foreach ($fields as $field) {
                $value = trim((string) ($row[$field] ?? ''));

                if ($value !== '' && in_array($field, $urlFields, true) && ! preg_match('#^https?://#i', $value)) {
                    $value = 'https://' . $value;
                }
                if ($value !== '' && ! in_array($field, $ignore, true)) {
                    $hasContent = true;
                }
                $clean[$field] = $value;
            }

            if ($hasContent) {
                $rows[] = $clean;
            }
        }

        $request->merge([$key => $rows]);
    }

    private function mainFields(array $data): array
    {
        return [
            'full_name' => $data['full_name'],
            'job_title' => $data['job_title'] ?? null,
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'address'   => $data['address'],
            'about'     => $data['about'],
        ];
    }

    private function syncChildren(Portfolio $portfolio, array $data): void
    {
        $map = [
            'educations'  => 'education',
            'skills'      => 'skills',
            'projects'    => 'projects',
            'experiences' => 'experience',
            'socialLinks' => 'links',
        ];

        foreach ($map as $relation => $key) {
            $portfolio->{$relation}()->delete();

            foreach (array_values($data[$key] ?? []) as $i => $row) {
                $portfolio->{$relation}()->create($row + ['sort_order' => $i]);
            }
        }
    }

    private function pictureFromRequest(Request $request): ?string
    {
        $file = $request->file('profile_picture');

        return $file ? $this->imageDataUri($file, 900) : null;
    }

    /**
     * Photos are stored inside the database (data URI) so they persist on any cloud host.
     * Uploads up to 5 MB are accepted; when the GD extension is available the image is scaled down to
     * at most $max px and re-encoded, which keeps the database and the pages fast.
     */
    private function imageDataUri(UploadedFile $file, int $max): string
    {
        @ini_set('memory_limit', '512M'); // large phone photos need room while they are decoded

        $raw  = file_get_contents($file->getRealPath());
        $mime = $file->getMimeType();

        if (function_exists('imagecreatefromstring') && ($img = @imagecreatefromstring($raw))) {
            $w = imagesx($img);
            $h = imagesy($img);

            if ($w > $max || $h > $max) {
                $scale   = $max / max($w, $h);
                $resized = imagescale($img, max(1, (int) round($w * $scale)), max(1, (int) round($h * $scale)));
                if ($resized) {
                    imagedestroy($img);
                    $img = $resized;
                }
            }

            if (! imageistruecolor($img)) {
                imagepalettetotruecolor($img);
            }
            imagealphablending($img, false);
            imagesavealpha($img, true);

            ob_start();
            if (function_exists('imagewebp')) {
                imagewebp($img, null, 85);
                $newMime = 'image/webp';
            } else {
                imagejpeg($img, null, 85);
                $newMime = 'image/jpeg';
            }
            $encoded = ob_get_clean();
            imagedestroy($img);

            if ($encoded !== false && $encoded !== '') {
                $raw  = $encoded;
                $mime = $newMime;
            }
        }

        return 'data:' . $mime . ';base64,' . base64_encode($raw);
    }

    /** At most 10 certificate photos per portfolio (kept ones + newly uploaded ones). */
    private function guardCertificateCount(Request $request, ?Portfolio $portfolio): void
    {
        $new  = count(array_filter((array) $request->file('certificates', [])));
        $kept = 0;

        if ($portfolio) {
            $kept = $request->has('certificates_present')
                ? $portfolio->certificates()->whereIn('id', (array) $request->input('keep_certificates', []))->count()
                : $portfolio->certificates()->count();
        }

        if ($new + $kept > 10) {
            throw ValidationException::withMessages(['certificates' => 'You can have up to 10 certificate photos in total.']);
        }
    }

    private function saveCertificates(Portfolio $portfolio, Request $request): void
    {
        // The form always sends "certificates_present"; the ones not listed in keep_certificates were removed.
        if ($request->has('certificates_present')) {
            $keep = array_map('intval', (array) $request->input('keep_certificates', []));
            $portfolio->certificates()->whereNotIn('id', $keep)->delete();
        }

        $next = (int) $portfolio->certificates()->max('sort_order') + 1;

        foreach ((array) $request->file('certificates', []) as $file) {
            if ($file instanceof UploadedFile) {
                $portfolio->certificates()->create(['image' => $this->imageDataUri($file, 1400), 'sort_order' => $next++]);
            }
        }
    }

    /** Certificate photo for the PDF: JPEG, at most 700 px wide, aspect ratio kept. */
    private function pdfCertificate(?string $dataUri): ?string
    {
        if (! $dataUri || ! preg_match('#^data:(image/[a-z+]+);base64,(.+)$#s', $dataUri, $m)) {
            return null;
        }

        if (! function_exists('imagecreatefromstring')) {
            return in_array($m[1], ['image/jpeg', 'image/png'], true) ? $dataUri : null;
        }

        $img = @imagecreatefromstring(base64_decode($m[2]));
        if (! $img) {
            return null;
        }

        $w = imagesx($img);
        $h = imagesy($img);
        $scale = min(1, 700 / max($w, 1));
        $nw = max(1, (int) round($w * $scale));
        $nh = max(1, (int) round($h * $scale));

        $out = imagecreatetruecolor($nw, $nh);
        imagefill($out, 0, 0, imagecolorallocate($out, 255, 255, 255));
        imagecopyresampled($out, $img, 0, 0, 0, 0, $nw, $nh, $w, $h);

        ob_start();
        imagejpeg($out, null, 82);
        $jpeg = ob_get_clean();
        imagedestroy($img);
        imagedestroy($out);

        return $jpeg ? 'data:image/jpeg;base64,' . base64_encode($jpeg) : null;
    }

    /** Rows used to fill the dynamic form (old input wins after a validation error). */
    private function formRows(?Portfolio $portfolio): array
    {
        $fromDb = fn (string $relation, array $cols) => $portfolio
            ? $portfolio->{$relation}->map(fn ($m) => $m->only($cols))->all()
            : [];

        return [
            'education'  => old('education',  $fromDb('educations',  ['school', 'degree', 'start_year', 'end_year', 'description'])),
            'skills'     => old('skills',     $fromDb('skills',      ['name', 'level'])),
            'projects'   => old('projects',   $fromDb('projects',    ['title', 'description', 'tech', 'url'])),
            'experience' => old('experience', $fromDb('experiences', ['company', 'position', 'start_date', 'end_date', 'description'])),
            'links'      => old('links',      $fromDb('socialLinks', ['platform', 'url'])),
        ];
    }
}
