<div>
    <!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
    {{--
    resources/views/components/cta-band.blade.php

    Usage:
        <x-cta-band />

    Custom:
        <x-cta-band
            phone="+1 403 555 0123"
            email="hello@yourdomain.com"
            messenger="https://m.me/yourpage"
            viber="viber://chat?number=%2B14035550123"
            hours="Mon–Fri 9 AM – 6 PM · Sat 9 AM – 3 PM"
        />

    Any contact option you leave empty (null or '') is hidden automatically.
    The main amber button goes to your contact page; change it with button="..." and :url="...".

    Needs only Tailwind (no JavaScript).

    IMPORTANT: the phone, email, Messenger and Viber values below are PLACEHOLDERS.
    Replace them with your real contact details before going live.
--}}
@props([
    'eyebrow' => 'Get in touch',
    'title' => 'Ready to send?',
    'highlight' => 'Talk to us.',
    'subtitle' => 'Message us and we will help you choose the right box, give you a quote and book your pickup.',
    'button' => 'Request a pickup',
    'phone' => null,
    'email' => null,
    'messenger' => null,
    'viber' => null,
    'hours' => null,
])

@php
    $s = \App\Models\SiteSetting::current();
    $phone     = $phone ?? $s->phone;
    $email     = $email ?? $s->email;
    $messenger = $messenger ?? $s->messenger_url;
    $viber     = $viber ?? $s->viber_url;

    $hours = $hours ?? collect($s->hoursRows())
        ->reject(fn ($r) => $r['time'] === 'Closed')
        ->map(fn ($r) => $r['label'] . ' ' . $r['time'])
        ->implode(' · ');
    $url = $url ?? route('contact');

    $options = [];

    if ($phone) {
        $options[] = [
            'label' => 'Call us',
            'value' => $phone,
            'href' => 'tel:' . preg_replace('/[^\d+]/', '', $phone),
            'external' => false,
            'icon' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z',
        ];
    }

    if ($email) {
        $options[] = [
            'label' => 'Email us',
            'value' => $email,
            'href' => 'mailto:' . $email,
            'external' => false,
            'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75',
        ];
    }

    if ($messenger) {
        $options[] = [
            'label' => 'Message us',
            'value' => 'Chat on Messenger',
            'href' => $messenger,
            'external' => true,
            'icon' => 'M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z',
        ];
    }

    if ($viber) {
        $options[] = [
            'label' => 'Viber',
            'value' => 'Chat on Viber',
            'href' => $viber,
            'external' => true,
            'icon' => 'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z',
        ];
    }

    $clock = 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z';
@endphp

<section
    {{ $attributes->class('relative my-10 overflow-hidden rounded-3xl border-b-4 border-amber-400 bg-blue-950') }}
    aria-labelledby="cta-heading"
>
    {{-- decoration --}}
    <div
        class="pointer-events-none absolute inset-0 opacity-40"
        style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;"
        aria-hidden="true"
    ></div>
    <div class="pointer-events-none absolute -right-24 -top-24 size-96 rounded-full bg-amber-400/25 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-32 -left-20 size-96 rounded-full bg-blue-500/20 blur-3xl" aria-hidden="true"></div>

    <div class="relative grid items-center gap-10 px-6 py-12 sm:px-12 sm:py-16 lg:grid-cols-[1.1fr_1fr] lg:gap-14">

        {{-- Message --}}
        <div>
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-400/15 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-300">
                <span class="size-1.5 rounded-full bg-amber-400"></span>
                {{ $eyebrow }}
            </p>

            <h2 id="cta-heading" class="mt-5 font-montserrat text-4xl font-extrabold leading-tight text-white sm:text-5xl">
                {{ $title }}
                <span class="block text-amber-400">{{ $highlight }}</span>
            </h2>

            @if ($subtitle)
                <p class="mt-5 max-w-xl text-lg leading-relaxed text-white/75">{{ $subtitle }}</p>
            @endif

            <div class="mt-8">
                <a
                    href="{{ $url }}"
                    wire:navigate
                    class="group inline-flex items-center gap-2 rounded-full bg-amber-400 px-7 py-3.5 font-montserrat text-base font-bold text-blue-950 shadow-lg shadow-amber-400/20 transition hover:-translate-y-0.5 hover:bg-amber-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-blue-950"
                >
                    {{ $button }}
                    <svg class="size-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            @if ($hours)
                <p class="mt-6 flex items-center gap-2 text-sm text-white/60">
                    <svg class="size-5 shrink-0 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $clock }}" /></svg>
                    {{ $hours }}
                </p>
            @endif
        </div>

        {{-- Contact options --}}
        @if (count($options))
            <ul class="grid gap-3 sm:grid-cols-2">
                @foreach ($options as $option)
                    <li>
                        <a
                            href="{{ $option['href'] }}"
                            @if ($option['external']) target="_blank" rel="noopener noreferrer" @endif
                            class="group flex h-full items-center gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-amber-400/60 hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400"
                        >
                            <span class="flex size-12 shrink-0 items-center justify-center rounded-full border-2 border-amber-400 text-amber-400 transition group-hover:bg-amber-400 group-hover:text-blue-950">
                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision" aria-hidden="true">
                                    <path d="{{ $option['icon'] }}" />
                                </svg>
                            </span>
                            <span class="min-w-0">
                                <span class="block text-xs font-bold uppercase tracking-wider text-amber-300">{{ $option['label'] }}</span>
                                <span class="block break-words font-montserrat text-sm font-bold text-white">{{ $option['value'] }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</section>
</div>
