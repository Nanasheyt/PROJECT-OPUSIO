@extends('layouts.app')
@php
    $editing = $portfolio->exists;
    $topFields = ['full_name', 'job_title', 'email', 'phone', 'address', 'about', 'profile_picture'];
    $sections = [
        'education'      => ['Education',                 'Add education',  'cap'],
        'skills'         => ['Skills',                    'Add skill',      'zap'],
        'projects'       => ['Projects',                  'Add project',    'folder'],
        'experience'     => ['Work experience',           'Add experience', 'briefcase'],
        'testimonials'   => ['Testimonials',              'Add testimonial', 'message-circle'],
        'publications'   => ['Publications',              'Add publication', 'book-open'],
        'languages'      => ['Languages',                 'Add language', 'globe'],
        'links'          => ['Social media and websites', 'Add link',       'link'],
    ];
@endphp
@section('title', $editing ? 'Edit Portfolio' : 'Create Portfolio')
@section('wrapclass', 'narrow')
@section('own_errors', '1')
@section('content')
@include('partials.stepper', ['step' => 1, 'portfolio' => $portfolio])
<style>
.cert-grid{list-style:none;margin:0 0 var(--s4);padding:0;display:grid;grid-template-columns:repeat(auto-fill,minmax(min(150px,100%),1fr));gap:var(--s3)}
.cert-item{position:relative;aspect-ratio:4/3;border:1.5px solid var(--hair);border-radius:14px;overflow:hidden;background:var(--muted)}
.cert-item img{width:100%;height:100%;object-fit:cover;display:block}
.cert-rm{position:absolute;top:6px;right:6px;width:40px;height:40px;border-radius:50%;border:1.5px solid var(--danger);background:var(--card);color:var(--danger);display:grid;place-items:center;cursor:pointer}
.cert-rm:hover{background:var(--danger);color:var(--on-danger)}
.cert-top{display:flex;justify-content:space-between;align-items:center;gap:var(--s3);flex-wrap:wrap;margin-bottom:var(--s3)}
input.sr:focus-visible + label.btn{outline:3px solid var(--ring);outline-offset:3px}
.pic-preview{display:flex;align-items:center;gap:var(--s4);flex-wrap:wrap;margin-top:var(--s3);padding:var(--s3);border:1.5px dashed var(--border);border-radius:10px}</style>

<div class="head">
    <div>
        <h1>{{ $editing ? 'Edit your information' : 'Tell us about yourself' }}</h1>
        <p class="sub">Fields marked <span class="req" aria-hidden="true">*</span><span class="sr">with an asterisk</span> are required. Everything is saved to your online database.</p>
    </div>
</div>

@if ($errors->any())
    <div class="alert err" role="alert" tabindex="-1" id="error-summary" aria-labelledby="error-title">
        <h2 id="error-title">There {{ $errors->count() === 1 ? 'is 1 problem' : 'are ' . $errors->count() . ' problems' }} with your form</h2>
        <ul>
            @foreach ($errors->keys() as $key)
                @php $root = explode('.', $key)[0]; $href = in_array($key, $topFields, true) ? '#f-' . $key : '#sec-' . $root; @endphp
                <li><a href="{{ $href }}">{{ $errors->first($key) }}</a></li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-layout">
    <aside class="toc" aria-label="Form sections">
        <p>Sections</p>
        <ol>
            <li><a href="#sec-personal"><x-icon name="user" :size="16" /> Personal</a></li>
            @foreach ($sections as $key => [$title, $add, $icon])
                <li><a href="#sec-{{ $key }}"><x-icon :name="$icon" :size="16" /> {{ $title }}</a></li>
            @endforeach
            <li><a href="#sec-certificates"><x-icon name="award" :size="16" /> Certificates</a></li>
        </ol>
    </aside>

    <form method="POST" enctype="multipart/form-data" class="stack"
          action="{{ $editing ? route('portfolios.update', $portfolio) : route('portfolios.store') }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <section class="card" id="sec-personal" aria-labelledby="h-personal">
            <div class="card-h"><span class="ib"><x-icon name="user" /></span><h2 id="h-personal">Personal information</h2></div>
            <div class="grid g2">
                <x-field name="full_name" label="Full name" :value="old('full_name', $portfolio->full_name)" required autocomplete="name" maxlength="150" letters />
                <x-field name="job_title" label="Professional title" :value="old('job_title', $portfolio->job_title)" autocomplete="organization-title" maxlength="150" hint="Letters only. For example: Web Developer" letters />
                <x-field name="email" label="Email" type="email" :value="old('email', $portfolio->email)" required autocomplete="email" maxlength="150" />
                <x-field name="phone" label="Contact number" type="text" :value="old('phone', $portfolio->phone)" required autocomplete="tel" maxlength="40" />
                <div class="span2"><x-field name="address" label="Address" :value="old('address', $portfolio->address)" required autocomplete="street-address" maxlength="255" /></div>
                <div class="span2"><x-field name="about" label="About me" type="textarea" :rows="6" :value="old('about', $portfolio->about)" required maxlength="3000" hint="A short introduction, up to 3000 characters." /></div>
                <div class="span2 field">
                    <label for="f-profile_picture">Profile picture</label>
                    @if ($editing && $portfolio->profile_picture)
                        <div class="actions" style="margin-bottom:12px">
                            <img class="avatar" style="width:72px;height:72px" src="{{ $portfolio->profile_picture }}" alt="Current profile picture">
                            <label class="check"><input type="checkbox" name="remove_picture" value="1"> Remove current picture</label>
                        </div>
                    @endif
                    <input id="f-profile_picture" type="file" name="profile_picture" accept="image/png,image/jpeg,image/webp"
                           aria-invalid="{{ $errors->has('profile_picture') ? 'true' : 'false' }}" aria-describedby="f-profile_picture-hint @error('profile_picture') f-profile_picture-err @enderror">
                    <p class="hint" id="f-profile_picture-hint">JPG, PNG or WEBP, up to 5 MB.</p>
                    <p class="err" id="pic-client-err" role="alert" hidden><x-icon name="alert" :size="16" /> <span>That photo is larger than 5 MB. Please choose a smaller one.</span></p>
                    <div class="pic-preview" id="pic-preview" hidden>
                        <img id="pic-preview-img" class="avatar" style="width:72px;height:72px" alt="Preview of the selected photo">
                        <div style="min-width:0;flex:1"><strong id="pic-name" style="display:block;overflow-wrap:anywhere"></strong><span class="hint" id="pic-size" style="margin:0"></span></div>
                        <button type="button" class="btn danger sm" id="pic-remove"><x-icon name="x" :size="16" /> Remove photo</button>
                    </div>
                    @error('profile_picture')<p class="err" id="f-profile_picture-err"><x-icon name="alert" :size="16" /> <span>{{ $message }}</span></p>@enderror
                </div>
            </div>
        </section>

        @foreach ($sections as $key => [$title, $add, $icon])
            <section class="card" id="sec-{{ $key }}" aria-labelledby="h-{{ $key }}">
                <div class="card-h"><span class="ib"><x-icon :name="$icon" /></span><h2 id="h-{{ $key }}">{{ $title }}</h2></div>
                <div id="list-{{ $key }}"></div>
                <button type="button" class="btn ghost sm" data-add="{{ $key }}"><x-icon name="plus" :size="16" /> {{ $add }}</button>
            </section>
        @endforeach

        @php
            $keepOld = old('certificates_present') ? (array) old('keep_certificates', []) : null;
            $certErr = $errors->first('certificates') ?: collect($errors->get('certificates.*'))->flatten()->first();
        @endphp
        <section class="card" id="sec-certificates" aria-labelledby="h-certificates">
            <div class="card-h"><span class="ib"><x-icon name="award" /></span><h2 id="h-certificates">Certificates</h2></div>
            <input type="hidden" name="certificates_present" value="1">
            <div class="cert-top">
                <p class="hint" style="margin:0">Add photos of your certificates: up to 10, JPG, PNG or WEBP, 5 MB each.</p>
                <span class="badge" id="cert-count" aria-live="polite">0 of 10</span>
            </div>
            <ul class="cert-grid" id="cert-grid" aria-label="Certificate photos">
                @foreach ($portfolio->certificates as $c)
                    @if (is_null($keepOld) || in_array($c->id, array_map('intval', $keepOld), true))
                        <li class="cert-item" data-existing>
                            <img src="{{ $c->image }}" alt="Saved certificate {{ $loop->iteration }}" loading="lazy" decoding="async">
                            <input type="hidden" name="keep_certificates[]" value="{{ $c->id }}">
                            <button type="button" class="cert-rm" aria-label="Remove saved certificate {{ $loop->iteration }}"><x-icon name="x" :size="18" /></button>
                        </li>
                    @endif
                @endforeach
            </ul>
            <input id="f-certificates" class="sr" type="file" name="certificates[]" accept="image/png,image/jpeg,image/webp" multiple aria-describedby="cert-msg">
            <label for="f-certificates" class="btn ghost sm" id="cert-add" style="display:inline-flex;margin:0"><x-icon name="plus" :size="16" /> Add certificate photos</label>
            <p class="err" id="cert-msg" role="alert" @if (! $certErr) hidden @endif><x-icon name="alert" :size="16" /> <span id="cert-msg-text">{{ $certErr }}</span></p>
        </section>

        <div class="actions">
            <button class="btn cta lg" type="submit" data-busy="Saving…">{{ $editing ? 'Save changes' : 'Save and choose template' }}</button>
            <a class="btn ghost lg" href="{{ $editing ? route('portfolios.index') : route('home') }}">Cancel</a>
        </div>
    </form>
</div>
<p class="sr" id="live" aria-live="polite"></p>
@endsection

@push('scripts')
<script>
(function () {
    const initial = @json($rows);
    const errs = @json($errors->messages());
    const levels = @json(array_keys(\App\Models\Portfolio::SKILL_LEVELS));
    const platforms = @json(\App\Models\Portfolio::PLATFORMS);
    const ALERT = '<svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>';
    const X = '<svg class="ico" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>';

    const cfg = {
        education:      { noun: 'education',      fields: [
            {n:'school', l:'School or university', req:1, ac:'organization'}, {n:'degree', l:'Degree or course', req:1},
            {n:'start_year', l:'Start year'}, {n:'end_year', l:'End year', hint:'Or write "Present"'},
            {n:'description', l:'Details', type:'textarea', hint:'Optional'}]},
        skills:         { noun: 'skill',          fields: [
            {n:'name', l:'Skill', req:1}, {n:'level', l:'Level', type:'select', options:levels, def:'Intermediate'}]},
        projects:       { noun: 'project',        fields: [
            {n:'title', l:'Project title', req:1}, {n:'tech', l:'Technologies used'}, {n:'url', l:'Project link', hint:'Optional, for example github.com/you/project'},
            {n:'description', l:'Description', type:'textarea'}]},
        experience:     { noun: 'experience',     fields: [
            {n:'company', l:'Company', req:1}, {n:'position', l:'Position', req:1},
            {n:'start_date', l:'Start', hint:'For example: Jan 2023'}, {n:'end_date', l:'End', hint:'Or write "Present"'},
            {n:'description', l:'Responsibilities and achievements', type:'textarea'}]},
        testimonials:   { noun: 'testimonial',    fields: [
            {n:'quote', l:'Quote', req:1, type:'textarea'}, {n:'author', l:'Author name', req:1}, {n:'role', l:'Role / Company', req:1}]},
        publications:   { noun: 'publication',    fields: [
            {n:'title', l:'Title', req:1}, {n:'venue', l:'Venue / Journal', req:1}, {n:'year', l:'Year'}, {n:'url', l:'URL', hint:'Optional, for example doi.org/...'}]},
        languages:      { noun: 'language',       fields: [
            {n:'name', l:'Language', req:1}, {n:'proficiency', l:'Proficiency', type:'select', options:@json(array_keys(\App\Models\Language::PROFICIENCIES)), def:'Professional'}, {n:'percent', l:'Proficiency %', hint:'Optional (0-100)'}]},
        links:          { noun: 'link',           fields: [
            {n:'platform', l:'Platform', type:'select', options:platforms, def:'GitHub'}, {n:'url', l:'URL', req:1, hint:'For example: github.com/yourname'}]},
    };

    const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const counters = {}, live = document.getElementById('live');

    function addRow(key, values, pos, focus) {
        const i = counters[key] = (counters[key] ?? 0) + 1;
        const c = cfg[key];
        const box = document.createElement('div');
        box.className = 'row-item';
        let html = `<div class="row-top"><strong>${esc(c.noun)} entry</strong>
            <button type="button" class="btn danger sm rm" aria-label="Remove this ${esc(c.noun)} entry">${X} Remove</button></div><div class="grid g2">`;
        c.fields.forEach(f => {
            const id = `${key}-${i}-${f.n}`, name = `${key}[${i}][${f.n}]`;
            const val = values?.[f.n] ?? f.def ?? '';
            const err = pos != null ? (errs[`${key}.${pos}.${f.n}`] || [])[0] : null;
            const desc = [f.hint ? id + '-h' : '', err ? id + '-e' : ''].join(' ').trim();
            const a = `id="${id}" name="${name}" aria-invalid="${err ? 'true' : 'false'}" ${desc ? `aria-describedby="${desc}"` : ''}`;
            let input;
            if (f.type === 'textarea') input = `<textarea ${a} rows="3">${esc(val)}</textarea>`;
            else if (f.type === 'select') input = `<select ${a}>` + f.options.map(o => `<option ${o === val ? 'selected' : ''}>${esc(o)}</option>`).join('') + '</select>';
            else input = `<input type="text" ${a} value="${esc(val)}" ${f.req ? 'required' : ''} ${f.ac ? `autocomplete="${f.ac}"` : ''}>`;
            html += `<div class="field ${f.type === 'textarea' ? 'span2' : ''}"><label for="${id}">${esc(f.l)}${f.req ? ' <span class="req" aria-hidden="true">*</span><span class="sr">(required)</span>' : ''}</label>${input}`
                  + (f.hint ? `<p class="hint" id="${id}-h">${esc(f.hint)}</p>` : '')
                  + (err ? `<p class="err" id="${id}-e">${ALERT} <span>${esc(err)}</span></p>` : '') + '</div>';
        });
        box.innerHTML = html + '</div>';
        box.querySelector('.rm').addEventListener('click', () => {
            const addBtn = document.querySelector(`[data-add="${key}"]`);
            box.remove(); live.textContent = `${c.noun} entry removed`; addBtn.focus();
        });
        document.getElementById('list-' + key).appendChild(box);
        if (focus) box.querySelector('input,textarea,select').focus();
    }

    Object.keys(cfg).forEach(key => {
        const rows = Object.values(initial[key] || {});
        rows.forEach((r, p) => addRow(key, r, p, false));
        if (!rows.length && (key === 'education' || key === 'skills')) addRow(key, null, null, false);
    });
    document.querySelectorAll('[data-add]').forEach(b => b.addEventListener('click', () => addRow(b.dataset.add, null, null, true)));

    // Profile picture: preview the chosen file and let the user remove it again
    (function () {
        const input = document.getElementById('f-profile_picture');
        const box = document.getElementById('pic-preview'), img = document.getElementById('pic-preview-img');
        const nameEl = document.getElementById('pic-name'), sizeEl = document.getElementById('pic-size');
        const tooBig = document.getElementById('pic-client-err'), remove = document.getElementById('pic-remove');
        let url = null;
        function clear(message) {
            input.value = '';
            if (url) { URL.revokeObjectURL(url); url = null; }
            img.removeAttribute('src'); box.hidden = true;
            if (message) live.textContent = message;
        }
        input.addEventListener('change', function () {
            tooBig.hidden = true;
            const f = input.files[0];
            if (!f) { clear(); return; }
            if (f.size > 5 * 1024 * 1024) { clear(); tooBig.hidden = false; return; }
            if (url) URL.revokeObjectURL(url);
            url = URL.createObjectURL(f);
            img.src = url; nameEl.textContent = f.name;
            sizeEl.textContent = (f.size / 1024 < 1024 ? Math.round(f.size / 1024) + ' KB' : (f.size / 1048576).toFixed(1) + ' MB');
            box.hidden = false;
        });
        remove.addEventListener('click', function () { clear('Photo removed'); input.focus(); });
    })();

    // Certificates: pick many photos, preview them, remove any before saving
    (function () {
        const MAX = 10, MAX_BYTES = 5 * 1024 * 1024;
        const input = document.getElementById('f-certificates'), grid = document.getElementById('cert-grid');
        const countEl = document.getElementById('cert-count'), msg = document.getElementById('cert-msg'), msgText = document.getElementById('cert-msg-text');
        const addBtn = document.getElementById('cert-add');
        let files = [];

        const total = () => grid.children.length;
        function refresh() {
            if (window.DataTransfer) { const dt = new DataTransfer(); files.forEach(f => dt.items.add(f)); input.files = dt.files; }
            countEl.textContent = total() + ' of ' + MAX;
        }
        function problem(text) { msgText.textContent = text; msg.hidden = !text; }

        function addPreview(file) {
            const url = URL.createObjectURL(file);
            const li = document.createElement('li');
            li.className = 'cert-item';
            li.innerHTML = '<img alt=""><button type="button" class="cert-rm">' + X + '</button>';
            const img = li.querySelector('img'); img.src = url; img.alt = 'New certificate: ' + file.name;
            const rm = li.querySelector('button'); rm.setAttribute('aria-label', 'Remove new certificate ' + file.name);
            rm.addEventListener('click', () => {
                files = files.filter(f => f !== file); URL.revokeObjectURL(url); li.remove();
                refresh(); problem(''); live.textContent = 'Certificate photo removed'; addBtn.focus();
            });
            grid.appendChild(li);
        }

        input.addEventListener('change', () => {
            const issues = [];
            Array.from(input.files).forEach(f => {
                if (!/^image\/(jpeg|png|webp)$/.test(f.type)) { issues.push(f.name + ' is not a JPG, PNG or WEBP image.'); return; }
                if (f.size > MAX_BYTES) { issues.push(f.name + ' is larger than 5 MB.'); return; }
                if (files.some(x => x.name === f.name && x.size === f.size && x.lastModified === f.lastModified)) return;
                if (total() >= MAX) { issues.push('You can add up to ' + MAX + ' certificate photos.'); return; }
                files.push(f); addPreview(f);
            });
            refresh(); problem(issues.join(' '));
        });

        // Saved certificates: removing one means it is not sent back in keep_certificates[]
        grid.addEventListener('click', e => {
            const b = e.target.closest('.cert-rm');
            if (!b) return;
            const li = b.closest('[data-existing]');
            if (!li) return;
            li.remove(); refresh(); problem(''); live.textContent = 'Saved certificate removed'; addBtn.focus();
        });
        refresh();
    })();

    const summary = document.getElementById('error-summary');
    if (summary) summary.focus();
})();
</script>
@endpush
