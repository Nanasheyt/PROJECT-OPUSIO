@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false, 'hint' => null,
        'autocomplete' => null, 'maxlength' => null, 'rows' => 5, 'placeholder' => null])
@php
    $id = 'f-' . $name;
    $err = $errors->first($name);
    $desc = trim(($hint ? $id . '-hint ' : '') . ($err ? $id . '-err' : ''));
@endphp
<div class="field">
    <label for="{{ $id }}">{{ $label }}@if ($required) <span class="req" aria-hidden="true">*</span><span class="sr">(required)</span>@endif</label>
    @if ($type === 'textarea')
        <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}" @required($required)
            @if ($maxlength) maxlength="{{ $maxlength }}" @endif
            aria-invalid="{{ $err ? 'true' : 'false' }}" @if ($desc) aria-describedby="{{ $desc }}" @endif>{{ $value }}</textarea>
    @else
        <input id="{{ $id }}" type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" @required($required)
            @if ($maxlength) maxlength="{{ $maxlength }}" @endif
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            aria-invalid="{{ $err ? 'true' : 'false' }}" @if ($desc) aria-describedby="{{ $desc }}" @endif>
    @endif
    @if ($hint)<p class="hint" id="{{ $id }}-hint">{{ $hint }}</p>@endif
    @if ($err)<p class="err" id="{{ $id }}-err"><x-icon name="alert" :size="16" /> <span>{{ $err }}</span></p>@endif
</div>
