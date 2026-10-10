<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@include('partials.portfolio-theme-head')
<script>
/* Colour-cycling animation: remembered separately; starts paused when the device asks for reduced motion */
(function () {
    try {
        if (localStorage.getItem('pg-portfolio-motion') === 'paused' || matchMedia('(prefers-reduced-motion: reduce)').matches)
            document.documentElement.setAttribute('data-motion', 'paused');
    } catch (e) {}
})();
</script>
<title>{{ $portfolio->full_name }} – Portfolio</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Orbitron:wght@700;900&display=swap" rel="stylesheet">
<style>
/* Template 3 – Aesthetic / Cyber-tech. HUD panels, neon accents that slowly change colour (@property --hue).
   Colour is used for glows, borders, bars and large headings only; body text keeps a fixed, high-contrast colour. */
@property --hue{syntax:'<number>';inherits:true;initial-value:190}
@keyframes cycle{from{--hue:0}to{--hue:360}}
*,*::before,*::after{box-sizing:border-box}
:root{animation:cycle 36s linear infinite;
    --bg:#05070F;--panel:rgba(9,14,30,.82);--ink:#E3ECFF;--mut:#9FB0D0;
    --a:hsl(var(--hue) 100% 68%);--a2:hsl(calc(var(--hue) + 70) 100% 68%);--edge:hsl(var(--hue) 100% 68% / .35);
    --glow:0 0 22px hsl(var(--hue) 100% 60% / .28);--grid:hsl(var(--hue) 100% 60% / .07);--mono:'JetBrains Mono',ui-monospace,Menlo,Consolas,monospace;--disp:Orbitron,'JetBrains Mono',sans-serif;color-scheme:dark}
:root[data-theme=light]{color-scheme:light;--bg:#EEF3FA;--panel:rgba(255,255,255,.88);--ink:#0B1220;--mut:#3C4A66;
    --a:hsl(var(--hue) 95% 28%);--a2:hsl(calc(var(--hue) + 70) 95% 28%);--edge:hsl(var(--hue) 95% 28% / .45);--glow:0 0 0 transparent;--grid:hsl(var(--hue) 90% 30% / .06)}
:root[data-motion=paused]{animation-play-state:paused}
@media (prefers-reduced-motion:reduce){:root{animation:none}#mt{display:none}}
html{font-size:clamp(15px,14px + .35vw,18px);-webkit-text-size-adjust:100%}img{max-width:100%}
body{margin:0;background:var(--bg);color:var(--ink);font:400 1rem/1.7 var(--mono);overflow-wrap:break-word;min-height:100vh;
    background-image:radial-gradient(60vmax 40vmax at 85% -10%,hsl(var(--hue) 100% 55% / .14),transparent 60%),radial-gradient(50vmax 40vmax at -10% 105%,hsl(calc(var(--hue) + 80) 100% 55% / .12),transparent 60%),
        linear-gradient(var(--grid) 1px,transparent 1px),linear-gradient(90deg,var(--grid) 1px,transparent 1px);background-size:auto,auto,44px 44px,44px 44px}
:root[data-theme=light] body{background-image:radial-gradient(60vmax 40vmax at 85% -10%,hsl(var(--hue) 100% 70% / .22),transparent 60%),radial-gradient(50vmax 40vmax at -10% 105%,hsl(calc(var(--hue) + 80) 100% 70% / .2),transparent 60%),linear-gradient(var(--grid) 1px,transparent 1px),linear-gradient(90deg,var(--grid) 1px,transparent 1px)}
body::after{content:"";position:fixed;inset:0;pointer-events:none;z-index:50;background:repeating-linear-gradient(0deg,rgba(255,255,255,.025) 0 1px,transparent 1px 3px);mix-blend-mode:overlay}
:root[data-theme=light] body::after{display:none}
a{color:var(--ink);text-decoration-color:var(--a);text-decoration-thickness:2px;text-underline-offset:4px}
a:hover{background:hsl(var(--hue) 100% 60% / .18)}
:focus-visible{outline:3px solid var(--a);outline-offset:3px}
.skip{position:absolute;left:12px;top:-70px;background:var(--bg);color:var(--ink);border:2px solid var(--a);padding:8px 14px;z-index:99}.skip:focus{top:12px}
.sr-only{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap}
.tt-bar{max-width:1120px;margin:0 auto;padding:16px 20px 0;display:flex;justify-content:flex-end;gap:10px}
.tt{width:44px;height:44px;border:1px solid var(--a);background:var(--panel);color:var(--ink);border-radius:0;box-shadow:var(--glow)}
.tt:hover{background:hsl(var(--hue) 100% 60% / .2)}
.tt .i-play{display:none}:root[data-motion=paused] .tt .i-play{display:block}:root[data-motion=paused] .tt .i-pause{display:none}
.wrap{max-width:1120px;margin:0 auto;padding:16px 20px 56px;display:grid;grid-template-columns:repeat(12,1fr);gap:20px;counter-reset:s}
.panel{position:relative;background:var(--panel);border:1px solid var(--edge);padding:24px;min-width:0;box-shadow:var(--glow)}
.panel::before,.panel::after{content:"";position:absolute;width:18px;height:18px;border:2px solid var(--a);pointer-events:none}
.panel::before{top:-1px;left:-1px;border-right:0;border-bottom:0}.panel::after{right:-1px;bottom:-1px;border-left:0;border-top:0}
.hero{grid-column:1/-1;display:grid;grid-template-columns:1fr auto;gap:28px;align-items:center;padding:32px}
.boot{margin:0 0 14px;font-size:.8125rem;color:var(--mut)}.boot b{color:var(--a)}
h1{font:900 clamp(2rem,6.5vw,4.5rem)/1.05 var(--disp);letter-spacing:.02em;text-transform:uppercase;margin:0;overflow-wrap:anywhere;color:var(--ink)}
@supports (background-clip:text){h1{background:linear-gradient(90deg,var(--a),var(--a2));-webkit-background-clip:text;background-clip:text;color:transparent}}
.role{display:inline-block;margin:18px 0 0;padding:4px 14px;border:1px solid var(--a);color:var(--ink);font-weight:700;font-size:.9375rem;text-transform:uppercase;letter-spacing:.12em;background:hsl(var(--hue) 100% 60% / .12)}
.pic{width:210px;height:210px;object-fit:cover;border:2px solid var(--a);box-shadow:var(--glow);display:block;background:var(--panel);clip-path:polygon(0 0,calc(100% - 28px) 0,100% 28px,100% 100%,28px 100%,0 calc(100% - 28px))}
.pic.ph{display:grid;place-items:center;font:900 3.5rem var(--disp);color:var(--a)}
h2.sh{font:700 1.0625rem var(--disp);letter-spacing:.14em;text-transform:uppercase;margin:0 0 18px;display:flex;align-items:center;gap:12px}
h2.sh::before{counter-increment:s;content:"0" counter(s) " /";color:var(--a);font-family:var(--mono)}
h2.sh::after{content:"";flex:1;height:1px;background:linear-gradient(90deg,var(--a),transparent)}
.about{grid-column:span 7}.about p{margin:0;max-width:64ch}
.contact{grid-column:span 5}
.contact ul{list-style:none;margin:0;padding:0;display:grid;gap:12px}.contact li{display:flex;gap:12px;align-items:flex-start;overflow-wrap:anywhere}.contact .ico{color:var(--a);margin-top:4px}
.links{display:flex;flex-wrap:wrap;gap:10px;margin-top:20px}
.links a{display:inline-flex;align-items:center;gap:8px;min-height:44px;padding:0 16px;border:1px solid var(--a);text-decoration:none;font-weight:700;font-size:.875rem;text-transform:uppercase;letter-spacing:.06em}
.links a:hover{background:hsl(var(--hue) 100% 60% / .2);box-shadow:var(--glow)}
.skills{grid-column:span 5}.exp,.proj,.certs{grid-column:1/-1}.edu{grid-column:span 7}
.bars{list-style:none;margin:0;padding:0;display:grid;gap:16px}
.bars .t{display:flex;justify-content:space-between;gap:12px;font-weight:700;font-size:.9375rem;margin-bottom:6px}.bars .t span{color:var(--mut);font-weight:400}
.track{height:8px;background:hsl(var(--hue) 60% 50% / .2)}.track i{display:block;height:100%;background:linear-gradient(90deg,var(--a),var(--a2));box-shadow:var(--glow)}
.ent{position:relative;margin:0 0 22px 6px;padding-left:22px;border-left:1px solid var(--edge)}.ent:last-child{margin-bottom:0}
.ent::before{content:"";position:absolute;left:-6px;top:7px;width:11px;height:11px;background:var(--a);box-shadow:var(--glow)}
.ent h3{font:700 1.0625rem var(--mono);margin:0}.meta{color:var(--mut);font-size:.875rem;margin-top:2px}.ent p{margin:8px 0 0;max-width:70ch}
.pg{display:grid;grid-template-columns:repeat(auto-fill,minmax(min(280px,100%),1fr));gap:20px}
.card{position:relative;border:1px solid var(--edge);padding:20px;background:hsl(var(--hue) 100% 60% / .06);display:flex;flex-direction:column;gap:10px;transition:box-shadow .25s ease,border-color .25s ease}
.card:hover{border-color:var(--a);box-shadow:var(--glow)}
.card h3{font:700 1.0625rem var(--disp);letter-spacing:.04em;text-transform:uppercase;margin:0}.card p{margin:0;font-size:.9375rem}
.tag{align-self:flex-start;border:1px solid var(--edge);padding:1px 10px;font-size:.8125rem;color:var(--mut)}
.card a.go{margin-top:auto;display:inline-flex;align-items:center;gap:8px;min-height:44px;font-weight:700}
footer{grid-column:1/-1;color:var(--mut);font-size:.8125rem;text-transform:uppercase;letter-spacing:.1em}
@media(max-width:860px){.about,.contact,.skills,.edu{grid-column:1/-1}.hero{grid-template-columns:1fr;padding:24px}.pic{order:-1;width:150px;height:150px}}
@media(max-width:560px){.tt-bar{padding:12px 12px 0}.wrap{padding:12px 12px 40px;gap:14px}.panel{padding:18px}}
@media(prefers-reduced-motion:reduce){.card{transition:none}}
#loader{--ld-bg:var(--bg);--ld-fg:var(--ink);--ld-a:var(--a);--ld-b:var(--a2);--ld-c:var(--a)}
:root{--pi-bg:var(--panel);--pi-fg:var(--ink);--pi-r:0;--pi-edge:var(--edge)}
@media (hover:hover){.panel{transition:box-shadow .3s ease,border-color .3s ease}.panel:hover{border-color:var(--a);box-shadow:0 0 34px hsl(var(--hue) 100% 60% / .35)}.ent::before{transition:transform .2s}.ent:hover::before{transform:scale(1.5)}.pic{transition:transform .3s ease}.pic:hover{transform:scale(1.04) rotate(1deg)}}
</style>
</head>
<body>
@include('partials.portfolio-loader')
<a class="skip" href="#content">Skip to content</a>
<div class="tt-bar">
    <button type="button" class="tt" id="mt" aria-pressed="false" aria-label="Pause colour animation" title="Pause or resume the colour-changing animation">
        <x-icon name="pause" class="i-pause" /><x-icon name="play" class="i-play" />
    </button>
    <button type="button" class="tt" id="tt" aria-pressed="false" aria-label="Dark mode" title="Switch between light and dark mode">
        <x-icon name="moon" class="i-moon" /><x-icon name="sun" class="i-sun" />
    </button>
</div>
<main id="content" class="wrap">
    <header class="panel hero">
        <div>
            <p class="boot" aria-hidden="true">&gt; loading profile <b>[ OK ]</b></p>
            <h1>{{ $portfolio->full_name }}</h1>
            @if ($portfolio->job_title)<p class="role">{{ $portfolio->job_title }}</p>@endif
        </div>
        @if ($portfolio->profile_picture)<img class="pic" src="{{ $portfolio->profile_picture }}" alt="Portrait of {{ $portfolio->full_name }}">
        @else<div class="pic ph" aria-hidden="true">{{ $portfolio->initials }}</div>@endif
    </header>

    <section class="panel about" aria-labelledby="c-about"><h2 class="sh" id="c-about">About</h2><p>{!! nl2br(e($portfolio->about)) !!}</p></section>

    <section class="panel contact" aria-labelledby="c-contact"><h2 class="sh" id="c-contact">Contact</h2>
        <ul>
            <li><x-icon name="mail" /><a href="mailto:{{ $portfolio->email }}">{{ $portfolio->email }}</a></li>
            <li><x-icon name="phone" /><span>{{ $portfolio->phone }}</span></li>
            <li><x-icon name="pin" /><span>{{ $portfolio->address }}</span></li>
        </ul>
        @if ($portfolio->socialLinks->count())
            <div class="links">@foreach ($portfolio->socialLinks as $l)<a href="{{ $l->url }}" target="_blank" rel="noopener">{{ $l->platform }} <x-icon name="external" :size="16" /><span class="sr-only"> (opens in a new tab)</span></a>@endforeach</div>
        @endif
    </section>

    @if ($portfolio->skills->count())
    <section class="panel skills" aria-labelledby="c-skills"><h2 class="sh" id="c-skills">Skills</h2>
        <ul class="bars">@foreach ($portfolio->skills as $s)
            <li><div class="t">{{ $s->name }}<span>{{ $s->level }}</span></div><div class="track" aria-hidden="true"><i style="width:{{ $s->percent }}%"></i></div></li>
        @endforeach</ul></section>
    @endif

    @if ($portfolio->educations->count())
    <section class="panel edu" aria-labelledby="c-edu"><h2 class="sh" id="c-edu">Education</h2>
        @foreach ($portfolio->educations as $e)
            <article class="ent"><h3>{{ $e->degree }}</h3>
                <div class="meta">{{ $e->school }}@if ($e->start_year || $e->end_year) // {{ $e->start_year }}{{ $e->start_year && $e->end_year ? ' – ' : '' }}{{ $e->end_year }}@endif</div>
                @if ($e->description)<p>{{ $e->description }}</p>@endif</article>
        @endforeach</section>
    @endif

    @if ($portfolio->experiences->count())
    <section class="panel exp" aria-labelledby="c-exp"><h2 class="sh" id="c-exp">Experience</h2>
        @foreach ($portfolio->experiences as $x)
            <article class="ent"><h3>{{ $x->position }}</h3>
                <div class="meta">{{ $x->company }}@if ($x->start_date || $x->end_date) // {{ $x->start_date }}{{ $x->start_date && $x->end_date ? ' → ' : '' }}{{ $x->end_date }}@endif</div>
                @if ($x->description)<p>{!! nl2br(e($x->description)) !!}</p>@endif</article>
        @endforeach</section>
    @endif

    @if ($portfolio->certificates->count())
    <section class="panel certs" aria-labelledby="c-cert"><h2 class="sh" id="c-cert">Certificates</h2>
        @include('partials.portfolio-gallery')
    </section>
    @endif

    @if ($portfolio->projects->count())
    <section class="panel proj" aria-labelledby="c-proj"><h2 class="sh" id="c-proj">Projects</h2>
        <div class="pg">@foreach ($portfolio->projects as $p)
            <article class="card"><h3>{{ $p->title }}</h3>
                @if ($p->description)<p>{{ $p->description }}</p>@endif
                @if ($p->tech)<span class="tag">{{ $p->tech }}</span>@endif
                @if ($p->url)<a class="go" href="{{ $p->url }}" target="_blank" rel="noopener">Open project <x-icon name="arrow" :size="18" /><span class="sr-only"> (opens in a new tab)</span></a>@endif</article>
        @endforeach</div></section>
    @endif
    <footer>&copy; {{ date('Y') }} {{ $portfolio->full_name }}</footer>
</main>
@include('partials.portfolio-interactions')
@include('partials.portfolio-theme-script')
<script>
(function () {
    var root = document.documentElement, btn = document.getElementById('mt');
    function sync() { btn.setAttribute('aria-pressed', root.getAttribute('data-motion') === 'paused' ? 'true' : 'false'); }
    btn.addEventListener('click', function () {
        var paused = root.getAttribute('data-motion') === 'paused';
        if (paused) root.removeAttribute('data-motion'); else root.setAttribute('data-motion', 'paused');
        try { localStorage.setItem('pg-portfolio-motion', paused ? 'running' : 'paused'); } catch (e) {}
        sync();
    });
    sync();
})();
</script>
</body>
</html>
