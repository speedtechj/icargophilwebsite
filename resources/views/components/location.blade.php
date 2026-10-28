<div>


    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Maria Skłodowska-Curie -->
    {{--
    resources/views/components/location-hours.blade.php

    Usage:
        <x-location-hours />

    With your real details:
        <x-location-hours
            address="123 Main Street, Calgary, AB T2P 0A1"
            directions="Free parking behind the building. Look for the blue iCargo sign."
            map-link="https://maps.google.com/?q=123+Main+Street+Calgary"
            map-embed="https://www.google.com/maps/embed?pb=PASTE_THE_EMBED_LINK_HERE"
            timezone="America/Edmonton"
            :hours="[
                ['label' => 'Monday – Friday', 'time' => '9:00 AM – 6:00 PM', 'days' => [1,2,3,4,5], 'open' => '09:00', 'close' => '18:00'],
                ['label' => 'Saturday',        'time' => '9:00 AM – 3:00 PM', 'days' => [6],         'open' => '09:00', 'close' => '15:00'],
                ['label' => 'Sunday',          'time' => 'Closed',            'days' => [7]],
            ]"
        />

    How to get the map-embed link: open Google Maps, find your address, press Share, choose
    "Embed a map", and copy only the address inside src="...".

    Hours: 'days' uses ISO numbers (1 = Monday ... 7 = Sunday). 'open' and 'close' use 24-hour
    time and are only used to show the "Open now / Closed now" badge. Leave them out for a closed day.
    The badge is worked out on the server each time the page loads, in the 'timezone' you give.

    Needs only Tailwind (no JavaScript).

    IMPORTANT: the address and hours below are PLACEHOLDERS. Replace them with your real details.
--}}
@props([
    'eyebrow' => 'Visit us',
    'title' => 'Find us and our hours',
    'address' => 'Unit D, Riverside, Tanzang Luma VI, Imus City, Cavite 4103 Philippines ',
    'directions' => 'Add a short tip here, such as parking, a landmark or where to drop off boxes.',
    'mapLink' => null,
    'mapEmbed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1932.1589398294825!2d120.94151398879306!3d14.408830044355208!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d25535aaa507%3A0x64763008084e8b59!2sTanzang%20Luma%20VI%2C%20Imus%2C%20Cavite%2C%20Philippines!5e0!3m2!1sen!2sca!4v1793141961701!5m2!1sen!2sca" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin',
    'timezone' => 'Asia/Manila',
    'hours' => [
        ['label' => 'Monday – Friday', 'time' => '9:00 AM – 6:00 PM', 'days' => [1, 2, 3, 4, 5], 'open' => '09:00', 'close' => '18:00'],
        ['label' => 'Saturday',        'time' => '9:00 AM – 3:00 PM', 'days' => [6],              'open' => '09:00', 'close' => '15:00'],
        ['label' => 'Sunday',          'time' => 'Closed',            'days' => [7]],
    ],
])

@php
    $now = now($timezone ?: config('app.timezone'));
    $today = $now->dayOfWeekIso;
    $clock = $now->format('H:i');

    // work out whether we are open right now
    $openNow = false;
    foreach ($hours as $row) {
        if (in_array($today, $row['days'] ?? [], true) && ! empty($row['open']) && ! empty($row['close'])) {
            $openNow = $clock >= $row['open'] && $clock < $row['close'];
        }
    }

    $pin = 'M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0c0 5.4-6.5 11-6.5 11ZM14.25 10a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z';
    $clockIcon = 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z';
    $mapUrl = $mapLink ?: 'https://www.google.com/maps/search/?api=1&query=' . urlencode($address);
@endphp

<section {{ $attributes->class('my-10 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm') }} aria-labelledby="location-heading">

    {{-- Map --}}
    <div class="relative aspect-[16/10] bg-blue-950">
        @if ($mapEmbed)
            <iframe
                src="{{ $mapEmbed }}"
                class="absolute inset-0 size-full border-0"
                title="Map showing our location"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen
            ></iframe>
        @else
            {{-- placeholder until a map link is added --}}
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-blue-950"></div>
            <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;" aria-hidden="true"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 text-center">
                <span class="flex size-16 items-center justify-center rounded-full border-2 border-amber-400 text-amber-400">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $pin }}" /></svg>
                </span>
                <p class="px-6 text-sm font-semibold text-white/55">Add your Google Maps embed link here</p>
            </div>
        @endif
    </div>

    <div class="space-y-8 p-6 sm:p-8">

        {{-- Address --}}
        <div>
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
                <span class="size-1.5 rounded-full bg-amber-500"></span>
                {{ $eyebrow }}
            </p>
            <h2 id="location-heading" class="mt-3 font-montserrat text-2xl font-extrabold text-blue-950">{{ $title }}</h2>

            <div class="mt-5 flex items-start gap-4">
                <span class="flex size-12 shrink-0 items-center justify-center rounded-full border-2 border-amber-400 text-amber-500">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $pin }}" /></svg>
                </span>
                <div>
                    <p class="font-montserrat text-base font-bold leading-snug text-blue-950">{{ $address }}</p>
                    @if ($directions)
                        <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $directions }}</p>
                    @endif
                    <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer"
                       class="group mt-3 inline-flex items-center gap-2 rounded-full bg-blue-950 px-5 py-2.5 font-montserrat text-sm font-bold text-white transition hover:bg-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2">
                        Get directions
                        <svg class="size-4 text-amber-400 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Hours --}}
        <div>
            <div class="flex items-center justify-between gap-3">
                <h3 class="flex items-center gap-2 font-montserrat text-lg font-extrabold text-blue-950">
                    <svg class="size-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $clockIcon }}" /></svg>
                    Opening hours
                </h3>

                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-extrabold uppercase tracking-wide {{ $openNow ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                    <span class="relative flex size-2">
                        @if ($openNow)
                            <span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-500 opacity-75"></span>
                        @endif
                        <span class="relative inline-flex size-2 rounded-full {{ $openNow ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                    </span>
                    {{ $openNow ? 'Open now' : 'Closed now' }}
                </span>
            </div>

            <ul class="mt-4 space-y-2">
                @foreach ($hours as $row)
                    @php $isToday = in_array($today, $row['days'] ?? [], true); @endphp
                    <li class="flex items-center justify-between gap-3 rounded-xl border px-4 py-3 text-sm {{ $isToday ? 'border-amber-400 bg-amber-50' : 'border-slate-200 bg-slate-50' }}">
                        <span class="flex items-center gap-2 font-semibold {{ $isToday ? 'text-blue-950' : 'text-slate-700' }}">
                            {{ $row['label'] }}
                            @if ($isToday)
                                <span class="rounded-full bg-amber-400 px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wide text-blue-950">Today</span>
                            @endif
                        </span>
                        <span class="font-bold {{ $isToday ? 'text-blue-950' : 'text-slate-600' }}">{{ $row['time'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
</div>
