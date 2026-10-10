{{-- Loading screen for portfolio pages. Colours come from --ld-* variables set by each template. --}}
<noscript><style>#loader{display:none}</style></noscript>
<style>
#loader{position:fixed;inset:0;z-index:1000;display:grid;place-items:center;background:var(--ld-bg,#fff);color:var(--ld-fg,#222);transition:opacity .4s ease,visibility .4s ease;animation:ldFail 0s linear 7s forwards}
#loader.done{opacity:0;visibility:hidden;pointer-events:none}
.in-frame #loader{display:none}
@keyframes ldFail{to{opacity:0;visibility:hidden;pointer-events:none}}
#loader .ld-in{text-align:center}
#loader .ld-mark{display:flex;gap:8px;height:56px;align-items:flex-end;justify-content:center}
#loader .ld-mark i{width:16px;height:100%;border-radius:5px;transform-origin:bottom;animation:ldBar 1s ease-in-out infinite}
#loader .ld-mark i:nth-child(1){background:var(--ld-a,#4F46E5)}#loader .ld-mark i:nth-child(2){background:var(--ld-b,#0E7490);animation-delay:.15s}#loader .ld-mark i:nth-child(3){background:var(--ld-c,#F59E0B);animation-delay:.3s}
#loader .ld-name{margin:16px 0 0;font:700 1.125rem system-ui,sans-serif;letter-spacing:.08em;text-transform:uppercase}
@keyframes ldBar{0%,100%{transform:scaleY(.35)}50%{transform:scaleY(1)}}
@media (prefers-reduced-motion:reduce){#loader .ld-mark i{animation:none;transform:scaleY(.7)}}
</style>
<div id="loader" role="status" aria-live="polite">
    <div class="ld-in"><div class="ld-mark" aria-hidden="true"><i></i><i></i><i></i></div><p class="ld-name">{{ $portfolio->full_name }}</p><span class="sr-only">Loading portfolio…</span></div>
</div>
<script>
(function () {
    var l = document.getElementById('loader'), t0 = performance.now();
    function hide() { setTimeout(function () { l.classList.add('done'); l.setAttribute('aria-hidden', 'true'); }, Math.max(0, 600 - (performance.now() - t0))); }
    if (document.readyState === 'complete') hide(); else addEventListener('load', hide);
    addEventListener('pageshow', function (e) { if (e.persisted) l.classList.add('done'); });
})();
</script>
