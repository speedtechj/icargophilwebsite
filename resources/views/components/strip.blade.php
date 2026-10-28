{{--
    resources/views/components/feature-strip.blade.php

    Usage:
        <x-feature-strip />

    Custom items (icon: shield | truck | box):
        <x-feature-strip :items="[
            ['icon' => 'shield', 'label' => 'Safe & Secure Handling'],
            ['icon' => 'truck',  'label' => 'Nationwide Delivery'],
        ]" />
--}}
<div>
@props([
    'items' => [
        ['icon' => 'shield', 'label' => 'Safe & Secure Handling'],
        ['icon' => 'truck',  'label' => 'Nationwide Delivery'],
        ['icon' => 'box',    'label' => 'Balikbayan Boxes & Other Cargo'],
    ],
])

@php
    // Heroicons (outline) paths
    $icons = [
    'shield' => 'M12 3 4.5 6v5.5c0 4.4 3.1 8.2 7.5 9.5 4.4-1.3 7.5-5.1 7.5-9.5V6L12 3ZM8.75 12l2.25 2.25 4.25-4.5',
    'truck'  => 'M3 7a2 2 0 0 1 2-2h8v11H3V7ZM13 9h3.6a1 1 0 0 1 .8.4l2.3 3.1a1 1 0 0 1 .2.6V16H13V9ZM9.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM18.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z',
    'box'    => 'M12 3 4 7.25v9.5L12 21l8-4.25v-9.5L12 3ZM4 7.25l8 4.25 8-4.25M12 11.5V21',
];
@endphp

<section {{ $attributes->class('my-4 rounded-2xl bg-blue-950') }} aria-label="Our highlights">
    <ul class="mx-auto flex max-w-7xl flex-col gap-6 px-6 py-6 md:flex-row md:items-center md:justify-between md:gap-0 lg:px-8">
        @foreach ($items as $item)
            <li class="flex items-center gap-4">
                <svg class="size-12 shrink-0 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$item['icon']] ?? $icons['box'] }}" />
                </svg>

                <span class="font-montserrat text-base font-medium leading-snug text-white lg:text-lg">
                    {{ $item['label'] }}
                </span>
            </li>

            {{-- Divider between items (desktop only) --}}
            @unless ($loop->last)
                <li class="hidden h-10 w-px bg-white/40 md:block" aria-hidden="true"></li>
            @endunless
        @endforeach
    </ul>
</section>
</div>
