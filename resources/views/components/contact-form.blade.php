<div>
    {{--
    resources/views/components/contact-form.blade.php

    A plain Blade component: it only draws the form. The saving, validating and spam
    protection live in the Contact page component (see contact-page.blade.php).

    Use it inside that page:
        <x-contact-form :sent="$sent" :sent-name="$sentName" :topic="$topic" />

    The root element has id="message", so a link to #message scrolls to the form.
--}}
    @props([
        'sent' => false,
        'sentName' => '',
        'topic' => '',
    ])
    @php
        $field =
            'mt-1.5 block w-full rounded-xl border bg-white px-4 py-3 text-base text-slate-900 placeholder-slate-400 shadow-sm transition focus:outline-none focus:ring-4';
        $ok = 'border-slate-300 focus:border-amber-400 focus:ring-amber-400/30';
        $bad = 'border-red-400 focus:border-red-400 focus:ring-red-300/40';

        $chip =
            'flex h-full items-center justify-center rounded-xl border-2 border-slate-200 bg-slate-50 px-3 py-3 text-center text-sm font-bold text-slate-700 transition hover:border-amber-300 hover:bg-white peer-checked:border-amber-400 peer-checked:bg-blue-950 peer-checked:text-white peer-focus-visible:ring-4 peer-focus-visible:ring-amber-400/40';
    @endphp

    <section id="message"
        {{ $attributes->class('relative scroll-mt-28 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm') }}
        aria-labelledby="contact-form-heading">

        {{-- Header --}}
        <div class="relative overflow-hidden bg-blue-950 px-6 py-8 sm:px-10">
            <div class="pointer-events-none absolute inset-0 opacity-40"
                style="background-image: radial-gradient(rgba(255,255,255,.16) 1px, transparent 1px); background-size: 22px 22px;"
                aria-hidden="true"></div>
            <div class="pointer-events-none absolute -right-16 -top-16 size-56 rounded-full bg-amber-400/25 blur-3xl"
                aria-hidden="true"></div>

            <div class="relative flex items-center gap-4">
                <span
                    class="flex size-14 shrink-0 items-center justify-center rounded-full border-2 border-amber-400 text-amber-400">
                    <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path
                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </span>
                <div>
                    <h2 id="contact-form-heading"
                        class="font-montserrat text-2xl font-extrabold text-white sm:text-3xl">Send us a message</h2>
                    <p class="mt-1 text-sm text-white/70 sm:text-base">Tell us what you are sending and we will help
                        from there.</p>
                </div>
            </div>
        </div>

        {{-- SUCCESS --}}
        @if ($sent)
            <div class="px-6 py-14 text-center sm:px-10" role="status" aria-live="polite">
                <span
                    class="mx-auto flex size-20 items-center justify-center rounded-full bg-amber-400 text-blue-950 shadow-lg shadow-amber-400/30">
                    <svg class="size-10" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </span>

                <h3 class="mt-6 font-montserrat text-2xl font-extrabold text-blue-950 sm:text-3xl">
                    Thank you{{ $sentName ? ', ' . $sentName : '' }}!
                </h3>
                <p class="mx-auto mt-3 max-w-md text-base leading-relaxed text-slate-600">
                    We have your message and will get back to you as soon as we can.
                </p>

                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    <button type="button" wire:click="sendAnother"
                        class="rounded-full bg-blue-950 px-6 py-3 font-montserrat text-sm font-bold text-white transition hover:bg-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2">
                        Send another message
                    </button>
                    <a href="{{ url('/') }}" wire:navigate
                        class="rounded-full border border-slate-300 px-6 py-3 font-montserrat text-sm font-bold text-blue-950 transition hover:border-amber-400 hover:bg-amber-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400">
                        Back to home
                    </a>
                </div>
            </div>

            {{-- FORM --}}
        @else
            <form wire:submit="submit" class="space-y-7 px-6 py-8 sm:px-10 sm:py-10" novalidate>

                {{-- 1. Topic --}}
                <fieldset>
                    <legend class="font-montserrat text-sm font-bold text-blue-950">
                        1. What do you need help with? <span class="text-amber-600" aria-hidden="true">*</span>
                    </legend>
                    <div class="mt-2 grid grid-cols-2 gap-2 sm:grid-cols-3">
                        @foreach (\App\Models\ContactMessage::topics() as $key => $label)
                            <label class="cursor-pointer" wire:key="topic-{{ $key }}">
                                <input type="radio" wire:model.live="topic" value="{{ $key }}"
                                    class="peer sr-only">
                                <span class="{{ $chip }}">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('topic')
                        <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </fieldset>

                {{-- 2. Destination --}}
                <fieldset>
                    <legend class="font-montserrat text-sm font-bold text-blue-950">
                        2. Where is it going? <span class="font-normal text-slate-500">(optional)</span>
                    </legend>
                    <div class="mt-2 grid grid-cols-2 gap-2 sm:grid-cols-4">
                        @foreach (\App\Models\ContactMessage::destinations() as $key => $label)
                            <label class="cursor-pointer" wire:key="destination-{{ $key }}">
                                <input type="radio" wire:model="destination" value="{{ $key }}"
                                    class="peer sr-only">
                                <span class="{{ $chip }}">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                {{-- Pickup details (only when relevant) --}}
                @if (in_array($topic, ['pickup', 'balikbayan'], true))
                    <div class="grid gap-5 rounded-2xl bg-amber-50 p-5 ring-1 ring-amber-200 sm:grid-cols-2"
                        wire:transition>
                        @if ($topic === 'pickup')
                            <div>
                                <label for="pickup_city" class="font-montserrat text-sm font-bold text-blue-950">Pickup
                                    city or area</label>
                                <input id="pickup_city" type="text" wire:model="pickup_city"
                                    autocomplete="address-level2" placeholder="For example, Calgary"
                                    class="{{ $field }} {{ $ok }}">
                            </div>
                        @endif
                        <div class="{{ $topic === 'pickup' ? '' : 'sm:col-span-2' }}">
                            <div>
                                <label for="box_size" class="text-sm font-semibold text-slate-700">Box size</label>
                                <div class="relative flex">
                                    <select id="box_size" wire:model="box_size"
                                        class="{{ $field }} {{ $ok }} appearance-none pr-12">
                                        <option value="">Select a box size</option>
                                        @foreach (\App\Models\ContactMessage::boxSizes() as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="pointer-events-none absolute inset-y-0 right-4 flex items-center pt-1.5 text-slate-500"
                                        aria-hidden="true">
                                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- 3. About you --}}
                <div>
                    <p class="font-montserrat text-sm font-bold text-blue-950">3. How can we reach you?</p>

                    <div class="mt-2 grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="text-sm font-semibold text-slate-700">Your name <span
                                    class="text-amber-600" aria-hidden="true">*</span></label>
                            <input id="name" type="text" wire:model.blur="name" autocomplete="name"
                                placeholder="Maria Santos"
                                class="{{ $field }} {{ $errors->has('name') ? $bad : $ok }}">
                            @error('name')
                                <p class="mt-1.5 text-sm font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="text-sm font-semibold text-slate-700">Phone</label>
                            <input id="phone" type="tel" wire:model.blur="phone" autocomplete="tel"
                                placeholder="+1 403 555 0123"
                                class="{{ $field }} {{ $errors->has('phone') ? $bad : $ok }}">
                            @error('phone')
                                <p class="mt-1.5 text-sm font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
                            <input id="email" type="email" wire:model.blur="email" autocomplete="email"
                                placeholder="you@example.com"
                                class="{{ $field }} {{ $errors->has('email') ? $bad : $ok }}">
                            @error('email')
                                <p class="mt-1.5 text-sm font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="relative flex">
                            <select id="reply_via" wire:model="reply_via"
                                class="{{ $field }} {{ $ok }} appearance-none pr-12">
                                @foreach (\App\Models\ContactMessage::replyOptions() as $key => $label)
                                    <option value="{{ $key }}" wire:key="reply-{{ $key }}">
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            <span
                                class="pointer-events-none absolute inset-y-0 right-4 flex items-center pt-1.5 text-slate-500"
                                aria-hidden="true">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Please give us at least a phone number or an email.</p>
                </div>

                {{-- 4. Message --}}
                <div>
                    <label for="message_text" class="font-montserrat text-sm font-bold text-blue-950">
                        4. Your message <span class="text-amber-600" aria-hidden="true">*</span>
                    </label>
                    <textarea id="message_text" rows="5" wire:model.blur="message"
                        placeholder="Tell us what you would like to send, and any questions you have."
                        class="{{ $field }} {{ $errors->has('message') ? $bad : $ok }}"></textarea>
                    @error('message')
                        <p class="mt-1.5 text-sm font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Honeypot (hidden from people) --}}
                <div class="absolute -left-[9999px] h-0 w-0 overflow-hidden" aria-hidden="true">
                    <label>Leave this field empty
                        <input type="text" wire:model="website" tabindex="-1" autocomplete="off">
                    </label>
                </div>

                {{-- Consent --}}
                <div>
                    <label class="flex cursor-pointer items-start gap-3">
                        <input type="checkbox" wire:model="consent"
                            class="mt-1 size-5 shrink-0 rounded border-slate-300 text-amber-500 focus:ring-4 focus:ring-amber-400/40">
                        <span class="text-sm leading-snug text-slate-600">
                            I am happy for iCargo to contact me about this message. We only use your details to reply to
                            you.
                        </span>
                    </label>
                    @error('consent')
                        <p class="mt-1.5 text-sm font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <button type="submit" wire:loading.attr="disabled" wire:target="submit"
                        class="group inline-flex items-center justify-center gap-2 rounded-full bg-amber-400 px-8 py-4 font-montserrat text-base font-bold text-blue-950 shadow-lg shadow-amber-400/20 transition hover:-translate-y-0.5 hover:bg-amber-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-900 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-70">
                        <span wire:loading.remove wire:target="submit">Send message</span>
                        <span wire:loading wire:target="submit">Sending...</span>

                        <svg wire:loading.remove wire:target="submit"
                            class="size-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                        <svg wire:loading wire:target="submit" class="size-5 animate-spin" viewBox="0 0 24 24"
                            fill="none" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3"
                                class="opacity-25" />
                            <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3"
                                stroke-linecap="round" />
                        </svg>
                    </button>

                    <p class="text-xs text-slate-500">Fields marked <span class="font-bold text-amber-600">*</span>
                        are required.</p>
                </div>
            </form>
        @endif
    </section>
</div>
