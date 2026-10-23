<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@include('partials.portfolio-theme-head')
<title>{{ $portfolio->full_name }} – Portfolio</title>
<meta name="description" content="{{ $portfolio->about ?? 'Professional portfolio of ' . $portfolio->full_name }}">
<meta property="og:title" content="{{ $portfolio->full_name }} – Portfolio">
<meta property="og:description" content="{{ $portfolio->about ?? 'Professional portfolio of ' . $portfolio->full_name }}">
<meta property="og:type" content="profile">
@if ($portfolio->profile_picture)
<meta property="og:image" content="{{ $portfolio->profile_picture }}">
@endif
<meta property="og:url" content="{{ request()->url() }}">
<meta name="twitter:card" content="summary_large_image">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Lato:wght@400;700&display=swap" rel="stylesheet">
<style>
/* Template 1 – Formal. Classic executive résumé: navy sidebar, gold accents, serif headings, print-friendly. */
*,*::before,*::after{box-sizing:border-box}
:root{--page:#E9EDF3;--paper:#fff;--side:#14284B;--on-side:#fff;--side-mut:#C9D3E6;--side-gold:#E3C57A;--ink:#1B2430;--mut:#4A5568;--gold:#8A6A1F;--gold-d:#B8903A;--rule:#D5DBE5;
    --serif:'EB Garamond',Georgia,'Times New Roman',serif;--sans:Lato,system-ui,-apple-system,'Segoe UI',sans-serif;color-scheme:light}
:root[data-theme=dark]{color-scheme:dark;--page:#080C14;--paper:#121A29;--side:#0A1120;--on-side:#F2F5FA;--side-mut:#A9B6CE;--side-gold:#E3C57A;--ink:#E8ECF4;--mut:#A3AFC4;--gold:#D8B25A;--gold-d:#C9A24D;--rule:#2A364D}
html{font-size:clamp(15px,14px + .35vw,18px);-webkit-text-size-adjust:100%}img{max-width:100%}
body{margin:0;background:var(--page);color:var(--ink);font:400 1rem/1.65 var(--sans);overflow-wrap:break-word}
a{color:inherit;text-underline-offset:3px;text-decoration-color:var(--gold-d)}a:hover{color:var(--gold)}
:focus-visible{outline:3px solid var(--gold-d);outline-offset:3px}
.skip{position:absolute;left:12px;top:-70px;background:var(--side);color:var(--on-side);padding:8px 14px;z-index:9}.skip:focus{top:12px}
.sr-only{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap}
.tt-bar{max-width:1040px;margin:0 auto;padding:16px 20px 0;display:flex;justify-content:flex-end}
.tt{width:44px;height:44px;border-radius:8px;border:1px solid var(--rule);background:var(--paper);color:var(--ink)}.tt:hover{border-color:var(--gold-d)}
.sheet{max-width:1040px;margin:16px auto 40px;display:grid;grid-template-columns:310px 1fr;background:var(--paper);box-shadow:0 12px 40px rgba(10,20,40,.18)}
.side{background:var(--side);color:var(--on-side);padding:40px 28px}
.pic{width:100%;max-width:200px;aspect-ratio:1;object-fit:cover;border:3px solid var(--gold-d);display:block;margin:0 auto 32px;background:var(--side)}
.pic.ph{display:grid;place-items:center;font:600 3.5rem var(--serif);color:var(--side-gold);border-color:var(--gold-d)}
.side h2{font:700 .8125rem var(--sans);letter-spacing:.18em;text-transform:uppercase;color:var(--side-gold);margin:28px 0 12px;padding-bottom:8px;border-bottom:1px solid rgba(255,255,255,.22)}
.side ul{list-style:none;margin:0;padding:0;display:grid;gap:12px}
.side li{display:flex;gap:10px;align-items:flex-start;font-size:.9375rem;color:var(--side-mut);overflow-wrap:anywhere}
.side li .ico{margin-top:4px;color:var(--side-gold)}
.side a{color:var(--on-side)}.side a:hover{color:var(--side-gold)}
.side li.sk{display:block}.sk b{display:block;font-weight:700;color:var(--on-side);font-size:.9375rem}
.sk .lv{display:flex;align-items:center;justify-content:space-between;gap:8px;font-size:.8125rem;color:var(--side-mut)}
.dots{display:flex;gap:4px}.dots i{width:9px;height:9px;border-radius:50%;border:1.5px solid var(--side-gold)}.dots i.on{background:var(--side-gold)}
.main{padding:48px 44px}
h1{font:600 clamp(2.25rem,5vw,3.25rem)/1.05 var(--serif);letter-spacing:.04em;text-transform:uppercase;margin:0;overflow-wrap:anywhere}
.role{font:italic 400 1.5rem var(--serif);color:var(--gold);margin:8px 0 0}
.rule{width:72px;height:3px;background:var(--gold-d);margin:22px 0 0}
h2.sec{font:600 1.625rem var(--serif);letter-spacing:.02em;margin:40px 0 18px;padding-bottom:6px;border-bottom:1px solid var(--rule)}
.about{margin:0;font-size:1.0625rem;max-width:68ch}
.e{margin-bottom:24px}.e:last-child{margin-bottom:0}
.e-top{display:flex;justify-content:space-between;align-items:baseline;gap:4px 16px;flex-wrap:wrap}
.e h3{font:700 1.25rem var(--serif);margin:0}
.when{font:700 .75rem var(--sans);letter-spacing:.1em;text-transform:uppercase;color:var(--mut)}
.org{font:italic 500 1.0625rem var(--serif);color:var(--gold);margin:0}
.e p.d{margin:6px 0 0;max-width:68ch}
.tech{font-size:.875rem;color:var(--mut);margin-top:4px}
footer{text-align:center;color:var(--mut);font-size:.8125rem;padding:0 20px 32px}
@media(max-width:820px){.sheet{grid-template-columns:1fr;margin:12px}.side{padding:32px 24px}.main{padding:32px 24px}.tt-bar{padding:12px 12px 0}}
@media print{body{background:#fff}.tt-bar,.skip,footer{display:none}.sheet{box-shadow:none;margin:0;max-width:none}*{-webkit-print-color-adjust:exact;print-color-adjust:exact}}
#loader{--ld-bg:var(--page);--ld-fg:var(--ink);--ld-a:#14284B;--ld-b:#B8903A;--ld-c:#E3C57A}:root[data-theme=dark] #loader{--ld-a:#E3C57A;--ld-b:#C9A24D;--ld-c:#A9B6CE}
:root{--pi-bg:var(--paper);--pi-fg:var(--ink);--pi-r:2px;--pi-edge:var(--gold-d)}
@media (hover:hover){.e{transition:transform .2s ease}.e:hover{transform:translateX(5px)}.side li a:hover,.main a:hover{text-decoration-thickness:2px}.pic{transition:transform .25s ease}.pic:hover{transform:scale(1.03)}}
</style>
</head>
<body>
@include('partials.portfolio-loader')
<a class="skip" href="#content">Skip to content</a>
@include('partials.portfolio-theme-button')
<div class="sheet">
    <aside class="side" aria-label="Contact and skills">
        @if ($portfolio->profile_picture)<img class="pic" src="{{ $portfolio->profile_picture }}" alt="Portrait of {{ $portfolio->full_name }}">
        @else<div class="pic ph" aria-hidden="true">{{ $portfolio->initials }}</div>@endif

        <h2>Contact</h2>
        <ul>
            <li><x-icon name="mail" :size="16" /><a href="mailto:{{ $portfolio->email }}">{{ $portfolio->email }}</a></li>
            <li><x-icon name="phone" :size="16" /><span>{{ $portfolio->phone }}</span></li>
            <li><x-icon name="pin" :size="16" /><span>{{ $portfolio->address }}</span></li>
        </ul>

        @if ($portfolio->socialLinks->count())
            <h2>Online</h2>
            <ul>@foreach ($portfolio->socialLinks as $l)
                <li><x-icon name="link" :size="16" /><a href="{{ $l->url }}" target="_blank" rel="noopener">{{ $l->platform }}<span class="sr-only"> (opens in a new tab)</span></a></li>
            @endforeach</ul>
        @endif

        @if ($portfolio->skills->count())
            <h2>Skills</h2>
            <ul>@foreach ($portfolio->skills as $s)
                @php $dots = max(1, min(5, (int) round($s->percent / 20))); @endphp
                <li class="sk"><b>{{ $s->name }}</b>
                    <span class="lv"><span>{{ $s->level }}</span>
                    <span class="dots" aria-hidden="true">@for ($i = 1; $i <= 5; $i++)<i class="{{ $i <= $dots ? 'on' : '' }}"></i>@endfor</span></span></li>
            @endforeach</ul>
        @endif
    </aside>

    <main class="main" id="content">
        <header>
            <h1>{{ $portfolio->full_name }}</h1>
            @if ($portfolio->job_title)<p class="role">{{ $portfolio->job_title }}</p>@endif
            <div class="rule"></div>
        </header>

        <section aria-labelledby="f-about"><h2 class="sec" id="f-about">Professional Profile</h2><p class="about">{!! nl2br(e($portfolio->about)) !!}</p></section>

        @if ($portfolio->experiences->count())
        <section aria-labelledby="f-exp"><h2 class="sec" id="f-exp">Professional Experience</h2>
            @foreach ($portfolio->experiences as $x)
                <article class="e">
                    <div class="e-top"><h3>{{ $x->position }}</h3>
                        @if ($x->start_date || $x->end_date)<span class="when">{{ $x->start_date }}{{ $x->start_date && $x->end_date ? ' – ' : '' }}{{ $x->end_date }}</span>@endif</div>
                    <p class="org">{{ $x->company }}</p>
                    @if ($x->description)<p class="d">{!! nl2br(e($x->description)) !!}</p>@endif
                </article>
            @endforeach
        </section>
        @endif

        @if ($portfolio->educations->count())
        <section aria-labelledby="f-edu"><h2 class="sec" id="f-edu">Education</h2>
            @foreach ($portfolio->educations as $e)
                <article class="e">
                    <div class="e-top"><h3>{{ $e->degree }}</h3>
                        @if ($e->start_year || $e->end_year)<span class="when">{{ $e->start_year }}{{ $e->start_year && $e->end_year ? ' – ' : '' }}{{ $e->end_year }}</span>@endif</div>
                    <p class="org">{{ $e->school }}</p>
                    @if ($e->description)<p class="d">{{ $e->description }}</p>@endif
                </article>
            @endforeach
        </section>
        @endif

        @if ($portfolio->certificates->count())
        <section aria-labelledby="f-cert"><h2 class="sec" id="f-cert">Certificates</h2>
            @include('partials.portfolio-gallery')
        </section>
        @endif

        @if ($portfolio->projects->count())
        <section aria-labelledby="f-proj"><h2 class="sec" id="f-proj">Selected Projects</h2>
            @foreach ($portfolio->projects as $p)
                <article class="e">
                    <div class="e-top"><h3>@if ($p->url)<a href="{{ $p->url }}" target="_blank" rel="noopener">{{ $p->title }}<span class="sr-only"> (opens in a new tab)</span></a>@else{{ $p->title }}@endif</h3></div>
                    @if ($p->tech)<div class="tech">{{ $p->tech }}</div>@endif
                    @if ($p->description)<p class="d">{{ $p->description }}</p>@endif
                </article>
            @endforeach
        </section>
        @endif

        @if ($portfolio->testimonials->count())
        <section aria-labelledby="f-test"><h2 class="sec" id="f-test">Testimonials</h2>
            @foreach ($portfolio->testimonials as $t)
                <article class="e" style="font-style:italic">
                    <p class="d" style="margin:0;font-size:1.0625rem">"{{ $t->quote }}"</p>
                    <div class="meta" style="margin-top:8px;font-style:normal;font-size:.9375rem">— {{ $t->author }}, {{ $t->role }}</div>
                </article>
            @endforeach
        </section>
        @endif

        @if ($portfolio->publications->count())
        <section aria-labelledby="f-pub"><h2 class="sec" id="f-pub">Publications</h2>
            @foreach ($portfolio->publications as $p)
                <article class="e">
                    <div class="e-top"><h3>{{ $p->title }}</h3></div>
                    <p class="org">{{ $p->venue }}@if ($p->year) &middot; {{ $p->year }}@endif</p>
                    @if ($p->url)<a class="go" href="{{ $p->url }}" target="_blank" rel="noopener">Read <x-icon name="external" :size="14" /><span class="sr-only"> (opens in a new tab)</span></a>@endif
                </article>
            @endforeach
        </section>
        @endif

        @if ($portfolio->languages->count())
        <section aria-labelledby="f-lang"><h2 class="sec" id="f-lang">Languages</h2>
            @foreach ($portfolio->languages as $l)
                <article class="e">
                    <div class="e-top"><h3>{{ $l->name }}</h3></div>
                    <p class="org">{{ $l->proficiency }} @if ($l->percent)({{ $l->percent }}%)@endif</p>
                </article>
            @endforeach
        </section>
        @endif
    </main>
</div>
<footer>&copy; {{ date('Y') }} {{ $portfolio->full_name }}</footer>
@include('partials.portfolio-interactions')
@include('partials.portfolio-theme-script')
</body>
</html>
