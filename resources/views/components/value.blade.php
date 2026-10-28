<div>
    <!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
    {{--
    resources/views/components/values-cards.blade.php

    Usage:
        <x-values-cards />

    Custom values (icon: care | honest | family | reliable):
        <x-values-cards :items="[
            ['icon' => 'care',   'title' => 'Care for every box', 'text' => 'One short line.'],
            ['icon' => 'family', 'title' => 'Family first',       'text' => 'One short line.'],
        ]" />

    Optional props: eyebrow, title, subtitle. Set subtitle="" to hide it.
    Works with 3 or 4 values. The cards sit in a 2-column grid beside the heading on desktop.

    Needs only Tailwind (no JavaScript).

    NOTE: your Mission & promise section already talks about care, honest pricing and reliable
    delivery. Values should say who you ARE; promises say what you will DO. If the two sections
    feel repetitive, keep different values here (for example Family first, Respect, Gratitude)
    or use the sample wording below, which focuses on attitude.
--}}
@props([
    'eyebrow' => 'Our values',
    'title' => 'What we believe in',
    'subtitle' => 'These simple values guide how we treat every box, every customer and every family on the other side.',
    'items' => [
        [
            'icon' => 'care',
            'title' => 'Care for every box',
            'text' => 'Every shipment is handled as if it were our own.',
        ],
        [
            'icon' => 'honest',
            'title' => 'Honest pricing',
            'text' => 'Clear rates and no surprises, so you can plan with confidence.',
        ],
        [
            'icon' => 'family',
            'title' => 'Family first',
            'text' => 'We know every box is a message of love, and we treat it that way.',
        ],
        [
            'icon' => 'reliable',
            'title' => 'Reliable service',
            'text' => 'We do what we say, and we keep you informed along the way.',
        ],
    ],
])

@php
    $icons = [
        'care'     => 'M12 20.5s-7.5-4.6-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.6-7.5 10.2-7.5 10.2Z',
        'honest'   => 'M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3ZM6 6h.008v.008H6V6Z',
        'family'   => 'M9 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.5 19.5a5.5 5.5 0 0 1 11 0M16.5 11a2.5 2.5 0 1 0 0-5M17.25 14.3a5 5 0 0 1 3.25 5.2',
        'reliable' => 'M9 12.75 11.25 15 15 9.75M12 3 4.5 6v5.5c0 4.4 3.1 8.2 7.5 9.5 4.4-1.3 7.5-5.1 7.5-9.5V6L12 3Z',
    ];
@endphp

<section
    {{ $attributes->class('relative my-10 overflow-hidden rounded-3xl bg-amber-50 ring-1 ring-amber-100') }}
    aria-labelledby="values-heading"
>
    {{-- soft decoration --}}
    <div class="pointer-events-none absolute -right-20 -top-20 size-72 rounded-full bg-amber-200/60 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-24 left-1/3 size-72 rounded-full bg-white/70 blur-3xl" aria-hidden="true"></div>

    <div class="relative grid gap-10 px-6 py-12 sm:px-10 sm:py-16 lg:grid-cols-[1fr_2fr] lg:gap-14">

        {{-- Heading --}}
        <div class="lg:sticky lg:top-28 lg:self-start">
            <p class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700 ring-1 ring-amber-200">
                <span class="size-1.5 rounded-full bg-amber-500"></span>
                {{ $eyebrow }}
            </p>

            <h2 id="values-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
                {{ $title }}
            </h2>

            @if ($subtitle)
                <p class="mt-4 text-base leading-relaxed text-slate-600">{{ $subtitle }}</p>
            @endif

            {{-- little accent --}}
            <div class="mt-8 flex items-center gap-2" aria-hidden="true">
                <span class="h-1.5 w-14 rounded-full bg-amber-400"></span>
                <span class="h-1.5 w-5 rounded-full bg-blue-950"></span>
                <span class="size-1.5 rounded-full bg-amber-400"></span>
            </div>
        </div>

        {{-- Cards --}}
        <ul class="grid gap-5 sm:grid-cols-2">
            @foreach ($items as $item)
                <li class="group relative flex flex-col overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-amber-300 sm:p-7">

                    {{-- amber bar that grows on hover --}}
                    <span class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-amber-400 transition duration-300 group-hover:scale-x-100" aria-hidden="true"></span>

                    {{-- faint number --}}
                    <span class="pointer-events-none absolute right-5 top-3 font-montserrat text-5xl font-extrabold text-slate-100 transition group-hover:text-amber-100" aria-hidden="true">
                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    {{-- icon tile --}}
                    <span class="relative flex size-16 items-center justify-center rounded-2xl bg-amber-400 shadow-md shadow-amber-400/30 transition duration-300 group-hover:-rotate-6 group-hover:bg-blue-950 group-hover:shadow-blue-950/20">
                        <svg class="size-9 text-blue-950 transition duration-300 group-hover:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision" aria-hidden="true">
                            <path d="{{ $icons[$item['icon']] ?? $icons['care'] }}" />
                        </svg>
                    </span>

                    <h3 class="relative mt-6 font-montserrat text-xl font-extrabold leading-snug text-blue-950">
                        {{ $item['title'] }}
                    </h3>
                    <p class="relative mt-2 text-base leading-relaxed text-slate-600">
                        {{ $item['text'] }}
                    </p>
                </li>
            @endforeach
        </ul>
    </div>
</section>
</div>
