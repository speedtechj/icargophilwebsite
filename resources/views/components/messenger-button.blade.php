<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Maria Skłodowska-Curie -->
    @props([
    'url' => null,
    'position' => 'left',   // left | right
    'label' => 'Chat with us on Messenger',
])

@php
    $url = $url ?: \App\Models\SiteSetting::current()->messenger_url;

    // allow just the page name, for example "iCargoXpress", as well as a full link
    if ($url && ! \Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) {
        $url = 'https://m.me/' . ltrim($url, '/@');
    }
@endphp

@if ($url)
    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $label }}"
       {{ $attributes->class([
            'group fixed bottom-5 z-40 flex items-center gap-3',
            $position === 'right' ? 'right-5 flex-row-reverse' : 'left-5',
       ]) }}>

        <span class="relative grid size-14 place-items-center rounded-full bg-gradient-to-br from-blue-900 to-blue-950 text-amber-400 shadow-xl shadow-blue-950/40 ring-2 ring-amber-400 transition group-hover:scale-105">
            <span class="absolute inset-0 animate-ping rounded-full bg-amber-400/25" aria-hidden="true"></span>
            <svg class="relative size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
            </svg>
        </span>

        <span class="hidden rounded-full bg-white px-4 py-2 font-montserrat text-sm font-bold text-blue-950 shadow-lg ring-1 ring-slate-200 sm:block">
            Message us
        </span>
    </a>
@endif
</div>
