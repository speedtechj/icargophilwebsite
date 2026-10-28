<div>
    <!-- We must ship. - Taylor Otwell -->
    {{--
    resources/views/components/mission-promise.blade.php

    Usage:
        <x-mission-promise />

    Custom wording:
        <x-mission-promise
            mission-start="Our mission is to deliver your balikbayan boxes and cargo"
            mission-highlight="safely and reliably"
            mission-end="across the Philippines, so every family feels closer to home."
            :promises="[
                ['icon' => 'care',   'title' => 'Care in every box', 'text' => '...'],
                ['icon' => 'honest', 'title' => 'Honest pricing',    'text' => '...'],
                ['icon' => 'time',   'title' => 'Reliable delivery', 'text' => '...'],
                ['icon' => 'help',   'title' => 'Here to help',      'text' => '...'],
            ]"
        />

    Promise icons: care | honest | time | help
    Optional props: missionLabel, promiseEyebrow, promiseTitle, footnote (set footnote="" to hide).

    Needs only Tailwind (no JavaScript).

    IMPORTANT: this wording is a DRAFT written for you. Read every promise and delete or reword
    any you cannot keep every time. A short list you keep is worth more than a long one you don't.
--}}
@props([
    'missionLabel' => 'Our mission',
    'missionStart' => 'We deliver your balikbayan boxes and cargo',
    'missionHighlight' => 'safely and reliably',
    'missionEnd' => 'across the Philippines, so every family feels closer to home.',

    'promiseEyebrow' => 'Our promise to you',
    'promiseTitle' => 'What you can count on',
    'promises' => [
        [
            'icon' => 'care',
            'title' => 'Care in every box',
            'text' => 'We handle every shipment as if it were our own family\'s, from the moment we receive it until it reaches the door.',
        ],
        [
            'icon' => 'honest',
            'title' => 'Honest pricing',
            'text' => 'You will know the cost before you send. We explain our rates clearly, so there are no surprises.',
        ],
        [
            'icon' => 'time',
            'title' => 'Reliable delivery',
            'text' => 'We give you a clear delivery estimate and work hard to keep to it.',
        ],
        [
            'icon' => 'help',
            'title' => 'Always here to help',
            'text' => 'Questions about your shipment? Message us and a real person will get back to you.',
        ],
    ],
    'footnote' => 'Something not right with your shipment? Tell us and we will do our best to make it right.',
])

@php
    $icons = [
        'care'   => 'M12 20.5s-7.5-4.6-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.6-7.5 10.2-7.5 10.2Z',
        'honest' => 'M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3ZM6 6h.008v.008H6V6Z',
        'time'   => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        'help'   => 'M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z',
    ];
@endphp

<section
    {{ $attributes->class('my-10 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm') }}
    aria-labelledby="mission-heading"
>
    {{-- MISSION --}}
    <div class="relative overflow-hidden bg-blue-950 px-6 py-14 text-center sm:px-12 sm:py-20">
        <div
            class="pointer-events-none absolute inset-0 opacity-40"
            style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;"
            aria-hidden="true"
        ></div>
        <div class="pointer-events-none absolute -right-24 -top-24 size-96 rounded-full bg-amber-400/20 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-20 size-96 rounded-full bg-blue-500/20 blur-3xl" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-4xl">
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-400/15 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-300">
                <span class="size-1.5 rounded-full bg-amber-400"></span>
                {{ $missionLabel }}
            </p>

            <h2 id="mission-heading" class="mt-6 font-montserrat text-3xl font-extrabold leading-snug text-white sm:text-4xl lg:text-5xl lg:leading-tight">
                {{ $missionStart }}
                <span class="relative whitespace-nowrap text-amber-400 sm:whitespace-normal">{{ $missionHighlight }}</span>
                {{ $missionEnd }}
            </h2>

            {{-- small divider --}}
            <div class="mx-auto mt-8 flex items-center justify-center gap-2" aria-hidden="true">
                <span class="h-0.5 w-10 rounded-full bg-amber-400/50"></span>
                <span class="size-2 rounded-full bg-amber-400"></span>
                <span class="h-0.5 w-10 rounded-full bg-amber-400/50"></span>
            </div>
        </div>
    </div>

    {{-- PROMISES --}}
    <div class="px-6 py-12 sm:px-10 sm:py-14">
        <div class="mx-auto max-w-2xl text-center">
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
                <span class="size-1.5 rounded-full bg-amber-500"></span>
                {{ $promiseEyebrow }}
            </p>
            <h3 class="mt-4 font-montserrat text-2xl font-extrabold leading-tight text-blue-950 sm:text-3xl">
                {{ $promiseTitle }}
            </h3>
        </div>

        <ul class="mx-auto mt-10 grid max-w-7xl gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($promises as $promise)
                <li class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-6 transition duration-300 hover:-translate-y-1 hover:border-amber-300 hover:bg-white hover:shadow-xl">

                    {{-- faint number --}}
                    <span class="pointer-events-none absolute right-4 top-2 font-montserrat text-6xl font-extrabold text-slate-100 transition group-hover:text-amber-100" aria-hidden="true">
                        {{ $loop->iteration }}
                    </span>

                    <span class="relative flex size-16 items-center justify-center rounded-full border-2 border-amber-400 bg-amber-50 transition group-hover:bg-amber-400">
                        <svg class="size-9 text-amber-500 transition group-hover:text-blue-950" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision" aria-hidden="true">
                            <path d="{{ $icons[$promise['icon']] ?? $icons['care'] }}" />
                        </svg>
                    </span>

                    <h4 class="relative mt-5 font-montserrat text-lg font-extrabold leading-snug text-blue-950">
                        {{ $promise['title'] }}
                    </h4>
                    <p class="relative mt-2 text-sm leading-relaxed text-slate-600">
                        {{ $promise['text'] }}
                    </p>
                </li>
            @endforeach
        </ul>

        @if ($footnote)
            <p class="mx-auto mt-10 flex max-w-2xl items-start justify-center gap-3 rounded-2xl bg-amber-50 px-5 py-4 text-center text-sm font-semibold leading-snug text-blue-950 sm:items-center">
                <svg class="mt-0.5 size-5 shrink-0 text-amber-500 sm:mt-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 12.75 11.25 15 15 9.75M12 3 4.5 6v5.5c0 4.4 3.1 8.2 7.5 9.5 4.4-1.3 7.5-5.1 7.5-9.5V6L12 3Z" />
                </svg>
                {{ $footnote }}
            </p>
        @endif
    </div>
</section>
</div>
