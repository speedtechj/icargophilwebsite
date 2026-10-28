<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
    {{--
    resources/views/components/rates-box-sizes.blade.php

    Usage:
        <x-rates-box-sizes />

    Custom sizes and prices:
        <x-rates-box-sizes :items="[
            ['name' => 'Small',  'dims' => '18 × 18 × 18 in', 'fits' => 'Clothes and small gifts', 'price' => '$55',  'scale' => 1, 'points' => ['Easy to pack', 'Light shipments']],
            ['name' => 'Medium', 'dims' => '18 × 18 × 24 in', 'fits' => 'Family gift boxes',        'price' => '$75',  'scale' => 2, 'popular' => true, 'points' => ['...', '...']],
        ]" />

    Item keys: name, dims, fits, price, scale (1-4, controls the drawn box size),
               points (2-3 short bullets), popular (true = highlighted card).
    Optional props: eyebrow, title, subtitle, fromLabel ("From"), note, cta.

    Needs Alpine.js (already in Livewire 3) and Tailwind.

    IMPORTANT: the sizes and dimensions are SAMPLES and every price is a PLACEHOLDER ("$00").
    Replace them with your real sizes and rates before going live.
--}}
@props([
    'eyebrow' => 'Rates & box sizes',
    'title' => 'Simple sizes, clear prices',
    'subtitle' => 'Choose the box that fits what you are sending. Prices shown are starting prices and may vary by destination.',
    'fromLabel' => 'From',
    'note' => 'Rates may change. Contact us for the latest rates.',
    'cta' => 'Contact us for the latest rates',
    'items' => [
        [
            'name' => 'Small',
            'dims' => '18 × 18 × 18 in',
            'fits' => 'Clothes, shoes and small gifts',
            'price' => '$00',
            'scale' => 1,
            'points' => ['Ideal for lighter shipments', 'Easy to pack and carry'],
        ],
        [
            'name' => 'Medium',
            'dims' => '18 × 18 × 24 in',
            'fits' => 'Gifts and everyday essentials',
            'price' => '$00',
            'scale' => 2,
            'popular' => true,
            'points' => ['A favourite for family boxes', 'Room for a mix of items', 'Good balance of size and price'],
        ],
        [
            'name' => 'Large',
            'dims' => '24 × 18 × 24 in',
            'fits' => 'Household goods and bigger gifts',
            'price' => '$00',
            'scale' => 3,
            'points' => ['Plenty of space for bulkier items', 'Great for holiday shipments'],
        ],
        [
            'name' => 'Extra large',
            'dims' => '24 × 24 × 30 in',
            'fits' => 'Large loads and bulky items',
            'price' => '$00',
            'scale' => 4,
            'points' => ['Maximum space in one box', 'Best value per item packed'],
        ],
    ],
])

@php
    $items = \App\Models\BoxSize::forSite() ?: $items;
    $ruler = 'M3 7.5h18v9H3v-9ZM7 7.5v3M11 7.5v4.5M15 7.5v3M19 7.5v4.5';
@endphp

<section
    {{ $attributes->class('my-10 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm') }}
    x-data="{ view: 'cards' }"
    aria-labelledby="rates-heading"
>
    <div class="px-6 py-8 sm:px-10 sm:py-10">

        {{-- Header --}}
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
                    <span class="size-1.5 rounded-full bg-amber-500"></span>
                    {{ $eyebrow }}
                </p>
                <h2 id="rates-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
                    {{ $title }}
                </h2>
                @if ($subtitle)
                    <p class="mt-3 text-base leading-relaxed text-slate-600">{{ $subtitle }}</p>
                @endif
            </div>

            {{-- View toggle --}}
            <div class="inline-flex shrink-0 self-start rounded-full border border-slate-200 bg-slate-100 p-1 lg:self-auto" role="tablist" aria-label="Choose view">
                <button
                    type="button"
                    role="tab"
                    @click="view = 'cards'"
                    :aria-selected="view === 'cards'"
                    :class="view === 'cards' ? 'bg-blue-950 text-white shadow' : 'text-slate-600 hover:text-blue-950'"
                    class="inline-flex items-center gap-2 rounded-full px-4 py-2 font-montserrat text-sm font-bold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400"
                >
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 4h6.5v6.5H4V4ZM13.5 4H20v6.5h-6.5V4ZM4 13.5h6.5V20H4v-6.5ZM13.5 13.5H20V20h-6.5v-6.5Z" />
                    </svg>
                    Cards
                </button>
                <button
                    type="button"
                    role="tab"
                    @click="view = 'table'"
                    :aria-selected="view === 'table'"
                    :class="view === 'table' ? 'bg-blue-950 text-white shadow' : 'text-slate-600 hover:text-blue-950'"
                    class="inline-flex items-center gap-2 rounded-full px-4 py-2 font-montserrat text-sm font-bold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400"
                >
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3.5 5.5h17v13h-17v-13ZM3.5 10h17M3.5 14.25h17M9.5 5.5v13" />
                    </svg>
                    Table
                </button>
            </div>
        </div>

        {{-- CARDS VIEW --}}
        <div x-show="view === 'cards'" x-transition.opacity.duration.200ms class="mt-10">
            <ul class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($items as $item)
                    @php
                        $pop = ! empty($item['popular']);
                        $scale = max(1, min(4, (int) ($item['scale'] ?? 2)));
                    @endphp

                    <li class="relative flex">
                        @if ($pop)
                            <span class="absolute -top-3 left-1/2 z-10 -translate-x-1/2 rounded-full bg-amber-400 px-4 py-1 font-montserrat text-xs font-extrabold uppercase tracking-wider text-blue-950 shadow-md">
                                Most popular
                            </span>
                        @endif

                        <article class="group relative flex w-full flex-col overflow-hidden rounded-2xl border-2 p-6 transition duration-300 hover:-translate-y-1 hover:shadow-xl
                            {{ $pop ? 'border-amber-400 bg-blue-950 text-white shadow-lg' : 'border-slate-200 bg-slate-50 hover:border-amber-300 hover:bg-white' }}">

                            @if ($pop)
                                <div class="pointer-events-none absolute -right-10 -top-10 size-40 rounded-full bg-amber-400/20 blur-2xl" aria-hidden="true"></div>
                            @endif

                            {{-- Box drawing: bottoms line up so you can compare sizes --}}
                            <div class="relative flex h-32 items-end justify-center" aria-hidden="true">
                                <svg viewBox="0 0 64 64" style="width: {{ 3.5 + $scale * 1.1 }}rem" class="transition duration-300 group-hover:-translate-y-1" stroke-linejoin="round" stroke-linecap="round">
                                    <path d="M32 6 54 18 32 30 10 18Z" class="fill-amber-200" stroke="#172554" stroke-width="2" />
                                    <path d="M10 18 32 30V58L10 46Z" class="fill-amber-400" stroke="#172554" stroke-width="2" />
                                    <path d="M54 18 32 30V58L54 46Z" class="fill-amber-500" stroke="#172554" stroke-width="2" />
                                    <path d="M21 12 43 24" stroke="#172554" stroke-width="2" />
                                    <path d="M26.5 9 48.5 21" stroke="#172554" stroke-opacity=".35" stroke-width="2" />
                                </svg>
                            </div>

                            {{-- Name + dimensions --}}
                            <h3 class="relative mt-5 font-montserrat text-2xl font-extrabold {{ $pop ? 'text-white' : 'text-blue-950' }}">
                                {{ $item['name'] }}
                            </h3>

                            <p class="relative mt-2 inline-flex w-fit items-center gap-2 rounded-full px-3 py-1 text-xs font-bold tracking-wide {{ $pop ? 'bg-white/10 text-amber-300' : 'bg-white text-slate-600 ring-1 ring-slate-200' }}">
                                <svg class="size-4 {{ $pop ? 'text-amber-400' : 'text-amber-500' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $ruler }}" /></svg>
                                {{ $item['dims'] }}
                            </p>

                            {{-- Price --}}
                            <div class="relative mt-5 border-y py-4 {{ $pop ? 'border-white/15' : 'border-slate-200' }}">
                                <p class="text-xs font-bold uppercase tracking-wider {{ $pop ? 'text-white/60' : 'text-slate-500' }}">{{ $fromLabel }}</p>
                                <p class="font-montserrat text-4xl font-extrabold tabular-nums {{ $pop ? 'text-amber-400' : 'text-blue-950' }}">
                                    {{ $item['price'] }}
                                </p>
                            </div>

                            {{-- What fits + bullets --}}
                            <p class="relative mt-4 text-sm font-semibold leading-snug {{ $pop ? 'text-white' : 'text-blue-950' }}">
                                {{ $item['fits'] }}
                            </p>

                            <ul class="relative mt-3 space-y-2">
                                @foreach ($item['points'] ?? [] as $point)
                                    <li class="flex items-start gap-2.5 text-sm leading-snug {{ $pop ? 'text-white/75' : 'text-slate-600' }}">
                                        <span class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full bg-amber-400 text-blue-950">
                                            <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </span>
                                        <span>{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Button --}}
                            <a
                                href="{{ route('contact') }}"
                                wire:navigate
                                class="relative mt-6 inline-flex items-center justify-center gap-2 rounded-full px-5 py-3 font-montserrat text-sm font-bold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2
                                    {{ $pop ? 'mt-auto bg-amber-400 text-blue-950 hover:bg-amber-300 focus-visible:ring-offset-blue-950' : 'mt-auto bg-blue-950 text-white hover:bg-blue-900' }}"
                            >
                                Ask about this size
                                <svg class="size-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </article>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- TABLE VIEW --}}
        <div x-show="view === 'table'" x-cloak x-transition.opacity.duration.200ms class="mt-10 overflow-x-auto rounded-2xl border border-slate-200">
            <table class="w-full min-w-[40rem] border-collapse text-left">
                <caption class="sr-only">Box sizes, dimensions and starting prices</caption>
                <thead>
                    <tr class="bg-blue-950 text-xs font-bold uppercase tracking-wider text-white">
                        <th scope="col" class="px-5 py-4">Box size</th>
                        <th scope="col" class="px-5 py-4">Dimensions</th>
                        <th scope="col" class="px-5 py-4">Best for</th>
                        <th scope="col" class="px-5 py-4 text-right">{{ $fromLabel }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($items as $item)
                        @php $pop = ! empty($item['popular']); @endphp
                        <tr class="transition hover:bg-amber-50 {{ $pop ? 'bg-amber-50' : ($loop->even ? 'bg-slate-50' : 'bg-white') }}">
                            <th scope="row" class="px-5 py-4 font-montserrat text-base font-extrabold text-blue-950">
                                {{ $item['name'] }}
                                @if ($pop)
                                    <span class="ml-2 rounded-full bg-amber-400 px-2.5 py-0.5 align-middle text-[10px] font-extrabold uppercase tracking-wide text-blue-950">Popular</span>
                                @endif
                            </th>
                            <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-700">{{ $item['dims'] }}</td>
                            <td class="px-5 py-4 text-sm text-slate-600">{{ $item['fits'] }}</td>
                            <td class="px-5 py-4 text-right font-montserrat text-xl font-extrabold tabular-nums text-blue-950">{{ $item['price'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Latest rates band --}}
        <div class="relative mt-8 overflow-hidden rounded-2xl bg-blue-950 p-6 sm:p-8">
            <div
                class="pointer-events-none absolute inset-0 opacity-30"
                style="background-image: radial-gradient(rgba(255,255,255,.18) 1px, transparent 1px); background-size: 22px 22px;"
                aria-hidden="true"
            ></div>
            <div class="pointer-events-none absolute -right-12 -top-12 size-52 rounded-full bg-amber-400/20 blur-3xl" aria-hidden="true"></div>

            <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-4">
                    <span class="flex size-12 shrink-0 items-center justify-center rounded-full border-2 border-amber-400 text-amber-400">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                    </span>
                    <div>
                        <p class="font-montserrat text-lg font-extrabold text-white">{{ $note }}</p>
                        <p class="mt-1 text-sm leading-snug text-white/65">Need something bigger or heavier? Ask us for a custom quote.</p>
                    </div>
                </div>

                <a
                    href="{{ route('contact') }}"
                    wire:navigate
                    class="group inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-amber-400 px-6 py-3 font-montserrat text-sm font-bold text-blue-950 transition hover:bg-amber-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-blue-950"
                >
                    {{ $cta }}
                    <svg class="size-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
</div>
