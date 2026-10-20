<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        /* Apply the saved (or system) theme before first paint to avoid a flash */
        (function () {
            try {
                var t = localStorage.getItem('pg-theme');
                if (t !== 'light' && t !== 'dark') t = matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                document.documentElement.setAttribute('data-theme', t);
            } catch (e) {}
            document.documentElement.classList.add('js');
        })();
    </script>
    <title>@yield('title', 'Build your portfolio online') · Opusio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Instrument+Serif:ital@1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Design language: cream page in a pink frame, navy ink, electric blue, yellow / salmon / sky stripes, pill buttons. */
        :root{
            --frame:#FFD8CF;--bg:#FBF8EE;--fg:#150F4A;--card:#fff;--muted:#F1ECDC;--muted-fg:#4B4777;--border:#8A85AD;--hair:#DDD7C2;--grid:#E6DCC6;
            --primary:#2B2BE8;--on-primary:#fff;--ink-blue:#2B2BE8;--link:#2B2BE8;--ring:#2B2BE8;
            --accent:#F8E27A;--on-accent:#150F4A;--salmon:#F9A58F;--sky:#9FD3F0;--lav:#B9A2FF;
            --danger:#C81E1E;--on-danger:#fff;
            --ok-bg:#F0FDF4;--ok-bd:#86EFAC;--ok-fg:#14532D;--err-bg:#FEF2F2;--err-bd:#FCA5A5;--err-fg:#7F1D1D;
            --s1:4px;--s2:8px;--s3:12px;--s4:16px;--s5:24px;--s6:32px;--s7:48px;--s8:64px;--r:24px;--navh:88px;
            --font:'Plus Jakarta Sans',system-ui,-apple-system,'Segoe UI',Roboto,sans-serif;
            --disp:'Dela Gothic One','Arial Black',Impact,system-ui,sans-serif;--serif:'Instrument Serif',Georgia,serif;color-scheme:light;
        }
        :root[data-theme=dark]{color-scheme:dark;
            --frame:#1B1238;--bg:#0E0B2A;--fg:#FBF8EE;--card:#171345;--muted:#221D55;--muted-fg:#BDB8E6;--border:#7D78B8;--hair:#2D2767;--grid:#2A2466;
            --primary:#4A4AF5;--ink-blue:#B4B4FF;--link:#B4B4FF;--ring:#F8E27A;--danger:#FF9A9A;--on-danger:#150F4A;
            --ok-bg:#052E16;--ok-bd:#166534;--ok-fg:#BBF7D0;--err-bg:#2A0F12;--err-bd:#7F1D1D;--err-fg:#FECACA}
        @media (prefers-color-scheme: dark){:root:not([data-theme]){color-scheme:dark;
            --frame:#1B1238;--bg:#0E0B2A;--fg:#FBF8EE;--card:#171345;--muted:#221D55;--muted-fg:#BDB8E6;--border:#7D78B8;--hair:#2D2767;--grid:#2A2466;
            --primary:#4A4AF5;--ink-blue:#B4B4FF;--link:#B4B4FF;--ring:#F8E27A;--danger:#FF9A9A;--on-danger:#150F4A;
            --ok-bg:#052E16;--ok-bd:#166534;--ok-fg:#BBF7D0;--err-bg:#2A0F12;--err-bd:#7F1D1D;--err-fg:#FECACA}}
        *,*::before,*::after{box-sizing:border-box}
        html{font-size:clamp(15px,14px + .35vw,18px);-webkit-text-size-adjust:100%;scroll-padding-top:24px}
        body{margin:0;font:400 1rem/1.6 var(--font);background:var(--frame);color:var(--fg)}
        a{color:var(--link);text-underline-offset:3px}
        h1,h2,h3{line-height:1.15;margin:0;letter-spacing:-.01em}
        h1{font:400 clamp(1.875rem,4.4vw,3rem)/1 var(--disp);text-transform:uppercase;letter-spacing:-.01em}
        h2{font-size:1.125rem;font-weight:700}p{margin:0}
        :focus-visible{outline:3px solid var(--ring);outline-offset:3px;border-radius:8px}
        .sr{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap}
        .skip{position:absolute;left:var(--s4);top:-80px;background:var(--fg);color:var(--bg);padding:var(--s3) var(--s4);border-radius:99px;z-index:100;font-weight:700}
        .skip:focus{top:var(--s3)}
        .ico{flex-shrink:0}
        img{max-width:100%}
        [hidden]{display:none!important}
        a,button,input,select,textarea,label{touch-action:manipulation}
        a,button{-webkit-tap-highlight-color:transparent}

        /* Framed sheet */
        .sheet{position:relative;background:var(--bg);width:calc(100% - 2*clamp(0px,4.5vw,56px));max-width:1320px;margin:0 auto;min-height:100vh;overflow-x:clip}
        .stripes{position:absolute;left:50%;top:0;bottom:0;width:48px;transform:translateX(-50%);display:flex;pointer-events:none;z-index:0}
        .stripes i{flex:1}.stripes i:nth-child(1){background:var(--accent)}.stripes i:nth-child(2){background:var(--salmon)}.stripes i:nth-child(3){background:var(--sky)}

        /* Header */
        .nav{position:relative;height:var(--navh)}
        .nav-in{position:relative;z-index:2;height:100%;max-width:1320px;margin:0 auto;padding:0 var(--s6);display:grid;grid-template-columns:minmax(0,1fr) 48px minmax(0,1fr);align-items:center}
        .cell{display:flex;align-items:center;justify-content:space-between;gap:var(--s4);min-width:0}
        .cell.r{grid-column:3}
        .brand{display:inline-flex;align-items:center;gap:var(--s2);font-weight:800;font-size:1.125rem;color:var(--fg);text-decoration:none;white-space:nowrap}
        .brand .mark{display:inline-flex;width:22px;height:22px;border-radius:6px;overflow:hidden}
        .brand .mark i{flex:1}.brand .mark i:nth-child(1){background:var(--accent)}.brand .mark i:nth-child(2){background:var(--salmon)}.brand .mark i:nth-child(3){background:var(--sky)}
        .nav ul{list-style:none;margin:0;padding:0;display:flex;gap:var(--s1)}
        .nav ul a{display:inline-flex;align-items:center;min-height:44px;padding:0 var(--s3);color:var(--fg);font-weight:500;font-size:.9375rem;text-decoration:none;border-radius:99px}
        .nav ul a:hover{text-decoration:underline;text-decoration-thickness:2px;text-underline-offset:6px}
        .nav ul a[aria-current=page]{font-weight:800;text-decoration:underline;text-decoration-thickness:3px;text-decoration-color:var(--salmon);text-underline-offset:6px}
        .nav-act{display:flex;align-items:center;gap:var(--s2)}
        .round{width:44px;height:44px;border-radius:50%;display:grid;place-items:center;border:1.5px solid var(--fg);background:transparent;color:var(--fg);cursor:pointer;text-decoration:none;transition:background-color .2s}
        .round:hover{background:var(--muted)}
        .round.blue{background:var(--primary);border-color:var(--primary);color:var(--on-primary);width:48px;height:48px}.round.blue:hover{filter:brightness(1.12);background:var(--primary)}
        .round .i-sun{display:none}:root[data-theme=dark] .round .i-sun{display:block}:root[data-theme=dark] .round .i-moon{display:none}

        /* Layout */
        .wrap{max-width:1120px;margin:auto;padding:var(--s5) var(--s6) var(--s8)}
        .wrap.home{max-width:none;padding:0}
        .narrow{max-width:1000px}
        .head{display:flex;justify-content:space-between;align-items:flex-end;gap:var(--s4);flex-wrap:wrap;margin-bottom:var(--s5)}
        .sub{color:var(--muted-fg);margin-top:var(--s3);max-width:65ch}
        .card{background:var(--card);border:1.5px solid var(--hair);border-radius:var(--r);padding:var(--s5)}
        .stack>*+*{margin-top:var(--s5)}
        .card-h{display:flex;align-items:center;gap:var(--s3);margin-bottom:var(--s5)}
        .card-h .ib{width:40px;height:40px;border-radius:50%;background:var(--accent);color:var(--on-accent);display:grid;place-items:center}
        .card:nth-of-type(3n+2) .card-h .ib{background:var(--salmon)}.card:nth-of-type(3n) .card-h .ib{background:var(--sky)}

        /* Buttons */
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:var(--s2);min-height:48px;padding:0 var(--s5);border-radius:99px;border:1.5px solid var(--primary);background:var(--primary);color:var(--on-primary);font:700 .9375rem var(--font);text-decoration:none;cursor:pointer;transition:background-color .2s,color .2s,filter .2s}
        .btn:hover{filter:brightness(1.12)}
        .btn.cta{background:var(--accent);border-color:var(--fg);color:var(--on-accent)}
        :root[data-theme=dark] .btn.cta{border-color:var(--accent)}
        .btn.ghost{background:transparent;color:var(--fg);border-color:var(--fg)}.btn.ghost:hover{background:var(--muted);filter:none}
        .btn.danger{background:transparent;color:var(--danger);border-color:var(--danger)}.btn.danger:hover{background:var(--err-bg);filter:none}
        .btn.danger-solid{background:var(--danger);border-color:var(--danger);color:var(--on-danger)}
        .btn.sm{min-height:44px;padding:0 var(--s4);font-size:.875rem}.btn.lg{min-height:56px;padding:0 var(--s6);font-size:1rem}
        .btn[disabled]{opacity:.65;cursor:progress}
        .actions{display:flex;gap:var(--s2);flex-wrap:wrap;align-items:center}

        /* Alerts */
        .alert{border:1.5px solid;border-radius:16px;padding:var(--s4);margin-bottom:var(--s5);display:flex;gap:var(--s3);align-items:flex-start}
        .alert.ok{background:var(--ok-bg);border-color:var(--ok-bd);color:var(--ok-fg)}
        .alert.err{background:var(--err-bg);border-color:var(--err-bd);color:var(--err-fg);display:block}
        .alert.err h2{color:inherit;margin-bottom:var(--s2)}.alert.err ul{margin:0;padding-left:var(--s5)}.alert.err a{color:inherit;font-weight:700}

        /* Forms */
        .field{margin:0}
        label{display:block;font-weight:700;font-size:.875rem;margin-bottom:6px}
        .req{color:var(--danger);margin-left:2px}
        input[type=text],input[type=email],input[type=password],input[type=url],input[type=file],select,textarea{width:100%;min-height:48px;padding:11px var(--s4);border:1.5px solid var(--border);border-radius:14px;font:inherit;background:var(--card);color:var(--fg);transition:border-color .2s}
        .pw-wrap{position:relative}.pw-wrap input{padding-right:52px}
        .pw-toggle{position:absolute;top:0;right:4px;height:48px;width:44px;display:inline-flex;align-items:center;justify-content:center;background:transparent;border:0;border-radius:99px;color:var(--muted-fg);cursor:pointer}
        .pw-toggle:hover{color:var(--fg)}.pw-toggle:focus-visible{outline:3px solid var(--ring);outline-offset:-3px}
        .pw-toggle span{display:inline-flex}.pw-toggle [hidden]{display:none}
        input[type=file]{padding:9px var(--s3)}
        textarea{resize:vertical;line-height:1.5}
        input:hover,select:hover,textarea:hover{border-color:var(--fg)}
        input:focus-visible,select:focus-visible,textarea:focus-visible{outline:3px solid var(--ring);outline-offset:1px;border-color:var(--fg)}
        [aria-invalid=true]{border-color:var(--danger)!important}
        .hint{font-size:.8125rem;color:var(--muted-fg);margin-top:6px}
        .err{display:flex;gap:6px;align-items:flex-start;font-size:.8125rem;font-weight:700;color:var(--danger);margin-top:6px}
        .grid{display:grid;gap:var(--s4)}.g2{grid-template-columns:repeat(2,1fr)}.span2{grid-column:1/-1}
        .check{display:flex;align-items:center;gap:var(--s2);font-weight:500;margin:0;min-height:44px}.check input{width:20px;height:20px;accent-color:var(--primary)}
        .row-item{border:1.5px dashed var(--border);border-radius:18px;padding:var(--s4);margin-bottom:var(--s3);background:var(--bg)}
        .row-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--s3)}
        .row-top strong{font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted-fg)}
        .form-layout{display:grid;grid-template-columns:200px 1fr;gap:var(--s6);align-items:start}
        .toc{position:sticky;top:24px}.toc p{font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:var(--muted-fg);margin-bottom:var(--s2)}
        .toc ol{list-style:none;margin:0;padding:0}.toc a{display:flex;align-items:center;gap:var(--s2);min-height:44px;padding:0 var(--s3);border-radius:99px;color:var(--fg);text-decoration:none;font-size:.9rem;font-weight:500}.toc a:hover{background:var(--muted)}
        .avatar{width:48px;height:48px;border-radius:50%;object-fit:cover;background:var(--accent);color:var(--on-accent);display:grid;place-items:center;font-weight:800;flex-shrink:0}

        /* Stepper */
        .stepper ol{list-style:none;margin:0 0 var(--s5);padding:0;display:flex;gap:var(--s2);flex-wrap:wrap}
        .stepper li{display:flex;align-items:center;gap:var(--s2);color:var(--muted-fg);font-weight:700;font-size:.875rem}
        .stepper li a{display:flex;align-items:center;gap:var(--s2);color:inherit;text-decoration:none;min-height:44px}
        .stepper li+li:before{content:"";width:28px;height:2px;background:var(--border);margin-right:var(--s2)}
        .stepper .dot{width:30px;height:30px;border-radius:50%;display:grid;place-items:center;border:1.5px solid var(--border);font-size:.8125rem}
        .stepper .now{color:var(--fg)}.stepper .now .dot{background:var(--primary);border-color:var(--primary);color:var(--on-primary)}
        .stepper .done .dot{background:var(--accent);border-color:var(--fg);color:var(--on-accent)}.stepper .done{color:var(--fg)}

        /* Badges / lists */
        .badge{display:inline-flex;align-items:center;gap:6px;padding:2px 12px;border-radius:99px;background:var(--muted);color:var(--fg);font-size:.75rem;font-weight:700}
        .badge.ok{background:var(--ok-bg);color:var(--ok-fg);border:1px solid var(--ok-bd)}
        .plist{display:grid;gap:var(--s3)}
        .pitem{display:flex;gap:var(--s4);align-items:center;justify-content:space-between;flex-wrap:wrap;padding:var(--s4) var(--s5)}
        .pitem .who{display:flex;gap:var(--s4);align-items:center;min-width:0}.pitem .who strong{display:block}.pitem .who small{color:var(--muted-fg);display:flex;gap:var(--s2);align-items:center;flex-wrap:wrap}
        .empty{text-align:center;padding:var(--s8) var(--s5)}.empty .ib{width:64px;height:64px;border-radius:50%;background:var(--accent);color:var(--on-accent);display:grid;place-items:center;margin:0 auto var(--s4)}
        .empty p{color:var(--muted-fg);margin:var(--s2) 0 var(--s5)}

        /* Template picker + preview */
        .tgrid{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(300px,100%),1fr));gap:var(--s5)}
        .tcard{background:var(--card);border:1.5px solid var(--hair);border-radius:var(--r);overflow:hidden;display:flex;flex-direction:column}
        .tcard.sel{border-color:var(--primary);box-shadow:0 0 0 3px color-mix(in srgb,var(--primary) 30%,transparent)}
        .thumb{height:220px;overflow:hidden;position:relative;background:#e5e7eb;border-bottom:1.5px solid var(--hair)}
        .thumb iframe{width:1200px;height:900px;border:0;transform-origin:0 0;pointer-events:none;position:absolute;top:0;left:0;background:#fff}
        .tbody{padding:var(--s5);display:flex;flex-direction:column;gap:var(--s3);flex:1}.tbody p{color:var(--muted-fg);font-size:.9375rem}.tbody .actions{margin-top:auto;padding-top:var(--s2)}
        .tbar{background:var(--card);border:1.5px solid var(--hair);border-radius:var(--r) var(--r) 0 0;padding:var(--s3) var(--s4);display:flex;gap:var(--s3);align-items:center;justify-content:space-between;flex-wrap:wrap}
        .tabs{display:flex;gap:var(--s2);flex-wrap:wrap}
        .tabs a{display:inline-flex;align-items:center;gap:6px;min-height:44px;padding:0 var(--s4);border-radius:99px;border:1.5px solid var(--fg);color:var(--fg);font-weight:700;font-size:.875rem;text-decoration:none}
        .tabs a:hover{background:var(--muted)}.tabs a[aria-current=true]{background:var(--fg);color:var(--bg)}
        .frame{width:100%;border:1.5px solid var(--hair);border-top:0;border-radius:0 0 var(--r) var(--r);display:block;height:78vh;min-height:560px;background:#fff}

        /* ---------- Home ---------- */
        .hero{position:relative;text-align:center;padding:0 var(--s6) var(--s7)}
        .hero-top{position:relative;width:100%;display:flex;flex-direction:column;align-items:center;padding:var(--s6) 0 var(--s7)}
        .hero-top>*{position:relative;z-index:1}
        .hero-top>.stripes{position:absolute;z-index:0;border-radius:0 0 24px 24px;overflow:hidden}
        .gridbg{position:absolute!important;left:50%;top:70px;width:min(78%,860px);height:440px;transform:translateX(-50%) perspective(800px) rotateX(38deg) rotateZ(-5deg);z-index:0!important;pointer-events:none;
            background-image:linear-gradient(var(--grid) 2px,transparent 2px),linear-gradient(90deg,var(--grid) 2px,transparent 2px);background-size:70px 70px;
            -webkit-mask-image:radial-gradient(closest-side,#000 40%,transparent 100%);mask-image:radial-gradient(closest-side,#000 40%,transparent 100%)}
        .pill{display:inline-flex;align-items:center;gap:var(--s2);border:1.5px solid var(--fg);background:var(--bg);border-radius:99px;padding:8px 18px;font-weight:800;font-size:.8125rem;text-transform:uppercase;letter-spacing:.03em;margin-top:var(--s5)}
        .mega{font:400 clamp(2.5rem,8.2vw,6.75rem)/.98 var(--disp);text-transform:uppercase;letter-spacing:-.02em;margin:var(--s5) 0 0;color:var(--fg)}
        .mega span{display:block}.mega .alt{display:inline;font-family:var(--serif);font-style:italic;font-weight:400;font-size:1.12em;letter-spacing:0;line-height:.8}
        .lead{max-width:48ch;margin:var(--s5) auto var(--s5);color:var(--muted-fg);font-size:1.125rem;font-weight:500}
        .bubble{position:absolute!important;border-radius:50%;display:grid;place-items:center;color:#150F4A;overflow:hidden}
        .bubble svg{width:68%;height:68%;margin-top:14%}
        .b1{left:10%;top:120px;width:84px;height:84px;background:var(--salmon)}
        .b2{left:17%;top:455px;width:58px;height:58px;background:var(--accent)}
        .b3{right:14%;top:410px;width:82px;height:82px;background:var(--lav)}
        .arrow{position:absolute!important;width:90px;height:190px;fill:none;stroke:var(--salmon);stroke-width:2.2;stroke-linecap:round;stroke-dasharray:5 7}
        .a1{left:7%;top:230px}.a2{right:8%;top:225px;transform:rotate(180deg)}
        .join{position:absolute!important;z-index:5!important;right:6%;top:16px;width:128px;height:128px;display:grid;place-items:center;text-decoration:none;color:#150F4A;transform:rotate(-4deg);transition:transform .2s}
        .join:hover{transform:rotate(4deg) scale(1.05)}
        .join svg{position:absolute;inset:0;width:100%;height:100%;fill:#F8E27A}
        .join span.sr{position:absolute;width:1px;height:1px;max-width:none;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap}
        .join span:not(.sr){position:relative;font-weight:800;font-size:.9375rem;line-height:1.15;text-transform:uppercase;text-align:center;max-width:none}
        .stats{width:100%;max-width:880px;margin:0 auto;position:relative;z-index:2;display:grid;grid-template-columns:1fr 1fr;align-items:start;gap:var(--s6)}
        .stat-side{display:grid;gap:var(--s4);justify-items:center;text-align:center}
        .stat-side .say{max-width:28ch;font-size:1rem;font-weight:500}
        .names{font:400 1.0625rem var(--disp);text-transform:uppercase;display:flex;gap:var(--s3);flex-wrap:wrap;justify-content:center}
        .dots{display:flex;gap:6px}.dots i{width:14px;height:14px;border-radius:50%}.dots i:nth-child(1){background:var(--accent)}.dots i:nth-child(2){background:var(--salmon)}.dots i:nth-child(3){background:var(--sky)}
        .uline{font-weight:800;text-transform:uppercase;font-size:.875rem;letter-spacing:.04em;color:var(--fg);text-decoration:none;border-bottom:2px solid var(--fg);padding:12px 0 2px}
        .uline:hover{color:var(--link);border-color:var(--link)}

        .band{padding:var(--s8) var(--s6) 0}
        .band h2.title{font:400 clamp(1.75rem,4.2vw,3rem)/1.02 var(--disp);text-transform:uppercase;text-align:center;letter-spacing:-.01em}
        .band .sub{text-align:center;margin:var(--s3) auto var(--s6)}
        .steps{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(auto-fit,minmax(min(250px,100%),1fr));gap:var(--s5);max-width:1120px;margin-inline:auto}
        .steps li{background:var(--card);border:1.5px solid var(--hair);border-radius:var(--r);padding:var(--s5)}
        .steps .n{width:52px;height:52px;border-radius:50%;display:grid;place-items:center;font:400 1.375rem var(--disp);color:#150F4A;margin-bottom:var(--s4)}
        .steps li:nth-child(1) .n{background:var(--accent)}.steps li:nth-child(2) .n{background:var(--salmon)}.steps li:nth-child(3) .n{background:var(--sky)}
        .steps h3{font-size:1.125rem;font-weight:800;margin-bottom:var(--s2)}.steps p{color:var(--muted-fg);font-size:.9375rem}
        .mocks{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(260px,100%),1fr));gap:var(--s5);max-width:1120px;margin-inline:auto}
        .mock{background:var(--card);border:1.5px solid var(--hair);border-radius:var(--r);padding:var(--s4)}
        .mock .scr{aspect-ratio:4/3;border-radius:14px;border:1.5px solid var(--hair);padding:var(--s3);display:grid;gap:6px;align-content:start;overflow:hidden;background:#fff}
        .mock i{display:block;border-radius:3px;background:#d4d9e2}.mock i.k{background:#111}
        .mock figcaption{margin-top:var(--s3);font-weight:800}.mock figcaption span{display:block;font-weight:400;font-size:.875rem;color:var(--muted-fg)}
        .m-formal .scr{grid-template-columns:34% 1fr;padding:0;gap:0;background:#fff}.m-formal .sd{background:#14284B;padding:10px;display:grid;gap:6px;align-content:start}.m-formal .sd i{background:#C9D3E6;height:6px}.m-formal .sd i.g{background:#E3C57A}
        .m-formal .mn{padding:10px;display:grid;gap:6px;align-content:start}.m-formal .mn i{height:6px;background:#d4d9e2}.m-formal .mn i.k{background:#14284B;height:14px;width:70%}.m-formal .mn i.g{background:#B8903A;height:3px;width:30%}
        .m-glass .scr{background:linear-gradient(135deg,#C7D2FE,#A5F3FC 55%,#F5D0FE);grid-template-columns:1fr 1fr;grid-auto-rows:30px}.m-glass i{border-radius:12px;background:rgba(255,255,255,.75);border:1px solid #fff}
        .m-cyber .scr{background:#05070F;border-color:#1b2a4a}.m-cyber i{border:1px solid #22d3ee;background:rgba(34,211,238,.14);border-radius:0;height:14px;animation:hr 14s linear infinite}.m-cyber i.p{border-color:#e879f9;background:rgba(232,121,249,.16)}
        @keyframes hr{to{filter:hue-rotate(360deg)}}
        .feat{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(240px,100%),1fr));gap:var(--s5);max-width:1120px;margin-inline:auto;list-style:none;padding:0}
        .feat li{background:var(--card);border:1.5px solid var(--hair);border-radius:var(--r);padding:var(--s5)}
        .feat .fi{width:44px;height:44px;border-radius:50%;display:grid;place-items:center;background:var(--muted);color:var(--ink-blue);margin-bottom:var(--s3)}
        .feat h3{font-size:1.0625rem;font-weight:800;margin-bottom:var(--s2)}.feat p{color:var(--muted-fg);font-size:.9375rem}
        .band.caps :is(.sub,h3,p){text-transform:capitalize}
        .cta-band{margin:var(--s8) var(--s6) var(--s7);text-align:center;background:#2B2BE8;color:#fff;border-radius:var(--r);padding:var(--s8) var(--s5);position:relative;overflow:hidden}
        .cta-band h2{font:400 clamp(1.75rem,4.2vw,3rem)/1.02 var(--disp);text-transform:uppercase;color:#fff}.cta-band p{margin:var(--s3) 0 var(--s5);opacity:.92}
        .cta-band .btn.cta{border-color:#F8E27A}

        /* ---------- Manage tiles ---------- */
        :root{--ph-bg:#D5DAE3;--ph-fg:#98A1B5}:root[data-theme=dark]{--ph-bg:#2A2F45;--ph-fg:#5E6682}
        .mgrid{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(auto-fill,minmax(min(230px,100%),1fr));gap:var(--s5)}
        .tile{background:var(--card);border:1.5px solid var(--hair);border-radius:var(--r);overflow:hidden;display:flex;flex-direction:column;transition:transform .2s ease,border-color .2s ease,box-shadow .2s ease}
        .tile .photo{aspect-ratio:1/1;width:100%;height:auto;object-fit:cover;display:block;background:var(--muted)}
        .tile .noimg{aspect-ratio:1/1;width:100%;display:grid;place-items:end center;background:var(--ph-bg);color:var(--ph-fg);overflow:hidden}
        .tile .noimg svg{width:80%;height:80%;display:block}
        .tile .tb{padding:var(--s4);display:grid;gap:var(--s3);flex:1;align-content:start}
        .tile .nm{font-weight:800;font-size:1.0625rem;line-height:1.25;overflow-wrap:anywhere}
        .tile .em{color:var(--muted-fg);font-size:.875rem;overflow-wrap:anywhere;margin-top:2px}
        .tile .upd{color:var(--muted-fg);font-size:.8125rem}
        .tile .acts{display:grid;grid-template-columns:1fr 1fr;gap:var(--s2);margin-top:var(--s2)}
        .tile .acts form{margin:0}.tile .acts .btn{width:100%;padding:0 var(--s3)}.tile .acts .full{grid-column:1/-1}

        /* ---------- Interaction ---------- */
        .btn:active,.round:active{transform:scale(.96)}
        .btn,.round{transition:background-color .2s,color .2s,filter .2s,transform .12s ease}
        .steps li,.feat li,.mock,.tcard,.stat-side{transition:transform .25s ease,border-color .25s ease,box-shadow .25s ease}
        @media (hover:hover){
            .tile:hover,.steps li:hover,.feat li:hover,.mock:hover,.tcard:hover{transform:translateY(-5px);border-color:var(--fg)}
            .tile:hover{box-shadow:0 14px 30px rgba(21,15,74,.16)}
            .bubble{transition:translate .25s ease-out,scale .2s ease}.bubble:hover{scale:1.12}
            .join{transition:transform .2s,translate .25s ease-out}
        }
        .hero .bubble,.hero .join,.hero .arrow{translate:calc(var(--px,0) * 16px) calc(var(--py,0) * 16px)}
        @media (prefers-reduced-motion:no-preference){
            html.js [data-reveal]{opacity:0;transform:translateY(22px);transition:opacity .7s ease,transform .7s ease}
            html.js [data-reveal].in{opacity:1;transform:none}
        }
        .totop{position:fixed;right:20px;bottom:20px;z-index:60;width:48px;height:48px;border-radius:50%;border:1.5px solid var(--fg);background:var(--accent);color:var(--on-accent);display:grid;place-items:center;cursor:pointer;transition:opacity .25s,transform .12s}
        .totop:active{transform:scale(.94)}.totop svg{transform:rotate(-90deg)}
        .toast{position:fixed;left:50%;bottom:24px;transform:translateX(-50%);z-index:80;background:var(--fg);color:var(--bg);padding:10px 20px;border-radius:99px;font-weight:700;font-size:.9375rem}

        /* ---------- Loading screen ---------- */
        #loader{position:fixed;inset:0;z-index:1000;display:grid;place-items:center;background:var(--bg);color:var(--fg);transition:opacity .4s ease,visibility .4s ease}
        #loader:not(.js-nav){animation:ldFail 0s linear 7s forwards}
        #loader.done{opacity:0;visibility:hidden;pointer-events:none}
        @keyframes ldFail{to{opacity:0;visibility:hidden;pointer-events:none}}
        .ld-in{text-align:center}
        .ld-mark{display:flex;gap:8px;height:64px;align-items:flex-end;justify-content:center}
        .ld-mark i{width:18px;height:100%;border-radius:6px;transform-origin:bottom;animation:ldBar 1s ease-in-out infinite}
        .ld-mark i:nth-child(1){background:var(--accent)}.ld-mark i:nth-child(2){background:var(--salmon);animation-delay:.15s}.ld-mark i:nth-child(3){background:var(--sky);animation-delay:.3s}
        @keyframes ldBar{0%,100%{transform:scaleY(.35)}50%{transform:scaleY(1)}}
        .ld-text{margin-top:var(--s4);font:400 1.5rem var(--disp);text-transform:uppercase;letter-spacing:.02em}

        /* ---------- Accounts ---------- */
        .nav-out{margin:0}
        .auth-wrap{max-width:460px;margin:var(--s6) auto 0}
        .auth-wrap h1{margin-bottom:var(--s2)}
        .auth-wrap .stack>*+*{margin-top:var(--s4)}
        .auth-note{display:flex;gap:var(--s3);align-items:flex-start;background:var(--muted);border-radius:14px;padding:var(--s3) var(--s4);color:var(--muted-fg);font-size:.875rem;margin-top:var(--s5)}
        .auth-alt{text-align:center;margin-top:var(--s5);color:var(--muted-fg)}
        .share-box{display:flex;gap:var(--s2);flex-wrap:wrap;align-items:center}
        .share-box input{flex:1;min-width:220px}
        .saved-grid{display:grid;grid-template-columns:240px 1fr;gap:var(--s6);align-items:start}
        .saved-photo{aspect-ratio:1/1;width:100%;border-radius:var(--r);border:1.5px solid var(--hair);overflow:hidden;background:var(--ph-bg);color:var(--ph-fg);display:grid;place-items:end center}
        .saved-photo img{width:100%;height:100%;object-fit:cover;display:block}.saved-photo svg{width:80%;height:80%}
        .tick{width:64px;height:64px;border-radius:50%;background:var(--accent);color:var(--on-accent);display:grid;place-items:center;margin-bottom:var(--s4)}
        @media (max-width:760px){.saved-grid{grid-template-columns:1fr}.saved-photo{max-width:220px}}

        /* Dialog + footer */
        dialog{border:1.5px solid var(--fg);border-radius:var(--r);padding:var(--s5);max-width:min(440px,calc(100vw - 32px));background:var(--card);color:var(--fg);box-shadow:0 20px 50px rgba(0,0,0,.3)}
        dialog::backdrop{background:rgba(21,15,74,.65)}
        dialog h2{margin-bottom:var(--s2);font-size:1.25rem}dialog p{color:var(--muted-fg);margin-bottom:var(--s5)}dialog .actions{justify-content:flex-end}
        .foot{border-top:1.5px solid var(--hair);margin-top:var(--s7);padding:var(--s7) var(--s6) var(--s5)}
        .foot-in{max-width:1120px;margin:auto;display:grid;grid-template-columns:1.6fr 1fr 1fr 1fr;gap:var(--s6)}
        .foot-brand p{color:var(--muted-fg);font-size:.9375rem;margin-top:var(--s3);max-width:38ch}
        .foot h2{font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:var(--muted-fg);margin-bottom:var(--s2)}
        .foot ul{list-style:none;margin:0;padding:0}
        .foot li a{display:inline-flex;align-items:center;min-height:44px;color:var(--fg);text-decoration:none;font-weight:500;font-size:.9375rem}
        .foot li a:hover{text-decoration:underline;text-underline-offset:4px}
        .foot-bottom{max-width:1120px;margin:var(--s6) auto 0;padding-top:var(--s4);border-top:1px solid var(--hair);color:var(--muted-fg);font-size:.8125rem}

        /* Info pages */
        .prose{max-width:74ch}
        .prose h2{font-size:1.375rem;font-weight:800;margin:var(--s7) 0 var(--s3)}.prose h2:first-child{margin-top:0}
        .prose p,.prose li{color:var(--fg);font-size:1.0625rem}.prose p+p{margin-top:var(--s3)}
        .prose ul{padding-left:var(--s5);margin:var(--s3) 0}.prose li{margin-bottom:var(--s2)}
        .prose .muted{color:var(--muted-fg)}
        .callout{border:1.5px solid var(--fg);border-radius:18px;background:var(--accent);color:var(--on-accent);padding:var(--s4) var(--s5);margin:var(--s5) 0;font-weight:500}
        .callout strong{font-weight:800}
        .faq{display:grid;gap:var(--s3);max-width:860px;margin-inline:auto}
        .faq details{border:1.5px solid var(--hair);border-radius:18px;background:var(--card)}
        .faq summary{display:flex;justify-content:space-between;align-items:center;gap:var(--s4);min-height:56px;padding:var(--s3) var(--s5);font-weight:700;cursor:pointer;list-style:none}
        .faq summary::-webkit-details-marker{display:none}
        .faq summary::after{content:"+";font:400 1.5rem/1 var(--disp);color:var(--ink-blue);flex-shrink:0}
        .faq details[open] summary::after{content:"\2013"}
        .faq details[open]{border-color:var(--fg)}
        .faq details p{padding:0 var(--s5) var(--s5);color:var(--muted-fg);max-width:68ch}
        .facts{list-style:none;margin:var(--s7) auto 0;padding:0 var(--s6);max-width:1120px;display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:var(--s5);text-align:center}
        .facts b{display:block;font:400 clamp(2.25rem,5vw,3.25rem)/1 var(--disp)}
        .facts span{display:block;color:var(--muted-fg);font-size:.9375rem;margin-top:var(--s2)}
        .facts li:nth-child(4n+1) b{text-decoration:underline 6px var(--accent);text-underline-offset:6px}.facts li:nth-child(4n+2) b{text-decoration:underline 6px var(--salmon);text-underline-offset:6px}
        .facts li:nth-child(4n+3) b{text-decoration:underline 6px var(--sky);text-underline-offset:6px}.facts li:nth-child(4n) b{text-decoration:underline 6px var(--lav);text-underline-offset:6px}
        .chips{list-style:none;margin:0 auto;padding:0;display:flex;flex-wrap:wrap;gap:var(--s2);justify-content:center;max-width:860px}
        .chips li{border:1.5px solid var(--fg);border-radius:99px;padding:8px 18px;font-weight:700;font-size:.9375rem;background:var(--card)}
        .more{text-align:center;margin-top:var(--s5)}
        .who .fi{background:var(--accent);color:var(--on-accent)}.who li:nth-child(2) .fi{background:var(--salmon)}.who li:nth-child(3) .fi{background:var(--sky)}
        .what .fi{background:var(--muted)}

        @media (hover:none){.btn:hover{filter:none}.btn.ghost:hover,.btn.danger:hover,.round:hover,.tabs a:hover,.toc a:hover{background:transparent}.join:hover{transform:rotate(-4deg)}}
        @media (max-width:1000px){.b1{left:5%}.b2{left:8%}.b3{right:6%}.a1,.a2{display:none}}
        @media (max-width:900px){
            .form-layout{grid-template-columns:1fr}.toc{display:none}
            .nav{height:auto;padding:var(--s3) 0}.nav>.stripes{display:none}
            .nav-in{display:flex;flex-wrap:wrap;gap:var(--s2) var(--s3);padding:0 var(--s4)}.cell{display:contents}
            .brand{order:1}.nav-act{order:2;margin-left:auto}.nav ul{order:3}
            .hero{padding:0 var(--s4) var(--s6)}.hero-top{padding-top:var(--s5)}.gridbg{top:40px;height:320px}
            .b1{top:40px;width:64px;height:64px}.b2{top:auto;bottom:260px;left:4%}.b3{top:auto;bottom:300px;right:4%;width:64px;height:64px}
            .join{top:12px;right:3%;width:96px;height:96px}.join span{font-size:.75rem}
            .foot-in{grid-template-columns:1fr 1fr}.stats{grid-template-columns:1fr}
        }
        @media (max-width:640px){.g2{grid-template-columns:1fr}.wrap{padding:var(--s5) var(--s4) var(--s7)}.card{padding:var(--s4)}.band{padding:var(--s7) var(--s4) 0}.cta-band{margin:var(--s7) var(--s4)}
            .foot{padding:var(--s6) var(--s4) var(--s4)}.foot-in{grid-template-columns:1fr}.facts{padding:0 var(--s4)}
            .sheet{width:100%}.b2,.b3{display:none}
            /* badge: smaller, tucked into the top-right corner so it no longer covers the "Portfolio platform" pill */
            .join{top:-14px;right:2%;width:80px;height:80px;transform:rotate(8deg)}.join span:not(.sr){font-size:.6875rem}
            .hero-top .pill{margin-top:72px;font-size:.75rem;padding:8px 14px}}
        /* Log in buttons (top bar + hero): coloured instead of a plain outline */
        .btn.ghost.login{background:var(--sky);border-color:var(--fg);color:#150F4A}
        .btn.ghost.login:hover{background:var(--sky);filter:brightness(1.08)}
        :root[data-theme=dark] .btn.ghost.login{border-color:var(--sky)}
        /* Preview toolbar: template tabs + action buttons stay in ONE row (scrolls sideways on narrow screens instead of wrapping) */
        .tbar{flex-wrap:nowrap;gap:var(--s2);overflow-x:auto;scrollbar-width:thin}
        .tbar .tabs,.tbar .actions{flex-wrap:nowrap;flex:0 0 auto;gap:var(--s2)}
        .tbar form{margin:0}
        .tbar .tabs a,.tbar .btn{white-space:nowrap;min-height:40px;padding:0 14px;font-size:.8125rem}
        @media (prefers-reduced-motion:reduce){*,*::before,*::after{transition:none!important;animation:none!important;scroll-behavior:auto!important}.ld-mark i{transform:scaleY(.7)!important}}
    </style>
</head>
<body>
<noscript><style>#loader{display:none}</style></noscript>
<div id="loader" role="status" aria-live="polite">
    <div class="ld-in"><div class="ld-mark" aria-hidden="true"><i></i><i></i><i></i></div><p class="ld-text">Opusio</p><span class="sr">Loading…</span></div>
</div>
<a class="skip" href="#main">Skip to main content</a>
<div class="sheet">
<header class="nav">
    <div class="stripes" aria-hidden="true"><i></i><i></i><i></i></div>
    <nav class="nav-in" aria-label="Main">
        <div class="cell l">
            <a class="brand" href="{{ route('home') }}"><span class="mark" aria-hidden="true"><i></i><i></i><i></i></span>Opusio</a>
            <ul>
                <li><a href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Home</a></li>
                <li><a href="{{ route('home') }}#how">How it works</a></li>
                <li><a href="{{ route('home') }}#templates">Templates</a></li>
            </ul>
        </div>
        <div class="cell r">
            <ul>
                <li><a href="{{ route('about') }}" @if (request()->routeIs('about')) aria-current="page" @endif>About</a></li>
                <li><a href="{{ route('faq') }}" @if (request()->routeIs('faq')) aria-current="page" @endif>FAQ</a></li>
                @auth
                    <li><a href="{{ route('portfolios.index') }}" @if (request()->routeIs('portfolios.index')) aria-current="page" @endif>Manage</a></li>
                @endauth
            </ul>
            <div class="nav-act">
                <button type="button" class="round" id="theme-toggle" aria-pressed="false" aria-label="Dark mode" title="Switch between light and dark mode">
                    <x-icon name="moon" class="i-moon" /><x-icon name="sun" class="i-sun" />
                </button>
                @auth
                    <a class="round blue" href="{{ route('portfolios.create') }}" aria-label="Create portfolio" title="Create portfolio" @if (request()->routeIs('portfolios.create')) aria-current="page" @endif><x-icon name="plus" /></a>
                    <form method="POST" action="{{ route('logout') }}" class="nav-out">
                        @csrf
                        <button type="submit" class="btn ghost sm" title="Logged in as {{ auth()->user()->name }}"><x-icon name="user" :size="16" /> Log out</button>
                    </form>
                @else
                    <a class="btn ghost login sm" href="{{ route('login') }}" @if (request()->routeIs('login')) aria-current="page" @endif>Log in</a>
                    <a class="btn sm" href="{{ route('register') }}" @if (request()->routeIs('register')) aria-current="page" @endif>Sign up</a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<main id="main" class="@hasSection('full')@else wrap @yield('wrapclass')@endif" tabindex="-1">
    @if (session('success'))
        <div class="@hasSection('full') wrap @endif" style="@hasSection('full') padding-bottom:0 @endif">
            <div class="alert ok" role="status"><x-icon name="check" /> <span>{{ session('success') }}</span></div>
        </div>
    @endif
    @if (session('error'))
        <div class="@hasSection('full') wrap @endif" style="@hasSection('full') padding-bottom:0 @endif">
            <div class="alert err" role="alert"><x-icon name="alert" /> <span>{{ session('error') }}</span></div>
        </div>
    @endif
    @if ($errors->any() && ! View::hasSection('own_errors'))
        <div class="alert err" role="alert"><h2>There is a problem</h2>
            <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    @hasSection('full')
        @yield('full')
    @else
        @yield('content')
    @endif
</main>
@unless (View::hasSection('full'))
<footer class="foot">
    <div class="foot-in">
        <div class="foot-brand">
            <a class="brand" href="{{ route('home') }}"><span class="mark" aria-hidden="true"><i></i><i></i><i></i></span>Opusio</a>
            <p>Build, preview and share an online portfolio in minutes. Your details are saved in a cloud database and shown in three ready-made designs.</p>
        </div>
        <nav aria-label="Product"><h2>Product</h2><ul>
            <li><a href="{{ route('portfolios.create') }}">Create portfolio</a></li>
            <li><a href="{{ route('portfolios.index') }}">Manage portfolios</a></li>
            <li><a href="{{ route('home') }}#templates">Templates</a></li>
            <li><a href="{{ route('home') }}#features">Features</a></li>
        </ul></nav>
        <nav aria-label="Learn"><h2>Learn</h2><ul>
            <li><a href="{{ route('home') }}#how">How it works</a></li>
            <li><a href="{{ route('faq') }}">FAQ</a></li>
            <li><a href="{{ route('about') }}">About Opusio</a></li>
        </ul></nav>
        <nav aria-label="Information"><h2>Information</h2><ul>
            <li><a href="{{ route('privacy') }}">Privacy and data</a></li>
        </ul></nav>
    </div>
    <p class="foot-bottom">&copy; {{ date('Y') }} Opusio &middot; Built with Laravel and Supabase PostgreSQL</p>
</footer>
@endunless

</div>

<dialog id="confirm" aria-labelledby="confirm-title" aria-describedby="confirm-text">
    <form method="dialog">
        <h2 id="confirm-title">Delete portfolio?</h2>
        <p id="confirm-text">This cannot be undone.</p>
        <div class="actions">
            <button class="btn ghost" value="cancel" autofocus>Cancel</button>
            <button class="btn danger-solid" value="ok">Delete</button>
        </div>
    </form>
</dialog>

<script>
(function () {
    // Light / dark toggle (choice is remembered; follows the system until the user picks one)
    var root = document.documentElement, btn = document.getElementById('theme-toggle');
    var mq = matchMedia('(prefers-color-scheme: dark)');
    function sync() { btn.setAttribute('aria-pressed', root.getAttribute('data-theme') === 'dark' ? 'true' : 'false'); }
    btn.addEventListener('click', function () {
        var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', next);
        try { localStorage.setItem('pg-theme', next); } catch (e) {}
        sync();
    });
    mq.addEventListener && mq.addEventListener('change', function (e) {
        var saved = null; try { saved = localStorage.getItem('pg-theme'); } catch (x) {}
        if (!saved) { root.setAttribute('data-theme', e.matches ? 'dark' : 'light'); sync(); }
    });
    sync();
})();
(function () {
    // Delete confirmation (native <dialog>: focus is trapped, Esc cancels, Cancel is focused first)
    const dlg = document.getElementById('confirm');
    document.addEventListener('submit', function (e) {
        const f = e.target;
        if (f.dataset.confirm && !f.dataset.ok && dlg && dlg.showModal) {
            e.preventDefault();
            document.getElementById('confirm-title').textContent = f.dataset.confirmTitle || 'Are you sure?';
            document.getElementById('confirm-text').textContent = f.dataset.confirm;
            dlg.returnValue = 'cancel';
            dlg.showModal();
            dlg.addEventListener('close', function once() {
                dlg.removeEventListener('close', once);
                if (dlg.returnValue === 'ok') { f.dataset.ok = '1'; f.requestSubmit(); }
            });
            return;
        }
        // Loading feedback: disable the submit button after the browser has started submitting
        const b = f.querySelector('[type=submit]');
        if (b && !e.defaultPrevented) setTimeout(function () {
            b.disabled = true; b.setAttribute('aria-busy', 'true');
            if (b.dataset.busy) b.textContent = b.dataset.busy;
        }, 0);
    });
    window.addEventListener('pageshow', function (e) {
        if (e.persisted) document.querySelectorAll('[type=submit][disabled]').forEach(function (b) { b.disabled = false; b.removeAttribute('aria-busy'); });
    });
})();
</script>
<button type="button" class="totop" id="totop" hidden aria-label="Back to top"><x-icon name="arrow" /></button>
<script>
(function () {
    var reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* Loading screen: shown on every page load (min 0.5 s), and again when you follow a link */
    var l = document.getElementById('loader'), t0 = performance.now();
    function hide() { setTimeout(function () { l.classList.add('done'); l.setAttribute('aria-hidden', 'true'); }, Math.max(0, 500 - (performance.now() - t0))); }
    if (l) {
        if (document.readyState === 'complete') hide(); else addEventListener('load', hide);
        addEventListener('pageshow', function (e) { if (e.persisted) { l.classList.add('done'); } });
        document.addEventListener('click', function (e) {
            var a = e.target.closest && e.target.closest('a[href]');
            if (!a || e.defaultPrevented || e.button || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
            if ((a.target && a.target !== '_self') || a.hasAttribute('download')) return;
            var u = new URL(a.href, location.href);
            if (u.origin !== location.origin || /\/pdf$/.test(u.pathname)) return;
            if (u.pathname === location.pathname && u.search === location.search) return;
            l.classList.add('js-nav'); l.classList.remove('done'); l.removeAttribute('aria-hidden');
            setTimeout(function () { l.classList.add('done'); }, 8000);
        });
    }

    /* Scroll reveal on the home page */
    var targets = document.querySelectorAll('.wrap.home .band,.wrap.home .cta-band,.wrap.home .facts');
    if ('IntersectionObserver' in window && !reduce) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); count(en.target); } });
        }, { threshold: .12 });
        targets.forEach(function (el) { el.setAttribute('data-reveal', ''); io.observe(el); });
    }

    /* Count-up numbers in the facts strip */
    function count(root) {
        if (reduce) return;
        root.querySelectorAll('.facts b').forEach(function (b) {
            var end = parseInt(b.textContent.replace(/[^0-9]/g, ''), 10);
            if (!end || end > 100000) return;
            var t = performance.now(), dur = 900;
            (function step(now) { var p = Math.min(1, (now - t) / dur); b.textContent = Math.round(end * (1 - Math.pow(1 - p, 3))); if (p < 1) requestAnimationFrame(step); else b.textContent = end.toLocaleString(); })(t);
        });
    }

    /* Gentle pointer parallax on the hero decorations */
    var hero = document.querySelector('.hero');
    if (hero && !reduce && matchMedia('(hover:hover)').matches) {
        hero.addEventListener('pointermove', function (e) {
            var r = hero.getBoundingClientRect();
            hero.style.setProperty('--px', ((e.clientX - r.left) / r.width - .5).toFixed(3));
            hero.style.setProperty('--py', ((e.clientY - r.top) / r.height - .5).toFixed(3));
        });
        hero.addEventListener('pointerleave', function () { hero.style.setProperty('--px', 0); hero.style.setProperty('--py', 0); });
    }

    /* Fields that accept letters only (name, professional title): digits and symbols are removed as you type */
    document.querySelectorAll('[data-letters]').forEach(function (inp) {
        var note = document.getElementById(inp.id + '-note'), re = /[^\p{L}\s.,'’\-]/gu;
        inp.addEventListener('input', function () {
            var clean = inp.value.replace(re, '');
            if (clean !== inp.value) {
                var pos = inp.selectionStart - (inp.value.length - clean.length);
                inp.value = clean; try { inp.setSelectionRange(pos, pos); } catch (e) {}
                if (note) note.hidden = false;
            } else if (note) note.hidden = true;
        });
    });

    /* Back to top */
    var top = document.getElementById('totop');
    addEventListener('scroll', function () { top.hidden = window.scrollY < 700; }, { passive: true });
    top.addEventListener('click', function () { scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' }); });

    /* Copy-to-clipboard buttons: <button data-copy="text"> */
    document.addEventListener('click', function (e) {
        var b = e.target.closest && e.target.closest('[data-copy]');
        if (!b) return;
        var text = b.getAttribute('data-copy');
        function done() {
            var t = document.createElement('div'); t.className = 'toast'; t.setAttribute('role', 'status'); t.textContent = 'Link copied to clipboard';
            document.body.appendChild(t); setTimeout(function () { t.remove(); }, 2200);
        }
        if (navigator.clipboard && window.isSecureContext) navigator.clipboard.writeText(text).then(done);
        else { var ta = document.createElement('textarea'); ta.value = text; document.body.appendChild(ta); ta.select(); try { document.execCommand('copy'); done(); } catch (x) {} ta.remove(); }
    });
})();
</script>
@stack('scripts')
<script>
document.addEventListener('click', function (e) {
    var b = e.target.closest('[data-pw-toggle]');
    if (!b) return;
    var input = document.getElementById(b.getAttribute('data-pw-toggle'));
    if (!input) return;
    var show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    b.setAttribute('aria-pressed', show ? 'true' : 'false');
    b.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    b.querySelector('.pw-show').hidden = show;
    b.querySelector('.pw-hide').hidden = !show;
});
</script>
</body>
</html>
