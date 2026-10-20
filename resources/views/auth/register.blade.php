@extends('layouts.app')
@section('title', 'Sign up')
@section('own_errors', '1')
@section('content')
<div class="auth-wrap">
    <h1>Create your account</h1>
    <p class="sub">An account keeps your portfolios private, so only you can edit or delete them.</p>

    <form method="POST" action="{{ route('register') }}" class="card stack" novalidate>
        @csrf
        <x-field name="name" label="Full name" :value="old('name')" required autocomplete="name" maxlength="100" letters />
        <x-field name="email" label="Email" type="email" :value="old('email')" required autocomplete="email" maxlength="150" />
        <x-field name="password" label="Password" type="password" required autocomplete="new-password" maxlength="100" hint="At least 8 characters." />
        <x-field name="password_confirmation" label="Confirm password" type="password" required autocomplete="new-password" maxlength="100" />
        <button class="btn cta lg" type="submit" data-busy="Creating account…" style="width:100%">Sign up</button>
    </form>

    <p class="auth-alt">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
    <p class="auth-note"><x-icon name="eye" :size="18" /> <span>Your password is stored encrypted (hashed), never as plain text.</span></p>
</div>
@endsection
