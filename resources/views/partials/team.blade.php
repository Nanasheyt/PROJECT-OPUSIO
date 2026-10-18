@php
    $team    = config('team');
    $members = array_values($team['members'] ?? []);
    $colors  = ['#F9A58F', '#F8E27A', '#9FD3F0', '#B9A2FF', '#F9A58F'];
@endphp
<section class="band team" id="team" aria-labelledby="team-t">
    <h2 class="title" id="team-t">Meet the team</h2>
    <p class="sub">Hover over a head and the hand goes up. Click it to see their details.</p>

    <ul class="team-row" aria-label="Team leader and members">
        @include('partials.team-member', ['m' => $team['leader'], 'i' => 0, 'lead' => true, 'color' => '#2B2BE8'])
        @foreach ($members as $n => $m)
            @include('partials.team-member', ['m' => $m, 'i' => $n + 1, 'lead' => false, 'color' => $colors[$n % count($colors)]])
        @endforeach
    </ul>
</section>

<style>
.team ul{list-style:none;margin:0;padding:0}
/* One row: the leader column is a little wider, so the leader is a little bigger. Everything scales with the character width. */
.team-row{display:flex;justify-content:center;align-items:flex-end;gap:var(--s5) var(--s5);max-width:1120px;margin:var(--s7) auto 0}
.member{position:relative;display:grid;justify-items:center;align-content:end;text-align:center;--w:124px;flex:1 1 0;min-width:0;max-width:calc(var(--w) + 32px)}
.member.is-lead{--w:148px}
.member:hover,.member:focus-within{z-index:6}
.char{position:relative;width:100%;max-width:var(--w);padding-top:4px}
.thead{position:relative;z-index:2;display:grid;place-items:end center;width:70%;aspect-ratio:1/1;height:auto;margin:0 auto -19%;padding:0;border-radius:50%;border:3px solid var(--fg);background:var(--ph-bg);color:var(--ph-fg);overflow:hidden;cursor:pointer;transition:transform .2s ease,box-shadow .2s ease;touch-action:manipulation}
.thead img{width:100%;height:100%;object-fit:cover;display:block}
.thead svg{width:84%;height:84%;display:block}
.thead:focus-visible{outline:4px solid var(--ring);outline-offset:4px}
.tfigure{display:block;width:100%;height:auto;overflow:visible}
.tfigure .torso,.tfigure .limb{fill:var(--bc);stroke:var(--fg);stroke-width:3}
.tfigure .hand{fill:#F3CDAE;stroke:var(--fg);stroke-width:3}
.arm-r{transform-origin:135px 58px;transform:rotate(-8deg);transition:transform .35s cubic-bezier(.3,1.4,.5,1)}
/* Hand goes up while the head is hovered / focused (or briefly after a tap on touch screens) */
.thead:hover + .tfigure .arm-r,.thead:focus-visible + .tfigure .arm-r,.char.wave .arm-r{transform:rotate(-150deg);animation:wave .7s ease-in-out .35s infinite alternate}
@keyframes wave{to{transform:rotate(-126deg)}}
@media (max-width:900px){.team-row{gap:var(--s3) var(--s3)}.member{--w:96px}.member.is-lead{--w:116px}.mname{font-size:.8125rem}.member.is-lead .mname{font-size:.9375rem}.mrole{font-size:.625rem;padding:2px 8px}}
@media (max-width:640px){.team-row{flex-wrap:wrap;row-gap:var(--s6)}.member{--w:104px;flex:0 0 calc(33.333% - var(--s3));max-width:none}.member.is-lead{--w:132px;flex:0 0 100%}}
@media (hover:hover){.thead:hover{transform:translateY(-4px);box-shadow:0 10px 22px rgba(21,15,74,.22)}}
@media (prefers-reduced-motion:reduce){.arm-r{transition:none}.thead:hover + .tfigure .arm-r,.thead:focus-visible + .tfigure .arm-r,.char.wave .arm-r{animation:none}}
.mname{margin-top:var(--s3);font-weight:800;font-size:.9375rem;line-height:1.25;overflow-wrap:anywhere}
.member.is-lead .mname{font-size:1.0625rem}
.mname.is-blank{color:var(--muted-fg)}
.mrole{margin-top:6px;display:inline-block;padding:2px 12px;border-radius:99px;font-size:.6875rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;border:1.5px solid var(--fg)}
.member.is-lead .mrole{background:var(--accent);color:var(--on-accent)}
.team dialog{width:min(460px,calc(100vw - 32px));text-align:left}
.mdlg-top{display:flex;align-items:center;gap:var(--s4);margin-bottom:var(--s4)}
.mdlg-top h3{font-size:1.25rem;font-weight:800;margin-bottom:6px;overflow-wrap:anywhere}
.mav{width:76px;height:76px;border-radius:50%;border:3px solid var(--fg);background:var(--ph-bg);color:var(--ph-fg);display:grid;place-items:end center;overflow:hidden;flex-shrink:0}
.mav img{width:100%;height:100%;object-fit:cover}.mav svg{width:84%;height:84%}
.mnote{background:var(--muted);border-radius:12px;padding:var(--s3) var(--s4);color:var(--muted-fg);margin-bottom:var(--s4)!important;font-size:.9375rem}
.mdl{margin:0 0 var(--s5);display:grid;gap:var(--s3)}
.mdl dt{font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:var(--muted-fg)}
.mdl dd{margin:2px 0 0;overflow-wrap:anywhere}
.mdl .na{color:var(--muted-fg);font-style:italic}
.mlinks{display:flex;flex-wrap:wrap;gap:var(--s2)}
.mlinks a{display:inline-flex;align-items:center;gap:6px;min-height:44px;padding:0 var(--s4);border-radius:99px;border:1.5px solid var(--fg);color:var(--fg);font-weight:700;font-size:.875rem;text-decoration:none}
.mlinks a:hover{background:var(--accent);color:var(--on-accent)}
.team dialog dd a{color:var(--link)}
.team dialog .mlinks a{color:var(--fg)}
</style>
<script>
(function () {
    var team = document.getElementById('team');
    if (!team) return;
    team.querySelectorAll('.thead').forEach(function (btn) {
        var dlg = document.getElementById(btn.getAttribute('aria-controls')), char = btn.closest('.char');
        btn.addEventListener('click', function () {
            char.classList.add('wave');
            setTimeout(function () { char.classList.remove('wave'); }, 1800);
            if (dlg && dlg.showModal) dlg.showModal();
        });
    });
    team.querySelectorAll('dialog').forEach(function (d) {
        d.addEventListener('click', function (e) { if (e.target === d) d.close(); });
        var c = d.querySelector('[data-close]'); if (c) c.addEventListener('click', function () { d.close(); });
    });
})();
</script>
