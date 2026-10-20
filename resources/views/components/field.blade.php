@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false, 'hint' => null,
        'autocomplete' => null, 'maxlength' => null, 'rows' => 5, 'placeholder' => null, 'letters' => false])
@php
    $id = 'f-' . $name;
    $err = $errors->first($name);
    if ($letters && ! $hint) { $hint = 'Letters only, no numbers.'; }
    $desc = trim(($hint ? $id . '-hint ' : '') . ($letters ? $id . '-note ' : '') . ($err ? $id . '-err' : ''));
@endphp
<div class="field">
    <label for="{{ $id }}">{{ $label }}@if ($required) <span class="req" aria-hidden="true">*</span><span class="sr">(required)</span>@endif</label>
    @if ($type === 'textarea')
        <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}" @required($required)
            @if ($maxlength) maxlength="{{ $maxlength }}" @endif
            aria-invalid="{{ $err ? 'true' : 'false' }}" @if ($desc) aria-describedby="{{ $desc }}" @endif>{{ $value }}</textarea>
    @else
        @if ($type === 'password')<div class="pw-wrap">@endif
        <input id="{{ $id }}" type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" @required($required)
            @if ($maxlength) maxlength="{{ $maxlength }}" @endif
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if ($letters) data-letters @endif
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            aria-invalid="{{ $err ? 'true' : 'false' }}" @if ($desc) aria-describedby="{{ $desc }}" @endif>
        @if ($type === 'password')
            <button type="button" class="pw-toggle" data-pw-toggle="{{ $id }}" aria-label="Show password" aria-pressed="false">
                <span class="pw-show"><x-icon name="eye" :size="20" /></span>
                <span class="pw-hide" hidden><x-icon name="eye-off" :size="20" /></span>
            </button>
        </div>
        @endif
    @endif
    @if ($hint)<p class="hint" id="{{ $id }}-hint">{{ $hint }}</p>@endif
    @if ($letters)<p class="hint" id="{{ $id }}-note" role="status" hidden>Numbers and symbols are not allowed here, so they were removed.</p>@endif
    @if ($err)<p class="err" id="{{ $id }}-err"><x-icon name="alert" :size="16" /> <span>{{ $err }}</span></p>@endif
</div>
