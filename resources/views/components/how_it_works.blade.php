<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    {{--
    resources/views/components/how-it-works.blade.php

    Usage:
        <x-how-it-works />

    Show the delivery-updates band (only if you really offer tracking or updates):
        <x-how-it-works :updates="true" />

    Custom steps (icon: book | pickup | truck | home):
        <x-how-it-works :steps="[
            ['icon' => 'book', 'title' => 'Book', 'text' => '...', 'points' => ['...', '...']],
        ]" />

    Optional props: eyebrow, title, subtitle, updatesTitle, updatesText, updatesPoints, cta.

    Needs only Tailwind (no JavaScript).

    NOTE: the wording is SUGGESTED. Edit it so each step describes how your business really works.
--}}
@props([
    'eyebrow' => 'How it works',
    'title' => 'Sending is easy in 4 simple steps',
    'subtitle' => 'From booking to your family\'s door, here is what to expect.',
    'cta' => 'Start your booking',
    'updates' => false,
    'updatesTitle' => 'Stay updated on your shipment',
    'updatesText' => 'We keep you informed from the moment we receive your items until they reach the recipient.',
    'updatesPoints' => ['Delivery updates by text or message', 'Ask us anytime for the status of your shipment'],
    'steps' => [
        [
            'icon' => 'book',
            'title' => 'Book',
            'text' => 'Tell us what you are sending and where it is going.',
            'points' => ['Message us or fill in the contact form', 'Get your quote and confirm your booking'],
        ],
        [
            'icon' => 'pickup',
            'title' => 'Pickup or drop-off',
            'text' => 'We collect from you, or you bring your items to us.',
            'points' => ['Schedule a pickup at your address', 'Or drop off at our branch'],
        ],
        [
            'icon' => 'truck',
            'title' => 'On the way',
            'text' => 'Your items are packed securely and shipped to the Philippines.',
            'points' => ['Handled with care', 'Sent to Luzon, Visayas or Mindanao'],
        ],
        [
            'icon' => 'home',
            'title' => 'Delivered',
            'text' => 'We bring everything to the recipient\'s door.',
            'points' => ['Door-to-door delivery', 'Your family receives it safely'],
        ],
    ],
])

@php
    $icons = [
        'book'   => 'M7 3.5h10A1.5 1.5 0 0 1 18.5 5v14a1.5 1.5 0 0 1-1.5 1.5H7A1.5 1.5 0 0 1 5.5 19V5A1.5 1.5 0 0 1 7 3.5ZM9 8h6M9 12h6M9 16h3',
        'pickup' => 'M12 3 4 7.25v9.5L12 21l8-4.25v-9.5L12 3ZM4 7.25l8 4.25 8-4.25M12 11.5V21',
        'truck'  => 'M3 7a2 2 0 0 1 2-2h8v11H3V7ZM13 9h3.6a1 1 0 0 1 .8.4l2.3 3.1a1 1 0 0 1 .2.6V16H13V9ZM9.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM18.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z',
        'home'   => 'M3 11.5 12 4l9 7.5M5.5 10v9.5a.5.5 0 0 0 .5.5h4v-5h4v5h4a.5.5 0 0 0 .5-.5V10',
    ];
    $bell = 'M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0';
@endphp

<section
    {{ $attributes->class('relative my-10 overflow-hidden rounded-3xl bg-blue-950') }}
    aria-labelledby="how-heading"
>
    {{-- decoration --}}
    <div
        class="pointer-events-none absolute inset-0 opacity-40"
        style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;"
        aria-hidden="true"
    ></div>
    <div class="pointer-events-none absolute -right-20 -top-20 size-80 rounded-full bg-amber-400/20 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-24 -left-16 size-80 rounded-full bg-blue-500/20 blur-3xl" aria-hidden="true"></div>

    <div class="relative px-6 py-12 sm:px-10 sm:py-14">

        {{-- Heading --}}
        <div class="mx-auto max-w-2xl text-center">
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-400/15 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-300">
                <span class="size-1.5 rounded-full bg-amber-400"></span>
                {{ $eyebrow }}
            </p>
            <h2 id="how-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-white sm:text-4xl">
                {{ $title }}
            </h2>
            @if ($subtitle)
                <p class="mt-3 text-base leading-relaxed text-white/70">{{ $subtitle }}</p>
            @endif
        </div>

        {{-- Steps --}}
        <ol class="relative mx-auto mt-14 grid max-w-7xl gap-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">

            {{-- connecting line (desktop) --}}
            <div class="pointer-events-none absolute left-[12.5%] right-[12.5%] top-10 hidden border-t-2 border-dashed border-amber-400/40 lg:block" aria-hidden="true"></div>

            @foreach ($steps as $step)
                <li class="group relative flex flex-col items-center text-center">

                    {{-- icon circle + number badge --}}
                    <div class="relative">
                        <span class="flex size-20 items-center justify-center rounded-full border-2 border-amber-400 bg-blue-950 shadow-lg shadow-amber-400/10 transition duration-300 group-hover:-translate-y-1 group-hover:bg-amber-400">
                            <svg class="size-10 text-amber-400 transition group-hover:text-blue-950" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision" aria-hidden="true">
                                <path d="{{ $icons[$step['icon']] ?? $icons['book'] }}" />
                            </svg>
                        </span>
                        <span class="absolute -right-1 -top-1 flex size-8 items-center justify-center rounded-full bg-amber-400 font-montserrat text-sm font-extrabold text-blue-950 ring-4 ring-blue-950">
                            {{ $loop->iteration }}
                        </span>
                    </div>

                    {{-- card --}}
                    <div class="mt-6 w-full flex-1 rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur transition duration-300 group-hover:border-amber-400/50 group-hover:bg-white/10">
                        <h3 class="font-montserrat text-xl font-extrabold text-white">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-white/70">{{ $step['text'] }}</p>

                        @if (! empty($step['points']))
                            <ul class="mt-4 space-y-2 border-t border-white/10 pt-4 text-left">
                                @foreach ($step['points'] as $point)
                                    <li class="flex items-start gap-2.5 text-sm leading-snug text-white/80">
                                        <span class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full bg-amber-400 text-blue-950">
                                            <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </span>
                                        <span>{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>

        {{-- Delivery updates band (optional) --}}
        @if ($updates)
            <div class="mx-auto mt-12 flex max-w-4xl flex-col gap-5 rounded-2xl border border-amber-400/40 bg-amber-400/10 p-6 sm:flex-row sm:items-center sm:gap-6 sm:p-8">
                <span class="flex size-14 shrink-0 items-center justify-center rounded-full border-2 border-amber-400 text-amber-400">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="{{ $bell }}" />
                    </svg>
                </span>
                <div class="flex-1">
                    <h3 class="font-montserrat text-lg font-extrabold text-white">{{ $updatesTitle }}</h3>
                    <p class="mt-1 text-sm leading-relaxed text-white/75">{{ $updatesText }}</p>
                    <ul class="mt-3 flex flex-wrap gap-x-6 gap-y-2">
                        @foreach ($updatesPoints as $point)
                            <li class="flex items-center gap-2 text-sm font-semibold text-amber-200">
                                <span class="size-1.5 rounded-full bg-amber-400"></span>
                                {{ $point }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- CTA --}}
        <div class="mt-12 text-center">
            <a
                href="{{ route('contact') }}"
                wire:navigate
                class="group inline-flex items-center gap-2 rounded-full bg-amber-400 px-7 py-3.5 font-montserrat text-base font-bold text-blue-950 shadow-lg shadow-amber-400/20 transition hover:-translate-y-0.5 hover:bg-amber-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-blue-950"
            >
                {{ $cta }}
                <svg class="size-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
</div>
