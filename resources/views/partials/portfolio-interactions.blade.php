{{-- Interactive behaviour shared by the portfolio templates (reveal on scroll, animated bars, copy email, back to top). --}}
<style>
.pi-cp{margin-left:8px;font:inherit;font-size:.75em;line-height:1;color:inherit;background:transparent;border:1px solid currentColor;border-radius:99px;padding:6px 12px;min-height:32px;cursor:pointer;vertical-align:middle;opacity:.9;touch-action:manipulation}
.pi-cp:hover{opacity:1;background:rgba(127,127,127,.18)}.pi-cp:focus-visible{outline:3px solid currentColor;outline-offset:2px}
.pi-top{position:fixed;right:16px;bottom:16px;z-index:60;width:48px;height:48px;border-radius:50%;border:2px solid var(--pi-fg,#222);background:var(--pi-bg,#fff);color:var(--pi-fg,#222);display:grid;place-items:center;cursor:pointer;touch-action:manipulation}
.pi-top[hidden]{display:none}.pi-top svg{transform:rotate(-90deg)}.pi-top:active{transform:scale(.94)}
.pi-toast{position:fixed;left:50%;bottom:24px;transform:translateX(-50%);z-index:80;background:var(--pi-fg,#222);color:var(--pi-bg,#fff);padding:10px 20px;border-radius:99px;font:600 .875rem system-ui,sans-serif}
@media (prefers-reduced-motion:no-preference){
    html.pi-js [data-reveal]{opacity:0;transform:translateY(22px);transition:opacity .7s ease,transform .7s ease}
    html.pi-js [data-reveal].in{opacity:1;transform:none}
    html.pi-js .track i{transition:width 1.1s cubic-bezier(.2,.8,.2,1)}
}
@media print{.pi-cp,.pi-top,.pi-toast,#loader,.tt-bar,.tt{display:none!important}[data-reveal]{opacity:1!important;transform:none!important}*{-webkit-print-color-adjust:exact;print-color-adjust:exact}}
</style>
<button type="button" class="pi-top" id="pi-top" hidden aria-label="Back to top"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></button>
<script>
(function () {
    var reduce = matchMedia('(prefers-reduced-motion: reduce)').matches, framed = self !== top;
    var printing = /[?&]print=1/.test(location.search);

    /* Reveal sections as they scroll into view; skill bars fill when visible */
    var sections = document.querySelectorAll('section'), bars = document.querySelectorAll('.track i');
    if ('IntersectionObserver' in window && !reduce && !framed && !printing) {
        document.documentElement.classList.add('pi-js');
        bars.forEach(function (b) { b.dataset.w = b.style.width; b.style.width = '0'; });
        var io = new IntersectionObserver(function (es) {
            es.forEach(function (en) {
                if (!en.isIntersecting) return;
                en.target.classList.add('in');
                en.target.querySelectorAll('.track i').forEach(function (b) { b.style.width = b.dataset.w; });
                io.unobserve(en.target);
            });
        }, { threshold: .1 });
        sections.forEach(function (s) { s.setAttribute('data-reveal', ''); io.observe(s); });
    }

    /* Make sure everything is visible when printing / saving as PDF */
    addEventListener('beforeprint', function () {
        document.querySelectorAll('[data-reveal]').forEach(function (s) { s.classList.add('in'); });
        bars.forEach(function (b) { if (b.dataset.w) b.style.width = b.dataset.w; });
    });
    if (printing && !framed) addEventListener('load', function () { setTimeout(function () { window.print(); }, 900); });

    /* Copy-email button next to every mailto link */
    function toast(msg) {
        var t = document.createElement('div'); t.className = 'pi-toast'; t.setAttribute('role', 'status'); t.textContent = msg;
        document.body.appendChild(t); setTimeout(function () { t.remove(); }, 2000);
    }
    if (!framed) document.querySelectorAll('a[href^="mailto:"]').forEach(function (a) {
        var addr = a.getAttribute('href').replace('mailto:', ''), b = document.createElement('button');
        b.type = 'button'; b.className = 'pi-cp'; b.textContent = 'Copy'; b.setAttribute('aria-label', 'Copy email address ' + addr);
        b.addEventListener('click', function () {
            function ok() { toast('Email copied'); }
            if (navigator.clipboard && window.isSecureContext) navigator.clipboard.writeText(addr).then(ok);
            else { var ta = document.createElement('textarea'); ta.value = addr; document.body.appendChild(ta); ta.select(); try { document.execCommand('copy'); ok(); } catch (x) {} ta.remove(); }
        });
        a.insertAdjacentElement('afterend', b);
    });

    /* Back to top */
    var up = document.getElementById('pi-top');
    if (framed) { up.remove(); return; }
    addEventListener('scroll', function () { up.hidden = window.scrollY < 600; }, { passive: true });
    up.addEventListener('click', function () { scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' }); });
})();
</script>
