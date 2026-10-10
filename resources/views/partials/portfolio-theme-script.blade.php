<script>
(function () {
    var root = document.documentElement, btn = document.getElementById('tt'), mq = matchMedia('(prefers-color-scheme: dark)');
    function sync() { btn.setAttribute('aria-pressed', root.getAttribute('data-theme') === 'dark' ? 'true' : 'false'); }
    btn.addEventListener('click', function () {
        var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', next);
        try { localStorage.setItem('pg-portfolio-theme', next); } catch (e) {}
        sync();
    });
    mq.addEventListener && mq.addEventListener('change', function (e) {
        var saved = null; try { saved = localStorage.getItem('pg-portfolio-theme'); } catch (x) {}
        if (!saved) { root.setAttribute('data-theme', e.matches ? 'dark' : 'light'); sync(); }
    });
    sync();
})();
</script>
