@extends('layouts.app')
@section('title', 'Forgot password')
@section('own_errors', '1')
@section('content')
<div class="auth-wrap">
    <h1>Forgot your password?</h1>
    <p class="sub">Enter the email of your account and we will send you a link to choose a new password.</p>

    <form method="POST" action="{{ route('password.email') }}" class="card stack" novalidate>
        @csrf
        <x-field name="email" label="Email" type="email" :value="old('email')" required autocomplete="email" maxlength="150" />
        <button class="btn cta lg" type="submit" data-busy="Sending…" style="width:100%">Send reset link</button>
    </form>

    <p class="auth-alt">Remembered it? <a href="{{ route('login') }}">Back to log in</a></p>
</div>
@endsection
