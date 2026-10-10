@extends('layouts.app')
@section('title', 'Build your portfolio online')
@section('wrapclass', 'home')
@section('content')
<section class="hero" aria-labelledby="hero-t">
    <div class="stripes" aria-hidden="true"><i></i><i></i><i></i></div>
    <div class="gridbg" aria-hidden="true"></div>

    <span class="bubble b1" aria-hidden="true"><svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><circle cx="32" cy="24" r="11" fill="currentColor"/><path d="M10 62c2-15 12-21 22-21s20 6 22 21z" fill="currentColor"/></svg></span>
    <span class="bubble b2" aria-hidden="true"><svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><circle cx="32" cy="24" r="11" fill="currentColor"/><path d="M10 62c2-15 12-21 22-21s20 6 22 21z" fill="currentColor"/></svg></span>
    <span class="bubble b3" aria-hidden="true"><svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><circle cx="32" cy="24" r="11" fill="currentColor"/><path d="M10 62c2-15 12-21 22-21s20 6 22 21z" fill="currentColor"/></svg></span>
    <svg class="arrow a1" viewBox="0 0 90 190" aria-hidden="true" focusable="false"><path d="M6 6C-12 92 18 150 76 182"/><path d="M58 182l20 2-8-18" stroke-dasharray="none"/></svg>
    <svg class="arrow a2" viewBox="0 0 90 190" aria-hidden="true" focusable="false"><path d="M6 6C-12 92 18 150 76 182"/><path d="M58 182l20 2-8-18" stroke-dasharray="none"/></svg>

    <a class="join" href="{{ route('portfolios.create') }}">
        <svg viewBox="0 0 140 140" aria-hidden="true" focusable="false"><path d="M135.5 70.0 L135.2 71.6 L134.2 73.1 L132.7 74.6 L130.9 75.9 L128.9 77.2 L127.0 78.3 L125.3 79.4 L124.0 80.6 L123.2 81.8 L123.1 83.1 L123.5 84.6 L124.3 86.2 L125.4 88.0 L126.7 90.0 L127.9 92.0 L128.9 94.0 L129.4 95.9 L129.3 97.6 L128.7 99.0 L127.4 100.1 L125.7 101.0 L123.6 101.5 L121.3 101.9 L119.0 102.1 L116.8 102.3 L114.9 102.7 L113.5 103.2 L112.5 104.1 L112.0 105.4 L111.8 107.1 L112.0 109.0 L112.3 111.3 L112.6 113.6 L112.7 115.9 L112.5 118.0 L112.0 119.8 L111.0 121.1 L109.6 121.9 L107.9 122.1 L105.9 122.0 L103.7 121.4 L101.4 120.6 L99.3 119.8 L97.3 119.2 L95.6 118.8 L94.2 118.9 L93.0 119.5 L92.1 120.7 L91.3 122.3 L90.6 124.3 L89.9 126.5 L89.1 128.7 L88.1 130.7 L87.0 132.3 L85.6 133.4 L84.1 133.9 L82.5 133.8 L80.8 133.0 L79.0 131.8 L77.3 130.2 L75.7 128.5 L74.1 126.9 L72.7 125.6 L71.3 124.8 L70.0 124.5 L68.7 124.8 L67.3 125.6 L65.9 126.9 L64.3 128.5 L62.7 130.2 L61.0 131.8 L59.2 133.0 L57.5 133.8 L55.9 133.9 L54.4 133.4 L53.0 132.3 L51.9 130.7 L50.9 128.7 L50.1 126.5 L49.4 124.3 L48.7 122.3 L47.9 120.7 L47.0 119.5 L45.8 118.9 L44.4 118.8 L42.7 119.2 L40.7 119.8 L38.6 120.6 L36.3 121.4 L34.1 122.0 L32.1 122.1 L30.4 121.9 L29.0 121.1 L28.0 119.8 L27.5 118.0 L27.3 115.9 L27.4 113.6 L27.7 111.3 L28.0 109.0 L28.2 107.1 L28.0 105.4 L27.5 104.1 L26.5 103.2 L25.1 102.7 L23.2 102.3 L21.0 102.1 L18.7 101.9 L16.4 101.5 L14.3 101.0 L12.6 100.1 L11.3 99.0 L10.7 97.6 L10.6 95.9 L11.1 94.0 L12.1 92.0 L13.3 90.0 L14.6 88.0 L15.7 86.2 L16.5 84.6 L16.9 83.1 L16.8 81.8 L16.0 80.6 L14.7 79.4 L13.0 78.3 L11.1 77.2 L9.1 75.9 L7.3 74.6 L5.8 73.1 L4.8 71.6 L4.5 70.0 L4.8 68.4 L5.8 66.9 L7.3 65.4 L9.1 64.1 L11.1 62.8 L13.0 61.7 L14.7 60.6 L16.0 59.4 L16.8 58.2 L16.9 56.9 L16.5 55.4 L15.7 53.8 L14.6 52.0 L13.3 50.0 L12.1 48.0 L11.1 46.0 L10.6 44.1 L10.7 42.4 L11.3 41.0 L12.6 39.9 L14.3 39.0 L16.4 38.5 L18.7 38.1 L21.0 37.9 L23.2 37.7 L25.1 37.3 L26.5 36.8 L27.5 35.9 L28.0 34.6 L28.2 32.9 L28.0 31.0 L27.7 28.7 L27.4 26.4 L27.3 24.1 L27.5 22.0 L28.0 20.2 L29.0 18.9 L30.4 18.1 L32.1 17.9 L34.1 18.0 L36.3 18.6 L38.6 19.4 L40.7 20.2 L42.7 20.8 L44.4 21.2 L45.8 21.1 L47.0 20.5 L47.9 19.3 L48.7 17.7 L49.4 15.7 L50.1 13.5 L50.9 11.3 L51.9 9.3 L53.0 7.7 L54.4 6.6 L55.9 6.1 L57.5 6.2 L59.2 7.0 L61.0 8.2 L62.7 9.8 L64.3 11.5 L65.9 13.1 L67.3 14.4 L68.7 15.2 L70.0 15.5 L71.3 15.2 L72.7 14.4 L74.1 13.1 L75.7 11.5 L77.3 9.8 L79.0 8.2 L80.8 7.0 L82.5 6.2 L84.1 6.1 L85.6 6.6 L87.0 7.7 L88.1 9.3 L89.1 11.3 L89.9 13.5 L90.6 15.7 L91.3 17.7 L92.1 19.3 L93.0 20.5 L94.2 21.1 L95.6 21.2 L97.3 20.8 L99.3 20.2 L101.4 19.4 L103.7 18.6 L105.9 18.0 L107.9 17.9 L109.6 18.1 L111.0 18.9 L112.0 20.2 L112.5 22.0 L112.7 24.1 L112.6 26.4 L112.3 28.7 L112.0 31.0 L111.8 32.9 L112.0 34.6 L112.5 35.9 L113.5 36.8 L114.9 37.3 L116.8 37.7 L119.0 37.9 L121.3 38.1 L123.6 38.5 L125.7 39.0 L127.4 39.9 L128.7 41.0 L129.3 42.4 L129.4 44.1 L128.9 46.0 L127.9 48.0 L126.7 50.0 L125.4 52.0 L124.3 53.8 L123.5 55.4 L123.1 56.9 L123.2 58.2 L124.0 59.4 L125.3 60.6 L127.0 61.7 L128.9 62.8 L130.9 64.1 L132.7 65.4 L134.2 66.9 L135.2 68.4 Z"/></svg>
        <span>Join us now<span class="sr"> – create your portfolio</span></span>
    </a>

    <p class="pill"><x-icon name="asterisk" :size="16" /> Portfolio platform</p>
    <h1 class="mega" id="hero-t"><span>Portfolios</span><span>that <span class="alt">w</span>ork</span><span>for y<span class="alt">o</span>u</span></h1>
    <p class="lead">Fill in your details once, pick a design, and get a portfolio page you can preview, edit and share.</p>
    <div class="actions" style="justify-content:center">
        <a class="btn cta lg" href="{{ route('portfolios.create') }}">Create portfolio <x-icon name="arrow" /></a>
        <a class="btn ghost lg" href="{{ route('portfolios.index') }}">Manage portfolios</a>
    </div>

    <div class="stats">
        <div class="stat-side">
            <p class="say">Fill it in once. Switch designs whenever you like.</p>
            <p class="names" aria-label="Templates"><span>Formal</span><span>Modern</span><span>Aesthetic</span></p>
        </div>
        <div class="statcard">
            <b>3</b>
            <p>ready-made templates, each with its own light and dark mode.</p>
        </div>
        <div class="stat-side">
            <div class="dots" aria-hidden="true"><i></i><i></i><i></i></div>
            <p class="say"><strong>Saved online</strong> in your own cloud database, so it works on any device.</p>
            <a class="uline" href="#how">See how it works</a>
        </div>
    </div>
</section>

{{-- Real facts only (counts come from the app itself) --}}
<ul class="facts" aria-label="Opusio at a glance">
    <li><b>3</b><span>ready-made templates</span></li>
    <li><b>7</b><span>portfolio sections</span></li>
    <li><b>2</b><span>themes: light and dark</span></li>
    @if (($portfolioCount ?? 0) > 0)
        <li><b>{{ number_format($portfolioCount) }}</b><span>{{ $portfolioCount === 1 ? 'portfolio created' : 'portfolios created' }}</span></li>
    @else
        <li><b>1</b><span>shareable link per portfolio</span></li>
    @endif
</ul>

<section class="band caps" id="how" aria-labelledby="how-t">
    <h2 class="title" id="how-t">How it works?</h2>
    <p class="sub">Four steps from a blank form to a finished portfolio.</p>
    <ol class="steps">
        <li><div class="n" aria-hidden="true">1</div><h3>Enter your information</h3><p>Profile, education, skills, projects, experience and links in one guided form, with an optional photo up to 5 MB.</p></li>
        <li><div class="n" aria-hidden="true">2</div><h3>Save it online</h3><p>Your details are stored in a cloud database the moment you save, so nothing is lost if you close the tab.</p></li>
        <li><div class="n" aria-hidden="true">3</div><h3>Choose a template</h3><p>See live previews built from your own data and pick Formal, Modern or Aesthetic.</p></li>
        <li><div class="n" aria-hidden="true">4</div><h3>Preview, edit and share</h3><p>Open the full page, share its link, change anything later, or delete it from the Manage page.</p></li>
    </ol>
</section>

<section class="band caps" aria-labelledby="what-t">
    <h2 class="title" id="what-t">What goes into your portfolio?</h2>
    <p class="sub">Seven sections cover everything a visitor, recruiter or client wants to know.</p>
    <ul class="feat what">
        <li><div class="fi"><x-icon name="user" /></div><h3>Profile</h3><p>Name, professional title, a short "About me", contact details and an optional photo.</p></li>
        <li><div class="fi"><x-icon name="cap" /></div><h3>Education</h3><p>Schools, degrees or courses, with years and a note about what you studied.</p></li>
        <li><div class="fi"><x-icon name="zap" /></div><h3>Skills</h3><p>List what you can do and rate each skill from Beginner to Expert.</p></li>
        <li><div class="fi"><x-icon name="award" /></div><h3>Certificates</h3><p>Upload photos of your certificates, up to ten, and visitors can tap any one to view it full size.</p></li>
        <li><div class="fi"><x-icon name="folder" /></div><h3>Projects</h3><p>Show what you have built with a description, the technologies used and a link.</p></li>
        <li><div class="fi"><x-icon name="briefcase" /></div><h3>Work experience</h3><p>Companies, positions, dates and your responsibilities or achievements.</p></li>
        <li><div class="fi"><x-icon name="link" /></div><h3>Links</h3><p>GitHub, LinkedIn, social media or your own website, all in one place.</p></li>
    </ul>
</section>

<section class="band" id="templates" aria-labelledby="tpl-t">
    <h2 class="title" id="tpl-t">Three templates, three styles</h2>
    <p class="sub">Every template is generated from the same saved information, so you can switch at any time.</p>
    <div class="mocks">
        <figure class="mock m-formal" style="margin:0">
            <div class="scr" aria-hidden="true">
                <div class="sd"><i style="height:30px;width:30px;border-radius:0"></i><i class="g" style="width:50%"></i><i></i><i style="width:80%"></i><i class="g" style="width:50%"></i><i style="width:70%"></i></div>
                <div class="mn"><i class="k"></i><i class="g"></i><i style="margin-top:6px"></i><i style="width:92%"></i><i style="width:80%"></i><i style="width:90%;margin-top:6px"></i><i style="width:60%"></i></div>
            </div>
            <figcaption>Formal <span>Classic executive résumé in navy and gold, ready to print. Best for job applications.</span></figcaption>
        </figure>
        <figure class="mock m-glass" style="margin:0">
            <div class="scr" aria-hidden="true"><i style="grid-column:span 2;height:44px"></i><i></i><i></i><i style="grid-column:span 2"></i></div>
            <figcaption>Modern <span>Frosted glass over a soft gradient with a section menu. Best for designers and developers.</span></figcaption>
        </figure>
        <figure class="mock m-cyber" style="margin:0">
            <div class="scr" aria-hidden="true"><i style="height:26px"></i><i class="p" style="width:60%"></i><i></i><i class="p" style="width:80%"></i><i style="width:45%"></i></div>
            <figcaption>Aesthetic <span>Cyber-tech neon that slowly changes colour, with a pause button. Best for tech creators.</span></figcaption>
        </figure>
    </div>
</section>

<section class="band caps" aria-labelledby="who-t">
    <h2 class="title" id="who-t">Who is it for?</h2>
    <p class="sub">Anyone who needs a clear online profile without building a website from scratch.</p>
    <ul class="feat who">
        <li><div class="fi"><x-icon name="cap" /></div><h3>Students and graduates</h3><p>Show your studies, projects and skills to schools, internships and first employers.</p></li>
        <li><div class="fi"><x-icon name="layout" /></div><h3>Freelancers and creatives</h3><p>Present your best work and the ways clients can reach you in one tidy page.</p></li>
        <li><div class="fi"><x-icon name="briefcase" /></div><h3>Job seekers</h3><p>Turn your résumé into a link you can put on an application, and print it when you need to.</p></li>
    </ul>
</section>

<section class="band" id="features" aria-labelledby="feat-t">
    <h2 class="title" id="feat-t">Built to be used</h2>
    <p class="sub">The details that make Opusio dependable.</p>
    <ul class="feat">
        <li><div class="fi"><x-icon name="database" /></div><h3>Cloud database</h3><p>Portfolios are stored in Supabase PostgreSQL, in related tables, so they are there when you come back.</p></li>
        <li><div class="fi"><x-icon name="pencil" /></div><h3>Edit any time</h3><p>Change your details or switch template whenever you like, or delete a portfolio for good.</p></li>
        <li><div class="fi"><x-icon name="link" /></div><h3>One link to share</h3><p>Each portfolio gets its own page that opens on any device, with no account needed to view it.</p></li>
        <li><div class="fi"><x-icon name="layout" /></div><h3>Every screen size</h3><p>Phones, tablets and desktops, with touch-friendly buttons.</p></li>
        <li><div class="fi"><x-icon name="moon" /></div><h3>Light and dark mode</h3><p>The app and each template have their own theme button, and remember your choice.</p></li>
        <li><div class="fi"><x-icon name="eye" /></div><h3>Easy to read</h3><p>High-contrast text, clear focus outlines, keyboard-friendly forms and optional motion.</p></li>
    </ul>
</section>

<section class="band" aria-labelledby="tech-t">
    <h2 class="title" id="tech-t">Under the hood</h2>
    <p class="sub">Opusio is a Laravel application backed by a cloud PostgreSQL database.</p>
    <ul class="chips" aria-label="Technology">
        <li>Laravel</li><li>PostgreSQL</li><li>Supabase</li><li>Blade templates</li><li>Responsive CSS</li><li>Light and dark themes</li><li>Keyboard accessible</li>
    </ul>
</section>

<section class="band" aria-labelledby="faq-t">
    <h2 class="title" id="faq-t">Questions, answered</h2>
    <p class="sub">The short version of how Opusio works.</p>
    @include('partials.faq', ['limit' => 5])
    <p class="more"><a class="uline" href="{{ route('faq') }}">See all questions</a></p>
</section>

<section class="cta-band" aria-labelledby="cta-t">
    <h2 id="cta-t">Ready to see yourself online?</h2>
    <p>It only takes a few minutes, and you can change everything later.</p>
    <a class="btn cta lg" href="{{ route('portfolios.create') }}">Create portfolio <x-icon name="arrow" /></a>
</section>

@include('partials.team')
@endsection
