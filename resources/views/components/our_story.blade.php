<div>
    <!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
    {{--
    resources/views/components/our-story.blade.php

    Usage:
        <x-our-story />

    With your real details:
        <x-our-story
            founder="Maria Santos"
            role="Founder"
            since="2014"
            :photo="asset('storage/about/founder.jpg')"
            photo-alt="Maria Santos, founder of iCargo"
            lead="Every box we deliver carries someone's love."
            :paragraphs="[
                'First paragraph: who started the business and when.',
                'Second paragraph: why you started it.',
                'Third paragraph: what you still believe in today.',
            ]"
            quote="We don't just move boxes. We bring families closer."
        />

    Optional milestones row (leave out to hide it):
        :milestones="[
            ['year' => '2014', 'label' => 'Started with our first shipment'],
            ['year' => '2018', 'label' => 'Opened our own warehouse'],
            ['year' => '2024', 'label' => 'Delivering nationwide'],
        ]"

    Other optional props: eyebrow, title, cta, ctaUrl. Set cta="" to hide the button.
    The section has id="story", so a hero link to #story scrolls here.

    Needs only Tailwind (no JavaScript).

    IMPORTANT: the story below is SAMPLE wording and the name and year are placeholders.
    Rewrite it with your real story. Short, honest and personal works best.
--}}
@props([
    'eyebrow' => 'Our story',
    'title' => 'A family business built on care',
    'lead' => 'Every box we deliver carries someone\'s love.',
    'paragraphs' => [
        'iCargo began with a simple idea: sending things home to the Philippines should feel safe, fair and easy. Too many families worried about whether their boxes would arrive, and we wanted to change that.',
        'We started small, with our own hands on every box. Today we still treat each shipment the way we would treat our own family\'s gifts: checked, packed with care and delivered to the door.',
        'Behind every box is a family waiting. That is why we answer every question, explain every step and keep our promises.',
    ],
    'quote' => 'We don\'t just move boxes. We bring families closer.',
    'founder' => 'Founder name',
    'role' => 'Founder, iCargo',
    'since' => '20XX',
    'photo' => null,
    'photoAlt' => 'The iCargo founder',
    'milestones' => [],
    'cta' => 'See how we handle your boxes',
    'ctaUrl' => null,
])

@php
    if ($s = \App\Models\OurStory::data()) {
    $eyebrow    = $s['eyebrow'] ?: $eyebrow;
    $title      = $s['title'] ?: $title;
    $lead       = $s['lead'];
    $paragraphs = $s['paragraphs'] ?: $paragraphs;
    $quote      = $s['quote'];
    $founder    = $s['founder'] ?: $founder;
    $role       = $s['role'] ?: $role;
    $since      = $s['since'];
    $photo      = $s['photo'];
    $photoAlt   = $s['photo_alt'] ?: $photoAlt;
    $milestones = $s['milestones'];
}
    $ctaUrl = $ctaUrl ?? url('/our-work');
    $person = 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z';
@endphp

<section
    id="story"
    {{ $attributes->class('relative my-10 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm') }}
    aria-labelledby="story-heading"
>
    {{-- soft decoration --}}
    <div class="pointer-events-none absolute -right-24 -top-24 size-80 rounded-full bg-amber-100 blur-3xl" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-24 -left-20 size-72 rounded-full bg-blue-100 blur-3xl" aria-hidden="true"></div>

    <div class="relative grid items-center gap-12 px-6 py-12 sm:px-10 sm:py-16 lg:grid-cols-[1fr_1.1fr] lg:gap-16">

        {{-- PHOTO --}}
        <div class="relative mx-auto w-full max-w-md lg:max-w-none">
            {{-- offset amber frame --}}
            <span class="absolute inset-0 translate-x-3 translate-y-3 rounded-[2rem] border-2 border-amber-400" aria-hidden="true"></span>

            <div class="relative aspect-[4/5] overflow-hidden rounded-[2rem] bg-blue-950 shadow-xl ring-1 ring-slate-200">
                @if ($photo)
                    <img src="{{ $photo }}" alt="{{ $photoAlt }}" loading="lazy" class="size-full object-cover">
                    <span class="pointer-events-none absolute inset-0 bg-gradient-to-t from-blue-950/60 via-transparent to-transparent"></span>
                @else
                    {{-- placeholder until a real photo is added --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-blue-950"></div>
                    <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;" aria-hidden="true"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 text-center">
                        <svg class="size-20 text-amber-400/80" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="{{ $person }}" />
                        </svg>
                        <p class="px-6 text-sm font-semibold text-white/55">Add a real photo of the founder or your team</p>
                    </div>
                @endif

                {{-- name card --}}
                <div class="absolute inset-x-4 bottom-4 rounded-2xl border border-white/15 bg-blue-950/85 px-5 py-4 backdrop-blur">
                    <p class="font-montserrat text-lg font-extrabold text-white">{{ $founder }}</p>
                    <p class="text-sm font-semibold text-amber-300">{{ $role }}</p>
                </div>
            </div>

            {{-- since badge --}}
            @if ($since)
                <div class="absolute -right-3 -top-5 flex size-28 flex-col items-center justify-center rounded-full bg-amber-400 text-center text-blue-950 shadow-xl ring-8 ring-white sm:-right-6 sm:size-32">
                    <span class="font-montserrat text-[11px] font-bold uppercase tracking-wider">Since</span>
                    <span class="font-montserrat text-2xl font-extrabold leading-none sm:text-3xl">{{ $since }}</span>
                </div>
            @endif
        </div>

        {{-- TEXT --}}
        <div>
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
                <span class="size-1.5 rounded-full bg-amber-500"></span>
                {{ $eyebrow }}
            </p>

            <h2 id="story-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
                {{ $title }}
            </h2>

            @if ($lead)
                <p class="mt-5 font-montserrat text-xl font-bold leading-snug text-amber-600">
                    {{ $lead }}
                </p>
            @endif

            <div class="mt-5 space-y-4 text-base leading-relaxed text-slate-600 sm:text-lg">
                @foreach ($paragraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>

            {{-- pull quote --}}
            @if ($quote)
                <figure class="relative mt-8 rounded-2xl border-l-4 border-amber-400 bg-amber-50 py-5 pl-6 pr-5">
                    <svg class="absolute right-4 top-4 size-8 text-amber-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M9.5 6C6.5 7 4.5 9.5 4.5 13v5h6v-6h-3c0-2 1-3 3-3.7L9.5 6Zm9 0c-3 1-5 3.5-5 7v5h6v-6h-3c0-2 1-3 3-3.7L18.5 6Z" />
                    </svg>
                    <blockquote class="pr-8 font-montserrat text-lg font-bold leading-snug text-blue-950">
                        {{ $quote }}
                    </blockquote>
                    <figcaption class="mt-3 text-sm font-semibold text-slate-500">
                        {{ $founder }}, <span class="text-slate-400">{{ $role }}</span>
                    </figcaption>
                </figure>
            @endif

            {{-- milestones (optional) --}}
            @if (! empty($milestones))
                <ol class="mt-8 grid gap-4 border-t border-slate-200 pt-6 sm:grid-cols-3">
                    @foreach ($milestones as $m)
                        <li>
                            <p class="font-montserrat text-2xl font-extrabold text-blue-950">{{ $m['year'] }}</p>
                            <p class="mt-1 text-sm leading-snug text-slate-600">{{ $m['label'] }}</p>
                        </li>
                    @endforeach
                </ol>
            @endif

            @if ($cta)
                <a
                    href="{{ $ctaUrl }}"
                    wire:navigate
                    class="group mt-8 inline-flex items-center gap-2 rounded-full bg-blue-950 px-6 py-3 font-montserrat text-sm font-bold text-white transition hover:bg-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2"
                >
                    {{ $cta }}
                    <svg class="size-4 text-amber-400 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            @endif
        </div>
    </div>
</section>
</div>
