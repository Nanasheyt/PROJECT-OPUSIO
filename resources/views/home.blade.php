@extends('layouts.app')
@section('title', 'Build your portfolio online')
@section('wrapclass', 'home')
@section('content')
<style>
/* ---- Hero ribbon on small screens: stays behind the headline block instead of running through the stats ---- */
.hero .lead{background:var(--bg);padding:6px 16px;border-radius:14px}
.hero-main{position:relative;z-index:1;width:100%;display:flex;flex-direction:column;align-items:center}
@media (max-width:900px){
    .hero .b2,.hero .b3{display:none}
    .hero-top>.stripes{border-radius:24px}
}
/* ---- More design: dividers, colourful cards, stickers, template showcase ---- */
.band{position:relative}
.steps li:nth-child(4) .n{background:var(--lav)}
.divider{display:flex;justify-content:center;gap:8px;margin:var(--s7) 0 calc(var(--s6) * -1)}
.divider i{width:56px;height:12px;border-radius:99px}
.divider i:nth-child(1){background:var(--accent)}.divider i:nth-child(2){background:var(--salmon)}.divider i:nth-child(3){background:var(--sky)}
.colorful .feat li{border-color:#150F4A;color:#150F4A}
.colorful .feat li:nth-child(5n+1){background:#F8E27A}.colorful .feat li:nth-child(5n+2){background:#F9A58F}.colorful .feat li:nth-child(5n+3){background:#9FD3F0}
.colorful .feat li:nth-child(5n+4){background:#B9A2FF}.colorful .feat li:nth-child(5n){background:#FBF8EE}
.colorful .feat li p{color:#150F4A}
.colorful .feat .fi{background:#150F4A;color:#FBF8EE}
.sticker{position:absolute;width:108px;height:108px;display:grid;place-items:center;color:#150F4A;transform:rotate(var(--r,8deg));transition:transform .25s ease;pointer-events:none;z-index:2}
.sticker svg{position:absolute;inset:0;width:100%;height:100%;fill:var(--sc,#F8E27A)}
.sticker b{position:relative;font:800 .6875rem/1.15 var(--font);text-transform:uppercase;text-align:center;letter-spacing:.03em}
.st-new{top:var(--s6);right:6%}.sc{position:relative}.st-pdf{top:-6px;right:0;width:96px;height:96px}
@media (hover:hover){.band:hover .sticker{transform:rotate(calc(var(--r,8deg) * -1)) scale(1.06)}}
@media (max-width:1000px){.sticker{display:none}}
@media (min-width:901px){.steps{position:relative}.steps::before{content:"";position:absolute;left:4%;right:4%;top:50px;border-top:2px dashed var(--salmon);z-index:0}.steps li{position:relative;z-index:1}}
.cta-band::before,.cta-band::after{content:"";position:absolute;bottom:0;width:60px;height:62%;background:linear-gradient(90deg,#F8E27A 0 33.33%,#F9A58F 33.33% 66.66%,#9FD3F0 66.66%);border-radius:30px 30px 0 0}
.cta-band::before{left:8%}.cta-band::after{right:8%}
.cta-band>*{position:relative;z-index:1}
@media (max-width:900px){.cta-band::before,.cta-band::after{display:none}}

/* template showcase */
.sc{max-width:1120px;margin:0 auto}
.sc-tabs{display:flex;justify-content:center;gap:var(--s2);flex-wrap:wrap;margin-bottom:var(--s6)}
html:not(.js) .sc-tabs{display:none}
.sc-tab{display:inline-flex;align-items:center;gap:var(--s2);min-height:48px;padding:0 var(--s5);border-radius:99px;border:1.5px solid var(--fg);background:transparent;color:var(--fg);font:700 .9375rem var(--font);cursor:pointer;transition:background-color .2s,color .2s,transform .12s}
.sc-tab .dot{width:12px;height:12px;border-radius:50%;border:1.5px solid #150F4A}
.sc-tab[aria-selected=true]{background:var(--fg);color:var(--bg)}
.sc-tab:active{transform:scale(.96)}
.sc-panel{display:grid;grid-template-columns:1.25fr 1fr;gap:var(--s7);align-items:center;margin-bottom:var(--s6)}
.sc-panel[hidden]{display:none}
.device{background:var(--card);border:1.5px solid var(--fg);border-radius:18px;padding:12px 12px 14px;box-shadow:14px 14px 0 var(--pc)}
.dbar{display:flex;gap:6px;margin-bottom:10px}.dbar i{width:10px;height:10px;border-radius:50%;border:1.5px solid var(--fg)}
.dscreen{aspect-ratio:16/10;border-radius:10px;border:1.5px solid var(--hair);overflow:hidden;position:relative}
.sc-info h3{font:400 clamp(1.5rem,3vw,2.25rem)/1 var(--disp);text-transform:uppercase;margin-bottom:var(--s3)}
.sc-info>p{color:var(--muted-fg);margin-bottom:var(--s4);max-width:44ch}
.best{list-style:none;margin:0 0 var(--s5);padding:0;display:grid;gap:var(--s2)}
.best li{display:flex;gap:var(--s2);align-items:center;font-weight:600}.best .ico{color:var(--ink-blue)}
@media (max-width:900px){.sc-panel{grid-template-columns:1fr;gap:var(--s5)}.device{box-shadow:8px 8px 0 var(--pc)}}
.dscreen i{display:block;border-radius:3px}
.dscreen .w50{width:50%}.dscreen .w60{width:60%}.dscreen .w70{width:70%}.dscreen .w80{width:80%}.dscreen .w90{width:90%}
.mf{display:grid;grid-template-columns:30% 1fr;background:#fff}
.mf .sd{background:#14284B;padding:9% 8%;display:grid;gap:6px;align-content:start;justify-items:center}
.mf .sd i{height:5px;background:#C9D3E6;width:100%}.mf .sd i.g{background:#E3C57A}
.mf .sd i.ph{width:52%;aspect-ratio:1;height:auto;border-radius:0;background:#F9A58F;border:2px solid #B8903A;margin-bottom:6px}
.mf .mn{padding:8% 7%;display:grid;gap:6px;align-content:start}
.mf .mn i{height:5px;background:#D4D9E2}.mf .mn i.nm{height:14px;width:62%;background:#14284B}.mf .mn i.gl{height:3px;width:18%;background:#B8903A;margin-bottom:6px}.mf .mn i.sh{width:34%;background:#B8903A;margin-top:6px}
.mg{background:linear-gradient(135deg,#C7D2FE,#A5F3FC 52%,#F5D0FE);padding:5%;display:grid;gap:7px;align-content:start}
.mg .pillnav{display:flex;gap:6px;background:rgba(255,255,255,.75);border-radius:99px;padding:6px 10px;width:66%;margin:0 auto}
.mg .pillnav i{height:6px;flex:1;background:#A7B0D6;border-radius:99px}
.mg .gcard{background:rgba(255,255,255,.78);border:1px solid #fff;border-radius:12px;padding:6%;display:flex;justify-content:space-between;align-items:center;gap:10px}
.mg .gl{flex:1;display:grid;gap:6px}.mg .chip{height:8px;width:40%;background:#C7D2FE;border-radius:99px}
.mg .big{height:16px;width:80%;background:linear-gradient(90deg,#4F46E5,#0E7490)}.mg .tx{height:5px;background:#CBD2E3}
.mg .avatar{width:24%;aspect-ratio:1;height:auto;border-radius:14px;background:linear-gradient(135deg,#4F46E5,#0E7490)}
.mg .grow{display:grid;grid-template-columns:repeat(3,1fr);gap:7px}.mg .grow i{height:34px;border-radius:10px;background:rgba(255,255,255,.78);border:1px solid #fff}
.mc{background:#05070F;background-image:linear-gradient(rgba(34,211,238,.07) 1px,transparent 1px),linear-gradient(90deg,rgba(34,211,238,.07) 1px,transparent 1px);background-size:18px 18px;padding:5%;display:grid;gap:8px;align-content:start;animation:hr 16s linear infinite}
.mc .cp{border:1px solid #22d3ee;background:rgba(34,211,238,.08);padding:6%;display:grid;gap:6px;box-shadow:0 0 12px rgba(34,211,238,.25)}
.mc .chero{grid-template-columns:1fr 20%;align-items:center;gap:10px}.mc .l{display:grid;gap:6px}
.mc .tag{height:7px;width:40%;border:1px solid #e879f9;background:rgba(232,121,249,.2)}.mc .nm{height:16px;width:85%;background:linear-gradient(90deg,#22d3ee,#e879f9)}
.mc .sq{aspect-ratio:1;height:auto;background:#e879f9;opacity:.8;border:1px solid #22d3ee}
.mc .crow{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.mc .sh{height:5px;width:45%;background:#22d3ee}.mc .bar{height:5px;background:linear-gradient(90deg,#22d3ee,#e879f9)}.mc .ln{height:4px;background:#2a3a5c}
</style>
<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false"><symbol id="scallop" viewBox="0 0 140 140"><path d="M135.5 70.0 L135.2 71.6 L134.2 73.1 L132.7 74.6 L130.9 75.9 L128.9 77.2 L127.0 78.3 L125.3 79.4 L124.0 80.6 L123.2 81.8 L123.1 83.1 L123.5 84.6 L124.3 86.2 L125.4 88.0 L126.7 90.0 L127.9 92.0 L128.9 94.0 L129.4 95.9 L129.3 97.6 L128.7 99.0 L127.4 100.1 L125.7 101.0 L123.6 101.5 L121.3 101.9 L119.0 102.1 L116.8 102.3 L114.9 102.7 L113.5 103.2 L112.5 104.1 L112.0 105.4 L111.8 107.1 L112.0 109.0 L112.3 111.3 L112.6 113.6 L112.7 115.9 L112.5 118.0 L112.0 119.8 L111.0 121.1 L109.6 121.9 L107.9 122.1 L105.9 122.0 L103.7 121.4 L101.4 120.6 L99.3 119.8 L97.3 119.2 L95.6 118.8 L94.2 118.9 L93.0 119.5 L92.1 120.7 L91.3 122.3 L90.6 124.3 L89.9 126.5 L89.1 128.7 L88.1 130.7 L87.0 132.3 L85.6 133.4 L84.1 133.9 L82.5 133.8 L80.8 133.0 L79.0 131.8 L77.3 130.2 L75.7 128.5 L74.1 126.9 L72.7 125.6 L71.3 124.8 L70.0 124.5 L68.7 124.8 L67.3 125.6 L65.9 126.9 L64.3 128.5 L62.7 130.2 L61.0 131.8 L59.2 133.0 L57.5 133.8 L55.9 133.9 L54.4 133.4 L53.0 132.3 L51.9 130.7 L50.9 128.7 L50.1 126.5 L49.4 124.3 L48.7 122.3 L47.9 120.7 L47.0 119.5 L45.8 118.9 L44.4 118.8 L42.7 119.2 L40.7 119.8 L38.6 120.6 L36.3 121.4 L34.1 122.0 L32.1 122.1 L30.4 121.9 L29.0 121.1 L28.0 119.8 L27.5 118.0 L27.3 115.9 L27.4 113.6 L27.7 111.3 L28.0 109.0 L28.2 107.1 L28.0 105.4 L27.5 104.1 L26.5 103.2 L25.1 102.7 L23.2 102.3 L21.0 102.1 L18.7 101.9 L16.4 101.5 L14.3 101.0 L12.6 100.1 L11.3 99.0 L10.7 97.6 L10.6 95.9 L11.1 94.0 L12.1 92.0 L13.3 90.0 L14.6 88.0 L15.7 86.2 L16.5 84.6 L16.9 83.1 L16.8 81.8 L16.0 80.6 L14.7 79.4 L13.0 78.3 L11.1 77.2 L9.1 75.9 L7.3 74.6 L5.8 73.1 L4.8 71.6 L4.5 70.0 L4.8 68.4 L5.8 66.9 L7.3 65.4 L9.1 64.1 L11.1 62.8 L13.0 61.7 L14.7 60.6 L16.0 59.4 L16.8 58.2 L16.9 56.9 L16.5 55.4 L15.7 53.8 L14.6 52.0 L13.3 50.0 L12.1 48.0 L11.1 46.0 L10.6 44.1 L10.7 42.4 L11.3 41.0 L12.6 39.9 L14.3 39.0 L16.4 38.5 L18.7 38.1 L21.0 37.9 L23.2 37.7 L25.1 37.3 L26.5 36.8 L27.5 35.9 L28.0 34.6 L28.2 32.9 L28.0 31.0 L27.7 28.7 L27.4 26.4 L27.3 24.1 L27.5 22.0 L28.0 20.2 L29.0 18.9 L30.4 18.1 L32.1 17.9 L34.1 18.0 L36.3 18.6 L38.6 19.4 L40.7 20.2 L42.7 20.8 L44.4 21.2 L45.8 21.1 L47.0 20.5 L47.9 19.3 L48.7 17.7 L49.4 15.7 L50.1 13.5 L50.9 11.3 L51.9 9.3 L53.0 7.7 L54.4 6.6 L55.9 6.1 L57.5 6.2 L59.2 7.0 L61.0 8.2 L62.7 9.8 L64.3 11.5 L65.9 13.1 L67.3 14.4 L68.7 15.2 L70.0 15.5 L71.3 15.2 L72.7 14.4 L74.1 13.1 L75.7 11.5 L77.3 9.8 L79.0 8.2 L80.8 7.0 L82.5 6.2 L84.1 6.1 L85.6 6.6 L87.0 7.7 L88.1 9.3 L89.1 11.3 L89.9 13.5 L90.6 15.7 L91.3 17.7 L92.1 19.3 L93.0 20.5 L94.2 21.1 L95.6 21.2 L97.3 20.8 L99.3 20.2 L101.4 19.4 L103.7 18.6 L105.9 18.0 L107.9 17.9 L109.6 18.1 L111.0 18.9 L112.0 20.2 L112.5 22.0 L112.7 24.1 L112.6 26.4 L112.3 28.7 L112.0 31.0 L111.8 32.9 L112.0 34.6 L112.5 35.9 L113.5 36.8 L114.9 37.3 L116.8 37.7 L119.0 37.9 L121.3 38.1 L123.6 38.5 L125.7 39.0 L127.4 39.9 L128.7 41.0 L129.3 42.4 L129.4 44.1 L128.9 46.0 L127.9 48.0 L126.7 50.0 L125.4 52.0 L124.3 53.8 L123.5 55.4 L123.1 56.9 L123.2 58.2 L124.0 59.4 L125.3 60.6 L127.0 61.7 L128.9 62.8 L130.9 64.1 L132.7 65.4 L134.2 66.9 L135.2 68.4 Z"/></symbol></svg>
<section class="hero" aria-labelledby="hero-t">
    <div class="hero-top">
        <div class="stripes" aria-hidden="true"><i></i><i></i><i></i></div>
        <div class="gridbg" aria-hidden="true"></div>

        <span class="bubble b1" aria-hidden="true"><svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><circle cx="32" cy="24" r="11" fill="currentColor"/><path d="M10 62c2-15 12-21 22-21s20 6 22 21z" fill="currentColor"/></svg></span>
        <span class="bubble b2" aria-hidden="true"><svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><circle cx="32" cy="24" r="11" fill="currentColor"/><path d="M10 62c2-15 12-21 22-21s20 6 22 21z" fill="currentColor"/></svg></span>
        <span class="bubble b3" aria-hidden="true"><svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><circle cx="32" cy="24" r="11" fill="currentColor"/><path d="M10 62c2-15 12-21 22-21s20 6 22 21z" fill="currentColor"/></svg></span>
        <svg class="arrow a1" viewBox="0 0 90 190" aria-hidden="true" focusable="false"><path d="M6 6C-12 92 18 150 76 182"/><path d="M58 182l20 2-8-18" stroke-dasharray="none"/></svg>
        <svg class="arrow a2" viewBox="0 0 90 190" aria-hidden="true" focusable="false"><path d="M6 6C-12 92 18 150 76 182"/><path d="M58 182l20 2-8-18" stroke-dasharray="none"/></svg>

        <a class="join" href="{{ route('portfolios.create') }}">
            <svg viewBox="0 0 140 140" aria-hidden="true" focusable="false"><path d="M135.5 70.0 L135.2 71.6 L134.2 73.1 L132.7 74.6 L130.9 75.9 L128.9 77.2 L127.0 78.3 L125.3 79.4 L124.0 80.6 L123.2 81.8 L123.1 83.1 L123.5 84.6 L124.3 86.2 L125.4 88.0 L126.7 90.0 L127.9 92.0 L128.9 94.0 L129.4 95.9 L129.3 97.6 L128.7 99.0 L127.4 100.1 L125.7 101.0 L123.6 101.5 L121.3 101.9 L119.0 102.1 L116.8 102.3 L114.9 102.7 L113.5 103.2 L112.5 104.1 L112.0 105.4 L111.8 107.1 L112.0 109.0 L112.3 111.3 L112.6 113.6 L112.7 115.9 L112.5 118.0 L112.0 119.8 L111.0 121.1 L109.6 121.9 L107.9 122.1 L105.9 122.0 L103.7 121.4 L101.4 120.6 L99.3 119.8 L97.3 119.2 L95.6 118.8 L94.2 118.9 L93.0 119.5 L92.1 120.7 L91.3 122.3 L90.6 124.3 L89.9 126.5 L89.1 128.7 L88.1 130.7 L87.0 132.3 L85.6 133.4 L84.1 133.9 L82.5 133.8 L80.8 133.0 L79.0 131.8 L77.3 130.2 L75.7 128.5 L74.1 126.9 L72.7 125.6 L71.3 124.8 L70.0 124.5 L68.7 124.8 L67.3 125.6 L65.9 126.9 L64.3 128.5 L62.7 130.2 L61.0 131.8 L59.2 133.0 L57.5 133.8 L55.9 133.9 L54.4 133.4 L53.0 132.3 L51.9 130.7 L50.9 128.7 L50.1 126.5 L49.4 124.3 L48.7 122.3 L47.9 120.7 L47.0 119.5 L45.8 118.9 L44.4 118.8 L42.7 119.2 L40.7 119.8 L38.6 120.6 L36.3 121.4 L34.1 122.0 L32.1 122.1 L30.4 121.9 L29.0 121.1 L28.0 119.8 L27.5 118.0 L27.3 115.9 L27.4 113.6 L27.7 111.3 L28.0 109.0 L28.2 107.1 L28.0 105.4 L27.5 104.1 L26.5 103.2 L25.1 102.7 L23.2 102.3 L21.0 102.1 L18.7 101.9 L16.4 101.5 L14.3 101.0 L12.6 100.1 L11.3 99.0 L10.7 97.6 L10.6 95.9 L11.1 94.0 L12.1 92.0 L13.3 90.0 L14.6 88.0 L15.7 86.2 L16.5 84.6 L16.9 83.1 L16.8 81.8 L16.0 80.6 L14.7 79.4 L13.0 78.3 L11.1 77.2 L9.1 75.9 L7.3 74.6 L5.8 73.1 L4.8 71.6 L4.5 70.0 L4.8 68.4 L5.8 66.9 L7.3 65.4 L9.1 64.1 L11.1 62.8 L13.0 61.7 L14.7 60.6 L16.0 59.4 L16.8 58.2 L16.9 56.9 L16.5 55.4 L15.7 53.8 L14.6 52.0 L13.3 50.0 L12.1 48.0 L11.1 46.0 L10.6 44.1 L10.7 42.4 L11.3 41.0 L12.6 39.9 L14.3 39.0 L16.4 38.5 L18.7 38.1 L21.0 37.9 L23.2 37.7 L25.1 37.3 L26.5 36.8 L27.5 35.9 L28.0 34.6 L28.2 32.9 L28.0 31.0 L27.7 28.7 L27.4 26.4 L27.3 24.1 L27.5 22.0 L28.0 20.2 L29.0 18.9 L30.4 18.1 L32.1 17.9 L34.1 18.0 L36.3 18.6 L38.6 19.4 L40.7 20.2 L42.7 20.8 L44.4 21.2 L45.8 21.1 L47.0 20.5 L47.9 19.3 L48.7 17.7 L49.4 15.7 L50.1 13.5 L50.9 11.3 L51.9 9.3 L53.0 7.7 L54.4 6.6 L55.9 6.1 L57.5 6.2 L59.2 7.0 L61.0 8.2 L62.7 9.8 L64.3 11.5 L65.9 13.1 L67.3 14.4 L68.7 15.2 L70.0 15.5 L71.3 15.2 L72.7 14.4 L74.1 13.1 L75.7 11.5 L77.3 9.8 L79.0 8.2 L80.8 7.0 L82.5 6.2 L84.1 6.1 L85.6 6.6 L87.0 7.7 L88.1 9.3 L89.1 11.3 L89.9 13.5 L90.6 15.7 L91.3 17.7 L92.1 19.3 L93.0 20.5 L94.2 21.1 L95.6 21.2 L97.3 20.8 L99.3 20.2 L101.4 19.4 L103.7 18.6 L105.9 18.0 L107.9 17.9 L109.6 18.1 L111.0 18.9 L112.0 20.2 L112.5 22.0 L112.7 24.1 L112.6 26.4 L112.3 28.7 L112.0 31.0 L111.8 32.9 L112.0 34.6 L112.5 35.9 L113.5 36.8 L114.9 37.3 L116.8 37.7 L119.0 37.9 L121.3 38.1 L123.6 38.5 L125.7 39.0 L127.4 39.9 L128.7 41.0 L129.3 42.4 L129.4 44.1 L128.9 46.0 L127.9 48.0 L126.7 50.0 L125.4 52.0 L124.3 53.8 L123.5 55.4 L123.1 56.9 L123.2 58.2 L124.0 59.4 L125.3 60.6 L127.0 61.7 L128.9 62.8 L130.9 64.1 L132.7 65.4 L134.2 66.9 L135.2 68.4 Z"/></svg>
            <span>Create<br>Now<span class="sr"> – start your portfolio</span></span>
        </a>

        <div class="hero-main">
            <p class="pill"><x-icon name="asterisk" :size="16" /> Portfolio platform</p>
            <h1 class="mega" id="hero-t"><span>Portfolios</span><span>that work</span><span>for you</span></h1>
            <p class="lead">Fill in your details once, pick a design, and get a portfolio page you can preview, edit and share.</p>
            <div class="actions" style="justify-content:center">
                <a class="btn cta lg" href="{{ route('portfolios.create') }}">Create portfolio <x-icon name="arrow" /></a>
                @auth
                    <a class="btn ghost lg" href="{{ route('portfolios.index') }}">Manage portfolios</a>
                @else
                    <a class="btn ghost lg" href="{{ route('login') }}">Log in</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="stats">
        <div class="stat-side">
            <p class="say">Fill it in once. Switch designs whenever you like.</p>
            <p class="names" aria-label="Templates"><span>Formal</span><span>Modern</span><span>Aesthetic</span></p>
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
    @auth
        {{-- Only shown to logged-in users: how many portfolios THEY created --}}
        <li><b>{{ number_format($portfolioCount ?? 0) }}</b><span>{{ ($portfolioCount ?? 0) === 1 ? 'portfolio created' : 'portfolios created' }}</span></li>
    @else
        <li><b>1</b><span>shareable link per portfolio</span></li>
    @endauth
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

<div class="divider" aria-hidden="true"><i></i><i></i><i></i></div>

<section class="band caps colorful" aria-labelledby="what-t">
    <span class="sticker st-new" style="--r:9deg;--sc:#F8E27A" aria-hidden="true"><svg viewBox="0 0 140 140"><use href="#scallop"/></svg><b>New<br>Certificates</b></span>
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

<div class="divider" aria-hidden="true"><i></i><i></i><i></i></div>

<section class="band showcase" id="templates" aria-labelledby="tpl-t">
    <h2 class="title" id="tpl-t">Three templates, three styles</h2>
    <p class="sub">Every template is generated from the same saved information, so you can switch at any time.</p>
    <div class="sc">
        <span class="sticker st-pdf" style="--r:-9deg;--sc:#9FD3F0" aria-hidden="true"><svg viewBox="0 0 140 140"><use href="#scallop"/></svg><b>PDF<br>ready</b></span>
        <div class="sc-tabs" role="tablist" aria-label="Choose a template to preview">
            <button type="button" role="tab" id="tab-formal" class="sc-tab" aria-selected="true" aria-controls="pan-formal"><span class="dot" style="background:#F8E27A"></span>Formal</button>
            <button type="button" role="tab" id="tab-modern" class="sc-tab" aria-selected="false" aria-controls="pan-modern" tabindex="-1"><span class="dot" style="background:#9FD3F0"></span>Modern</button>
            <button type="button" role="tab" id="tab-aesthetic" class="sc-tab" aria-selected="false" aria-controls="pan-aesthetic" tabindex="-1"><span class="dot" style="background:#F9A58F"></span>Aesthetic</button>
        </div>

        <div class="sc-panel" role="tabpanel" id="pan-formal" aria-labelledby="tab-formal" style="--pc:#F8E27A">
            <div class="device" aria-hidden="true"><div class="dbar"><i></i><i></i><i></i></div>
                <div class="dscreen mf"><div class="sd"><i class="ph"></i><i class="g w50"></i><i></i><i class="w80"></i><i class="g w50"></i><i class="w70"></i><i></i></div>
                    <div class="mn"><i class="nm"></i><i class="gl"></i><i class="sh"></i><i></i><i class="w90"></i><i class="w70"></i><i class="sh"></i><i></i><i class="w80"></i><i class="sh"></i><i class="w90"></i><i class="w60"></i></div></div></div>
            <div class="sc-info"><h3>Formal</h3><p>A classic executive résumé with a navy sidebar, gold accents and serif headings.</p>
                <ul class="best"><li><x-icon name="check" :size="18" /> Best for job applications</li><li><x-icon name="check" :size="18" /> Print-friendly: just press Ctrl+P</li><li><x-icon name="check" :size="18" /> Its own light and dark mode</li></ul>
                <a class="btn cta" href="{{ route('portfolios.create') }}">Create portfolio <x-icon name="arrow" /></a></div>
        </div>

        <div class="sc-panel" role="tabpanel" id="pan-modern" aria-labelledby="tab-modern" style="--pc:#9FD3F0">
            <div class="device" aria-hidden="true"><div class="dbar"><i></i><i></i><i></i></div>
                <div class="dscreen mg"><div class="pillnav"><i></i><i></i><i></i><i></i></div>
                    <div class="gcard"><div class="gl"><i class="chip"></i><i class="big"></i><i class="tx"></i><i class="tx w70"></i></div><i class="avatar"></i></div>
                    <div class="grow"><i></i><i></i><i></i></div></div></div>
            <div class="sc-info"><h3>Modern</h3><p>Frosted-glass cards over a soft gradient, with a sticky menu that jumps to each section.</p>
                <ul class="best"><li><x-icon name="check" :size="18" /> Best for designers and developers</li><li><x-icon name="check" :size="18" /> Skill bars and a section menu</li><li><x-icon name="check" :size="18" /> Its own light and dark mode</li></ul>
                <a class="btn cta" href="{{ route('portfolios.create') }}">Create portfolio <x-icon name="arrow" /></a></div>
        </div>

        <div class="sc-panel" role="tabpanel" id="pan-aesthetic" aria-labelledby="tab-aesthetic" style="--pc:#F9A58F">
            <div class="device" aria-hidden="true"><div class="dbar"><i></i><i></i><i></i></div>
                <div class="dscreen mc"><div class="cp chero"><div class="l"><i class="tag"></i><i class="nm"></i></div><i class="sq"></i></div>
                    <div class="crow"><div class="cp"><i class="sh"></i><i class="bar"></i><i class="bar w60"></i><i class="bar w80"></i></div><div class="cp"><i class="sh"></i><i class="ln"></i><i class="ln w80"></i><i class="ln w60"></i></div></div></div></div>
            <div class="sc-info"><h3>Aesthetic</h3><p>A cyber-tech look with neon colours that slowly shift. A pause button keeps it calm.</p>
                <ul class="best"><li><x-icon name="check" :size="18" /> Best for tech creators</li><li><x-icon name="check" :size="18" /> Colour animation you can pause</li><li><x-icon name="check" :size="18" /> Its own light and dark mode</li></ul>
                <a class="btn cta" href="{{ route('portfolios.create') }}">Create portfolio <x-icon name="arrow" /></a></div>
        </div>
    </div>
</section>

<div class="divider" aria-hidden="true"><i></i><i></i><i></i></div>

<section class="band caps colorful" aria-labelledby="who-t">
    <h2 class="title" id="who-t">Who is it for?</h2>
    <p class="sub">Anyone who needs a clear online profile without building a website from scratch.</p>
    <ul class="feat who">
        <li><div class="fi"><x-icon name="cap" /></div><h3>Students and graduates</h3><p>Show your studies, projects and skills to schools, internships and first employers.</p></li>
        <li><div class="fi"><x-icon name="layout" /></div><h3>Freelancers and creatives</h3><p>Present your best work and the ways clients can reach you in one tidy page.</p></li>
        <li><div class="fi"><x-icon name="briefcase" /></div><h3>Job seekers</h3><p>Turn your résumé into a link you can put on an application, and print it when you need to.</p></li>
    </ul>
</section>

<div class="divider" aria-hidden="true"><i></i><i></i><i></i></div>

<section class="band colorful" id="features" aria-labelledby="feat-t">
    <span class="sticker st-new" style="--r:-8deg;--sc:#B9A2FF" aria-hidden="true"><svg viewBox="0 0 140 140"><use href="#scallop"/></svg><b>Light<br>+ Dark</b></span>
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

<div class="divider" aria-hidden="true"><i></i><i></i><i></i></div>

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
@push('scripts')
<script>
(function () {
    var tabs = [].slice.call(document.querySelectorAll('.sc-tab'));
    if (!tabs.length) return;
    var panels = tabs.map(function (t) { return document.getElementById(t.getAttribute('aria-controls')); });
    function select(i, focus) {
        tabs.forEach(function (t, n) { var on = n === i; t.setAttribute('aria-selected', on ? 'true' : 'false'); t.tabIndex = on ? 0 : -1; panels[n].hidden = !on; });
        if (focus) tabs[i].focus();
    }
    tabs.forEach(function (t, i) {
        t.addEventListener('click', function () { select(i); });
        t.addEventListener('keydown', function (e) {
            var n = i;
            if (e.key === 'ArrowRight') n = (i + 1) % tabs.length; else if (e.key === 'ArrowLeft') n = (i - 1 + tabs.length) % tabs.length;
            else if (e.key === 'Home') n = 0; else if (e.key === 'End') n = tabs.length - 1; else return;
            e.preventDefault(); select(n, true);
        });
    });
    select(0);
})();
</script>
@endpush
@endsection
