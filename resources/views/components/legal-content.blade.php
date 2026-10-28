<div>
    @props(['slug'])

@php
    $page = \App\Models\LegalPage::where('slug', $slug)->where('is_published', true)->first();
@endphp

<section {{ $attributes->class('mx-auto max-w-3xl px-6 py-16 sm:py-20') }}>
    @if ($page)
        <h1 class="font-montserrat text-4xl font-extrabold text-blue-950">{{ $page->title }}</h1>
        <p class="mt-2 text-sm text-slate-500">Last updated {{ $page->updated_at->format('F j, Y') }}</p>

        <div class="prose prose-slate mt-8 max-w-none">
            {!! $page->content !!}
        </div>
    @else
        <p class="text-center text-slate-500">This page is not available yet.</p>
    @endif
</section>
</div>
