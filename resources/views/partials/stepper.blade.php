@php
    $steps = [
        1 => ['Information', isset($portfolio) && $portfolio->exists ? route('portfolios.edit', $portfolio) : route('portfolios.create')],
        2 => ['Template',    isset($portfolio) && $portfolio->exists ? route('portfolios.templates', $portfolio) : null],
        3 => ['Preview',     isset($portfolio) && $portfolio->exists ? route('portfolios.preview', $portfolio) : null],
        4 => ['Saved',       isset($portfolio) && $portfolio->exists ? route('portfolios.saved', $portfolio) : null],
    ];
@endphp
<nav class="stepper" aria-label="Progress">
    <ol>
        @foreach ($steps as $n => [$label, $url])
            <li @if ($n === $step) aria-current="step" @endif class="{{ $n < $step ? 'done' : ($n === $step ? 'now' : '') }}">
                @if ($url && $n !== $step)<a href="{{ $url }}">@endif
                <span class="dot">@if ($n < $step)<x-icon name="check" :size="14" />@else{{ $n }}@endif</span>
                <span class="lbl">{{ $label }}</span>
                @if ($url && $n !== $step)</a>@endif
            </li>
        @endforeach
    </ol>
</nav>
