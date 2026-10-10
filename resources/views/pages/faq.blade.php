@extends('layouts.app')
@section('title', 'FAQ')
@section('content')
<div class="head"><div><h1>Frequently asked questions</h1><p class="sub">Quick answers about how Opusio works, where your data goes and what each template does.</p></div></div>
@include('partials.faq')
<div class="more"><p class="sub" style="margin:0 auto var(--s4)">Ready to try it?</p>
    <a class="btn cta lg" href="{{ route('portfolios.create') }}">Create portfolio <x-icon name="arrow" /></a></div>
@endsection
