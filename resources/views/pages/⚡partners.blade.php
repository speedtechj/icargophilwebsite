<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
   {{--
    "For Cargo Partners" page content, built from your existing components.
    Put it inside the same page wrapper as your other pages.
    Route example:  Route::view('/partners', 'partners')->name('partners');

    NOTE: all wording is SUGGESTED. Keep only what iCargo really does and edit the rest.
--}}
<div class="mx-auto max-w-7xl">

    {{-- 1. Hero --}}
    <x-hero
        eyebrow="For cargo companies abroad"
        title="Your balikbayan boxes,"
        highlight="delivered in the Philippines."
        subtitle="We are your partner on the Philippine side: port clearance, trucking, warehousing and nationwide door-to-door delivery for your customers' boxes."
        button="Become a partner"
        url="#partner"
        secondary="See what we handle"
        secondary-url="#services"
        :points="['Port clearance', 'Trucking', 'Warehousing', 'Nationwide delivery']"
    />

    {{-- 2. What we handle --}}
    <x-services1
        id="services1"
        class="scroll-mt-28"
        cols="lg:grid-cols-4"
        eyebrow="What we handle for you"
        title="Everything after your container ships"
        subtitle="One partner for the whole Philippine side, so your customers' boxes keep moving from the port to their families' doors."
        :items="[
            [
                'icon' => 'port',
                'title' => 'Port clearance',
                'benefit' => 'We receive and clear your containers.',
                'points' => [
                    'Handling of port and customs procedures',
                    'Coordination of your shipping documents',
                    'Updates when your container arrives',
                ],
            ],
            [
                'icon' => 'truck',
                'title' => 'Trucking',
                'benefit' => 'From the port to our warehouse and beyond.',
                'points' => [
                    'Container hauling from the port',
                    'Trucks for long-distance and provincial routes',
                    'Safe handling of every load',
                ],
            ],
            [
                'icon' => 'warehouse',
                'title' => 'Warehousing',
                'benefit' => 'A safe place to sort and store boxes.',
                'points' => [
                    'Unloading and sorting by destination',
                    'Secure storage before dispatch',
                    'Box counts checked against your list',
                ],
            ],
            [
                'icon' => 'delivery',
                'title' => 'Nationwide delivery',
                'benefit' => 'Balikbayan boxes to every door.',
                'points' => [
                    'Door-to-door in Luzon, Visayas and Mindanao',
                    'Delivery to cities and provinces',
                    'Confirmation once boxes are delivered',
                ],
            ],
        ]"
    />

    {{-- 3. How a partnership works --}}
    <x-how_it_works
        eyebrow="How it works"
        title="From your container to every customer's door"
        subtitle="A simple flow that keeps you informed at each step."
        cta="Talk to us about your containers"
        :steps="[
            [
                'icon' => 'book',
                'title' => 'You send the details',
                'text' => 'Share your shipping documents and list of boxes before the container arrives.',
                'points' => ['Container and shipping documents', 'Box list with receiver names and addresses'],
            ],
            [
                'icon' => 'pickup',
                'title' => 'We clear and receive',
                'text' => 'Your container is received and cleared at the port.',
                'points' => ['Port and customs procedures', 'Container unloaded at our warehouse'],
            ],
            [
                'icon' => 'truck',
                'title' => 'We sort and truck',
                'text' => 'Boxes are checked, sorted by destination and loaded for delivery.',
                'points' => ['Counted against your list', 'Dispatched by route and island group'],
            ],
            [
                'icon' => 'home',
                'title' => 'Delivered nationwide',
                'text' => 'Every box goes to the receiver\'s door.',
                'points' => ['Door-to-door delivery', 'You are told when boxes are delivered'],
            ],
        ]"
    />

    {{-- 4. Where you can deliver --}}
    <x-coverage_area />
    {{-- <x-partners_logo :partners="[
    ['name' => '', 'country' => 'Canada', 'logo' => 'images/partners/canada-store.png', 'url' => 'https://theirwebsite.com'],
]" /> --}}
    <x-partners_logo
        eyebrow="Our partners abroad"
        title="Trusted By  Companies Overseas"
        subtitle="These companies send their customers' balikbayan boxes to us, and we clear, truck and deliver them across the Philippines."
        cta="Become a partner"
        url="#partner"
        :partners="[
            ['name' => 'Forex Cargo Travel & Tours', 'country' => 'Canada', 'logo' => null, 'url' => null],
            ['name' => 'Forex Cargo Inc.', 'country' => 'Canada', 'logo' => null, 'url' => null],
            ['name' => 'IcargoXpress', 'country' => 'Canada', 'logo' => null, 'url' => null],
            ['name' => 'Alpha & Omega Cargo Express Inc.', 'country' => 'Canada', 'logo' => null, 'url' => null],
            // ['name' => 'Sample Island Cargo', 'country' => 'Australia', 'logo' => null, 'url' => null],
            // ['name' => 'Sample Home Link Cargo', 'country' => 'United Kingdom', 'logo' => null, 'url' => null],
        ]"
        />
       <x-partners_faq accreditation="DTI-accredited freight forwarder / deconsolidator, No. 000000" />
    {{-- 5. Closing call to action (partner form comes next) --}}
    <x-cta
        id="partner"
        class="scroll-mt-28"
        eyebrow="Become a partner"
        title="Have a container coming?"
        highlight="Let's talk."
        subtitle="Tell us your country, how many boxes you ship and where they go. We will reply with how we can work together."
        button="Message us"
    />

</div>
</div>
