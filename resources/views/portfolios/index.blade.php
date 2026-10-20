@extends('layouts.app')
@section('title', 'Manage Portfolios')
@section('content')
<div class="head">
    <div><h1>Manage Portfolios</h1><p class="sub">View, edit or delete the portfolios stored in the online database.</p></div>
    <a class="btn cta" href="{{ route('portfolios.create') }}"><x-icon name="plus" /> New Portfolio</a>
</div>

@forelse ($portfolios as $p)
    @if ($loop->first)<ul class="mgrid" aria-label="Portfolios">@endif
    <li class="tile">
        @if ($p->profile_picture)
            <img class="photo" src="{{ $p->profile_picture }}" width="400" height="400" loading="lazy" decoding="async" alt="Profile photo of {{ $p->full_name }}">
        @else
            <div class="noimg" role="img" aria-label="No profile photo">
                <svg viewBox="0 0 100 100" aria-hidden="true" focusable="false"><circle cx="50" cy="36" r="19" fill="currentColor"/><path d="M10 100c0-26 18-40 40-40s40 14 40 40z" fill="currentColor"/></svg>
            </div>
        @endif
        <div class="tb">
            <div>
                <div class="nm">{{ $p->full_name }}</div>
                <div class="em">{{ $p->email }}</div>
            </div>
            <div class="actions" style="gap:6px">
                <span class="badge"><x-icon name="layout" :size="12" /> {{ \App\Models\Portfolio::TEMPLATES[$p->template]['name'] ?? 'Formal' }}</span>
                <span class="upd">Updated {{ $p->updated_at->diffForHumans() }}</span>
            </div>
            <div class="acts">
                <a class="btn sm full" href="{{ route('portfolios.saved', $p) }}" aria-label="View portfolio of {{ $p->full_name }}"><x-icon name="eye" :size="16" /> View</a>
                <a class="btn sm ghost" href="{{ route('portfolios.edit', $p) }}" aria-label="Edit portfolio of {{ $p->full_name }}"><x-icon name="pencil" :size="16" /> Edit</a>
                <a class="btn sm ghost" href="{{ route('portfolios.pdf', $p) }}" aria-label="Download PDF of {{ $p->full_name }}"><x-icon name="download" :size="16" /> PDF</a>
                <form method="POST" class="full" action="{{ route('portfolios.destroy', $p) }}"
                      data-confirm="The portfolio of {{ $p->full_name }} and all its details will be permanently removed." data-confirm-title="Delete this portfolio?">
                    @csrf @method('DELETE')
                    <button class="btn sm danger" type="submit" data-busy="Deleting…" aria-label="Delete portfolio of {{ $p->full_name }}"><x-icon name="trash" :size="16" /> Delete</button>
                </form>
            </div>
        </div>
    </li>
    @if ($loop->last)</ul>@endif
@empty
    <div class="card empty">
        <div class="ib"><x-icon name="folder" :size="28" /></div>
        <h2>No portfolios yet</h2>
        <p>Create your first portfolio and it will appear here.</p>
        <a class="btn cta" href="{{ route('portfolios.create') }}"><x-icon name="plus" /> Create Portfolio</a>
    </div>
@endforelse
@endsection
