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
    eyebrow="About us"
    title="About"
    highlight="iCargoxpess"
    subtitle="Sending love home, safely."
    button="Message us"
    :url="route('contact')"
    :points="['Safe handling', 'Nationwide delivery', 'Balikbayan boxes & cargo']"
/>
<x-our_story class="mx-auto max-w-7xl"/>
<x-mission class="mx-auto max-w-7xl"/>
<x-value class="mx-auto max-w-7xl"/>
 <x-counters class="mx-auto max-w-7xl"/>
  <x-coverage_area class="mx-auto max-w-7xl"/>
  <x-team class="mx-auto max-w-7xl"/>
  <x-why_choose_us class="mx-auto max-w-7xl"/>
</div>
