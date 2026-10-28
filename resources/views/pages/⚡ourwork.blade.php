<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <x-hero
        class="mx-auto max-w-7xl"
        eyebrow="Our work"
        title="See how we handle"
        highlight="your boxes."
        subtitle="From the container to your family's door."
        button="Request a pickup"
        :points="['Checked on arrival', 'Handled by our team', 'Delivered to the door']"
    />

  <x-work_gallery class="mx-auto max-w-7xl" />
  <x-container_timeline class="mx-auto max-w-7xl" />

    <x-cta class="mx-auto max-w-7xl" />
</div>
