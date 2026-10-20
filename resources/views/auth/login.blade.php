@extends('layouts.app')
@section('title', 'Log in')
@section('own_errors', '1')
@section('content')
<div class="auth-wrap">
    <h1>Log in</h1>
    <p class="sub">Welcome back. Log in to create, edit and manage your portfolios.</p>

    <form method="POST" action="{{ route('login') }}" class="card stack" novalidate>
        @csrf
        <x-field name="email" label="Email" type="email" :value="old('email')" required autocomplete="email" maxlength="150" />
        <x-field name="password" label="Password" type="password" required autocomplete="current-password" maxlength="100" />
        <p class="forgot"><a href="{{ route('password.request') }}">Forgot password?</a></p>
        <label class="check"><input type="checkbox" name="remember" value="1"> Keep me logged in on this device</label>
        <button class="btn cta lg" type="submit" data-busy="Logging in…" style="width:100%">Log in</button>
    </form>

    <p class="auth-alt">New to Opusio? <a href="{{ route('register') }}">Create an account</a></p>
    <p class="auth-note"><x-icon name="eye" :size="18" /> <span>Your portfolios are private to your account. People you share a link with can view your portfolio, but can never edit it.</span></p>
</div>
@endsection
