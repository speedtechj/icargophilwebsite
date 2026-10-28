<div>
    <!-- Order your soul. Reduce your wants. - Augustine -->
    {{--
    resources/views/components/partner-faq.blade.php

    Usage:
        <x-partner-faq />

    Show your accreditation (only if it is true and current):
        <x-partner-faq accreditation="DTI-accredited freight forwarder / deconsolidator, No. 000000" />

    Your own questions (cat: ports | handling | damages | invoicing | customs):
        <x-partner-faq :items="[
            ['cat' => 'ports', 'q' => 'Which ports do you use?', 'a' => 'Your real answer.'],
        ]" />

    Optional props: eyebrow, title, subtitle, contactUrl.
    Needs Alpine.js (already in Livewire) and Tailwind. Only one answer is open at a time.

    WHERE THE CUSTOMS ANSWERS COME FROM
    The "Customs & inspections" answers and the "Customs at a glance" card follow the Bureau of Customs
    page "BOC Guidelines on Balikbayan Boxes" (customs.gov.ph/boc-guidelines-on-balikbayan-boxes-2/):
    PHP 150,000 value limit, personal and household effects only, privilege up to 3 times a calendar year,
    documents (information sheet, passport photocopy, invoice or receipt if any), and the advice to use
    DTI-accredited freight forwarders or deconsolidators.
    Customs rules change. Before going live, re-read the BOC page and update these answers if needed.

    EVERYTHING ELSE (ports, handling times, damages, invoicing) is a DRAFT written without your real
    policies. It makes no promises about times, prices or insurance. Edit each answer so it is true for
    iCargo, and delete any question you cannot answer yet.
--}}
@props([
    'eyebrow' => 'Partner FAQ',
    'title' => 'Answers for cargo companies',
    'subtitle' => 'Ports, handling times, damages, invoicing and Philippine customs, explained in plain language.',
    'accreditation' => null,
    'contactUrl' => '#partner',
    'items' => [

        // ---------------- Ports ----------------
        [
            'cat' => 'ports',
            'q' => 'Which ports can you receive containers at?',
            'a' => 'Tell us which Philippine port your container is booked to arrive at, and we will confirm that we can receive and clear it there. Please share the port with us before you book your vessel.',
        ],
        [
            'cat' => 'ports',
            'q' => 'Can you receive a container at a port outside Manila?',
            'a' => 'It depends on the port and your shipping line. Tell us your destination port and we will tell you whether we can receive it there, or whether it is better to land in a main port and truck the boxes onward.',
        ],
        [
            'cat' => 'ports',
            'q' => 'What do you need from us before the container arrives?',
            'a' => 'Send us your container and shipping documents and the list of boxes, with the receiver\'s name, address and contact number for each. For every sender, the Bureau of Customs also needs the information sheet and a copy of the passport photo page, plus an invoice or receipt if there is one. The earlier we have everything, the smoother the clearance.',
        ],

        // ---------------- Handling times ----------------
        [
            'cat' => 'handling',
            'q' => 'How long does it take from arrival to delivery?',
            'a' => 'We give you an estimate once we have your container details. The time depends on port processing, whether customs examines any boxes, and how far each box has to travel. We keep you updated as your boxes move.',
        ],
        [
            'cat' => 'handling',
            'q' => 'How do you sort and dispatch the boxes?',
            'a' => 'After the container is unloaded at our warehouse, boxes are counted against your list, sorted by destination and loaded by route and island group, so each truck goes where the boxes are going.',
        ],
        [
            'cat' => 'handling',
            'q' => 'Do boxes for Visayas and Mindanao take longer?',
            'a' => 'Usually yes, because they travel farther and may need inter-island transport. We confirm the expected time for each destination when you share your box list.',
        ],

        // ---------------- Damages & claims ----------------
        [
            'cat' => 'damages',
            'q' => 'What happens if a box is damaged or missing?',
            'a' => 'We check the container as it is unloaded and record any damage, with photos. If a box is damaged or cannot be found, we tell you right away and work with you on the next step. Please ask us for our full claims process.',
        ],
        [
            'cat' => 'damages',
            'q' => 'Are boxes covered by insurance?',
            'a' => 'Please ask us about coverage options before you ship. We will explain what is covered, what is not, and how a claim is made, so there are no surprises.',
        ],
        [
            'cat' => 'damages',
            'q' => 'What if a box was already damaged before it reached you?',
            'a' => 'We record the condition of every box when the container is opened. If a box arrives damaged or opened, we note it and photograph it, so you and your customer have a clear record of where the problem happened.',
        ],

        // ---------------- Invoicing ----------------
        [
            'cat' => 'invoicing',
            'q' => 'How and when do you invoice?',
            'a' => 'We agree the rates and payment terms with you before your first container. We send an itemized invoice that shows our handling and delivery services, so you can match it to your own records.',
        ],
        [
            'cat' => 'invoicing',
            'q' => 'Which charges are separate from your service rates?',
            'a' => 'Government charges are separate from our services. That includes any duties or taxes assessed by customs, and port or shipping-line fees. We show these clearly and never hide them inside another figure.',
        ],
        [
            'cat' => 'invoicing',
            'q' => 'How can we pay you from abroad?',
            'a' => 'We will go over the payment options when we set up your account. Tell us what works best for your company, and we will see how we can accommodate it.',
        ],

        // ---------------- Customs & inspections ----------------
        [
            'cat' => 'customs',
            'q' => 'Are balikbayan boxes duty-free?',
            'a' => 'They can be, if all three conditions are met: the box does not exceed PHP 150,000 in value, it contains personal and household effects only, and it is not in commercial quantities or meant for barter, sale or hire. If a box does not meet these conditions, the Bureau of Customs collects duties and taxes.',
        ],
        [
            'cat' => 'customs',
            'q' => 'How many boxes can one sender send duty-free?',
            'a' => 'The Bureau of Customs says the duty-free privilege may only be used up to three times in a calendar year. Please remind your customers so they plan their shipments with this in mind.',
        ],
        [
            'cat' => 'customs',
            'q' => 'Who is allowed to send a balikbayan box?',
            'a' => 'The Bureau of Customs says qualified Filipinos while abroad may send balikbayan boxes. This covers non-resident Filipinos, Overseas Filipino Workers and resident Filipinos.',
        ],
        [
            'cat' => 'customs',
            'q' => 'What documents does customs need for each box?',
            'a' => 'An information sheet, a photocopy of the sender\'s passport photo page, and an invoice or receipt if there is one. Your company collects these abroad and sends them to us, and we pass them on for customs processing.',
        ],
        [
            'cat' => 'customs',
            'q' => 'Will boxes be inspected by customs?',
            'a' => 'The Bureau of Customs decides which boxes are examined, and we cannot skip an inspection. What helps is complete documents, honest declarations of what is inside, and correct values. Wrong or missing declarations can cause delays and penalties.',
        ],
        [
            'cat' => 'customs',
            'q' => 'What can not go inside a box?',
            'a' => 'Prohibited goods, restricted goods that are not authorized by law, and regulated goods without the required permits cannot be sent. If your customer wants to send something unusual, they should check with the agency that regulates it first. When in doubt, ask us before the box is packed.',
        ],
    ],
])

@php
    $cats = [
        ['key' => 'ports',     'label' => 'Ports',                 'icon' => 'M3.5 13h8v5.5h-8ZM12.5 13h8v5.5h-8ZM8 6.5h8V12H8ZM2.5 21.5h19'],
        ['key' => 'handling',  'label' => 'Handling times',        'icon' => 'M12 7v5l3 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
        ['key' => 'damages',   'label' => 'Damages and claims',    'icon' => 'M12 4 3 20h18L12 4ZM12 10v4M12 17h.01'],
        ['key' => 'invoicing', 'label' => 'Invoicing',             'icon' => 'M7 3.5h10v17l-2.5-1.5-2.5 1.5-2.5-1.5L7 20.5v-17ZM10 8h4M10 12h4'],
        ['key' => 'customs',   'label' => 'Customs and inspections', 'icon' => 'M12 3 5 6v5.5c0 4.2 2.9 7.6 7 8.5 4.1-.9 7-4.3 7-8.5V6l-7-3ZM9 12l2 2 4-4'],
    ];
    $counts = collect($items)->countBy('cat');
    $first  = $cats[0]['key'];
@endphp

<section
    {{ $attributes->class('my-10 rounded-3xl border border-slate-200 bg-white px-5 py-10 shadow-sm sm:px-10 sm:py-14') }}
    x-data="{ cat: '{{ $first }}', open: null }"
    aria-labelledby="partner-faq-heading"
>
    <div class="grid gap-10 lg:grid-cols-[22rem_1fr] lg:gap-12">

        {{-- LEFT: heading, categories, customs facts --}}
        <div class="min-w-0">
            <p class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 font-montserrat text-xs font-bold uppercase tracking-wider text-amber-700">
                <span class="size-1.5 rounded-full bg-amber-500"></span>
                {{ $eyebrow }}
            </p>
            <h2 id="partner-faq-heading" class="mt-4 font-montserrat text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
                {{ $title }}
            </h2>
            @if ($subtitle)
                <p class="mt-3 text-base leading-relaxed text-slate-600">{{ $subtitle }}</p>
            @endif

            {{-- categories --}}
            <div class="-mx-5 mt-6 flex gap-2 overflow-x-auto px-5 pb-2 sm:-mx-10 sm:px-10 lg:mx-0 lg:flex-col lg:overflow-visible lg:px-0 lg:pb-0" role="tablist" aria-label="Question topics">
                @foreach ($cats as $c)
                    <button
                        type="button"
                        role="tab"
                        id="pfaq-tab-{{ $c['key'] }}"
                        @click="cat = '{{ $c['key'] }}'; open = null"
                        :aria-selected="cat === '{{ $c['key'] }}'"
                        :class="cat === '{{ $c['key'] }}' ? 'border-blue-950 bg-blue-950 text-white shadow-md' : 'border-slate-200 bg-slate-50 text-blue-950 hover:border-amber-300'"
                        class="flex shrink-0 items-center gap-3 rounded-full border px-4 py-2.5 text-left font-montserrat text-sm font-bold transition focus:outline-none focus-visible:ring-4 focus-visible:ring-amber-400/50 lg:rounded-2xl lg:px-5 lg:py-3"
                    >
                        <span
                            class="flex size-8 shrink-0 items-center justify-center rounded-full border-2 border-amber-400 transition"
                            :class="cat === '{{ $c['key'] }}' ? 'bg-amber-400 text-blue-950' : 'bg-amber-50 text-amber-500'"
                        >
                            <svg class="size-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" shape-rendering="geometricPrecision" aria-hidden="true"><path d="{{ $c['icon'] }}" /></svg>
                        </span>
                        <span class="whitespace-nowrap lg:whitespace-normal">{{ $c['label'] }}</span>
                        <span class="ml-auto hidden font-mono text-xs font-semibold opacity-60 lg:inline">{{ $counts[$c['key']] ?? 0 }}</span>
                    </button>
                @endforeach
            </div>

            {{-- customs at a glance --}}
            <aside class="relative mt-8 hidden overflow-hidden rounded-3xl bg-blue-950 p-6 text-white lg:block" aria-labelledby="customs-glance">
                <div class="pointer-events-none absolute -right-12 -top-12 size-40 rounded-full bg-amber-400/20 blur-2xl" aria-hidden="true"></div>
                <h3 id="customs-glance" class="relative font-montserrat text-sm font-bold uppercase tracking-wider text-amber-400">Customs at a glance</h3>
                <dl class="relative mt-4 space-y-4">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-white/50">Duty-free value limit</dt>
                        <dd class="font-montserrat text-2xl font-extrabold">PHP 150,000</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-white/50">Privilege</dt>
                        <dd class="text-sm font-semibold text-white/90">Up to 3 times per calendar year</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-white/50">Contents</dt>
                        <dd class="text-sm font-semibold text-white/90">Personal and household effects only</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-white/50">Documents</dt>
                        <dd class="text-sm font-semibold text-white/90">Information sheet, passport copy, invoice or receipt if any</dd>
                    </div>
                </dl>
                @if ($accreditation)
                    <p class="relative mt-5 rounded-xl border border-amber-400/40 bg-amber-400/10 px-3 py-2 text-xs font-semibold text-amber-200">{{ $accreditation }}</p>
                @endif
                <p class="relative mt-5 border-t border-white/10 pt-4 text-xs leading-relaxed text-white/60">
                    Based on the Bureau of Customs guidelines on balikbayan boxes. Rules can change, so always confirm with the
                    <a href="https://customs.gov.ph/boc-guidelines-on-balikbayan-boxes-2/" target="_blank" rel="noopener noreferrer" class="font-semibold text-amber-300 underline underline-offset-2 hover:text-amber-200">Bureau of Customs</a>
                    before you ship.
                </p>
            </aside>
        </div>

        {{-- RIGHT: questions --}}
        <div class="min-w-0">
            <div class="space-y-3" role="tabpanel">
                @foreach ($items as $i => $item)
                    <div
                        x-show="cat === '{{ $item['cat'] }}'"
                        @if ($item['cat'] !== $first) x-cloak @endif
                        class="overflow-hidden rounded-2xl border transition duration-300"
                        :class="open === {{ $i }} ? 'border-amber-400 bg-amber-50 shadow-md' : 'border-slate-200 bg-slate-50 hover:border-amber-300'"
                    >
                        <h3>
                            <button
                                type="button"
                                @click="open = open === {{ $i }} ? null : {{ $i }}"
                                :aria-expanded="open === {{ $i }}"
                                aria-controls="pfaq-panel-{{ $i }}"
                                id="pfaq-button-{{ $i }}"
                                class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left font-montserrat text-base font-bold text-blue-950 focus:outline-none focus-visible:ring-4 focus-visible:ring-amber-400/50 sm:px-6 sm:py-5 sm:text-lg"
                            >
                                <span>{{ $item['q'] }}</span>
                                <span
                                    class="flex size-9 shrink-0 items-center justify-center rounded-full border-2 border-amber-400 text-amber-500 transition duration-300"
                                    :class="open === {{ $i }} ? 'rotate-45 bg-amber-400 text-blue-950' : ''"
                                    aria-hidden="true"
                                >
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                </span>
                            </button>
                        </h3>

                        <div
                            id="pfaq-panel-{{ $i }}"
                            role="region"
                            aria-labelledby="pfaq-button-{{ $i }}"
                            x-show="open === {{ $i }}"
                            x-cloak
                            x-collapse
                        >
                            <p class="px-5 pb-5 text-base leading-relaxed text-slate-600 sm:px-6 sm:pb-6">{{ $item['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- still have questions --}}
            <div class="mt-8 flex flex-col items-start justify-between gap-4 rounded-2xl border border-dashed border-amber-400 bg-amber-50/60 p-5 sm:flex-row sm:items-center sm:p-6">
                <div>
                    <p class="font-montserrat text-base font-extrabold text-blue-950">Still have a question about your container?</p>
                    <p class="mt-1 text-sm text-slate-600">Tell us about your shipment and we will answer before you book.</p>
                </div>
                <a href="{{ $contactUrl }}" @if (! str_starts_with($contactUrl, '#')) wire:navigate @endif class="group inline-flex shrink-0 items-center gap-2 rounded-full bg-amber-400 px-5 py-2.5 font-montserrat text-sm font-bold text-blue-950 transition hover:-translate-y-0.5 hover:bg-amber-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-950 focus-visible:ring-offset-2">
                    Talk to us
                    <svg class="size-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
            </div>
        </div>
    </div>
</section>
</div>
