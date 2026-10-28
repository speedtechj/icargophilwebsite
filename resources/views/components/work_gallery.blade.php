<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
    {{--
    resources/views/components/our-work-gallery.blade.php

    Usage:
        <x-our-work-gallery />

    Your own photos and videos:
        <x-our-work-gallery :items="[
            ['type' => 'photo', 'category' => 'unloading',  'src' => asset('storage/work/unloading-1.jpg'), 'caption' => 'Unloading boxes from the container', 'meta' => 'Manila warehouse · Oct 2026'],
            ['type' => 'video', 'category' => 'deliveries', 'src' => asset('storage/work/delivery-thumb.jpg'), 'video' => 'https://www.youtube.com/watch?v=XXXXXXXXXXX', 'caption' => 'Delivery to Cebu', 'meta' => 'Cebu · Sep 2026'],
        ]" />

    Item keys:
        type      photo | video
        category  unloading | deliveries | warehouse | customers  (must match a key in $categories)
        src       photo URL, or the video's thumbnail. Leave empty to show a placeholder.
        video     (videos only) a YouTube link, a Facebook embed link, or a .mp4/.webm file URL.
        caption   short title shown on hover and in the viewer
        meta      small line such as place and date

    Featured video at the top (optional):
        <x-our-work-gallery :featured="[
            'title' => 'Container unloading day',
            'caption' => 'Watch how every box is checked as it comes off the container.',
            'video' => 'https://www.youtube.com/watch?v=XXXXXXXXXXX',
            'poster' => asset('storage/work/featured.jpg'),
        ]" />
        Set :featured="null" to hide it.

    Tips:
      - Upload videos to YouTube or Facebook and paste the link. Do not host large video files yourself.
      - Resize photos to about 1600 px wide and compress them before uploading.
      - Blur faces, house numbers and address labels, and get staff and customers' permission.

    Needs Alpine.js (already in Livewire 3) and Tailwind.

    IMPORTANT: everything below is SAMPLE content with empty photo slots. Add your own photos,
    videos and captions, and edit the "promise" wording so it only says what you really do.
--}}
@props([
    'eyebrow' => 'Our work',
    'title' => 'See how we handle your boxes',
    'subtitle' => 'From the container to your family\'s door. Real photos and videos from our team.',
    'allLabel' => 'All',
    'categories' => [
        ['key' => 'unloading',  'label' => 'Container unloading'],
        ['key' => 'deliveries', 'label' => 'Deliveries'],
        ['key' => 'warehouse',  'label' => 'Warehouse & packing'],
        ['key' => 'customers',  'label' => 'Happy customers'],
    ],
    'featured' => [
        'title' => 'Container unloading day',
        'caption' => 'Watch how every box is checked and sorted as it comes off the container.',
        'video' => null,
        'poster' => null,
    ],
    'promise' => [
        ['title' => 'Checked on arrival', 'text' => 'Boxes are checked as they come off the container.'],
        ['title' => 'Handled by our team', 'text' => 'Our own staff sort and load every shipment.'],
        ['title' => 'Delivered to the door', 'text' => 'Riders bring your boxes to the recipient\'s address.'],
    ],
    'items' => [
        ['type' => 'video', 'category' => 'unloading',  'src' => null, 'video' => null, 'caption' => 'Unloading the container', 'meta' => 'Warehouse · Add date'],
        ['type' => 'photo', 'category' => 'unloading',  'src' => null, 'caption' => 'Boxes coming off the container', 'meta' => 'Warehouse · Add date'],
        ['type' => 'photo', 'category' => 'unloading',  'src' => null, 'caption' => 'Counting and checking every box', 'meta' => 'Warehouse · Add date'],
        ['type' => 'photo', 'category' => 'warehouse',  'src' => null, 'caption' => 'Sorting boxes by destination', 'meta' => 'Warehouse · Add date'],
        ['type' => 'photo', 'category' => 'warehouse',  'src' => null, 'caption' => 'Loading the delivery truck', 'meta' => 'Warehouse · Add date'],
        ['type' => 'video', 'category' => 'deliveries', 'src' => null, 'video' => null, 'caption' => 'On the road to the province', 'meta' => 'Luzon · Add date'],
        ['type' => 'photo', 'category' => 'deliveries', 'src' => null, 'caption' => 'Delivery in Visayas', 'meta' => 'Cebu · Add date'],
        ['type' => 'photo', 'category' => 'deliveries', 'src' => null, 'caption' => 'Delivery in Mindanao', 'meta' => 'Davao · Add date'],
        ['type' => 'photo', 'category' => 'customers',  'src' => null, 'caption' => 'A family receiving their balikbayan box', 'meta' => 'Add place · Add date'],
        ['type' => 'photo', 'category' => 'customers',  'src' => null, 'caption' => 'Smiles on delivery day', 'meta' => 'Add place · Add date'],
    ],
])

@php
    $box = 'M12 3 4 7.25v9.5L12 21l8-4.25v-9.5L12 3ZM4 7.25l8 4.25 8-4.25M12 11.5V21';
    // tabs always match the categories in the admin form
    $categories = collect(\App\Models\WorkItem::CATEGORIES)
        ->map(fn ($label, $key) => ['key' => $key, 'label' => $label])->values()->all();

    $db = \App\Models\WorkItem::gallery();
    $feat = \App\Models\WorkItem::featured();

    if ($db || $feat) {
        $items = $db;
        $featured = $feat;
    }
@endphp

<section
    {{ $attributes->class('my-10') }}
    aria-labelledby="work-heading"
    x-data="{
        items: @js($items),
        cats: @js($categories),
        filter: 'all',
        open: false,
        idx: 0,
        get list() { return this.filter === 'all' ? this.items : this.items.filter(i => i.category === this.filter); },
        get cur() { return this.list[this.idx] || null; },
        count(k) { return k === 'all' ? this.items.length : this.items.filter(i => i.category === k).length; },
        label(k) { const c = this.cats.find(c => c.key === k); return c ? c.label : ''; },
        show(i) { this.idx = i; this.open = true; },
        close() { this.open = false; },
        next() { if (this.list.length) this.idx = (this.idx + 1) % this.list.length; },
        prev() { if (this.list.length) this.idx = (this.idx - 1 + this.list.length) % this.list.length; },
        isFile(u) { return /\.(mp4|webm|ogg)(\?.*)?$/i.test(u || ''); },
        embed(u) {
            const m = (u || '').match(/(?:youtu\.be\/|v=|embed\/)([A-Za-z0-9_-]{6,})/);
            return m ? 'https://www.youtube.com/embed/' + m[1] + '?autoplay=1&amp;rel=0' : u;
        }
    }"
    x-effect="document.body.classList.toggle('overflow-hidden', open)"
    @keydown.window="if (open) { if ($event.key === 'Escape') close(); if ($event.key === 'ArrowRight') next(); if ($event.key === 'ArrowLeft') prev(); }"
>

    {{-- Heading --}}
    <div class="mx-auto max-w-2xl text-center">
        <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
            <span class="size-1.5 rounded-full bg-amber-500"></span>
            {{ $eyebrow }}
        </p>
        <h2 id="work-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
            {{ $title }}
        </h2>
        @if ($subtitle)
            <p class="mt-3 text-base leading-relaxed text-slate-600">{{ $subtitle }}</p>
        @endif
    </div>

    {{-- FEATURED VIDEO --}}
    @if (! empty($featured))
        <div
            class="relative mx-auto mt-10 max-w-5xl overflow-hidden rounded-3xl bg-blue-950 shadow-xl"
            x-data="{ play: false }"
        >
            <div class="relative aspect-video">
                @if (! empty($featured['video']))
                    {{-- poster + play button --}}
                    <button
                        type="button"
                        x-show="!play"
                        @click="play = true"
                        class="group absolute inset-0 flex items-center justify-center focus:outline-none focus-visible:ring-4 focus-visible:ring-amber-400"
                        aria-label="Play video: {{ $featured['title'] ?? 'featured video' }}"
                    >
                        @if (! empty($featured['poster']))
                            <img src="{{ $featured['poster'] }}" alt="" class="absolute inset-0 size-full object-cover transition duration-500 group-hover:scale-105">
                            <span class="absolute inset-0 bg-gradient-to-t from-blue-950/90 via-blue-950/20 to-transparent"></span>
                        @else
                            <span class="absolute inset-0 bg-gradient-to-br from-blue-900 to-blue-950"></span>
                        @endif
                        <span class="relative flex size-20 items-center justify-center rounded-full bg-amber-400 text-blue-950 shadow-xl shadow-amber-400/30 transition duration-300 group-hover:scale-110 sm:size-24">
                            <svg class="ml-1 size-9 sm:size-10" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5.14v13.72a1 1 0 0 0 1.5.86l11.04-6.86a1 1 0 0 0 0-1.72L9.5 4.28A1 1 0 0 0 8 5.14Z" /></svg>
                        </span>
                    </button>

                    <template x-if="play">
                        <div class="absolute inset-0">
                            @php
                                $fv = $featured['video'];
                                $isFile = preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $fv);
                                $fe = $fv;
                                if (! $isFile && preg_match('/(?:youtu\.be\/|v=|embed\/)([A-Za-z0-9_-]{6,})/', $fv, $m)) {
                                    $fe = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=1&rel=0';
                                }
                            @endphp
                            @if ($isFile)
                                <video src="{{ $fv }}" class="size-full bg-black" controls autoplay playsinline></video>
                            @else
                                <iframe src="{{ $fe }}" class="size-full" title="{{ $featured['title'] ?? 'Video' }}" allow="autoplay; encrypted-media; picture-in-picture; fullscreen" allowfullscreen></iframe>
                            @endif
                        </div>
                    </template>
                @else
                    {{-- placeholder until a video link is added --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-blue-950"></div>
                    <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;" aria-hidden="true"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 text-center">
                        <span class="flex size-20 items-center justify-center rounded-full bg-amber-400 text-blue-950 sm:size-24">
                            <svg class="ml-1 size-9 sm:size-10" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5.14v13.72a1 1 0 0 0 1.5.86l11.04-6.86a1 1 0 0 0 0-1.72L9.5 4.28A1 1 0 0 0 8 5.14Z" /></svg>
                        </span>
                        <p class="text-sm font-semibold text-white/60">Add your featured video link here</p>
                    </div>
                @endif
            </div>

            {{-- caption --}}
            <div class="relative flex flex-col gap-1 border-t-4 border-amber-400 bg-blue-950 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:gap-6">
                <div>
                    <p class="font-montserrat text-lg font-extrabold text-white">{{ $featured['title'] ?? '' }}</p>
                    @if (! empty($featured['caption']))
                        <p class="mt-0.5 text-sm text-white/65">{{ $featured['caption'] }}</p>
                    @endif
                </div>
                <span class="inline-flex w-fit items-center gap-2 rounded-full bg-amber-400/15 px-3 py-1 text-xs font-bold uppercase tracking-wider text-amber-300">
                    <span class="size-1.5 rounded-full bg-amber-400"></span> Featured video
                </span>
            </div>
        </div>
    @endif

    {{-- FILTER TABS --}}
    <div class="mt-12 flex flex-wrap justify-center gap-2" role="tablist" aria-label="Filter photos and videos">
        <button
            type="button"
            role="tab"
            @click="filter = 'all'"
            :aria-selected="filter === 'all'"
            :class="filter === 'all' ? 'bg-blue-950 text-white shadow-md' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:text-blue-950 hover:ring-amber-300'"
            class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 font-montserrat text-sm font-bold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400"
        >
            {{ $allLabel }}
            <span class="rounded-full bg-amber-400 px-2 py-0.5 text-[11px] font-extrabold text-blue-950" x-text="count('all')"></span>
        </button>

        <template x-for="c in cats" :key="c.key">
            <button
                type="button"
                role="tab"
                @click="filter = c.key"
                :aria-selected="filter === c.key"
                :class="filter === c.key ? 'bg-blue-950 text-white shadow-md' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:text-blue-950 hover:ring-amber-300'"
                class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 font-montserrat text-sm font-bold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400"
            >
                <span x-text="c.label"></span>
                <span class="rounded-full bg-amber-400 px-2 py-0.5 text-[11px] font-extrabold text-blue-950" x-text="count(c.key)"></span>
            </button>
        </template>
    </div>

    {{-- GRID --}}
    <ul class="mx-auto mt-8 grid max-w-7xl grid-cols-2 gap-3 sm:gap-5 lg:grid-cols-3 xl:grid-cols-4">
        <template x-for="(it, n) in list" :key="it.category + '-' + n + '-' + (it.caption || '')">
            <li>
                <button
                    type="button"
                    @click="show(n)"
                    class="group relative block aspect-[4/3] w-full overflow-hidden rounded-2xl bg-blue-950 shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-amber-300 focus:outline-none focus-visible:ring-4 focus-visible:ring-amber-400"
                    :aria-label="'Open: ' + (it.caption || 'photo')"
                >
                    {{-- photo / thumbnail --}}
                    <template x-if="it.src">
                        <img :src="it.src" :alt="it.caption || ''" loading="lazy" class="absolute inset-0 size-full object-cover transition duration-500 group-hover:scale-110">
                    </template>

                    {{-- placeholder --}}
                    <template x-if="!it.src">
                        <span class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-900 to-blue-950">
                            <svg class="size-12 text-amber-400/70" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $box }}" /></svg>
                        </span>
                    </template>

                    {{-- shade --}}
                    <span class="absolute inset-0 bg-gradient-to-t from-blue-950/85 via-transparent to-transparent opacity-80 transition group-hover:opacity-100"></span>

                    {{-- category chip --}}
                    <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wide text-blue-950 backdrop-blur" x-text="label(it.category)"></span>

                    {{-- play badge --}}
                    <template x-if="it.type === 'video'">
                        <span class="absolute inset-0 flex items-center justify-center">
                            <span class="flex size-14 items-center justify-center rounded-full bg-amber-400 text-blue-950 shadow-lg transition duration-300 group-hover:scale-110">
                                <svg class="ml-0.5 size-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5.14v13.72a1 1 0 0 0 1.5.86l11.04-6.86a1 1 0 0 0 0-1.72L9.5 4.28A1 1 0 0 0 8 5.14Z" /></svg>
                            </span>
                        </span>
                    </template>

                    {{-- caption slides up on hover --}}
                    <span class="absolute inset-x-0 bottom-0 translate-y-1 border-t-2 border-amber-400 bg-blue-950/90 px-3 py-2.5 text-left backdrop-blur transition duration-300 group-hover:translate-y-0">
                        <span class="block truncate font-montserrat text-sm font-bold text-white" x-text="it.caption"></span>
                        <span class="block truncate text-xs text-white/60" x-text="it.meta"></span>
                    </span>
                </button>
            </li>
        </template>
    </ul>

    {{-- empty state --}}
    <p x-show="list.length === 0" x-cloak class="mt-10 text-center text-slate-500">Nothing here yet. Check back soon!</p>

    {{-- PROMISE STRIP --}}
    @if (! empty($promise))
        <div class="relative mx-auto mt-14 max-w-7xl overflow-hidden rounded-3xl bg-blue-950 px-6 py-10 sm:px-10">
            <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -right-20 -top-20 size-72 rounded-full bg-amber-400/20 blur-3xl" aria-hidden="true"></div>

            <ul class="relative grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($promise as $p)
                    <li class="flex items-start gap-4">
                        <span class="flex size-12 shrink-0 items-center justify-center rounded-full border-2 border-amber-400 text-amber-400">
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="2.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m4.5 12.75 6 6 9-13.5" /></svg>
                        </span>
                        <div>
                            <h3 class="font-montserrat text-lg font-extrabold text-white">{{ $p['title'] }}</h3>
                            <p class="mt-1 text-sm leading-relaxed text-white/70">{{ $p['text'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- LIGHTBOX --}}
    <div
        x-show="open"
        x-cloak
        x-transition.opacity.duration.200ms
        class="fixed inset-0 z-[100] flex flex-col bg-blue-950/95 backdrop-blur-sm"
        role="dialog"
        aria-modal="true"
        aria-label="Photo and video viewer"
        @click.self="close()"
    >
        {{-- top bar --}}
        <div class="flex items-center justify-between px-4 py-3 sm:px-6" @click.self="close()">
            <p class="font-montserrat text-sm font-bold text-white/70">
                <span x-text="idx + 1"></span> / <span x-text="list.length"></span>
            </p>
            <button type="button" @click="close()" aria-label="Close viewer"
                class="flex size-11 items-center justify-center rounded-full border border-white/20 text-white transition hover:border-amber-400 hover:bg-amber-400 hover:text-blue-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- stage --}}
        <div class="relative flex min-h-0 flex-1 items-center justify-center px-4 sm:px-20" @click.self="close()">

            <button type="button" @click="prev()" aria-label="Previous"
                class="absolute left-2 z-10 flex size-12 items-center justify-center rounded-full border border-white/20 bg-blue-950/60 text-white transition hover:border-amber-400 hover:bg-amber-400 hover:text-blue-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 sm:left-6">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
            </button>

            <div class="flex max-h-full w-full max-w-5xl items-center justify-center">
                {{-- video --}}
                <template x-if="cur && cur.type === 'video' && cur.video">
                    <div class="aspect-video w-full overflow-hidden rounded-2xl bg-black shadow-2xl">
                        <template x-if="isFile(cur.video)">
                            <video :src="cur.video" class="size-full" controls autoplay playsinline></video>
                        </template>
                        <template x-if="!isFile(cur.video)">
                            <iframe :src="embed(cur.video)" class="size-full" :title="cur.caption || 'Video'" allow="autoplay; encrypted-media; picture-in-picture; fullscreen" allowfullscreen></iframe>
                        </template>
                    </div>
                </template>

                {{-- photo (or video thumbnail when no link yet) --}}
                <template x-if="cur && cur.src && !(cur.type === 'video' && cur.video)">
                    <img :src="cur.src" :alt="cur.caption || ''" class="max-h-[70vh] w-auto max-w-full rounded-2xl object-contain shadow-2xl">
                </template>

                {{-- placeholder --}}
                <template x-if="cur && !cur.src && !(cur.type === 'video' && cur.video)">
                    <div class="flex aspect-[4/3] w-full max-w-3xl flex-col items-center justify-center gap-3 rounded-2xl bg-gradient-to-br from-blue-900 to-blue-950 text-center ring-1 ring-white/10">
                        <svg class="size-16 text-amber-400/70" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $box }}" /></svg>
                        <p class="text-sm font-semibold text-white/60">Add your photo or video here</p>
                    </div>
                </template>
            </div>

            <button type="button" @click="next()" aria-label="Next"
                class="absolute right-2 z-10 flex size-12 items-center justify-center rounded-full border border-white/20 bg-blue-950/60 text-white transition hover:border-amber-400 hover:bg-amber-400 hover:text-blue-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 sm:right-6">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
            </button>
        </div>

        {{-- caption --}}
        <div class="px-4 py-5 text-center sm:px-6" @click.self="close()">
            <p class="font-montserrat text-lg font-extrabold text-white" x-text="cur ? cur.caption : ''"></p>
            <p class="mt-1 text-sm text-amber-300" x-text="cur ? cur.meta : ''"></p>
        </div>
    </div>
</section>
</div>
