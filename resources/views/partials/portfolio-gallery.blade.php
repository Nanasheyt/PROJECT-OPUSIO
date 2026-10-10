{{-- Certificate gallery + full-size viewer (native <dialog>: Esc closes, arrow keys move between photos). --}}
<ul class="pi-gal">
    @foreach ($portfolio->certificates as $c)
        <li><button type="button" class="pi-thumb" aria-label="Open certificate {{ $loop->iteration }} of {{ $loop->count }} full size"><img src="{{ $c->image }}" alt="Certificate {{ $loop->iteration }}" loading="lazy" decoding="async"></button></li>
    @endforeach
</ul>
<dialog id="pi-lb" aria-label="Certificate viewer">
    <img id="pi-lb-img" alt="">
    <div class="pi-lb-bar">
        <button type="button" id="pi-prev" aria-label="Previous certificate"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg></button>
        <span id="pi-count" aria-live="polite"></span>
        <button type="button" id="pi-next" aria-label="Next certificate"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></button>
        <button type="button" id="pi-close" aria-label="Close viewer"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
    </div>
</dialog>
<style>
.pi-gal{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(auto-fill,minmax(min(210px,100%),1fr));gap:16px}
.pi-thumb{display:block;width:100%;padding:0;aspect-ratio:4/3;border:1px solid var(--pi-edge,rgba(127,127,127,.4));border-radius:var(--pi-r,12px);overflow:hidden;background:rgba(127,127,127,.12);cursor:zoom-in;touch-action:manipulation}
.pi-thumb img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .3s ease}
.pi-thumb:focus-visible{outline:3px solid var(--pi-fg,#222);outline-offset:3px}
@media (hover:hover){.pi-thumb:hover img{transform:scale(1.06)}}
@media (prefers-reduced-motion:reduce){.pi-thumb img{transition:none}.pi-thumb:hover img{transform:none}}
#pi-lb{border:0;padding:0;background:transparent;max-width:min(980px,96vw);max-height:96vh;overflow:visible}
#pi-lb::backdrop{background:rgba(0,0,0,.82)}
#pi-lb img{display:block;max-width:100%;max-height:78vh;margin:0 auto;object-fit:contain;background:#fff;border-radius:4px}
.pi-lb-bar{display:flex;align-items:center;justify-content:center;gap:10px;margin-top:12px;color:#fff;font:600 .9375rem system-ui,sans-serif}
.pi-lb-bar button{width:44px;height:44px;border-radius:50%;border:2px solid #fff;background:rgba(0,0,0,.5);color:#fff;display:grid;place-items:center;cursor:pointer}
.pi-lb-bar button:hover{background:#fff;color:#000}.pi-lb-bar button:focus-visible{outline:3px solid #FFE600;outline-offset:2px}
</style>
<script>
(function () {
    var thumbs = [].slice.call(document.querySelectorAll('.pi-thumb')), dlg = document.getElementById('pi-lb');
    if (!thumbs.length || !dlg || !dlg.showModal) return;
    var img = document.getElementById('pi-lb-img'), count = document.getElementById('pi-count'), i = 0;
    function show(n) {
        i = (n + thumbs.length) % thumbs.length;
        var src = thumbs[i].querySelector('img');
        img.src = src.src; img.alt = src.alt; count.textContent = (i + 1) + ' / ' + thumbs.length;
    }
    thumbs.forEach(function (b, n) { b.addEventListener('click', function () { show(n); dlg.showModal(); }); });
    document.getElementById('pi-prev').addEventListener('click', function () { show(i - 1); });
    document.getElementById('pi-next').addEventListener('click', function () { show(i + 1); });
    document.getElementById('pi-close').addEventListener('click', function () { dlg.close(); });
    if (thumbs.length < 2) { document.getElementById('pi-prev').hidden = true; document.getElementById('pi-next').hidden = true; }
    dlg.addEventListener('click', function (e) { if (e.target === dlg) dlg.close(); });
    dlg.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') { e.preventDefault(); show(i - 1); } else if (e.key === 'ArrowRight') { e.preventDefault(); show(i + 1); }
    });
})();
</script>
