@php
    // $m = member array, $i = position (0 = leader), $lead = bool, $color = body colour
    $given   = trim($m['name'] ?? '');
    $name    = $given !== '' ? $given : 'Member ' . $i;
    $role    = $m['role'] ?? ($lead ? 'Team Leader' : 'Member');
    $links   = array_values(array_filter($m['links'] ?? [], fn ($l) => ! empty($l['url'])));
    $phone   = trim($m['phone'] ?? '');
    $email   = trim($m['email'] ?? '');
    $school  = trim($m['school'] ?? '');
    $photo   = ! empty($m['photo']) ? asset($m['photo']) : null;
    $id      = 'team-dlg-' . $i;
    $empty   = $given === '' && ! $phone && ! $email && ! $school && ! count($links);
@endphp
<li class="member {{ $lead ? 'is-lead' : '' }}">
    <div class="char" style="--bc: {{ $color }}">
        <button type="button" class="head" aria-haspopup="dialog" aria-controls="{{ $id }}"
                aria-label="Open the info of {{ $name }}, {{ $role }}">
            @if ($photo)
                <img src="{{ $photo }}" alt="" loading="lazy" decoding="async">
            @else
                <svg viewBox="0 0 100 100" aria-hidden="true" focusable="false"><circle cx="50" cy="38" r="19" fill="currentColor"/><path d="M10 100c0-26 18-40 40-40s40 14 40 40z" fill="currentColor"/></svg>
            @endif
        </button>
        <svg class="body" viewBox="0 0 160 120" aria-hidden="true" focusable="false">
            <g transform="rotate(8 25 58)"><rect x="14" y="58" width="22" height="58" rx="11" class="limb"/><circle cx="25" cy="112" r="12" class="hand"/></g>
            <path d="M36 120V64C36 42 54 28 80 28s44 14 44 36v56z" class="torso"/>
            <g class="arm-r"><rect x="124" y="58" width="22" height="58" rx="11" class="limb"/><circle cx="135" cy="112" r="12" class="hand"/></g>
        </svg>
    </div>
    <p class="mname {{ $given === '' ? 'is-blank' : '' }}">{{ $name }}</p>
    <span class="mrole">{{ $role }}</span>

    <dialog id="{{ $id }}" aria-labelledby="{{ $id }}-t">
        <div class="mdlg-top">
            <span class="mav">
                @if ($photo)<img src="{{ $photo }}" alt="">@else
                    <svg viewBox="0 0 100 100" aria-hidden="true" focusable="false"><circle cx="50" cy="38" r="19" fill="currentColor"/><path d="M10 100c0-26 18-40 40-40s40 14 40 40z" fill="currentColor"/></svg>
                @endif
            </span>
            <div><h3 id="{{ $id }}-t">{{ $name }}</h3><span class="badge">{{ $role }}</span></div>
        </div>
        @if ($empty)<p class="mnote">This member's details have not been added yet.</p>@endif
        <dl class="mdl">
            <dt>School</dt><dd>@if ($school){{ $school }}@else<span class="na">Not added yet</span>@endif</dd>
            <dt>Contact number</dt><dd>@if ($phone)<a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a>@else<span class="na">Not added yet</span>@endif</dd>
            <dt>Email</dt><dd>@if ($email)<a href="mailto:{{ $email }}">{{ $email }}</a>@else<span class="na">Not added yet</span>@endif</dd>
            <dt>Social links</dt>
            <dd>@if (count($links))
                <ul class="mlinks">@foreach ($links as $l)<li><a href="{{ $l['url'] }}" target="_blank" rel="noopener"><x-icon name="external" :size="16" /> {{ $l['label'] ?? 'Link' }}<span class="sr"> (opens in a new tab)</span></a></li>@endforeach</ul>
            @else<span class="na">Not added yet</span>@endif</dd>
        </dl>
        <div class="actions" style="justify-content:flex-end"><button type="button" class="btn ghost" data-close>Close</button></div>
    </dialog>
</li>
