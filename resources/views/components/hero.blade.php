<div>
    <!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
    {{--
    resources/views/components/page-hero.blade.php

    Usage:
        <x-page-hero />

    Custom:
        <x-page-hero
            title="Nationwide delivery,"
            highlight="door to door."
            subtitle="From Manila to the farthest provinces, we deliver safely."
            button="Request a pickup"
            :url="route('contact')"
            :points="['Safe handling', 'Nationwide delivery', 'Balikbayan boxes & cargo']"
        />

    Optional second link: secondary="See our rates" secondary-url="#rates"
--}}
@props([
    'eyebrow' => 'Our services',
    'title' => 'Nationwide delivery,',
    'highlight' => 'door to door.',
    'subtitle' => 'From Manila to the farthest provinces, we deliver safely.',
    'button' => 'Request a pickup',
    'url' => null,
    'secondary' => null,
    'secondaryUrl' => '#',
    'points' => ['Safe handling', 'Nationwide delivery', 'Balikbayan boxes & cargo'],
])

@php
    $url = $url ?? route('contact');
    $truck = 'M3 7a2 2 0 0 1 2-2h8v11H3V7ZM13 9h3.6a1 1 0 0 1 .8.4l2.3 3.1a1 1 0 0 1 .2.6V16H13V9ZM9.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM18.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z';
@endphp

<section {{ $attributes->class('relative overflow-hidden rounded-3xl bg-blue-950') }} aria-labelledby="page-hero-heading">
    {{-- decoration --}}
    <div
        class="pointer-events-none absolute inset-0 opacity-40"
        style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;"
        aria-hidden="true"
    ></div>
    <div class="pointer-events-none absolute -right-24 -top-24 size-96 rounded-full bg-amber-400/20 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-32 -left-20 size-96 rounded-full bg-blue-500/20 blur-3xl" aria-hidden="true"></div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-10 px-6 py-12 sm:px-12 sm:py-16 lg:grid-cols-[1.25fr_1fr]">

        {{-- Text --}}
        <div>
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-400/15 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-300">
                <span class="size-1.5 rounded-full bg-amber-400"></span>
                {{ $eyebrow }}
            </p>

            <h1 id="page-hero-heading" class="mt-5 font-montserrat text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-6xl">
                {{ $title }}
                <span class="text-amber-400">{{ $highlight }}</span>
            </h1>

            <p class="mt-5 max-w-xl text-lg leading-relaxed text-white/75">
                {{ $subtitle }}
            </p>

            {{-- Buttons --}}
            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a
                    href="{{ $url }}"
                    wire:navigate
                    class="group inline-flex items-center gap-2 rounded-full bg-amber-400 px-7 py-3.5 font-montserrat text-base font-bold text-blue-950 shadow-lg shadow-amber-400/20 transition hover:-translate-y-0.5 hover:bg-amber-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-blue-950"
                >
                    {{ $button }}
                    <svg class="size-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>

                @if ($secondary)
                    <a href="{{ $secondaryUrl }}" class="font-montserrat text-base font-semibold text-white underline decoration-amber-400 decoration-2 underline-offset-8 transition hover:text-amber-300">
                        {{ $secondary }}
                    </a>
                @endif
            </div>

            {{-- Trust points --}}
            <ul class="mt-10 flex flex-wrap gap-x-6 gap-y-3 border-t border-white/10 pt-6">
                @foreach ($points as $point)
                    <li class="flex items-center gap-2 text-sm font-semibold text-white/90">
                        <span class="flex size-6 items-center justify-center rounded-full bg-amber-400 text-blue-950">
                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </span>
                        {{ $point }}
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Decorative graphic (desktop only) --}}
        <div class="relative mx-auto hidden size-80 lg:block" aria-hidden="true">
            <div class="absolute inset-0 rounded-full border border-white/10"></div>
            <div class="absolute inset-8 rounded-full border border-dashed border-amber-400/40"></div>
            <div class="absolute inset-16 rounded-full border border-white/10 bg-white/5 backdrop-blur"></div>

            <div class="absolute inset-0 flex items-center justify-center">
                <span class="flex size-32 items-center justify-center rounded-full border-2 border-amber-400 bg-blue-950/60">
                    <svg class="size-16 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision">
                        <path d="{{ $truck }}" />
                    </svg>
                </span>
            </div>

            {{-- island chips --}}
            <span class="absolute left-1/2 top-0 -translate-x-1/2 -translate-y-1/2 rounded-full border border-white/20 bg-blue-950 px-4 py-1.5 font-montserrat text-xs font-bold tracking-wider text-white">
                <span class="mr-1.5 inline-block size-2 rounded-full bg-amber-400"></span>LUZON
            </span>
            <span class="absolute right-0 top-2/3 translate-x-1/4 rounded-full border border-white/20 bg-blue-950 px-4 py-1.5 font-montserrat text-xs font-bold tracking-wider text-white">
                <span class="mr-1.5 inline-block size-2 rounded-full bg-amber-400"></span>VISAYAS
            </span>
            <span class="absolute bottom-2 left-0 -translate-x-1/4 rounded-full border border-white/20 bg-blue-950 px-4 py-1.5 font-montserrat text-xs font-bold tracking-wider text-white">
                <span class="mr-1.5 inline-block size-2 rounded-full bg-amber-400"></span>MINDANAO
            </span>
        </div>
    </div>
</section>
</div>
