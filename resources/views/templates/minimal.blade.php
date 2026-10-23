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
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
/* Template 4 – Minimal. Ultra-clean, typography-first, maximum content density, zero decoration. */
*,*::before,*::after{box-sizing:border-box}
:root{
  --bg:#FAFAFA; --ink:#0A0A0A; --mut:#525252; --line:#E5E5E5; --accent:#0A0A0A;
  --font-sans:'DM Sans',system-ui,-apple-system,'Segoe UI',sans-serif;
  --font-display:'Space Grotesk',system-ui,-apple-system,'Segoe UI',sans-serif;
  --radius:0; --radius-sm:0; --radius-lg:0;
  --shadow:0 1px 0 var(--line); --shadow-lg:0 4px 12px rgba(10,10,10,.08);
  --transition:200ms ease; color-scheme:light
}
:root[data-theme=dark]{
  color-scheme:dark; --bg:#050505; --ink:#FAFAFA; --mut:#A3A3A3; --line:#262626; --accent:#FAFAFA;
  --shadow:0 1px 0 var(--line); --shadow-lg:0 4px 12px rgba(0,0,0,.4)
}
@media (prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}}
html{font-size:clamp(15px,14px + .35vw,18px);-webkit-text-size-adjust:100%}img{max-width:100%}
body{margin:0;background:var(--bg);color:var(--ink);font:400 1rem/1.7 var(--font-sans);overflow-wrap:break-word}
a{color:var(--accent);text-underline-offset:2px;text-decoration-thickness:1px}
a:hover{text-decoration-thickness:2px}
:focus-visible{outline:2px solid var(--accent);outline-offset:2px}
.skip{position:absolute;left:12px;top:-70px;background:var(--accent);color:var(--bg);padding:8px 14px;z-index:99;font:600 .875rem var(--font-sans)}.skip:focus{top:12px}
.sr-only{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)}
.tt-bar{max-width:720px;margin:0 auto;padding:16px 20px 0;display:flex;justify-content:flex-end}
.tt{width:40px;height:40px;border:1px solid var(--line);background:var(--bg);color:var(--ink);border-radius:4px}.tt:hover{border-color:var(--accent)}
.wrap{max-width:720px;margin:0 auto;padding:40px 20px 80px}
header{margin-bottom:48px;padding-bottom:32px;border-bottom:1px solid var(--line)}
h1{font:700 clamp(2.25rem,5vw,3.5rem)/1.05 var(--font-display);letter-spacing:-.03em;margin:0;overflow-wrap:anywhere}
.role{font:400 1.125rem/1.5 var(--font-sans);color:var(--mut);margin:12px 0 0}
.contact{list-style:none;margin:24px 0 0;padding:0;display:flex;flex-wrap:wrap;gap:16px;font-size:.9375rem;color:var(--mut)}
.contact li{display:flex;align-items:center;gap:8px}.contact a{color:var(--mut);text-decoration:none}.contact a:hover{color:var(--accent);text-decoration:underline}
.social{display:flex;flex-wrap:wrap;gap:8px;margin-top:16px}
.social a{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border:1px solid var(--line);border-radius:4px;font:500 .8125rem var(--font-sans);text-decoration:none;color:var(--ink);background:var(--bg)}
.social a:hover{border-color:var(--accent);background:var(--accent);color:var(--bg)}
.sec{margin-top:48px}
.sec>h2{font:600 1.125rem/1.3 var(--font-display);letter-spacing:-.01em;text-transform:uppercase;color:var(--mut);margin:0 0 20px;padding-bottom:8px;border-bottom:1px solid var(--line)}
.about{margin:0;max-width:70ch}
.tl{display:grid;gap:24px}
.card{padding:20px 0;border-top:1px solid var(--line)}
.card:first-child{border-top:none;padding-top:0}
.card h3{font:600 1.0625rem/1.3 var(--font-display);margin:0}
.meta{color:var(--mut);font-size:.875rem;margin-top:4px}.card p{margin:12px 0 0}
.skills{list-style:none;margin:0;padding:0;display:grid;gap:16px}
.skills .t{display:flex;justify-content:space-between;gap:12px;font:500 .9375rem var(--font-sans);margin-bottom:6px}.skills .t span{color:var(--mut);font-weight:400}
.track{height:4px;background:var(--line);border-radius:2px;overflow:hidden}.track i{display:block;height:100%;background:var(--accent);transition:width 1s ease-out}
.pgrid{display:grid;gap:20px}
.proj{padding:20px 0;border-top:1px solid var(--line);display:flex;flex-direction:column;gap:8px}
.proj:first-child{border-top:none;padding-top:0}
.proj h3{font:600 1.0625rem/1.3 var(--font-display);margin:0}
.proj p{margin:0;color:var(--mut)}.proj .tag{display:inline-block;margin-top:4px;padding:2px 8px;border:1px solid var(--line);border-radius:2px;font:500 .75rem var(--font-sans);color:var(--mut)}
.proj a.go{margin-top:auto;display:inline-flex;align-items:center;gap:8px;font:500 .875rem var(--font-sans);color:var(--accent);text-decoration:none}
.proj a.go:hover{text-decoration:underline}
footer{margin-top:60px;padding-top:32px;border-top:1px solid var(--line);text-align:center;color:var(--mut);font-size:.8125rem}
@media print{.tt-bar,.skip,.social a{display:none}body{background:#fff;color:#000}.card,.proj{border-top-color:#ccc}a{color:#000;text-decoration:underline}*{-webkit-print-color-adjust:exact;print-color-adjust:exact}}
#loader{--ld-bg:var(--bg);--ld-fg:var(--ink);--ld-a:var(--accent);--ld-b:var(--accent);--ld-c:var(--accent)}
:root{--pi-bg:var(--bg);--pi-fg:var(--ink);--pi-r:0;--pi-edge:var(--line)}
</style>
</head>
<body>
@include('partials.portfolio-loader')
<a class="skip" href="#content">Skip to content</a>
@include('partials.portfolio-theme-button')
<div class="wrap" id="content">
  <header>
    <h1>{{ $portfolio->full_name }}</h1>
    @if ($portfolio->job_title)<p class="role">{{ $portfolio->job_title }}</p>@endif
    <ul class="contact">
      <li><x-icon name="mail" :size="16" /><a href="mailto:{{ $portfolio->email }}">{{ $portfolio->email }}</a></li>
      <li><x-icon name="phone" :size="16" /><span>{{ $portfolio->phone }}</span></li>
      <li><x-icon name="pin" :size="16" /><span>{{ $portfolio->address }}</span></li>
    </ul>
    @if ($portfolio->socialLinks->count())
    <div class="social">@foreach ($portfolio->socialLinks as $l)<a href="{{ $l->url }}" target="_blank" rel="noopener">{{ $l->platform }} <x-icon name="external" :size="14" /><span class="sr-only"> (opens in a new tab)</span></a>@endforeach</div>
    @endif
  </header>

  <section class="sec" id="about" aria-labelledby="h-about"><h2 id="h-about">About</h2><p class="about">{!! nl2br(e($portfolio->about)) !!}</p></section>

  @if ($portfolio->experiences->count())
  <section class="sec" id="experience" aria-labelledby="h-exp"><h2 id="h-exp">Experience</h2>
    <div class="tl">@foreach ($portfolio->experiences as $x)
      <article class="card"><h3>{{ $x->position }}</h3>
        <div class="meta">{{ $x->company }}@if ($x->start_date || $x->end_date) &middot; {{ $x->start_date }}{{ $x->start_date && $x->end_date ? ' – ' : '' }}{{ $x->end_date }}@endif</div>
        @if ($x->description)<p>{!! nl2br(e($x->description)) !!}</p>@endif</article>
    @endforeach</div></section>
  @endif

  @if ($portfolio->educations->count() || $portfolio->skills->count())
  <div class="tl">
    @if ($portfolio->educations->count())
    <section class="sec" id="education" aria-labelledby="h-edu"><h2 id="h-edu">Education</h2>
      <div class="tl">@foreach ($portfolio->educations as $e)
        <article class="card"><h3>{{ $e->degree }}</h3>
          <div class="meta">{{ $e->school }}@if ($e->start_year || $e->end_year) &middot; {{ $e->start_year }}{{ $e->start_year && $e->end_year ? ' – ' : '' }}{{ $e->end_year }}@endif</div>
          @if ($e->description)<p>{{ $e->description }}</p>@endif</article>
      @endforeach</div></section>
    @endif
    @if ($portfolio->skills->count())
    <section class="sec" id="skills" aria-labelledby="h-skills"><h2 id="h-skills">Skills</h2>
      <ul class="skills">@foreach ($portfolio->skills as $s)
        <li><div class="t">{{ $s->name }}<span>{{ $s->level }}</span></div><div class="track" aria-hidden="true"><i style="width:{{ $s->percent }}%"></i></div></li>
      @endforeach</ul></section>
    @endif
  </div>
  @endif

  @if ($portfolio->certificates->count())
  <section class="sec" id="certificates" aria-labelledby="h-cert"><h2 id="h-cert">Certificates</h2>
    @include('partials.portfolio-gallery')
  </section>
  @endif

  @if ($portfolio->projects->count())
  <section class="sec" id="projects" aria-labelledby="h-proj"><h2 id="h-proj">Projects</h2>
    <div class="pgrid">@foreach ($portfolio->projects as $p)
      <article class="proj"><h3>{{ $p->title }}</h3>
        @if ($p->description)<p>{{ $p->description }}</p>@endif
        @if ($p->tech)<span class="tag">{{ $p->tech }}</span>@endif
        @if ($p->url)<a class="go" href="{{ $p->url }}" target="_blank" rel="noopener">View project <x-icon name="external" :size="14" /><span class="sr-only"> (opens in a new tab)</span></a>@endif</article>
    @endforeach</div></section>
  @endif

  @if ($portfolio->testimonials->count())
  <section class="sec" id="testimonials" aria-labelledby="h-test"><h2 id="h-test">Testimonials</h2>
    <div class="tl">@foreach ($portfolio->testimonials as $t)
      <article class="card">
        <p style="font-size:1.0625rem;font-style:italic;margin:0">"{{ $t->quote }}"</p>
        <div class="meta" style="margin-top:12px;font-style:normal">— {{ $t->author }}, {{ $t->role }}</div>
      </article>
    @endforeach</div></section>
  @endif

  @if ($portfolio->publications->count())
  <section class="sec" id="publications" aria-labelledby="h-pub"><h2 id="h-pub">Publications</h2>
    <div class="tl">@foreach ($portfolio->publications as $p)
      <article class="card">
        <h3>{{ $p->title }}</h3>
        <div class="meta">{{ $p->venue }} @if ($p->year) &middot; {{ $p->year }}@endif</div>
        @if ($p->url)<a class="go" href="{{ $p->url }}" target="_blank" rel="noopener">Read <x-icon name="external" :size="14" /><span class="sr-only"> (opens in a new tab)</span></a>@endif
      </article>
    @endforeach</div></section>
  @endif

  @if ($portfolio->languages->count())
  <section class="sec" id="languages" aria-labelledby="h-lang"><h2 id="h-lang">Languages</h2>
    <ul class="skills">@foreach ($portfolio->languages as $l)
      <li><div class="t">{{ $l->name }}<span>{{ $l->proficiency }}</span></div><div class="track" aria-hidden="true"><i style="width:{{ $l->percent }}%"></i></div></li>
    @endforeach</ul></section>
  @endif

  <footer>&copy; {{ date('Y') }} {{ $portfolio->full_name }}</footer>
</div>
@include('partials.portfolio-interactions')
@include('partials.portfolio-theme-script')
</body>
</html>