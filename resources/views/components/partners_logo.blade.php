<div>
    <!-- He who is contented is rich. - Laozi -->
    {{--
    resources/views/components/partner-logos.blade.php

    Usage:
        <x-partner-logos />

    Your real partners (logo and url are optional):
        <x-partner-logos :partners="[
            ['name' => 'Your Partner Cargo Store', 'country' => 'Canada', 'logo' => 'images/partners/partner-one.png', 'url' => 'https://example.com'],
        ]" />

    - Put logo files in public/images/partners/ (a PNG with a transparent background looks best).
      "logo" can be a path inside public/ or a full https:// address.
    - No logo yet? A round badge with the company's initials is shown instead.
    - 5 or more partners scroll slowly and pause on hover. Fewer than 5 sit still, centered.
    - Countries are listed automatically from your partners.

    Optional props: eyebrow, title, subtitle, cta, url (where the "Become a partner" link goes).

    NOTE: the sample names below are PLACEHOLDERS, not real companies.
    Replace them with your real partners, and get each partner's permission before showing their name or logo.
--}}
@props([
    'eyebrow' => 'Our partners abroad',
    'title' => 'Trusted by cargo companies overseas',
    'subtitle' => 'These companies send their customers\' balikbayan boxes to us, and we clear, truck and deliver them across the Philippines.',
    'cta' => 'Become a partner',
    'url' => '#partner',
    'partners' => [
        ['name' => 'Sample Cargo Store', 'country' => 'Canada', 'logo' => null, 'url' => null],
        ['name' => 'Sample Balikbayan Express', 'country' => 'Canada', 'logo' => null, 'url' => null],
        ['name' => 'Sample Padala Cargo', 'country' => 'United States', 'logo' => null, 'url' => null],
        ['name' => 'Sample Kabayan Freight', 'country' => 'United Arab Emirates', 'logo' => null, 'url' => null],
        ['name' => 'Sample Island Cargo', 'country' => 'Australia', 'logo' => null, 'url' => null],
        ['name' => 'Sample Home Link Cargo', 'country' => 'United Kingdom', 'logo' => null, 'url' => null],
    ],
])

@php
     $partners = \App\Models\Partner::forSite() ?: $partners;
    $marquee   = count($partners) >= 5;
    $items     = $marquee ? array_merge($partners, $partners) : $partners;
    $half      = count($partners);
    $countries = array_values(array_unique(array_filter(array_column($partners, 'country'))));

    $initials = function (string $name) {
        $words = preg_split('/\s+/', trim(preg_replace('/^sample\s+/i', '', $name)));
        $letters = collect($words)->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
        return $letters ?: 'P';
    };
    $logoSrc = fn ($logo) => str_starts_with($logo, 'http') ? $logo : asset($logo);
@endphp

<section {{ $attributes->class('my-10') }} aria-labelledby="partners-heading">

    {{-- Heading --}}
    <div class="mx-auto max-w-2xl text-center">
        <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
            <span class="size-1.5 rounded-full bg-amber-500"></span>
            {{ $eyebrow }}
        </p>
        <h2 id="partners-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
            {{ $title }}
        </h2>
        @if ($subtitle)
            <p class="mt-3 text-base leading-relaxed text-slate-600">{{ $subtitle }}</p>
        @endif
    </div>

    <div class="relative mt-10 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        {{-- soft decoration --}}
        <div class="pointer-events-none absolute -right-20 -top-20 size-64 rounded-full bg-amber-400/10 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-16 size-64 rounded-full bg-blue-500/10 blur-3xl" aria-hidden="true"></div>

        {{-- Countries --}}
        @if (count($countries))
            <div class="relative flex flex-wrap items-center justify-center gap-2 px-6 pt-8">
                <span class="mr-1 font-montserrat text-xs font-bold uppercase tracking-wider text-slate-400">Shipping from</span>
                @foreach ($countries as $country)
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-blue-950/10 bg-blue-950 px-3 py-1 font-montserrat text-xs font-semibold text-white">
                        <span class="size-1.5 rounded-full bg-amber-400"></span>{{ $country }}
                    </span>
                @endforeach
            </div>
        @endif

        {{-- Logos --}}
        <div class="pl-wrap relative py-8 {{ $marquee ? 'pl-fade' : '' }}">
            <ul class="{{ $marquee ? 'pl-track flex w-max items-stretch' : 'flex flex-wrap items-stretch justify-center gap-5 px-6' }}">
                @foreach ($items as $i => $p)
                    @php
                        $tag  = ! empty($p['url']) ? 'a' : 'div';
                        $dupe = $marquee && $i >= $half;
                    @endphp
                    <li class="{{ $marquee ? 'mr-5' : '' }} flex" @if ($dupe) aria-hidden="true" @endif>
                        <{{ $tag }}
                            @if (! empty($p['url'])) href="{{ $p['url'] }}" target="_blank" rel="noopener noreferrer" @if ($dupe) tabindex="-1" @endif @endif
                            class="group flex w-64 items-center gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 transition duration-300 hover:-translate-y-0.5 hover:border-amber-300 hover:bg-white hover:shadow-lg"
                        >
                            {{-- logo or initials --}}
                            <span class="flex size-16 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-white p-2">
                                @if (! empty($p['logo']))
                                    <img src="{{ $logoSrc($p['logo']) }}" alt="{{ $dupe ? '' : $p['name'] . ' logo' }}" loading="lazy" class="max-h-full max-w-full object-contain opacity-80 grayscale transition duration-300 group-hover:opacity-100 group-hover:grayscale-0">
                                @else
                                    <span class="flex size-full items-center justify-center rounded-lg bg-blue-950 font-montserrat text-lg font-extrabold tracking-wide text-amber-400">{{ $initials($p['name']) }}</span>
                                @endif
                            </span>

                            {{-- name + country --}}
                            <span class="min-w-0">
                                <span class="line-clamp-2 font-montserrat text-sm font-extrabold leading-snug text-blue-950">{{ $p['name'] }}</span>
                                @if (! empty($p['country']))
                                    <span class="mt-1 flex items-center gap-1.5 text-xs font-medium text-slate-500">
                                        <svg class="size-3.5 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-6.5-5.6-6.5-10.5a6.5 6.5 0 0 1 13 0C18.5 15.4 12 21 12 21ZM14 10.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" /></svg>
                                        <span class="truncate">{{ $p['country'] }}</span>
                                    </span>
                                @endif
                            </span>
                        </{{ $tag }}>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Invitation --}}
        <div class="relative flex flex-col items-center justify-between gap-3 border-t border-slate-100 bg-slate-50/70 px-6 py-5 text-center sm:flex-row sm:text-left">
            <p class="text-sm font-medium text-slate-600">
                Run a cargo or balikbayan business abroad? <span class="font-bold text-blue-950">We would like to work with you.</span>
            </p>
            <a href="{{ $url }}" @if (! str_starts_with($url, '#')) wire:navigate @endif class="group inline-flex shrink-0 items-center gap-2 rounded-full bg-amber-400 px-5 py-2.5 font-montserrat text-sm font-bold text-blue-950 transition hover:-translate-y-0.5 hover:bg-amber-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-950 focus-visible:ring-offset-2">
                {{ $cta }}
                <svg class="size-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
    </div>

    <style>
        .pl-wrap { overflow: hidden; }
        .pl-fade {
            -webkit-mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent);
                    mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent);
        }
        .pl-track { animation: pl-scroll 45s linear infinite; }
        .pl-wrap:hover .pl-track, .pl-wrap:focus-within .pl-track { animation-play-state: paused; }
        @keyframes pl-scroll { to { transform: translateX(-50%); } }
        @media (prefers-reduced-motion: reduce) {
            .pl-wrap { overflow-x: auto; }
            .pl-track { animation: none; }
        }
    </style>
</section>
</div>
