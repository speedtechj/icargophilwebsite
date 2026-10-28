<div>
   @props([
    'slides' => [],
    'autoplay' => false,   // false, or interval in ms, e.g. 5000
    'height' => 'h-64 sm:h-96 lg:h-[32rem]',
])

@php
    $id = 'slider-' . \Illuminate\Support\Str::random(6);
@endphp

@if (count($slides))
<div
    x-data="{
        current: 0,
        total: {{ count($slides) }},
        paused: false,
        next() { this.current = (this.current + 1) % this.total },
        prev() { this.current = (this.current - 1 + this.total) % this.total },
        go(i) { this.current = i },
    }"
    @if ($autoplay)
        x-init="setInterval(() => { if (!paused) next() }, {{ (int) $autoplay }})"
        @mouseenter="paused = true"
        @mouseleave="paused = false"
    @endif
    @keydown.right="next()"
    @keydown.left="prev()"
    tabindex="0"
    role="region"
    aria-roledescription="carousel"
    aria-label="Slider"
    {{ $attributes->class('relative overflow-hidden rounded-xl shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400') }}
>
    {{-- Track --}}
    <div
        class="flex transition-transform duration-500 ease-in-out"
        :style="`transform: translateX(-${current * 100}%)`"
    >
        @foreach ($slides as $slide)
            <div class="relative {{ $height }} w-full shrink-0">
                <img
                    src="{{ $slide['image'] }}"
                    alt="{{ $slide['title'] ?? '' }}"
                    class="h-full w-full object-cover"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-blue-950/50 via-transparent to-transparent"></div>

               <div class="absolute bottom-0 left-0 max-w-full p-6 pb-12 pl-16 pr-16 text-white sm:p-10 sm:pb-14 sm:pl-24 sm:pr-24">
                    @isset($slide['title'])
                        <h2 class="font-montserrat text-2xl font-bold uppercase sm:text-4xl">{{ $slide['title'] }}</h2>
                    @endisset

                    @isset($slide['text'])
                        <p class="mt-2 max-w-md text-sm sm:text-lg">{{ $slide['text'] }}</p>
                    @endisset

                    @isset($slide['link'])
                        <a href="{{ $slide['link'] }}" wire:navigate
                           class="mt-4 inline-block rounded-md bg-amber-400 px-5 py-2 font-bold uppercase text-blue-900 transition hover:bg-amber-300">
                            {{ $slide['button'] ?? 'Learn more' }}
                        </a>
                    @endisset
                </div>
            </div>
        @endforeach
    </div>

    {{-- Previous --}}
    <button type="button" @click="prev()" aria-label="Previous slide"
        class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/80 p-2 text-blue-900 shadow transition hover:bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
    </button>

    {{-- Next --}}
    <button type="button" @click="next()" aria-label="Next slide"
        class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/80 p-2 text-blue-900 shadow transition hover:bg-white focus:outline-none focus:ring-2 focus:ring-amber-400">
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-2">
        @foreach ($slides as $i => $slide)
            <button type="button" @click="go({{ $i }})"
                :class="current === {{ $i }} ? 'w-6 bg-amber-400' : 'w-2.5 bg-white/70 hover:bg-white'"
                class="h-2.5 rounded-full transition-all duration-300"
                aria-label="Go to slide {{ $i + 1 }}"></button>
        @endforeach
    </div>
</div>
@endif
</div>
