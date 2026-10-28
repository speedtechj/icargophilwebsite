<div>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
    {{--
    resources/views/components/container-timeline.blade.php

    Usage:
        <x-container-timeline />

    With your own photos:
        <x-container-timeline :steps="[
            ['icon' => 'container', 'title' => 'Container arrives', 'text' => '...', 'points' => ['...', '...'], 'photo' => asset('storage/work/step-1.jpg'), 'tag' => 'Step 1'],
            ...
        ]" />

    Step keys:
        icon    container | unload | check | truck | home
        title   short heading
        text    one or two sentences
        points  (optional) 2-3 short bullets
        photo   (optional) photo URL. Without one, a placeholder is shown.
        alt     (optional) photo description for screen readers
        tag     (optional) small label, defaults to "Step 1", "Step 2" ...

    Optional props: eyebrow, title, subtitle, cta, ctaUrl. Set cta="" to hide the button.

    Needs Alpine.js (already in Livewire 3) and Tailwind. Steps fade in as you scroll.

    IMPORTANT: the step wording is SUGGESTED. Edit it so it matches what you really do at each stage,
    and add one real photo per step.
--}}
@props([
    'eyebrow' => 'From the container to your door',
    'title' => 'What happens to your box?',
    'subtitle' => 'Follow your shipment step by step, from the moment the container arrives to the moment your family opens the door.',
    'cta' => 'Send your box with us',
    'ctaUrl' => null,
    'steps' => [
        [
            'icon' => 'container',
            'title' => 'Container arrives',
            'text' => 'Your boxes reach our warehouse in the Philippines, ready to be unloaded.',
            'points' => ['Container opened and inspected', 'Boxes counted against the shipping list'],
            'photo' => null,
        ],
        [
            'icon' => 'unload',
            'title' => 'Careful unloading',
            'text' => 'Our team unloads every box by hand and sets it down with care.',
            'points' => ['Boxes lifted, not dropped or dragged', 'Fragile and heavy boxes handled separately'],
            'photo' => null,
        ],
        [
            'icon' => 'check',
            'title' => 'Checking and sorting',
            'text' => 'Each box is checked and sorted by destination, so it goes to the right province.',
            'points' => ['Boxes checked for damage', 'Sorted into Luzon, Visayas and Mindanao'],
            'photo' => null,
        ],
        [
            'icon' => 'truck',
            'title' => 'Loading the truck',
            'text' => 'Boxes are loaded in order, so deliveries go out smoothly and safely.',
            'points' => ['Packed securely to prevent shifting', 'Delivery routes planned by area'],
            'photo' => null,
        ],
        [
            'icon' => 'home',
            'title' => 'Delivered to the door',
            'text' => 'Our rider brings your box straight to your family\'s address.',
            'points' => ['Handed to the recipient', 'Another happy family'],
            'photo' => null,
        ],
    ],
])

@php
    $steps = \App\Models\TimelineStep::forSite() ?: $steps;
    $ctaUrl = $ctaUrl ?? route('contact');

    $icons = [
        'container' => 'M3 6.5h18v11H3v-11ZM7 6.5v11M11 6.5v11M15 6.5v11M19 6.5v11M3 20h18',
        'unload'    => 'M12 3 4 7.25v9.5L12 21l8-4.25v-9.5L12 3ZM4 7.25l8 4.25 8-4.25M12 11.5V21',
        'check'     => 'M9 12.75 11.25 15 15 9.75M12 3 4.5 6v5.5c0 4.4 3.1 8.2 7.5 9.5 4.4-1.3 7.5-5.1 7.5-9.5V6L12 3Z',
        'truck'     => 'M3 7a2 2 0 0 1 2-2h8v11H3V7ZM13 9h3.6a1 1 0 0 1 .8.4l2.3 3.1a1 1 0 0 1 .2.6V16H13V9ZM9.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM18.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z',
        'home'      => 'M3 11.5 12 4l9 7.5M5.5 10v9.5a.5.5 0 0 0 .5.5h4v-5h4v5h4a.5.5 0 0 0 .5-.5V10',
    ];

    $count = count($steps);
@endphp

<section
    {{ $attributes->class('relative my-10 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm') }}
    aria-labelledby="timeline-heading"
>
    <div class="px-6 py-12 sm:px-10 sm:py-16">

        {{-- Heading --}}
        <div class="mx-auto max-w-2xl text-center">
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
                <span class="size-1.5 rounded-full bg-amber-500"></span>
                {{ $eyebrow }}
            </p>
            <h2 id="timeline-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
                {{ $title }}
            </h2>
            @if ($subtitle)
                <p class="mt-3 text-base leading-relaxed text-slate-600">{{ $subtitle }}</p>
            @endif
        </div>

        {{-- Timeline --}}
        <ol class="relative mx-auto mt-14 max-w-6xl space-y-12 lg:space-y-20">

            {{-- vertical line --}}
            <div class="pointer-events-none absolute bottom-6 left-6 top-6 w-0 -translate-x-1/2 border-l-2 border-dashed border-amber-400/60 lg:left-1/2" aria-hidden="true"></div>

            @foreach ($steps as $step)
                @php
                    $isLast = $loop->last;
                    $photoOrder = $loop->odd ? 'lg:order-1' : 'lg:order-2';
                    $textOrder  = $loop->odd ? 'lg:order-2' : 'lg:order-1';
                    $textAlign  = $loop->odd ? 'lg:text-left' : 'lg:text-right';
                    $tag = $step['tag'] ?? 'Step ' . $loop->iteration;
                @endphp

                <li
                    class="relative grid items-center gap-6 pl-16 transition duration-700 ease-out lg:grid-cols-2 lg:gap-24 lg:pl-0"
                    x-data="{ shown: false }"
                    x-init="
                        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) { shown = true; }
                        else {
                            new IntersectionObserver((entries, obs) => {
                                if (entries[0].isIntersecting) { shown = true; obs.disconnect(); }
                            }, { threshold: 0.2 }).observe($el);
                        }
                    "
                    :class="shown ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'"
                >
                    {{-- marker on the line --}}
                    <div class="absolute left-0 top-0 z-10 lg:left-1/2 lg:top-1/2 lg:-translate-x-1/2 lg:-translate-y-1/2">
                        <span class="relative flex size-12 items-center justify-center rounded-full border-2 border-amber-400 bg-blue-950 shadow-lg shadow-amber-400/20 ring-8 ring-white lg:size-16">
                            <svg class="size-6 text-amber-400 lg:size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision" aria-hidden="true">
                                <path d="{{ $icons[$step['icon']] ?? $icons['unload'] }}" />
                            </svg>
                            <span class="absolute -right-2 -top-2 flex size-6 items-center justify-center rounded-full bg-amber-400 font-montserrat text-xs font-extrabold text-blue-950 ring-2 ring-white lg:size-7 lg:text-sm">
                                {{ $loop->iteration }}
                            </span>
                        </span>
                    </div>

                    {{-- photo --}}
                    <div class="{{ $photoOrder }}">
                        <div class="group relative">
                            {{-- offset amber frame --}}
                            <span class="absolute inset-0 translate-x-2 translate-y-2 rounded-3xl border-2 border-amber-400/70 transition duration-300 group-hover:translate-x-3 group-hover:translate-y-3" aria-hidden="true"></span>

                            <div class="relative aspect-[4/3] overflow-hidden rounded-3xl bg-blue-950 shadow-lg ring-1 ring-slate-200">
                                @if (! empty($step['photo']))
                                    <img
                                        src="{{ $step['photo'] }}"
                                        alt="{{ $step['alt'] ?? $step['title'] }}"
                                        loading="lazy"
                                        class="size-full object-cover transition duration-700 group-hover:scale-105"
                                    >
                                    <span class="pointer-events-none absolute inset-0 bg-gradient-to-t from-blue-950/50 via-transparent to-transparent"></span>
                                @else
                                    {{-- placeholder until a photo is added --}}
                                    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-blue-950"></div>
                                    <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;" aria-hidden="true"></div>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 text-center">
                                        <svg class="size-16 text-amber-400/80" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="{{ $icons[$step['icon']] ?? $icons['unload'] }}" />
                                        </svg>
                                        <p class="text-sm font-semibold text-white/55">Add your photo here</p>
                                    </div>
                                @endif

                                {{-- tag --}}
                                <span class="absolute left-4 top-4 rounded-full bg-amber-400 px-3 py-1 font-montserrat text-xs font-extrabold uppercase tracking-wider text-blue-950 shadow">
                                    {{ $tag }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- text --}}
                    <div class="{{ $textOrder }} {{ $textAlign }}">
                        <h3 class="font-montserrat text-2xl font-extrabold leading-snug text-blue-950 sm:text-3xl">
                            {{ $step['title'] }}
                        </h3>
                        <p class="mt-3 text-base leading-relaxed text-slate-600">
                            {{ $step['text'] }}
                        </p>

                        @if (! empty($step['points']))
                            <ul class="mt-5 space-y-2.5 {{ $loop->odd ? '' : 'lg:ml-auto lg:w-fit' }}">
                                @foreach ($step['points'] as $point)
                                    <li class="flex items-start gap-3 text-left text-sm leading-snug text-slate-700">
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

                        @if ($isLast)
                            <p class="mt-5 inline-flex items-center gap-2 rounded-full bg-amber-100 px-4 py-2 font-montserrat text-sm font-bold text-amber-800">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                Journey complete
                            </p>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>

        {{-- CTA --}}
        @if ($cta)
            <div class="mt-14 text-center">
                <a
                    href="{{ $ctaUrl }}"
                    wire:navigate
                    class="group inline-flex items-center gap-2 rounded-full bg-amber-400 px-7 py-3.5 font-montserrat text-base font-bold text-blue-950 shadow-lg shadow-amber-400/20 transition hover:-translate-y-0.5 hover:bg-amber-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2"
                >
                    {{ $cta }}
                    <svg class="size-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>
</div>
