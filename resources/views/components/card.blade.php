<div>
    <!-- Well begun is half done. - Aristotle -->
    {{--
    resources/views/components/service-cards.blade.php

    Usage:
        <x-service-cards />

    Custom services (icon: box | parcel | pickup | branch | island | business):
        <x-service-cards :items="[
            ['icon' => 'box', 'title' => 'Balikbayan box delivery', 'benefit' => 'Door-to-door to any province.', 'points' => ['Point one', 'Point two']],
        ]" />

    Optional: eyebrow="..." title="..." subtitle="..." (set subtitle="" to hide it)

    NOTE: the bullet points are SUGGESTED wording. Edit them so they only say what you really offer.
--}}
@props([
    'eyebrow' => 'What we offer',
    'title' => 'Our main services',
    'subtitle' => 'Whatever you are sending and wherever it is going in the Philippines, we have a simple, safe way to get it there.',
    'items' => [
        [
            'icon' => 'box',
            'title' => 'Balikbayan box delivery',
            'benefit' => 'Door-to-door to any province.',
            'points' => [
                'Delivered right to the recipient\'s address',
                'Handled with care from pickup to delivery',
                'Great for gifts and household items',
            ],
        ],
        [
            'icon' => 'parcel',
            'title' => 'Parcel and cargo delivery',
            'benefit' => 'Boxes, packages and bulk items.',
            'points' => [
                'From small parcels to large cargo',
                'Securely packed and handled',
                'Nationwide destinations',
            ],
        ],
        [
            'icon' => 'pickup',
            'title' => 'Pickup service',
            'benefit' => 'Collection from the sender\'s address.',
            'points' => [
                'Schedule a pickup that suits you',
                'No need to travel to drop off',
                'Convenient for heavy or many boxes',
            ],
        ],
        [
            'icon' => 'branch',
            'title' => 'Drop-off or branch pickup',
            'benefit' => 'For customers who prefer to bring or collect items.',
            'points' => [
                'Drop off your items at our branch',
                'Recipients can collect at the branch',
                'Friendly staff to assist you',
            ],
        ],
        [
            'icon' => 'island',
            'title' => 'Inter-island delivery',
            'benefit' => 'Luzon, Visayas and Mindanao.',
            'points' => [
                'Covers all three island groups',
                'One booking for any destination',
                'Reaches cities and provinces',
            ],
        ],
        [
            'icon' => 'business',
            'title' => 'Business or bulk shipping',
            'benefit' => 'For sellers and companies.',
            'points' => [
                'Ideal for online sellers and shops',
                'Handles larger volumes',
                'Reliable delivery for your customers',
            ],
        ],
    ],
])

@php
    // Simple geometric icons on a 24x24 grid
    $icons = [
        'box'      => 'M12 3 4 7.25v9.5L12 21l8-4.25v-9.5L12 3ZM4 7.25l8 4.25 8-4.25M12 11.5V21',
        'parcel'   => 'M3.5 7.5h17V10h-17ZM5 10v8.5A1.5 1.5 0 0 0 6.5 20h11a1.5 1.5 0 0 0 1.5-1.5V10M10 13.5h4',
        'pickup'   => 'M3 11.5 12 4l9 7.5M5.5 10v9.5a.5.5 0 0 0 .5.5h4v-5h4v5h4a.5.5 0 0 0 .5-.5V10',
        'branch'   => 'M4 20V7.5l8-4 8 4V20M2.5 20h19M9 20v-6h6v6',
        'island'   => 'M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM3.6 9h16.8M3.6 15h16.8M12 3c2.5 2.5 3.75 5.5 3.75 9S14.5 18.5 12 21c-2.5-2.5-3.75-5.5-3.75-9S9.5 5.5 12 3Z',
        'business' => 'M3.5 8.5h17V19a1 1 0 0 1-1 1h-15a1 1 0 0 1-1-1V8.5ZM8.5 8.5V6A1.5 1.5 0 0 1 10 4.5h4A1.5 1.5 0 0 1 15.5 6v2.5M3.5 13.5h17',
    ];
@endphp

<section {{ $attributes->class('my-10') }} aria-labelledby="services-heading">

    {{-- Heading --}}
    <div class="mx-auto max-w-2xl text-center">
        <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
            <span class="size-1.5 rounded-full bg-amber-500"></span>
            {{ $eyebrow }}
        </p>
        <h2 id="services-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
            {{ $title }}
        </h2>
        @if ($subtitle)
            <p class="mt-3 text-base leading-relaxed text-slate-600">{{ $subtitle }}</p>
        @endif
    </div>

    {{-- Cards --}}
    <ul class="mx-auto mt-10 grid max-w-7xl gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($items as $item)
            <li class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-amber-300 hover:shadow-xl sm:p-7">

                {{-- big faint number --}}
                <span class="pointer-events-none absolute right-5 top-3 font-montserrat text-6xl font-extrabold text-slate-100 transition group-hover:text-amber-100" aria-hidden="true">
                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                </span>

                {{-- icon --}}
                <span class="relative flex size-16 items-center justify-center rounded-full border-2 border-amber-400 bg-amber-50 transition group-hover:bg-amber-400">
                    <svg class="size-9 text-amber-500 transition group-hover:text-blue-950" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision" aria-hidden="true">
                        <path d="{{ $icons[$item['icon']] ?? $icons['box'] }}" />
                    </svg>
                </span>

                {{-- text --}}
                <h3 class="relative mt-6 font-montserrat text-xl font-extrabold leading-snug text-blue-950">
                    {{ $item['title'] }}
                </h3>
                <p class="relative mt-1.5 font-medium text-slate-600">
                    {{ $item['benefit'] }}
                </p>

                {{-- bullets --}}
                <ul class="relative mt-5 space-y-2.5 border-t border-slate-100 pt-5">
                    @foreach ($item['points'] as $point)
                        <li class="flex items-start gap-3 text-sm leading-snug text-slate-700">
                            <span class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full bg-amber-400 text-blue-950">
                                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </span>
                            <span>{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</section>
</div>
