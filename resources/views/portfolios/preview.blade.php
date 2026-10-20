@extends('layouts.app')
@section('title', 'Preview – ' . $portfolio->full_name)
@section('full')
<div class="wrap">
    @include('partials.stepper', ['step' => 3, 'portfolio' => $portfolio])
    <div class="head" style="margin-bottom:var(--s4)">
        <div><h1>{{ $portfolio->full_name }}</h1>
            <p class="sub">Previewing the <strong>{{ \App\Models\Portfolio::TEMPLATES[$template]['name'] }}</strong> template @if ($template === $portfolio->template)(currently selected)@endif.</p></div>
    </div>

    <div class="tbar">
        <nav class="tabs" aria-label="Template preview">
            @foreach (\App\Models\Portfolio::TEMPLATES as $key => $t)
                <a href="{{ route('portfolios.preview', [$portfolio, 'template' => $key]) }}" @if ($template === $key) aria-current="true" @endif>
                    {{ $t['name'] }}@if ($portfolio->template === $key) <x-icon name="check" :size="14" /><span class="sr">(selected)</span>@endif</a>
            @endforeach
        </nav>
        <div class="actions">
            <form method="POST" action="{{ route('portfolios.save', $portfolio) }}">
                @csrf <input type="hidden" name="template" value="{{ $template }}">
                <button class="btn cta sm" type="submit" data-busy="Saving…"><x-icon name="check" :size="16" /> Save</button>
            </form>
            <a class="btn sm" href="{{ route('portfolios.pdf', [$portfolio, 'template' => $template]) }}"><x-icon name="download" :size="16" /> Download PDF</a>
            <button type="button" class="btn sm ghost" data-copy="{{ route('portfolios.show', $portfolio) }}"><x-icon name="link" :size="16" /> Copy link</button>
            <a class="btn sm ghost" href="{{ route('portfolios.show', $portfolio) }}" target="_blank" rel="noopener"><x-icon name="external" :size="16" /> Open full page<span class="sr"> (new tab)</span></a>
            <a class="btn sm ghost" href="{{ route('portfolios.edit', $portfolio) }}"><x-icon name="pencil" :size="16" /> Edit</a>
            <form method="POST" action="{{ route('portfolios.destroy', $portfolio) }}"
                  data-confirm="The portfolio of {{ $portfolio->full_name }} and all its details will be permanently removed." data-confirm-title="Delete this portfolio?">
                @csrf @method('DELETE')
                <button class="btn sm danger" type="submit" data-busy="Deleting…"><x-icon name="trash" :size="16" /> Delete</button>
            </form>
        </div>
    </div>
    <iframe class="frame" src="{{ route('portfolios.show', [$portfolio, 'template' => $template]) }}" title="Portfolio preview of {{ $portfolio->full_name }}"></iframe>
</div>
@endsection
