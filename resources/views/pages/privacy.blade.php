@extends('layouts.app')
@section('title', 'Privacy and data')
@section('content')
<div class="head"><div><h1>Privacy and data</h1><p class="sub">What Opusio stores, where it lives and how to remove it.</p></div></div>
<div class="prose">
    <h2>What is stored</h2>
    <p>Only what you type into the portfolio form is saved:</p>
    <ul>
        <li>Your name, professional title, email, phone number, address and the "About me" text.</li>
        <li>Optionally, your profile photo (a resized copy is stored in the database).</li>
        <li>Your education, skills, projects, work experience and links.</li>
        <li>Optionally, up to ten certificate photos (resized copies are stored in the database).</li>
        <li>The template you chose, and the time the portfolio was created and last updated.</li>
    </ul>

    <h2>Where it is stored</h2>
    <p>Everything is kept in a PostgreSQL database hosted on Supabase. The tables are protected with Row Level Security, so they cannot be read through Supabase's public API key. The application connects with its own database credentials.</p>

    <h2>Who can see it</h2>
    <p>A portfolio is visible to anyone who has its link. This version has no login, so the Manage page lists every portfolio on the site. Only enter details you are happy to share, and delete your portfolio when you no longer need it.</p>

    <h2>Cookies and browser storage</h2>
    <ul>
        <li>The site uses essential cookies that Laravel needs to keep forms secure and working.</li>
        <li>Your light or dark mode choice, and the Aesthetic template's pause choice, are saved in your browser only.</li>
        <li>Opusio includes no advertising or analytics scripts.</li>
        <li>Fonts are loaded from Google Fonts, so your browser contacts Google to download them.</li>
    </ul>

    <h2>Deleting your data</h2>
    <p>Open <a href="{{ route('portfolios.index') }}">Manage</a> and choose Delete on your portfolio. It permanently removes the portfolio and everything attached to it from the database.</p>
    <p class="muted">For questions about this installation, contact the person or team who runs this site.</p>
</div>
@endsection
