<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('storage/favicon/favicon.ico') }}?v=2" sizes="any">
    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-slate-50">
       <x-loader2 />
      {{-- <x-messenger-button url="https://www.messenger.com/t/61569773083238/" /> --}}
    {{-- One sticky element only (the old header + nav were both sticky) --}}
    <header
        x-data="{ open: false }"
        @keydown.escape.window="open = false"
        @click.outside="open = false"
        class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/80 backdrop-blur-md supports-[backdrop-filter]:bg-white/70"
    >
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8" aria-label="Main">

            {{-- Logo --}}
            <a href="{{ url('/') }}" wire:navigate class="shrink-0 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400">
                <img src="{{ asset('storage/logo/icargologo.png') }}" alt="iCargo Logo" class="w-40 sm:w-48">
            </a>

            {{-- Desktop links --}}
            <ul class="hidden items-center gap-1 rounded-full border border-slate-200 bg-white/70 p-1 font-montserrat text-sm font-semibold text-slate-600 md:flex">
                <li>
                    <a href="{{ route('home') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white"
                       class="block rounded-full px-4 py-2 transition hover:bg-slate-100 hover:text-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400">Home</a>
                </li>
                <li>
                    <a href="{{ route('services') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white"
                       class="block rounded-full px-4 py-2 transition hover:bg-slate-100 hover:text-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400">Services</a>
                </li>
                <li>
                    <a href="{{ route('partner') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white"
                       class="block rounded-full px-4 py-2 transition hover:bg-slate-100 hover:text-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400">Partners</a>
                </li>
                <li>
                    <a href="{{ route('ourwork') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white"
                       class="block rounded-full px-4 py-2 transition hover:bg-slate-100 hover:text-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400">Our Work</a>
                </li>
                <li>
                    <a href="{{ route('about') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white"
                       class="block rounded-full px-4 py-2 transition hover:bg-slate-100 hover:text-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400">About Us</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white"
                       class="block rounded-full px-4 py-2 transition hover:bg-slate-100 hover:text-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400">Contact Us</a>
                </li>
            </ul>


            {{-- Hamburger button (mobile only) --}}
            <button
                type="button"
                @click="open = !open"
                :aria-expanded="open"
                aria-controls="mobile-menu"
                aria-label="Toggle menu"
                class="inline-flex size-10 items-center justify-center rounded-full border border-slate-200 bg-white text-blue-900 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 md:hidden"
            >
                <svg x-show="!open" class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-show="open" x-cloak class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </nav>

        {{-- Mobile menu --}}
        <div
            id="mobile-menu"
            x-show="open"
            x-cloak
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="px-4 pb-4 md:hidden"
        >
            <ul class="space-y-1 rounded-2xl border border-slate-200 bg-white p-2 font-montserrat text-base font-semibold text-slate-700 shadow-lg">
                <li>
                    <a href="{{ route('home') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white" @click="open = false"
                       class="block rounded-xl px-4 py-3 transition hover:bg-slate-100 hover:text-blue-900">Home</a>
                </li>
                <li>
                    <a href="{{ route('services') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white" @click="open = false"
                       class="block rounded-xl px-4 py-3 transition hover:bg-slate-100 hover:text-blue-900">Services</a>
                </li>
                <li>
                    <a href="{{ route('partner') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white" @click="open = false"
                       class="block rounded-xl px-4 py-3 transition hover:bg-slate-100 hover:text-blue-900">Partners</a>
                </li>
                <li>
                    <a href="{{ route('ourwork') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white" @click="open = false"
                       class="block rounded-xl px-4 py-3 transition hover:bg-slate-100 hover:text-blue-900">Our Work</a>
                </li>
                <li>
                    <a href="{{ route('about') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white" @click="open = false"
                       class="block rounded-xl px-4 py-3 transition hover:bg-slate-100 hover:text-blue-900">About Us</a>
                </li>

                <li>
                    <a href="{{ route('contact') }}" wire:navigate wire:current.exact="!bg-blue-900 !text-white" @click="open = false"
                       class="block rounded-xl px-4 py-3 transition hover:bg-slate-100 hover:text-blue-900">Contact Us</a>
                </li>

            </ul>
        </div>
    </header>

    <main class="px-5 py-4">
        {{ $slot }}
    </main>
    <x-footer />
    @livewireScripts
</body>

</html>
