<div>
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
    {{--
    resources/views/components/stats-counters.blade.php

    Usage:
        <x-stats-counters />

    Custom numbers (icon: box | calendar | pin | heart):
        <x-stats-counters :items="[
            ['icon' => 'box', 'value' => 25000, 'suffix' => '+', 'label' => 'Boxes delivered', 'text' => 'Safely to doorsteps'],
        ]" />

    Numbers count up when the section scrolls into view (Alpine.js, already in Livewire 3).
    NOTE: the default numbers are SAMPLES. Replace them with your real figures.
--}}
@props([
    'eyebrow' => 'Our track record',
    'title' => 'Numbers that show how much we care',
    'items' => [
        ['icon' => 'box',      'value' => 20000, 'suffix' => '+', 'label' => 'Boxes delivered',    'text' => 'Safely handed to families back home.'],
        ['icon' => 'calendar', 'value' => 2,    'suffix' => '+', 'label' => 'Years in business',  'text' => 'Years of reliable cargo service.'],
        ['icon' => 'pin',      'value' => 80,    'suffix' => '+', 'label' => 'Cities served',      'text' => 'Delivering across the Philippines.'],
        ['icon' => 'heart',    'value' => 20000, 'suffix' => '+', 'label' => 'Happy customers',    'text' => 'Families who trust us every time.'],
    ],
])

@php
        $items = \App\Models\StatCounter::forSite() ?: $items;

    $icons = [
        'box'      => 'M12 3 4 7.25v9.5L12 21l8-4.25v-9.5L12 3ZM4 7.25l8 4.25 8-4.25M12 11.5V21',
        'calendar' => 'M7 3v3M17 3v3M4 9.5h16M5.5 5h13A1.5 1.5 0 0 1 20 6.5v12a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 18.5v-12A1.5 1.5 0 0 1 5.5 5ZM9 15l2 2 4-4',
        'pin'      => 'M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0c0 5.4-6.5 11-6.5 11ZM14.25 10a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z',
        'heart'    => 'M12 20.5s-7.5-4.6-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.6-7.5 10.2-7.5 10.2Z',
    ];
@endphp

<section
    {{ $attributes->class('relative my-10 overflow-hidden rounded-3xl bg-blue-950') }}
    aria-labelledby="stats-heading"
>
    {{-- decoration --}}
    <div
        class="pointer-events-none absolute inset-0 opacity-40"
        style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;"
        aria-hidden="true"
    ></div>
    <div class="pointer-events-none absolute -right-20 -top-20 size-80 rounded-full bg-amber-400/20 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-24 -left-16 size-80 rounded-full bg-blue-500/20 blur-3xl" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-7xl px-6 py-12 sm:px-10 sm:py-14">

        {{-- Heading --}}
        <div class="mx-auto max-w-2xl text-center">
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-400/15 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-300">
                <span class="size-1.5 rounded-full bg-amber-400"></span>
                {{ $eyebrow }}
            </p>
            <h2 id="stats-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-white sm:text-4xl">
                {{ $title }}
            </h2>
        </div>

        {{-- Counters --}}
        <dl class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($items as $item)
                <div
                    class="group rounded-2xl border border-white/10 bg-white/5 p-6 text-center backdrop-blur transition hover:-translate-y-1 hover:border-amber-400/50 hover:bg-white/10"
                    x-data="{ n: 0, target: {{ (int) $item['value'] }}, started: false }"
                    x-init="
                        const run = () => {
                            if (started) return;
                            started = true;
                            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) { n = target; return; }
                            const duration = 1800, t0 = performance.now();
                            const step = (t) => {
                                const p = Math.min((t - t0) / duration, 1);
                                n = Math.round(target * (1 - Math.pow(1 - p, 3)));
                                if (p < 1) requestAnimationFrame(step);
                            };
                            requestAnimationFrame(step);
                        };
                        if ('IntersectionObserver' in window) {
                            new IntersectionObserver((entries, obs) => {
                                if (entries[0].isIntersecting) { run(); obs.disconnect(); }
                            }, { threshold: 0.4 }).observe($el);
                        } else { n = target; }
                    "
                >
                    <span class="mx-auto flex size-14 items-center justify-center rounded-full border-2 border-amber-400 transition group-hover:bg-amber-400/10">
                        <svg class="size-8 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision" aria-hidden="true">
                            <path d="{{ $icons[$item['icon']] ?? $icons['box'] }}" />
                        </svg>
                    </span>

                    <dd class="mt-5 font-montserrat text-4xl font-extrabold tabular-nums text-white sm:text-5xl">
                        <span x-text="n.toLocaleString()">{{ number_format((int) $item['value']) }}</span><span class="text-amber-400">{{ $item['suffix'] ?? '' }}</span>
                    </dd>

                    <dt class="mt-2 font-montserrat text-base font-bold text-white">
                        {{ $item['label'] }}
                    </dt>

                    @if (! empty($item['text']))
                        <p class="mt-1 text-sm leading-snug text-white/60">{{ $item['text'] }}</p>
                    @endif
                </div>
            @endforeach
        </dl>
    </div>
</section>
</div>
