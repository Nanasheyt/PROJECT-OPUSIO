<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@include('partials.portfolio-theme-head')
<title>{{ $portfolio->full_name }} – Portfolio</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
<style>
/* Template 2 – Modern. Glassmorphism: frosted cards over a soft gradient, sticky pill menu, gradient accents. */
*,*::before,*::after{box-sizing:border-box}
:root{--bg:#EEF2FF;--ink:#111827;--mut:#475569;--glass:rgba(255,255,255,.74);--glass-b:rgba(255,255,255,.8);--line:rgba(15,23,42,.1);
    --brand:#4F46E5;--brand2:#0891B2;--link:#4338CA;--chip:rgba(79,70,229,.1);--b1:#A5B4FC;--b2:#67E8F9;--b3:#F5D0FE;--blobs:.7;
    --sh:0 8px 30px rgba(49,46,129,.12);--grad:linear-gradient(90deg,#4F46E5,#0E7490);color-scheme:light}
:root[data-theme=dark]{color-scheme:dark;--bg:#0A0E1F;--ink:#F1F5F9;--mut:#A9B4C9;--glass:rgba(20,27,52,.74);--glass-b:rgba(255,255,255,.12);--line:rgba(255,255,255,.12);
    --brand:#818CF8;--brand2:#22D3EE;--link:#A5B4FC;--chip:rgba(129,140,248,.18);--b1:#3730A3;--b2:#0E7490;--b3:#86198F;--blobs:.55;
    --sh:0 8px 30px rgba(0,0,0,.45);--grad:linear-gradient(90deg,#A5B4FC,#67E8F9)}
html{font-size:clamp(15px,14px + .35vw,18px);-webkit-text-size-adjust:100%;scroll-padding-top:96px}img{max-width:100%}
body{margin:0;background:var(--bg);color:var(--ink);font:400 1rem/1.65 'Open Sans',system-ui,sans-serif;overflow-wrap:break-word;min-height:100vh}
body::before{content:"";position:fixed;inset:0;z-index:-1;opacity:var(--blobs);
    background:radial-gradient(45vmax 45vmax at 8% 4%,var(--b1),transparent 62%),radial-gradient(38vmax 38vmax at 94% 18%,var(--b2),transparent 62%),radial-gradient(45vmax 45vmax at 55% 105%,var(--b3),transparent 62%)}
a{color:var(--link);text-underline-offset:3px}
:focus-visible{outline:3px solid var(--link);outline-offset:3px;border-radius:8px}
.skip{position:absolute;left:12px;top:-70px;background:var(--brand);color:#fff;padding:8px 14px;border-radius:8px;z-index:99}.skip:focus{top:12px}
.sr-only{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap}
h1,h2,h3{font-family:Poppins,system-ui,sans-serif;margin:0;letter-spacing:-.01em}
.glass{background:var(--glass);border:1px solid var(--glass-b);border-radius:28px;backdrop-filter:blur(16px) saturate(140%);-webkit-backdrop-filter:blur(16px) saturate(140%);box-shadow:var(--sh)}
@supports not (backdrop-filter:blur(1px)){.glass{background:var(--bg)}}
.nav{position:sticky;top:12px;z-index:30;max-width:1120px;margin:12px auto 0;width:calc(100% - 24px);display:flex;align-items:center;gap:12px;padding:8px 8px 8px 22px;border-radius:99px}
.nav .brand{font:600 1rem Poppins,sans-serif;white-space:nowrap}
.nav ul{list-style:none;margin:0 0 0 auto;padding:0;display:flex;gap:4px;overflow-x:auto;scrollbar-width:none}
.nav ul a{display:inline-flex;align-items:center;min-height:44px;padding:0 14px;border-radius:99px;color:var(--ink);text-decoration:none;font-weight:600;font-size:.875rem;white-space:nowrap}
.nav ul a:hover{background:var(--chip)}
.tt{width:44px;height:44px;border-radius:50%;border:0;background:var(--chip);color:var(--ink);flex-shrink:0}.tt:hover{background:var(--glass-b)}
.wrap{max-width:1120px;margin:0 auto;padding:32px 12px 48px;display:grid;gap:24px}
.hero{display:grid;grid-template-columns:1.25fr .75fr;gap:32px;align-items:center;padding:48px}
.chip{display:inline-flex;align-items:center;gap:8px;background:var(--chip);color:var(--link);font:600 .875rem Poppins,sans-serif;padding:6px 16px;border-radius:99px}
h1{font-size:clamp(2.25rem,6vw,4rem);font-weight:700;line-height:1.05;margin:16px 0 0;overflow-wrap:anywhere}
.grad{background:var(--grad);-webkit-background-clip:text;background-clip:text;color:transparent}
@supports not (background-clip:text){.grad{color:var(--link)}}
.lead{margin:20px 0 0;font-size:1.125rem;color:var(--mut);max-width:58ch}
.contact{list-style:none;margin:24px 0 0;padding:0;display:flex;flex-wrap:wrap;gap:8px}
.contact li{display:flex;align-items:center;gap:8px;background:var(--chip);padding:8px 16px;border-radius:99px;font-size:.875rem}
.contact a{color:var(--ink)}
.social{display:flex;flex-wrap:wrap;gap:8px;margin-top:16px}
.social a{display:inline-flex;align-items:center;gap:8px;min-height:44px;padding:0 20px;border-radius:99px;background:var(--grad);color:#fff;font:600 .875rem Poppins,sans-serif;text-decoration:none}
:root[data-theme=dark] .social a{color:#0A0E1F}
.social a:hover{filter:brightness(1.1)}
.ph-wrap{justify-self:center;padding:5px;border-radius:36px;background:var(--grad)}
.pic{width:min(100%,300px);aspect-ratio:1;border-radius:32px;object-fit:cover;display:block;background:var(--bg)}
.pic.ph{display:grid;place-items:center;font:700 4rem Poppins;color:var(--link);width:min(70vw,300px)}
.sec{padding:36px}
.sec>h2{font-size:1.5rem;font-weight:600;margin-bottom:24px;display:flex;align-items:center;gap:12px}
.sec>h2::before{content:"";width:28px;height:6px;border-radius:6px;background:var(--grad)}
.sec p.t{margin:0;font-size:1.0625rem;max-width:72ch}
.tl{display:grid;gap:16px}
.card{background:var(--chip);border:1px solid var(--line);border-radius:20px;padding:20px 24px}
.card h3{font-size:1.125rem;font-weight:600}.meta{color:var(--mut);font-size:.875rem;margin-top:2px}.card p{margin:8px 0 0}
.two{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(320px,100%),1fr));gap:24px}
.skills{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(auto-fill,minmax(min(240px,100%),1fr));gap:16px 28px}
.skills .t{display:flex;justify-content:space-between;gap:12px;font-weight:600;font-size:.9375rem;margin-bottom:6px}.skills .t span{color:var(--mut);font-weight:500}
.track{height:8px;border-radius:8px;background:var(--line);overflow:hidden}.track i{display:block;height:100%;border-radius:8px;background:var(--grad)}
.pgrid{display:grid;grid-template-columns:repeat(auto-fill,minmax(min(300px,100%),1fr));gap:20px}
.proj{display:flex;flex-direction:column;gap:8px;transition:transform .25s ease,box-shadow .25s ease}
.proj:hover{transform:translateY(-4px);box-shadow:var(--sh)}
.proj a.go{margin-top:auto;display:inline-flex;align-items:center;gap:8px;min-height:44px;font-weight:600}
.tag{align-self:flex-start;background:var(--chip);color:var(--link);border-radius:99px;padding:2px 12px;font-size:.8125rem;font-weight:600}
footer{text-align:center;color:var(--mut);font-size:.8125rem;padding:0 20px 32px}
@media(max-width:860px){.hero{grid-template-columns:1fr;padding:28px}.ph-wrap{order:-1;justify-self:start}.sec{padding:24px}}
@media(max-width:640px){.nav ul{display:none}.nav .brand{flex:1}}
@media(hover:none){.proj:hover{transform:none;box-shadow:var(--sh)}}
@media(prefers-reduced-motion:reduce){.proj{transition:none}.proj:hover{transform:none}}
#loader{--ld-bg:var(--bg);--ld-fg:var(--ink);--ld-a:#4F46E5;--ld-b:#0891B2;--ld-c:#F0ABFC}:root[data-theme=dark] #loader{--ld-a:#818CF8;--ld-b:#22D3EE;--ld-c:#E879F9}
:root{--pi-bg:var(--bg);--pi-fg:var(--ink);--pi-r:18px;--pi-edge:var(--line)}
@media (hover:hover){.card{transition:transform .25s ease,box-shadow .25s ease}.card:hover{transform:translateY(-4px);box-shadow:var(--sh)}.social a{transition:transform .2s ease,filter .2s}.social a:hover{transform:translateY(-2px)}.contact li{transition:transform .2s}.contact li:hover{transform:translateY(-2px)}.ph-wrap{transition:transform .3s ease}.ph-wrap:hover{transform:rotate(-2deg) scale(1.03)}}
</style>
</head>
<body>
@include('partials.portfolio-loader')
<a class="skip" href="#content">Skip to content</a>
<header class="nav glass">
    <span class="brand">{{ \Illuminate\Support\Str::of($portfolio->full_name)->explode(' ')->first() }}</span>
    <nav aria-label="Sections"><ul>
        <li><a href="#about">About</a></li>
        @if ($portfolio->experiences->count())<li><a href="#experience">Experience</a></li>@endif
        @if ($portfolio->educations->count())<li><a href="#education">Education</a></li>@endif
        @if ($portfolio->skills->count())<li><a href="#skills">Skills</a></li>@endif
        @if ($portfolio->certificates->count())<li><a href="#certificates">Certificates</a></li>@endif
        @if ($portfolio->projects->count())<li><a href="#projects">Projects</a></li>@endif
    </ul></nav>
    <button type="button" class="tt" id="tt" aria-pressed="false" aria-label="Dark mode" title="Switch between light and dark mode">
        <x-icon name="moon" class="i-moon" /><x-icon name="sun" class="i-sun" />
    </button>
</header>

<main id="content" class="wrap">
    <section class="glass hero" aria-labelledby="m-name">
        <div>
            @if ($portfolio->job_title)<span class="chip">{{ $portfolio->job_title }}</span>@endif
            <h1 id="m-name" class="grad">{{ $portfolio->full_name }}</h1>
            <ul class="contact">
                <li><x-icon name="mail" :size="16" /><a href="mailto:{{ $portfolio->email }}">{{ $portfolio->email }}</a></li>
                <li><x-icon name="phone" :size="16" /><span>{{ $portfolio->phone }}</span></li>
                <li><x-icon name="pin" :size="16" /><span>{{ $portfolio->address }}</span></li>
            </ul>
            @if ($portfolio->socialLinks->count())
                <div class="social">@foreach ($portfolio->socialLinks as $l)<a href="{{ $l->url }}" target="_blank" rel="noopener">{{ $l->platform }} <x-icon name="external" :size="16" /><span class="sr-only"> (opens in a new tab)</span></a>@endforeach</div>
            @endif
        </div>
        <div class="ph-wrap">
            @if ($portfolio->profile_picture)<img class="pic" src="{{ $portfolio->profile_picture }}" alt="Portrait of {{ $portfolio->full_name }}">
            @else<div class="pic ph" aria-hidden="true">{{ $portfolio->initials }}</div>@endif
        </div>
    </section>

    <section class="glass sec" id="about" aria-labelledby="h-about"><h2 id="h-about">About me</h2><p class="t">{!! nl2br(e($portfolio->about)) !!}</p></section>

    @if ($portfolio->experiences->count())
    <section class="glass sec" id="experience" aria-labelledby="h-exp"><h2 id="h-exp">Experience</h2>
        <div class="tl">@foreach ($portfolio->experiences as $x)
            <article class="card"><h3>{{ $x->position }}</h3>
                <div class="meta">{{ $x->company }}@if ($x->start_date || $x->end_date) &middot; {{ $x->start_date }}{{ $x->start_date && $x->end_date ? ' – ' : '' }}{{ $x->end_date }}@endif</div>
                @if ($x->description)<p>{!! nl2br(e($x->description)) !!}</p>@endif</article>
        @endforeach</div></section>
    @endif

    @if ($portfolio->educations->count() || $portfolio->skills->count())
    <div class="two">
        @if ($portfolio->educations->count())
        <section class="glass sec" id="education" aria-labelledby="h-edu"><h2 id="h-edu">Education</h2>
            <div class="tl">@foreach ($portfolio->educations as $e)
                <article class="card"><h3>{{ $e->degree }}</h3>
                    <div class="meta">{{ $e->school }}@if ($e->start_year || $e->end_year) &middot; {{ $e->start_year }}{{ $e->start_year && $e->end_year ? ' – ' : '' }}{{ $e->end_year }}@endif</div>
                    @if ($e->description)<p>{{ $e->description }}</p>@endif</article>
            @endforeach</div></section>
        @endif
        @if ($portfolio->skills->count())
        <section class="glass sec" id="skills" aria-labelledby="h-skills"><h2 id="h-skills">Skills</h2>
            <ul class="skills">@foreach ($portfolio->skills as $s)
                <li><div class="t">{{ $s->name }}<span>{{ $s->level }}</span></div><div class="track" aria-hidden="true"><i style="width:{{ $s->percent }}%"></i></div></li>
            @endforeach</ul></section>
        @endif
    </div>
    @endif

    @if ($portfolio->certificates->count())
    <section class="glass sec" id="certificates" aria-labelledby="h-cert"><h2 id="h-cert">Certificates</h2>
        @include('partials.portfolio-gallery')
    </section>
    @endif

    @if ($portfolio->projects->count())
    <section class="glass sec" id="projects" aria-labelledby="h-proj"><h2 id="h-proj">Projects</h2>
        <div class="pgrid">@foreach ($portfolio->projects as $p)
            <article class="card proj"><h3>{{ $p->title }}</h3>
                @if ($p->description)<p style="margin:0">{{ $p->description }}</p>@endif
                @if ($p->tech)<span class="tag">{{ $p->tech }}</span>@endif
                @if ($p->url)<a class="go" href="{{ $p->url }}" target="_blank" rel="noopener">View project <x-icon name="external" :size="16" /><span class="sr-only"> (opens in a new tab)</span></a>@endif</article>
        @endforeach</div></section>
    @endif
</main>
<footer>&copy; {{ date('Y') }} {{ $portfolio->full_name }}</footer>
@include('partials.portfolio-interactions')
@include('partials.portfolio-theme-script')
</body>
</html>
