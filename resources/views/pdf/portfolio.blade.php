@php
    // Accent colours follow the template the portfolio uses.
    $themes = [
        'simple'   => ['head' => '#14284B', 'title' => '#E3C57A', 'accent' => '#8A6A1F', 'line' => '#B8903A', 'bar' => '#B8903A'],
        'modern'   => ['head' => '#4F46E5', 'title' => '#E0E7FF', 'accent' => '#4338CA', 'line' => '#818CF8', 'bar' => '#4F46E5'],
        'creative' => ['head' => '#0B1020', 'title' => '#67E8F9', 'accent' => '#0E7490', 'line' => '#22D3EE', 'bar' => '#0E7490'],
    ];
    $t = $themes[$template] ?? $themes['simple'];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{{ $portfolio->full_name }} – Portfolio</title>
<style>
    @page { margin: 26px 34px 24px 34px; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 9.5px; line-height: 1.55; color: #1B2430; margin: 0; }
    table { border-collapse: collapse; width: 100%; }
    td { vertical-align: top; padding: 0; }
    a { color: #1B2430; text-decoration: none; }
    .head { background: {{ $t['head'] }}; color: #ffffff; }
    .head td { padding: 18px 24px; }
    .name { font-size: 22px; font-weight: bold; letter-spacing: 0.5px; margin: 0; color: #ffffff; }
    .role { font-size: 11px; color: {{ $t['title'] }}; margin: 4px 0 0 0; }
    .contact { font-size: 9px; color: #ffffff; margin-top: 12px; line-height: 1.7; }
    .photo { width: 84px; height: 84px; border: 3px solid {{ $t['line'] }}; }
    .initials { width: 84px; height: 84px; border: 3px solid {{ $t['line'] }}; text-align: center; font-size: 28px; font-weight: bold; color: {{ $t['title'] }}; line-height: 84px; }
    h2 { font-size: 10.5px; font-weight: bold; text-transform: uppercase; letter-spacing: 1.5px; color: {{ $t['accent'] }};
         border-bottom: 2px solid {{ $t['line'] }}; padding-bottom: 3px; margin: 15px 0 7px 0; page-break-after: avoid; }
    .entry { margin-bottom: 8px; page-break-inside: avoid; }
    .etitle { font-size: 11px; font-weight: bold; margin: 0; }
    .meta { color: #4A5568; font-size: 9px; }
    .when { text-align: right; color: #4A5568; font-size: 8.5px; white-space: nowrap; }
    .desc { margin: 3px 0 0 0; }
    .tech { color: #4A5568; font-size: 8.5px; margin-top: 2px; }
    .about { font-size: 10px; margin: 0; }
    .skill td { padding: 0 0 5px 0; }
    .sname { font-weight: bold; }
    .slevel { color: #4A5568; font-size: 8.5px; text-align: right; }
    .track { background: #E5E7EB; height: 5px; }
    .fill { background: {{ $t['bar'] }}; height: 5px; }
    .foot { margin-top: 12px; padding-top: 6px; border-top: 1px solid #D5DBE5; color: #6B7280; font-size: 8px; text-align: center; }
</style>
</head>
<body>

<table class="head">
    <tr>
        <td>
            <p class="name">{{ $portfolio->full_name }}</p>
            @if ($portfolio->job_title)<p class="role">{{ $portfolio->job_title }}</p>@endif
            <div class="contact">
                {{ $portfolio->email }}<br>
                {{ $portfolio->phone }}<br>
                {{ $portfolio->address }}
            </div>
        </td>
        <td style="width: 90px; text-align: right;">
            @if ($photo)
                <img class="photo" src="{{ $photo }}" width="84" height="84" alt="">
            @else
                <div class="initials">{{ $portfolio->initials }}</div>
            @endif
        </td>
    </tr>
</table>

<h2>Profile</h2>
<p class="about">{!! nl2br(e($portfolio->about)) !!}</p>

@if ($portfolio->experiences->count())
    <h2>Work Experience</h2>
    @foreach ($portfolio->experiences as $x)
        <div class="entry">
            <table>
                <tr>
                    <td><p class="etitle">{{ $x->position }}</p></td>
                    <td class="when">{{ $x->start_date }}{{ $x->start_date && $x->end_date ? ' – ' : '' }}{{ $x->end_date }}</td>
                </tr>
            </table>
            <div class="meta">{{ $x->company }}</div>
            @if ($x->description)<p class="desc">{!! nl2br(e($x->description)) !!}</p>@endif
        </div>
    @endforeach
@endif

@if ($portfolio->educations->count())
    <h2>Education</h2>
    @foreach ($portfolio->educations as $e)
        <div class="entry">
            <table>
                <tr>
                    <td><p class="etitle">{{ $e->degree }}</p></td>
                    <td class="when">{{ $e->start_year }}{{ $e->start_year && $e->end_year ? ' – ' : '' }}{{ $e->end_year }}</td>
                </tr>
            </table>
            <div class="meta">{{ $e->school }}</div>
            @if ($e->description)<p class="desc">{{ $e->description }}</p>@endif
        </div>
    @endforeach
@endif

@if ($portfolio->projects->count())
    <h2>Projects</h2>
    @foreach ($portfolio->projects as $p)
        <div class="entry">
            <p class="etitle">{{ $p->title }}</p>
            @if ($p->tech)<div class="tech">{{ $p->tech }}</div>@endif
            @if ($p->description)<p class="desc">{{ $p->description }}</p>@endif
            @if ($p->url)<div class="tech"><a href="{{ $p->url }}">{{ $p->url }}</a></div>@endif
        </div>
    @endforeach
@endif

@if ($portfolio->skills->count())
    <h2>Skills</h2>
    <table>
        @foreach ($portfolio->skills as $s)
            <tr class="skill">
                <td style="width: 32%;" class="sname">{{ $s->name }}</td>
                <td style="width: 52%;">
                    <div class="track"><div class="fill" style="width: {{ $s->percent }}%;"></div></div>
                </td>
                <td style="width: 16%;" class="slevel">{{ $s->level }}</td>
            </tr>
        @endforeach
    </table>
@endif

@if ($portfolio->socialLinks->count())
    <div style="page-break-inside: avoid;">
        <h2>Links</h2>
        @foreach ($portfolio->socialLinks as $l)
            <div style="margin-bottom: 4px;"><strong>{{ $l->platform }}:</strong> <a href="{{ $l->url }}">{{ $l->url }}</a></div>
        @endforeach
    </div>
@endif

@if (! empty($certRows))
    <h2>Certificates</h2>
    <table>
        @foreach ($certRows as $row)
            <tr style="page-break-inside: avoid;">
                @foreach ($row as $img)
                    <td style="width: 33.33%; padding: 0 8px 10px 0;"><img src="{{ $img }}" style="width: 100%; border: 1px solid #D5DBE5;" alt=""></td>
                @endforeach
                @if (count($row) < 3)<td colspan="{{ 3 - count($row) }}"></td>@endif
            </tr>
        @endforeach
    </table>
@endif

<div class="foot">Created with Opusio &middot; {{ now()->format('F j, Y') }}</div>

</body>
</html>
