<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen px-5 py-4 bg-slate-50">
        <header>
            <nav x-data="{ open: false }" @keydown.escape.window="open = false" @click.outside="open = false"
                class="relative bg-white after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-2 py-3 sm:px-6 lg:px-8">

                    <a href="{{ url('/') }}">
                        <img src="{{ asset('storage/logo/icargologo.png') }}" alt="iCargo Logo" class="w-32">
                    </a>

                    {{-- Desktop links --}}
                    <ul
                        class="hidden items-center gap-6 font-montserrat text-lg font-bold uppercase text-blue-900 md:flex">
                        <li><a href="#" class="transition hover:text-amber-500 border-amber-400">Home</a></li>
                        <li><a href="#" class="transition hover:text-amber-500 border-amber-400">Services</a></li>
                        <li><a href="#" class="transition hover:text-amber-500 border-amber-400">Contact</a></li>
                        <li><a href="#" class="transition hover:text-amber-500 border-amber-400">About</a></li>
                    </ul>

                    {{-- Hamburger button (mobile only) --}}
                    <button type="button" @click="open = !open" :aria-expanded="open" aria-controls="mobile-menu"
                        aria-label="Toggle menu"
                        class="inline-flex items-center justify-center rounded-md p-2 text-blue-900 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-amber-400 md:hidden">
                        <svg x-show="!open" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg x-show="open" x-cloak class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Mobile menu --}}
                <div id="mobile-menu" x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden">
                    <ul class="space-y-1 px-4 pb-4 pt-2 font-montserrat text-lg font-bold uppercase text-blue-900">
                        <li><a href="#" @click="open = false"
                                class="block rounded-md px-3 py-2 hover:bg-blue-50 hover:text-amber-500">Home</a></li>
                        <li><a href="#" @click="open = false"
                                class="block rounded-md px-3 py-2 hover:bg-blue-50 hover:text-amber-500">Services</a>
                        </li>
                        <li><a href="#" @click="open = false"
                                class="block rounded-md px-3 py-2 hover:bg-blue-50 hover:text-amber-500">Contact</a>
                        </li>
                        <li><a href="#" @click="open = false"
                                class="block rounded-md px-3 py-2 hover:bg-blue-50 hover:text-amber-500">About</a></li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>
</body>

</html>
