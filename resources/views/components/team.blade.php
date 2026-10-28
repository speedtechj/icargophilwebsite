<div>
    <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->
    {{--
    resources/views/components/team-cards.blade.php

    Usage:
        <x-team-cards />

    With your real team:
        <x-team-cards
            :team-photo="asset('storage/about/team.jpg')"
            team-photo-caption="The iCargo team, October 2026"
            :leader="[
                'name' => 'Maria Santos',
                'role' => 'Owner & Manager',
                'text' => 'I started iCargo so families can send love home with peace of mind.',
                'photo' => asset('storage/about/maria.jpg'),
            ]"
            :groups="[
                ['name' => 'Warehouse', 'icon' => 'box', 'text' => 'The hands that check and pack every box.', 'members' => [
                    ['name' => 'Juan Dela Cruz', 'role' => 'Warehouse Supervisor', 'text' => 'Every box gets my full attention.', 'photo' => asset('storage/about/juan.jpg')],
                ]],
                ['name' => 'Drivers', 'icon' => 'truck', 'members' => [ ... ]],
            ]"
        />

    Group icons: briefcase | box | truck | chat
    Member keys: name, role, text (one friendly line), photo (optional)
    Optional props: eyebrow, title, subtitle, teamPhoto, teamPhotoCaption, leader (null hides it)

    The leader card and team photo come first, then each group in order. Groups with no members are skipped.

    Needs only Tailwind (no JavaScript).

    IMPORTANT: every name, role and line below is a PLACEHOLDER. Add your real people.
    Get each person's permission before publishing their photo and name, and use photos
    of the same size and style (portrait, plain background) so the grid looks tidy.
--}}
@props([
    'eyebrow' => 'Meet our team',
    'title' => 'The people behind your boxes',
    'subtitle' => 'Real people, careful hands and friendly voices. Meet the team that looks after every shipment.',
    'teamPhoto' => null,
    'teamPhotoCaption' => 'The iCargo team',
    'leader' => [
        'name' => 'Owner name',
        'role' => 'Owner & Manager',
        'text' => 'A short, friendly line from the owner about why they love this work.',
        'photo' => null,
    ],
    'groups' => [
        [
            'name' => 'Management',
            'icon' => 'briefcase',
            'text' => 'Planning every shipment from start to finish.',
            'members' => [
                ['name' => 'Staff name', 'role' => 'Operations Manager', 'text' => 'A short, friendly line about this person.', 'photo' => null],
            ],
        ],
        [
            'name' => 'Warehouse',
            'icon' => 'box',
            'text' => 'The hands that check and pack every box.',
            'members' => [
                ['name' => 'Staff name', 'role' => 'Warehouse Supervisor', 'text' => 'A short, friendly line about this person.', 'photo' => null],
                ['name' => 'Staff name', 'role' => 'Packing Team', 'text' => 'A short, friendly line about this person.', 'photo' => null],
                ['name' => 'Staff name', 'role' => 'Packing Team', 'text' => 'A short, friendly line about this person.', 'photo' => null],
            ],
        ],
        [
            'name' => 'Drivers',
            'icon' => 'truck',
            'text' => 'Bringing your boxes safely to the door.',
            'members' => [
                ['name' => 'Staff name', 'role' => 'Delivery Driver', 'text' => 'A short, friendly line about this person.', 'photo' => null],
                ['name' => 'Staff name', 'role' => 'Delivery Driver', 'text' => 'A short, friendly line about this person.', 'photo' => null],
                ['name' => 'Staff name', 'role' => 'Delivery Rider', 'text' => 'A short, friendly line about this person.', 'photo' => null],
            ],
        ],
        [
            'name' => 'Customer service',
            'icon' => 'chat',
            'text' => 'The friendly voices who answer your questions.',
            'members' => [
                ['name' => 'Staff name', 'role' => 'Customer Service', 'text' => 'A short, friendly line about this person.', 'photo' => null],
                ['name' => 'Staff name', 'role' => 'Customer Service', 'text' => 'A short, friendly line about this person.', 'photo' => null],
            ],
        ],
    ],
])

@php
    if ($page = \App\Models\TeamPage::data()) {
    $eyebrow          = $page['eyebrow'] ?: $eyebrow;
    $title            = $page['title'] ?: $title;
    $subtitle         = $page['subtitle'] ?: $subtitle;
    $teamPhoto        = $page['team_photo'];
    $teamPhotoCaption = $page['team_photo_caption'] ?: $teamPhotoCaption;
    $leader           = $page['leader'];     // null hides the owner card
}

$groups = \App\Models\TeamGroup::forSite() ?: $groups;
    $icons = [
        'briefcase' => 'M3.5 8.5h17V19a1 1 0 0 1-1 1h-15a1 1 0 0 1-1-1V8.5ZM8.5 8.5V6A1.5 1.5 0 0 1 10 4.5h4A1.5 1.5 0 0 1 15.5 6v2.5M3.5 13.5h17',
        'box'       => 'M12 3 4 7.25v9.5L12 21l8-4.25v-9.5L12 3ZM4 7.25l8 4.25 8-4.25M12 11.5V21',
        'truck'     => 'M3 7a2 2 0 0 1 2-2h8v11H3V7ZM13 9h3.6a1 1 0 0 1 .8.4l2.3 3.1a1 1 0 0 1 .2.6V16H13V9ZM9.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM18.5 17.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z',
        'chat'      => 'M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z',
    ];

    $person = 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z';
    $users  = 'M9 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.5 19.5a5.5 5.5 0 0 1 11 0M16.5 11a2.5 2.5 0 1 0 0-5M17.25 14.3a5 5 0 0 1 3.25 5.2';
@endphp

<section
    {{ $attributes->class('my-10') }}
    aria-labelledby="team-heading"
>
    {{-- Heading --}}
    <div class="mx-auto max-w-2xl text-center">
        <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
            <span class="size-1.5 rounded-full bg-amber-500"></span>
            {{ $eyebrow }}
        </p>
        <h2 id="team-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
            {{ $title }}
        </h2>
        @if ($subtitle)
            <p class="mt-3 text-base leading-relaxed text-slate-600">{{ $subtitle }}</p>
        @endif
    </div>

    <div class="mx-auto mt-10 max-w-7xl space-y-14">

        {{-- TEAM PHOTO --}}
        <figure class="group relative">
            <span class="absolute inset-0 translate-x-2 translate-y-2 rounded-3xl border-2 border-amber-400/70" aria-hidden="true"></span>

            <div class="relative aspect-[16/10] overflow-hidden rounded-3xl bg-blue-950 shadow-xl ring-1 ring-slate-200 sm:aspect-[21/9]">
                @if ($teamPhoto)
                    <img src="{{ $teamPhoto }}" alt="{{ $teamPhotoCaption }}" loading="lazy" class="size-full object-cover transition duration-700 group-hover:scale-105">
                    <span class="pointer-events-none absolute inset-0 bg-gradient-to-t from-blue-950/70 via-transparent to-transparent"></span>
                @else
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-blue-950"></div>
                    <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;" aria-hidden="true"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 text-center">
                        <svg class="size-16 text-amber-400/80 sm:size-20" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $users }}" /></svg>
                        <p class="px-6 text-sm font-semibold text-white/55">Add one photo of the whole team here</p>
                    </div>
                @endif

                <figcaption class="absolute bottom-4 left-4 rounded-full border border-white/20 bg-blue-950/80 px-4 py-2 font-montserrat text-sm font-bold text-white backdrop-blur">
                    <span class="mr-2 inline-block size-2 rounded-full bg-amber-400"></span>{{ $teamPhotoCaption }}
                </figcaption>
            </div>
        </figure>

        {{-- LEADER --}}
        @if (! empty($leader))
            <div class="relative overflow-hidden rounded-3xl bg-blue-950 shadow-xl">
                <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -right-20 -top-20 size-80 rounded-full bg-amber-400/20 blur-3xl" aria-hidden="true"></div>

                <div class="relative grid items-center gap-8 p-6 sm:p-10 md:grid-cols-[18rem_1fr] md:gap-12">
                    <div class="relative mx-auto aspect-[4/5] w-full max-w-xs overflow-hidden rounded-2xl bg-blue-900 ring-4 ring-amber-400/80 md:max-w-none">
                        @if (! empty($leader['photo']))
                            <img src="{{ $leader['photo'] }}" alt="{{ $leader['name'] }}" loading="lazy" class="size-full object-cover">
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-gradient-to-br from-blue-900 to-blue-950">
                                <svg class="size-20 text-amber-400/80" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $person }}" /></svg>
                                <p class="text-xs font-semibold text-white/55">Add owner photo</p>
                            </div>
                        @endif
                    </div>

                    <div class="text-center md:text-left">
                        <p class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-3 py-1 font-montserrat text-xs font-extrabold uppercase tracking-wider text-blue-950">
                            {{ $leader['role'] }}
                        </p>
                        <h3 class="mt-4 font-montserrat text-3xl font-extrabold text-white sm:text-4xl">{{ $leader['name'] }}</h3>

                        @if (! empty($leader['text']))
                            <div class="relative mt-5">
                                <svg class="absolute -top-2 left-1/2 size-10 -translate-x-1/2 text-amber-400/30 md:-left-3 md:translate-x-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M9.5 6C6.5 7 4.5 9.5 4.5 13v5h6v-6h-3c0-2 1-3 3-3.7L9.5 6Zm9 0c-3 1-5 3.5-5 7v5h6v-6h-3c0-2 1-3 3-3.7L18.5 6Z" />
                                </svg>
                                <p class="relative pt-8 text-lg leading-relaxed text-white/85 sm:text-xl">{{ $leader['text'] }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- GROUPS --}}
        @foreach ($groups as $group)
            @continue(empty($group['members']))

            <div>
                {{-- group header --}}
                <div class="flex items-center gap-4">
                    <span class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-amber-400 shadow-md shadow-amber-400/30">
                        <svg class="size-7 text-blue-950" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision" aria-hidden="true">
                            <path d="{{ $icons[$group['icon'] ?? 'briefcase'] ?? $icons['briefcase'] }}" />
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <h3 class="font-montserrat text-2xl font-extrabold text-blue-950">{{ $group['name'] }}</h3>
                        @if (! empty($group['text']))
                            <p class="text-sm text-slate-500">{{ $group['text'] }}</p>
                        @endif
                    </div>
                    <span class="ml-auto hidden h-px flex-1 bg-gradient-to-r from-amber-300 to-transparent sm:block" aria-hidden="true"></span>
                    <span class="shrink-0 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ count($group['members']) }}</span>
                </div>

                {{-- member cards --}}
                <ul class="mt-6 grid grid-cols-2 gap-4 sm:gap-6 md:grid-cols-3 lg:grid-cols-4">
                    @foreach ($group['members'] as $member)
                        <li class="group relative overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-amber-300">

                            {{-- photo --}}
                            <div class="relative aspect-[4/5] overflow-hidden bg-blue-950">
                                @if (! empty($member['photo']))
                                    <img src="{{ $member['photo'] }}" alt="{{ $member['name'] }}" loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-110">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-900 to-blue-950">
                                        <svg class="size-16 text-amber-400/70" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $person }}" /></svg>
                                    </div>
                                @endif

                                {{-- friendly line slides up on hover (desktop) --}}
                                @if (! empty($member['text']))
                                    <div class="absolute inset-x-0 bottom-0 hidden translate-y-full border-t-2 border-amber-400 bg-blue-950/95 p-4 text-sm leading-snug text-white transition duration-300 group-hover:translate-y-0 md:block">
                                        {{ $member['text'] }}
                                    </div>
                                @endif
                            </div>

                            {{-- name + role --}}
                            <div class="border-t-4 border-amber-400 p-4">
                                <h4 class="font-montserrat text-base font-extrabold leading-snug text-blue-950">{{ $member['name'] }}</h4>
                                <p class="mt-0.5 text-sm font-semibold text-amber-600">{{ $member['role'] }}</p>

                                {{-- friendly line always visible on phones --}}
                                @if (! empty($member['text']))
                                    <p class="mt-2 text-sm leading-snug text-slate-600 md:hidden">{{ $member['text'] }}</p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</section>
</div>
