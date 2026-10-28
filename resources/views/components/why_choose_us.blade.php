<div>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
    {{--
    resources/views/components/why-choose-us.blade.php

    Usage:
        <x-why-choose-us />

    With your photo and wording:
        <x-why-choose-us
            :photo="asset('storage/about/delivery.jpg')"
            photo-alt="Our rider handing a box to a happy family"
            :badge="['value' => '10+', 'label' => 'years of deliveries']"
            :points="[
                ['icon' => 'door',    'title' => 'Door-to-door delivery', 'text' => 'One short line.'],
                ['icon' => 'care',    'title' => 'Careful handling',      'text' => 'One short line.'],
                ['icon' => 'rates',   'title' => 'Clear rates',           'text' => 'One short line.'],
                ['icon' => 'support', 'title' => 'Friendly support',      'text' => 'One short line.'],
            ]"
        />

    Point icons: door | care | rates | support
    Optional props: eyebrow, title, subtitle, cta, ctaUrl, badge (null hides it), photo, photoAlt.
    Set cta="" to hide the button.

    Needs only Tailwind (no JavaScript).

    Tip: put <x-testimonials-slider /> directly after this section. Reasons to choose you
    are far more convincing when a real customer quote follows them.

    IMPORTANT: the wording is a DRAFT. Only keep points that are true every time.
    Do not add the badge unless the number is real.
--}}
@props([
    'eyebrow' => 'Why choose us',
    'title' => 'Why families trust iCargo with their boxes',
    'subtitle' => 'Sending a box home is personal. Here is what you can expect when you send with us.',
    'photo' => null,
    'photoAlt' => 'An iCargo delivery',
    'badge' => null,
    'cta' => 'Message us today',
    'ctaUrl' => null,
    'points' => [
        [
            'icon' => 'door',
            'title' => 'Door-to-door delivery',
            'text' => 'We bring your box straight to your family\'s address, so nobody has to travel to collect it.',
        ],
        [
            'icon' => 'care',
            'title' => 'Careful handling',
            'text' => 'Every box is checked, sorted and loaded with care from start to finish.',
        ],
        [
            'icon' => 'rates',
            'title' => 'Clear rates',
            'text' => 'You know the cost before you send, with simple pricing that is easy to understand.',
        ],
        [
            'icon' => 'support',
            'title' => 'Friendly support',
            'text' => 'Ask us anything, anytime in our opening hours. We are happy to help.',
        ],
    ],
])

@php
   $p = \App\Models\Wcu::photo();
$photo    = $photo ?? $p['url'] ?? null;
$photoAlt = $photoAlt ?? $p['alt'] ?? 'An iCargo delivery';
    $ctaUrl = $ctaUrl ?? route('contact');

    $icons = [
        'door'    => 'M3 11.5 12 4l9 7.5M5.5 10v9.5a.5.5 0 0 0 .5.5h4v-5h4v5h4a.5.5 0 0 0 .5-.5V10',
        'care'    => 'M12 3 4 7.25v9.5L12 21l8-4.25v-9.5L12 3ZM4 7.25l8 4.25 8-4.25M12 11.5V21',
        'rates'   => 'M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3ZM6 6h.008v.008H6V6Z',
        'support' => 'M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z',
    ];

    $truck = 'M3 7a2 2 0 0 1 2-2h8v11H3V7ZM13 9h3.6a1 1 0 0 1 .8.4l2.3 3.1a1 1 0 0 1 .2.6V16H13V9ZM9.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM18.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z';
@endphp

<section
    {{ $attributes->class('relative my-10 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm') }}
    aria-labelledby="why-heading"
>
    <div class="pointer-events-none absolute -left-24 -top-24 size-72 rounded-full bg-amber-100 blur-3xl" aria-hidden="true"></div>

    <div class="relative grid items-center gap-12 px-6 py-12 sm:px-10 sm:py-16 lg:grid-cols-[1.1fr_1fr] lg:gap-16">

        {{-- TEXT + POINTS --}}
        <div>
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
                <span class="size-1.5 rounded-full bg-amber-500"></span>
                {{ $eyebrow }}
            </p>

            <h2 id="why-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
                {{ $title }}
            </h2>

            @if ($subtitle)
                <p class="mt-3 max-w-xl text-base leading-relaxed text-slate-600">{{ $subtitle }}</p>
            @endif

            <ul class="mt-8 divide-y divide-slate-200">
                @foreach ($points as $point)
                    <li class="group flex items-start gap-5 py-5 first:pt-0 last:pb-0">
                        <span class="flex size-14 shrink-0 items-center justify-center rounded-full border-2 border-amber-400 bg-amber-50 transition duration-300 group-hover:bg-amber-400">
                            <svg class="size-8 text-amber-500 transition duration-300 group-hover:text-blue-950" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision" aria-hidden="true">
                                <path d="{{ $icons[$point['icon']] ?? $icons['care'] }}" />
                            </svg>
                        </span>

                        <div class="min-w-0">
                            <h3 class="font-montserrat text-lg font-extrabold leading-snug text-blue-950">{{ $point['title'] }}</h3>
                            <p class="mt-1 text-sm leading-relaxed text-slate-600 sm:text-base">{{ $point['text'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>

            @if ($cta)
                <a
                    href="{{ $ctaUrl }}"
                    wire:navigate
                    class="group mt-8 inline-flex items-center gap-2 rounded-full bg-amber-400 px-7 py-3.5 font-montserrat text-base font-bold text-blue-950 shadow-lg shadow-amber-400/20 transition hover:-translate-y-0.5 hover:bg-amber-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2"
                >
                    {{ $cta }}
                    <svg class="size-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            @endif
        </div>

        {{-- PHOTO --}}
        <div class="relative mx-auto w-full max-w-md lg:max-w-none">
            <span class="absolute inset-0 -translate-x-3 translate-y-3 rounded-[2rem] border-2 border-amber-400" aria-hidden="true"></span>

            <div class="relative aspect-[4/5] overflow-hidden rounded-[2rem] bg-blue-950 shadow-xl ring-1 ring-slate-200">
                @if ($photo)
                    <img src="{{ $photo }}" alt="{{ $photoAlt }}" loading="lazy" class="size-full object-cover">
                    <span class="pointer-events-none absolute inset-0 bg-gradient-to-t from-blue-950/50 via-transparent to-transparent"></span>
                @else
                    {{-- placeholder until a real photo is added --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-blue-950"></div>
                    <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;" aria-hidden="true"></div>
                    <div class="pointer-events-none absolute -right-16 -top-16 size-64 rounded-full bg-amber-400/20 blur-3xl" aria-hidden="true"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 text-center">
                        <span class="flex size-24 items-center justify-center rounded-full border-2 border-amber-400">
                            <svg class="size-12 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $truck }}" /></svg>
                        </span>
                        <p class="px-8 text-sm font-semibold text-white/55">Add a photo of a delivery, like a rider handing a box to a family</p>
                    </div>
                @endif

                {{-- optional badge (only shows if you pass real numbers) --}}
                @if (! empty($badge))
                    <div class="absolute inset-x-4 bottom-4 flex items-center gap-4 rounded-2xl border border-white/15 bg-blue-950/85 px-5 py-4 backdrop-blur">
                        <span class="font-montserrat text-3xl font-extrabold text-amber-400">{{ $badge['value'] }}</span>
                        <span class="text-sm font-semibold leading-snug text-white/85">{{ $badge['label'] }}</span>
                    </div>
                @endif
            </div>

            {{-- check badge --}}
            <span class="absolute -right-3 -top-4 flex size-16 items-center justify-center rounded-full bg-amber-400 text-blue-950 shadow-xl ring-8 ring-white sm:-right-5 sm:size-20" aria-hidden="true">
                <svg class="size-8 sm:size-10" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="m4.5 12.75 6 6 9-13.5" /></svg>
            </span>
        </div>
    </div>
</section>
</div>
