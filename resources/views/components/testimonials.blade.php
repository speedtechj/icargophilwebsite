<div>
    <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
    {{--
    resources/views/components/testimonials-slider.blade.php

    Usage:
        <x-testimonials-slider />

    Custom testimonials:
        <x-testimonials-slider :items="[
            ['name' => 'Maria Santos', 'detail' => 'Balikbayan box · Cebu', 'quote' => '...', 'rating' => 5],
            ['name' => 'John Reyes',   'detail' => 'Cargo · Davao',         'quote' => '...', 'photo' => asset('storage/customers/john.jpg')],
        ]" />

    'rating' (1-5) and 'photo' are optional. Without a photo, the initials are shown.

    Needs Alpine.js (already in Livewire 3) and Tailwind. No slider library required.

    IMPORTANT: the default testimonials are SAMPLE TEXT. Replace them with real customer
    reviews (with permission) before going live.
--}}
@props([
    'eyebrow' => 'Testimonials',
    'title' => 'What our customers say',
    'subtitle' => 'Families trust us with their gifts, their belongings and their love. Here is what they tell us.',
    'items' => [
        ['name' => 'Maria Santos',    'detail' => 'Balikbayan box · Cebu',        'rating' => 5, 'quote' => 'Everything arrived complete and well packed. My family was so happy opening the box, and I had peace of mind the whole time.'],
        ['name' => 'John Reyes',      'detail' => 'Cargo · Davao',                'rating' => 5, 'quote' => 'Fair price and friendly staff. They answered all my questions about what I could put in the box and how to pack it.'],
        ['name' => 'Liza Mendoza',    'detail' => 'Balikbayan box · Iloilo',      'rating' => 5, 'quote' => 'This is my third time using iCargo and I have never had a problem. My parents received everything in perfect condition.'],
        ['name' => 'Ramon Cruz',      'detail' => 'Balikbayan box · Pampanga',    'rating' => 5, 'quote' => 'They handle my boxes like they are their own. I trust them with my family\'s gifts every Christmas.'],
        ['name' => 'Angelica Dizon',  'detail' => 'Cargo · Quezon City',          'rating' => 5, 'quote' => 'Smooth and stress-free from start to finish. It is such a relief to know my things are in good hands.'],
        ['name' => 'Carlo Bautista',  'detail' => 'Balikbayan box · Bohol',       'rating' => 5, 'quote' => 'Delivery was right to my mother\'s door and she was thrilled. I will keep using them for every shipment.'],
    ],
])
@php
    $items = \App\Models\Testimonial::forSite() ?: $items;
@endphp
<section
    {{ $attributes->class('my-10 overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-10') }}
    aria-roledescription="carousel"
    aria-labelledby="testimonials-heading"
    @mouseenter="stop()"
    @mouseleave="play()"
    @focusin="stop()"
    @focusout="play()"
    x-data="{
        idx: 0,
        pages: 1,
        step: 0,
        timer: null,
        init() {
            this.measure();
            this.play();
            window.addEventListener('resize', () => this.measure());
        },
        measure() {
            const t = this.$refs.track;
            const first = t.firstElementChild;
            if (!first || first.offsetWidth === 0) return;
            this.step = first.offsetWidth + 24;
            const per = Math.max(1, Math.round((t.clientWidth + 24) / this.step));
            this.pages = Math.max(1, t.children.length - per + 1);
            this.idx = Math.min(this.idx, this.pages - 1);
        },
        go(i) {
            if (!this.step) return;
            this.idx = Math.max(0, Math.min(i, this.pages - 1));
            this.$refs.track.scrollTo({ left: this.idx * this.step, behavior: 'smooth' });
        },
        onScroll() {
            if (!this.step) return;
            this.idx = Math.min(this.pages - 1, Math.round(this.$refs.track.scrollLeft / this.step));
        },
        next() { this.go(this.idx >= this.pages - 1 ? 0 : this.idx + 1); },
        prev() { this.go(this.idx <= 0 ? this.pages - 1 : this.idx - 1); },
        play() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            this.stop();
            this.timer = setInterval(() => this.next(), 6000);
        },
        stop() { clearInterval(this.timer); },
        destroy() { this.stop(); }
    }"
>
    {{-- Header --}}
    <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div class="max-w-2xl">
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
                <span class="size-1.5 rounded-full bg-amber-500"></span>
                {{ $eyebrow }}
            </p>
            <h2 id="testimonials-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
                {{ $title }}
            </h2>
            @if ($subtitle)
                <p class="mt-3 text-base leading-relaxed text-slate-600">{{ $subtitle }}</p>
            @endif
        </div>

        {{-- Arrows --}}
        <div class="flex shrink-0 gap-2">
            <button
                type="button"
                @click="prev()"
                aria-label="Previous testimonials"
                class="inline-flex size-11 items-center justify-center rounded-full border border-slate-200 bg-white text-blue-950 transition hover:border-amber-400 hover:bg-amber-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400"
            >
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>
            <button
                type="button"
                @click="next()"
                aria-label="Next testimonials"
                class="inline-flex size-11 items-center justify-center rounded-full border border-slate-200 bg-white text-blue-950 transition hover:border-amber-400 hover:bg-amber-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400"
            >
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Slider track (native scroll-snap: swipe on touch, buttons and dots on desktop) --}}
    <div
        x-ref="track"
        @scroll.debounce.60ms="onScroll()"
        class="-mx-1 mt-8 flex snap-x snap-mandatory gap-6 overflow-x-auto scroll-smooth px-1 pb-4 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
        tabindex="0"
        aria-live="off"
    >
        @foreach ($items as $item)
            @php
                $initials = collect(preg_split('/\s+/', trim($item['name'])))
                    ->filter()
                    ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
                    ->take(2)
                    ->implode('');
                $rating = max(0, min(5, (int) ($item['rating'] ?? 5)));
            @endphp

            <figure
                class="group relative flex shrink-0 basis-full snap-start flex-col rounded-2xl border border-slate-200 bg-slate-50 p-6 transition hover:-translate-y-1 hover:border-amber-300 hover:bg-white hover:shadow-lg md:basis-[calc((100%_-_1.5rem)/2)] lg:basis-[calc((100%_-_3rem)/3)]"
                role="group"
                aria-roledescription="slide"
                aria-label="Testimonial {{ $loop->iteration }} of {{ count($items) }}"
            >
                {{-- Quote mark --}}
                <svg class="size-10 text-amber-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M9.5 6C6.5 7 4.5 9.5 4.5 13v5h6v-6h-3c0-2 1-3 3-3.7L9.5 6Zm9 0c-3 1-5 3.5-5 7v5h6v-6h-3c0-2 1-3 3-3.7L18.5 6Z" />
                </svg>

                {{-- Stars --}}
                <div class="mt-3 flex gap-0.5" role="img" aria-label="{{ $rating }} out of 5 stars">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="size-5 {{ $i <= $rating ? 'text-amber-400' : 'text-slate-300' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                        </svg>
                    @endfor
                </div>

                <blockquote class="mt-4 text-base leading-relaxed text-slate-700">
                    "{{ $item['quote'] }}"
                </blockquote>

                <figcaption class="mt-auto flex items-center gap-3 border-t border-slate-200 pt-5">
                    @if (! empty($item['photo']))
                        <img src="{{ $item['photo'] }}" alt="{{ $item['name'] }}" class="size-12 shrink-0 rounded-full object-cover ring-2 ring-amber-400" loading="lazy">
                    @else
                        <span class="flex size-12 shrink-0 items-center justify-center rounded-full bg-blue-950 font-montserrat text-sm font-bold text-amber-300 ring-2 ring-amber-400">
                            {{ $initials }}
                        </span>
                    @endif

                    <span class="min-w-0">
                        <span class="block truncate font-montserrat text-sm font-bold text-blue-950">{{ $item['name'] }}</span>
                        @if (! empty($item['detail']))
                            <span class="block truncate text-sm text-slate-500">{{ $item['detail'] }}</span>
                        @endif
                    </span>
                </figcaption>
            </figure>
        @endforeach
    </div>

    {{-- Dots --}}
    <div class="mt-4 flex items-center justify-center gap-2" x-show="pages > 1" role="tablist" aria-label="Choose testimonial">
        <template x-for="i in pages" :key="i">
            <button
                type="button"
                @click="go(i - 1)"
                :aria-label="'Go to testimonial ' + i"
                :aria-selected="idx === i - 1"
                :class="idx === i - 1 ? 'w-8 bg-amber-400' : 'w-2.5 bg-slate-300 hover:bg-slate-400'"
                class="h-2.5 rounded-full transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2"
            ></button>
        </template>
    </div>
</section>
</div>
