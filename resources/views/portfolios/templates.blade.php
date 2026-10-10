@extends('layouts.app')
@section('title', 'Choose a Template')
@section('content')
@include('partials.stepper', ['step' => 2, 'portfolio' => $portfolio])
<div class="head">
    <div><h1>Choose a template</h1>
        <p class="sub">These are live previews built from the information saved for {{ $portfolio->full_name }}. Pick the one that fits you; you can change it later.</p></div>
    <a class="btn ghost" href="{{ route('portfolios.edit', $portfolio) }}"><x-icon name="pencil" :size="16" /> Edit information</a>
</div>

<ul class="tgrid" style="list-style:none;padding:0;margin:0">
    @foreach (\App\Models\Portfolio::TEMPLATES as $key => $t)
        <li class="tcard {{ $portfolio->template === $key ? 'sel' : '' }}">
            <div class="thumb"><iframe loading="lazy" tabindex="-1" src="{{ route('portfolios.show', [$portfolio, 'template' => $key]) }}" title="{{ $t['name'] }} template preview"></iframe></div>
            <div class="tbody">
                <h2>{{ $loop->iteration }}. {{ $t['name'] }}
                    @if ($portfolio->template === $key)<span class="badge ok" style="margin-left:8px"><x-icon name="check" :size="12" /> Selected</span>@endif</h2>
                <p>{{ $t['description'] }}</p>
                <div class="actions">
                    <a class="btn ghost sm" href="{{ route('portfolios.preview', [$portfolio, 'template' => $key]) }}" aria-label="Preview the {{ $t['name'] }} template full size"><x-icon name="eye" :size="16" /> Preview</a>
                    <form method="POST" action="{{ route('portfolios.select', $portfolio) }}">
                        @csrf <input type="hidden" name="template" value="{{ $key }}">
                        <button class="btn sm" type="submit" data-busy="Applying…" aria-label="Use the {{ $t['name'] }} template">
                            <x-icon name="check" :size="16" /> {{ $portfolio->template === $key ? 'Keep this template' : 'Use this template' }}</button>
                    </form>
                </div>
            </div>
        </li>
    @endforeach
</ul>
@endsection

@push('scripts')
<script>
function fitThumbs() {
    document.querySelectorAll('.thumb').forEach(function (t) {
        var s = t.clientWidth / 1200;
        t.querySelector('iframe').style.transform = 'scale(' + s + ')';
        t.style.height = Math.round(900 * s * 0.72) + 'px';
    });
}
window.addEventListener('load', fitThumbs);
window.addEventListener('resize', fitThumbs);
fitThumbs();
</script>
@endpush
