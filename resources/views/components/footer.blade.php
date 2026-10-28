<div>
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
    {{--
    resources/views/components/site-footer.blade.php

    Usage (in your layout, right after </main>):
        <x-site-footer />

    Override anything with props, for example:
        <x-site-footer
            address="123 Main St, Calgary, AB"
            phone="+1 403 555 0123"
            email="hello@icargo.ca"
            :socials="[
                ['name' => 'Facebook',  'url' => 'https://facebook.com/yourpage',  'icon' => 'facebook'],
                ['name' => 'Instagram', 'url' => 'https://instagram.com/yourpage', 'icon' => 'instagram'],
                ['name' => 'YouTube',   'url' => 'https://youtube.com/@yourpage',  'icon' => 'youtube'],
            ]"
        />

    IMPORTANT: the address, phone, email, hours and social URLs below are PLACEHOLDERS.
    Replace them with your real details.
--}}
{{-- @props([
    'tagline' => 'Safe, reliable balikbayan boxes and cargo delivered to your loved ones across the Philippines.',
    'address' => 'Your street address, City, Province',
    'phone' => '+1 (000) 000-0000',
    'email' => 'info@yourdomain.com',

    // days use ISO numbers: 1 = Monday ... 7 = Sunday (the row for today is highlighted)
    'hours' => [
        ['label' => 'Monday – Friday', 'time' => '9:00 AM – 6:00 PM', 'days' => [1, 2, 3, 4, 5]],
        ['label' => 'Saturday',        'time' => '9:00 AM – 3:00 PM', 'days' => [6]],
        ['label' => 'Sunday',          'time' => 'Closed',            'days' => [7]],
    ],

    'socials' => [
        ['name' => 'Facebook',  'url' => '#', 'icon' => 'facebook'],
        ['name' => 'Instagram', 'url' => '#', 'icon' => 'instagram'],
        ['name' => 'YouTube',   'url' => '#', 'icon' => 'youtube'],
    ],
]) --}}
@props([
    'tagline' => 'Safe, reliable balikbayan boxes and cargo delivered to your loved ones across the Philippines.',
    'address' => null,
    'phone' => null,
    'email' => null,
    'hours' => null,

    'socials' => [
        ['name' => 'Facebook',  'url' => '#', 'icon' => 'facebook'],
        ['name' => 'Instagram', 'url' => '#', 'icon' => 'instagram'],
        ['name' => 'YouTube',   'url' => '#', 'icon' => 'youtube'],
    ],
])
@php
     $s = \App\Models\SiteSetting::current();
    $address = $address ?? ($s->address ?: 'Your street address, City, Province');
    $phone   = $phone ?? ($s->phone ?: '+1 (000) 000-0000');
    $email   = $email ?? ($s->email ?: 'info@yourdomain.com');
    $hours   = $hours ?? $s->hoursRows();
    $today = now()->dayOfWeekIso;

    $quickLinks = [
        ['label' => 'Home',     'url' => route('home')],
        ['label' => 'Services', 'url' => route('services')],
         ['label' => 'Our Work', 'url' => route('ourwork')],
        ['label' => 'About',    'url' => route('about')],
        ['label' => 'Contact',  'url' => route('contact')],
    ];

    // Heroicons (outline)
    $pin   = 'M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0c0 5.4-6.5 11-6.5 11ZM14.25 10a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z';
    $phoneIcon = 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z';
    $mailIcon = 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75';
    $clock = 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z';
@endphp

<footer {{ $attributes->class('relative mt-12 overflow-hidden border-t-4 border-amber-400 bg-blue-950 text-white') }}>
    {{-- decoration --}}
    <div
        class="pointer-events-none absolute inset-0 opacity-30"
        style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;"
        aria-hidden="true"
    ></div>
    <div class="pointer-events-none absolute -right-24 -top-24 size-80 rounded-full bg-amber-400/15 blur-3xl" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-7xl px-6 py-12 lg:px-8 lg:py-16">
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-12 lg:gap-8">

            {{-- Brand + social --}}
            <div class="lg:col-span-4">
                <a href="{{ url('/') }}" wire:navigate class="inline-block rounded-xl bg-white px-3 py-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400">
                    <img src="{{ asset('storage/logo/icargologo.png') }}" alt="iCargo Logo" class="w-28">
                </a>

                <p class="mt-5 max-w-sm text-sm leading-relaxed text-white/70">{{ $tagline }}</p>

                <div class="mt-6 flex items-center gap-3">
                    @foreach ($socials as $social)
                        <a
                            href="{{ $social['url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="{{ $social['name'] }}"
                            class="flex size-11 items-center justify-center rounded-full border border-white/20 text-white transition hover:-translate-y-0.5 hover:border-amber-400 hover:bg-amber-400 hover:text-blue-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400"
                        >
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                @switch($social['icon'])
                                    @case('facebook')
                                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                        @break
                                    @case('instagram')
                                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                                        @break
                                    @case('youtube')
                                        <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z" />
                                        <polygon points="9.75 15.02 15.75 11.75 9.75 8.48 9.75 15.02" />
                                        @break
                                    @default
                                        <path d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                @endswitch
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Quick links --}}
            <nav class="lg:col-span-2" aria-label="Quick links">
                <h3 class="font-montserrat text-sm font-bold uppercase tracking-wider text-amber-400">Quick links</h3>
                <ul class="mt-5 space-y-3">
                    @foreach ($quickLinks as $link)
                        <li>
                            <a href="{{ $link['url'] }}" wire:navigate class="group inline-flex items-center gap-2 text-sm font-medium text-white/80 transition hover:text-amber-300 focus:outline-none focus-visible:text-amber-300">
                                <span class="h-px w-3 bg-amber-400/60 transition-all group-hover:w-5 group-hover:bg-amber-300"></span>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            {{-- Contact --}}
            <div class="lg:col-span-3">
                <h3 class="font-montserrat text-sm font-bold uppercase tracking-wider text-amber-400">Contact us</h3>
                <ul class="mt-5 space-y-4 text-sm">
                    <li class="flex gap-3">
                        <span class="flex size-9 shrink-0 items-center justify-center rounded-full border border-amber-400/60 text-amber-400">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $pin }}" /></svg>
                        </span>
                        <span class="pt-1.5 leading-snug text-white/80">{{ $address }}</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex size-9 shrink-0 items-center justify-center rounded-full border border-amber-400/60 text-amber-400">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $phoneIcon }}" /></svg>
                        </span>
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="pt-1.5 text-white/80 transition hover:text-amber-300">{{ $phone }}</a>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex size-9 shrink-0 items-center justify-center rounded-full border border-amber-400/60 text-amber-400">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $mailIcon }}" /></svg>
                        </span>
                        <a href="mailto:{{ $email }}" class="break-all pt-1.5 text-white/80 transition hover:text-amber-300">{{ $email }}</a>
                    </li>
                </ul>
            </div>

            {{-- Office hours --}}
            <div class="lg:col-span-3">
                <h3 class="flex items-center gap-2 font-montserrat text-sm font-bold uppercase tracking-wider text-amber-400">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $clock }}" /></svg>
                    Office hours
                </h3>

                <ul class="mt-5 space-y-2">
                    @foreach ($hours as $row)
                        @php $isToday = in_array($today, $row['days'] ?? []); @endphp
                        <li class="rounded-xl border px-4 py-3 text-sm transition {{ $isToday ? 'border-amber-400/70 bg-amber-400/10' : 'border-white/10 bg-white/5' }}">
                            <div class="flex items-center justify-between gap-2">
                                <span class="font-semibold {{ $isToday ? 'text-amber-300' : 'text-white' }}">{{ $row['label'] }}</span>
                                @if ($isToday)
                                    <span class="rounded-full bg-amber-400 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-blue-950">Today</span>
                                @endif
                            </div>
                            <p class="mt-0.5 text-white/70">{{ $row['time'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-6 text-sm text-white/60 sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <div class="flex flex-col items-center gap-2 sm:flex-row sm:gap-6">

    <div class="flex items-center gap-4">
        <a href="/privacy-policy" wire:navigate class="transition hover:text-amber-300">Privacy Policy</a>
        <a href="/terms" wire:navigate class="transition hover:text-amber-300">Terms of Service</a>
    </div>
</div>
            <button
                type="button"
                x-data
                @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                class="inline-flex items-center gap-2 rounded-full border border-white/20 px-4 py-2 font-semibold text-white/80 transition hover:border-amber-400 hover:text-amber-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400"
            >
                Back to top
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </button>
        </div>
    </div>
</footer>
</div>
