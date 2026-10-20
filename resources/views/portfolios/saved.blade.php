@extends('layouts.app')
@section('title', 'Saved')
@section('content')
@include('partials.stepper', ['step' => 4, 'portfolio' => $portfolio])

@php $link = route('portfolios.show', $portfolio); @endphp
<div class="saved-grid">
    @if ($portfolio->profile_picture)
        <div class="saved-photo"><img src="{{ $portfolio->profile_picture }}" alt="Profile photo of {{ $portfolio->full_name }}"></div>
    @else
        <div class="saved-photo" role="img" aria-label="No profile photo"><svg viewBox="0 0 100 100" aria-hidden="true" focusable="false"><circle cx="50" cy="36" r="19" fill="currentColor"/><path d="M10 100c0-26 18-40 40-40s40 14 40 40z" fill="currentColor"/></svg></div>
    @endif

    <div>
        <div class="tick"><x-icon name="check" :size="30" /></div>
        <h1>Your portfolio is saved</h1>
        <p class="sub"><strong>{{ $portfolio->full_name }}</strong> is saved to your account with the
            <span class="badge"><x-icon name="layout" :size="12" /> {{ \App\Models\Portfolio::TEMPLATES[$portfolio->template]['name'] ?? 'Formal' }}</span> template.</p>

        <div class="card" style="margin-top:var(--s5)">
            <h2 style="margin-bottom:var(--s2)">Share your portfolio</h2>
            <p class="hint" style="margin:0 0 var(--s3)">Anyone with this link can view your portfolio. They cannot edit it: only you can, after logging in.</p>
            <div class="share-box">
                <input type="text" readonly value="{{ $link }}" aria-label="Public link to your portfolio" onfocus="this.select()">
                <button type="button" class="btn sm" data-copy="{{ $link }}"><x-icon name="link" :size="16" /> Copy link</button>
            </div>
        </div>

        {{-- All five buttons share the same height and shape; each row fills the full width --}}
        <style>
            .sact{display:grid;grid-template-columns:repeat(6,1fr);gap:var(--s3);margin-top:var(--s5)}
            .sact .btn{width:100%;min-height:52px;padding:0 var(--s4);white-space:nowrap}
            .sact .b3{grid-column:span 2}.sact .b2{grid-column:span 3}
            @media (max-width:640px){.sact{grid-template-columns:1fr}.sact .b3,.sact .b2{grid-column:auto}}
        </style>
        <div class="sact">
            <a class="btn b3" href="{{ route('portfolios.show', $portfolio) }}" target="_blank" rel="noopener"><x-icon name="external" :size="16" /> Open my portfolio<span class="sr"> (new tab)</span></a>
            <a class="btn ghost b3" href="{{ route('portfolios.pdf', $portfolio) }}"><x-icon name="download" :size="16" /> Download PDF</a>
            <a class="btn ghost b3" href="{{ route('portfolios.edit', $portfolio) }}"><x-icon name="pencil" :size="16" /> Edit</a>
            <a class="btn cta b2" href="{{ route('portfolios.index') }}">Go to Manage portfolios <x-icon name="arrow" /></a>
            <a class="btn ghost b2" href="{{ route('portfolios.create') }}"><x-icon name="plus" :size="16" /> Create another</a>
        </div>
    </div>
</div>
@endsection
