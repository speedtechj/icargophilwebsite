@php
    $rates = class_exists(\App\Models\DeliveryRate::class) ? \App\Models\DeliveryRate::forSite() : [];
@endphp

<div class="pointer-events-none fixed inset-y-0 left-0 z-0 hidden w-[calc(100%-36rem)] flex-col justify-between p-12 lg:flex" aria-hidden="true">
    <img src="{{ asset('storage/logo/icargologo-dark.png') }}" alt="iCargo" class="h-16 w-auto self-start">

    <div class="relative flex items-center justify-center">
        <div class="absolute size-[30rem] rounded-full border border-white/10"></div>
        <div class="absolute size-[40rem] rounded-full border border-dashed border-amber-400/20"></div>

        <img src="{{ asset('images/login-map.svg') }}" alt="" class="relative h-[34rem] w-auto" style="filter: drop-shadow(0 0 22px rgba(251,191,36,.35))">

        @if (! empty($rates))
            @foreach ([
                'luzon'    => ['Luzon',    'left-2 top-10'],
                'visayas'  => ['Visayas',  'right-0 top-[45%]'],
                'mindanao' => ['Mindanao', 'bottom-6 left-10'],
            ] as $key => [$label, $position])
                @isset($rates[$key])
                    <div class="absolute {{ $position }} rounded-2xl border border-white/15 bg-white/10 px-4 py-3 backdrop-blur-xl">
                        <p class="text-[10px] font-bold uppercase tracking-[.25em] text-amber-300">{{ $label }}</p>
                        <p class="font-mono text-lg font-bold text-white">{{ $rates[$key]['eta'] }}</p>
                    </div>
                @endisset
            @endforeach
        @endif
    </div>

    <div>
        <p class="text-xs font-bold uppercase tracking-[.35em] text-amber-400">Control center</p>
        <h1 class="mt-3 max-w-md text-4xl font-extrabold leading-tight text-white">
            Every box, <span class="text-amber-400">every island</span>, one dashboard.
        </h1>
    </div>
</div>
