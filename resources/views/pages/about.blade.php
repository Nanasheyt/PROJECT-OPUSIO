@extends('layouts.app')
@section('title', 'About')
@section('content')
<div class="head"><div><h1>About Opusio</h1><p class="sub">A simple way to turn your details into a portfolio page that looks good on every screen.</p></div></div>
<div class="prose">
    <h2>What Opusio does</h2>
    <p>Opusio takes the information you would put on a résumé or personal website, such as who you are, where you studied, what you can do, what you have built and where people can find you, and presents it in a clean, shareable page.</p>
    <p>You enter your information once. From then on you can preview it in three different templates, switch between them, update your details, or delete the portfolio entirely.</p>

    <h2>What goes into a portfolio</h2>
    <ul>
        <li><strong>Profile:</strong> name, professional title, about me, contact details and an optional photo.</li>
        <li><strong>Education:</strong> schools, degrees or courses, years and notes.</li>
        <li><strong>Skills:</strong> each with a level from Beginner to Expert.</li>
        <li><strong>Certificates:</strong> photos of your certificates, up to ten, shown as a gallery that opens full size.</li>
        <li><strong>Projects:</strong> title, description, technologies used and a link.</li>
        <li><strong>Work experience:</strong> company, position, dates and responsibilities.</li>
        <li><strong>Links:</strong> GitHub, LinkedIn, social media or your own website.</li>
    </ul>

    <h2>The three templates</h2>
    <ul>
        <li><strong>Formal:</strong> a classic executive résumé in navy and gold, with a print-friendly layout. Best for job applications.</li>
        <li><strong>Modern:</strong> frosted-glass cards on a soft gradient with a section menu. Best for designers and developers.</li>
        <li><strong>Aesthetic:</strong> a cyber-tech look with neon colours that slowly shift, and a pause button. Best for tech creators.</li>
    </ul>

    <h2>How it is built</h2>
    <p>Opusio is a Laravel web application. Portfolio data is stored in a PostgreSQL database hosted on Supabase, split into related tables for the profile, education, skills, projects, experience, certificates and links. Deleting a portfolio removes all of its related rows automatically.</p>

    <h2>Design principles</h2>
    <ul>
        <li><strong>Works everywhere:</strong> layouts adapt to phones, tablets and desktops.</li>
        <li><strong>Easy to read:</strong> high-contrast text, clear focus outlines and keyboard-friendly forms with helpful error messages.</li>
        <li><strong>Your choice of theme:</strong> light and dark mode for the app and for each template, with motion kept optional.</li>
    </ul>

    <div class="callout"><strong>Good to know:</strong> you need an account to create and manage portfolios, and each portfolio is private to the account that made it. Anyone with a portfolio's public link can view it, but cannot edit it.</div>
    <div class="actions"><a class="btn cta" href="{{ route('portfolios.create') }}">Create portfolio <x-icon name="arrow" /></a>
        <a class="btn ghost" href="{{ route('faq') }}">Read the FAQ</a></div>
</div>
@include('partials.team')
@endsection
