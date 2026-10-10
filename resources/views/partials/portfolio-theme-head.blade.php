{{-- Portfolio pages have their OWN theme setting (key: pg-portfolio-theme), separate from the app toggle. --}}
<script>
(function () {
    try {
        var t = localStorage.getItem('pg-portfolio-theme');
        if (t !== 'light' && t !== 'dark') t = matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', t);
    } catch (e) {}
    if (self !== top) document.documentElement.classList.add('in-frame');
})();
</script>
<style>.tt .i-sun{display:none}:root[data-theme=dark] .tt .i-sun{display:block}:root[data-theme=dark] .tt .i-moon{display:none}
.tt{cursor:pointer;display:grid;place-items:center;touch-action:manipulation;-webkit-tap-highlight-color:transparent}</style>
