{{--
    resources/views/components/page-loader.blade.php

    "Cargo scanner" loader: a holographic 3D shipping box rotates inside an orbit ring
    (three glowing nodes = Luzon, Visayas, Mindanao) while a laser scans it and a counter
    runs from 0 to 100 and ends on "Delivered".

    Usage: put right after <body> in your layout (app.blade.php):
        <x-page-loader />

    Timing (see the two numbers in x-data):
        min    = first visit / refresh, loader lasts at least this many ms
        navMin = every wire:navigate page change, at least this many ms
--}}
@persist('page-loader')
<div
    x-data="{
        show: document.readyState !== 'complete',
        pct: 0,
        ready: false,
        start: Date.now(),
        min: 2600,      {{-- first visit: minimum ms --}}
        navMin: 1100,   {{-- page changes: minimum ms --}}
        dur: 2600,
        raf: null,
        safety: null,
        run() {
            cancelAnimationFrame(this.raf);
            const step = () => {
                const t = Math.min(1, (Date.now() - this.start) / this.dur);
                const eased = 1 - Math.pow(1 - t, 2);
                const cap = this.ready ? 100 : 94;
                this.pct = Math.min(cap, Math.round(eased * 100));
                if (this.ready && this.pct >= 100) {
                    setTimeout(() => this.show = false, 450);
                    return;
                }
                this.raf = requestAnimationFrame(step);
            };
            step();
        },
        open() {
            this.dur = this.navMin;
            this.start = Date.now();
            this.pct = 0;
            this.ready = false;
            this.show = true;
            this.run();
            clearTimeout(this.safety);
            this.safety = setTimeout(() => this.ready = true, 6000); {{-- never get stuck --}}
        },
        get label() {
            return this.pct >= 100 ? 'Delivered' : this.pct >= 66 ? 'Delivering' : this.pct >= 33 ? 'Routing' : 'Packing';
        },
    }"
    x-init="
        if (show) {
            run();
            safety = setTimeout(() => ready = true, 6000);
        }
        window.addEventListener('load', () => ready = true);
        document.addEventListener('livewire:navigate', () => open());
        document.addEventListener('livewire:navigated', () => ready = true);
    "
    x-show="show"
    x-transition:leave="transition duration-700 ease-in"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-105"
    class="ic-loader fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden bg-blue-950"
    role="status"
    aria-live="polite"
    aria-label="Loading"
>
    <style>
        .ic-loader { --amber: 251 191 36; }

        /* background: dot grid + moving scanlines + glow */
        .ic-grid { position:absolute; inset:0; opacity:.35;
            background-image: radial-gradient(rgba(255,255,255,.18) 1px, transparent 1px);
            background-size: 26px 26px;
            -webkit-mask-image: radial-gradient(circle at center, #000 0%, transparent 70%);
                    mask-image: radial-gradient(circle at center, #000 0%, transparent 70%); }
        .ic-lines { position:absolute; inset:0; pointer-events:none; opacity:.5;
            background: repeating-linear-gradient(0deg, rgba(255,255,255,.035) 0 1px, transparent 1px 4px); }
        .ic-sweep { position:absolute; left:0; right:0; height:140px; pointer-events:none;
            background: linear-gradient(180deg, transparent, rgb(var(--amber) / .08), transparent);
            animation: ic-sweep 3.4s linear infinite; }
        .ic-glow { position:absolute; width:520px; height:520px; border-radius:9999px; pointer-events:none;
            background: radial-gradient(circle, rgb(var(--amber) / .16), transparent 65%); }

        /* 3D scene */
        .ic-scene { position:relative; width:240px; height:240px; perspective:760px; }
        .ic-stage { position:absolute; inset:0; transform-style:preserve-3d; transform: rotateX(-22deg); }
        .ic-cube { position:absolute; left:50%; top:50%; width:88px; height:88px; margin:-44px 0 0 -44px;
            transform-style:preserve-3d; animation: ic-spin 8s linear infinite; }
        .ic-face { position:absolute; inset:0; border:1.5px solid rgb(var(--amber) / .95);
            background:
                linear-gradient(90deg, transparent calc(50% - 7px), rgb(var(--amber) / .28) calc(50% - 7px), rgb(var(--amber) / .28) calc(50% + 7px), transparent calc(50% + 7px)),
                rgb(var(--amber) / .06);
            box-shadow: inset 0 0 20px rgb(var(--amber) / .28), 0 0 16px rgb(var(--amber) / .2); }
        .ic-f1 { transform: translateZ(44px); }
        .ic-f2 { transform: rotateY(180deg) translateZ(44px); }
        .ic-f3 { transform: rotateY(90deg) translateZ(44px); }
        .ic-f4 { transform: rotateY(-90deg) translateZ(44px); }
        .ic-f5 { transform: rotateX(90deg) translateZ(44px); }
        .ic-f6 { transform: rotateX(-90deg) translateZ(44px); }

        /* laser plane moving up and down through the box */
        .ic-scan { position:absolute; inset:-14px; border:1.5px solid #fff;
            background: radial-gradient(circle, rgb(var(--amber) / .55), rgb(var(--amber) / .08) 70%);
            box-shadow: 0 0 22px rgb(var(--amber) / .9);
            transform: rotateX(90deg) translateZ(-44px);
            animation: ic-scan 1.9s ease-in-out infinite alternate; }

        /* orbit ring with three nodes */
        .ic-orbit { position:absolute; left:50%; top:50%; width:220px; height:220px; margin:-110px 0 0 -110px;
            transform-style:preserve-3d; transform: rotateX(76deg); }
        .ic-ring { position:absolute; inset:0; border-radius:9999px; border:1px solid rgba(255,255,255,.28);
            animation: ic-rot 6s linear infinite; }
        .ic-ring2 { position:absolute; inset:-22px; border-radius:9999px; border:1px dashed rgb(var(--amber) / .45);
            animation: ic-rot 11s linear infinite reverse; }
        .ic-node { position:absolute; width:12px; height:12px; border-radius:9999px; background:rgb(var(--amber));
            box-shadow: 0 0 14px 3px rgb(var(--amber) / .9); }
        .ic-n1 { top:-6px; left:calc(50% - 6px); }
        .ic-n2 { bottom:14px; left:14px; }
        .ic-n3 { bottom:14px; right:14px; }

        /* floor glow under the box */
        .ic-floor { position:absolute; left:50%; bottom:-8px; width:260px; height:70px; transform:translateX(-50%);
            background: radial-gradient(ellipse at center, rgb(var(--amber) / .4), rgb(var(--amber) / .08) 45%, transparent 70%);
            filter: blur(2px); animation: ic-pulse 1.9s ease-in-out infinite alternate; }

        /* HUD corners */
        .ic-corner { position:absolute; width:26px; height:26px; }
        .ic-c1 { top:22px; left:22px;  border-top:2px solid rgb(251 191 36 / .8); border-left:2px solid rgb(251 191 36 / .8); }
        .ic-c2 { top:22px; right:22px; border-top:2px solid rgb(251 191 36 / .8); border-right:2px solid rgb(251 191 36 / .8); }
        .ic-c3 { bottom:22px; left:22px;  border-bottom:2px solid rgb(251 191 36 / .8); border-left:2px solid rgb(251 191 36 / .8); }
        .ic-c4 { bottom:22px; right:22px; border-bottom:2px solid rgb(251 191 36 / .8); border-right:2px solid rgb(251 191 36 / .8); }

        /* segmented progress bar */
        .ic-bar { height:6px; width:min(320px, 70vw); background: rgba(255,255,255,.1); border-radius:9999px; overflow:hidden; }
        .ic-fill { height:100%; border-radius:9999px; transition: width .12s linear;
            background: linear-gradient(90deg, rgb(var(--amber) / .55), rgb(var(--amber)));
            box-shadow: 0 0 14px rgb(var(--amber) / .8); }
        .ic-ticks { width:min(320px, 70vw); height:6px; margin-top:4px;
            background: repeating-linear-gradient(90deg, rgba(255,255,255,.28) 0 1px, transparent 1px calc(100% / 20)); }

        @keyframes ic-spin  { from { transform: rotateY(0deg) rotateX(14deg); } to { transform: rotateY(360deg) rotateX(14deg); } }
        @keyframes ic-rot   { to { transform: rotate(360deg); } }
        @keyframes ic-scan  { to { transform: rotateX(90deg) translateZ(44px); } }
        @keyframes ic-sweep { from { top:-160px; } to { top:100%; } }
        @keyframes ic-pulse { from { opacity:.55; } to { opacity:1; } }

        @media (prefers-reduced-motion: reduce) {
            .ic-cube, .ic-ring, .ic-ring2, .ic-scan, .ic-sweep, .ic-floor { animation: none; }
        }
    </style>

    <div class="ic-grid" aria-hidden="true"></div>
    <div class="ic-lines" aria-hidden="true"></div>
    <div class="ic-sweep" aria-hidden="true"></div>
    <div class="ic-glow" aria-hidden="true"></div>

    <span class="ic-corner ic-c1" aria-hidden="true"></span>
    <span class="ic-corner ic-c2" aria-hidden="true"></span>
    <span class="ic-corner ic-c3" aria-hidden="true"></span>
    <span class="ic-corner ic-c4" aria-hidden="true"></span>

    {{-- top HUD text --}}
    <p class="absolute left-0 right-0 top-8 text-center font-mono text-[10px] font-semibold uppercase tracking-[0.35em] text-white/40" aria-hidden="true">
        Nationwide delivery <span class="text-amber-400">//</span> Philippines
    </p>

    {{-- 3D cargo scanner --}}
    <div class="ic-scene" aria-hidden="true">
        <div class="ic-floor"></div>
        <div class="ic-stage">
            <div class="ic-orbit">
                <div class="ic-ring2"></div>
                <div class="ic-ring">
                    <span class="ic-node ic-n1"></span>
                    <span class="ic-node ic-n2"></span>
                    <span class="ic-node ic-n3"></span>
                </div>
            </div>

            <div class="ic-cube">
                <span class="ic-face ic-f1"></span>
                <span class="ic-face ic-f2"></span>
                <span class="ic-face ic-f3"></span>
                <span class="ic-face ic-f4"></span>
                <span class="ic-face ic-f5"></span>
                <span class="ic-face ic-f6"></span>
                <span class="ic-scan"></span>
            </div>
        </div>
    </div>

    {{-- brand + counter --}}
    <p class="relative mt-6 font-montserrat text-2xl font-extrabold tracking-[0.25em] text-white">
        i<span class="text-amber-400">CARGOEXPRESS</span>
    </p>

    <div class="relative mt-6 flex w-[min(320px,70vw)] items-end justify-between font-mono">
        <span class="text-[11px] font-semibold uppercase tracking-[0.3em] text-amber-300" x-text="label"></span>
        <span class="text-3xl font-bold leading-none tabular-nums text-white">
            <span x-text="String(pct).padStart(2, '0')"></span><span class="ml-0.5 text-base text-amber-400">%</span>
        </span>
    </div>

    <div class="relative mt-3">
        <div class="ic-bar"><div class="ic-fill" :style="`width:${pct}%`"></div></div>
        <div class="ic-ticks" aria-hidden="true"></div>
    </div>
</div>
@endpersist
