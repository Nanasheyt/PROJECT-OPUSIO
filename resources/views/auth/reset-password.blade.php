@extends('layouts.app')
@section('title', 'Reset password')
@section('own_errors', '1')
@section('content')
<div class="auth-wrap">
    <h1>Choose a new password</h1>
    <p class="sub">Enter a new password for your account.</p>

    <form method="POST" action="{{ route('password.update') }}" class="card stack" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <x-field name="email" label="Email" type="email" :value="old('email', $email)" required autocomplete="email" maxlength="150" />
        <x-field name="password" label="New password" type="password" required autocomplete="new-password" maxlength="100" hint="At least 8 characters." />
        <x-field name="password_confirmation" label="Confirm new password" type="password" required autocomplete="new-password" maxlength="100" />
        <button class="btn cta lg" type="submit" data-busy="Saving…" style="width:100%">Change password</button>
    </form>

    <p class="auth-alt"><a href="{{ route('login') }}">Back to log in</a></p>
</div>
@endsection
