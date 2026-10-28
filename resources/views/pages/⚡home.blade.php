<?php

use App\Models\Slide;
use Livewire\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'slides' => Slide::where('is_active', true)
                ->orderBy('sort')
                ->get()
                ->map(
                    fn($s) => [
                        'image' => asset('storage/' . $s->image),
                        'title' => $s->title,
                        'text' => $s->text,
                        'link' => $s->link,
                        'button' => $s->button,
                    ],
                )
                ->all(),
        ];
    }
};
?>

<div>
    <div class="mx-auto max-w-7xl">
        <x-slider :slides="$slides" :autoplay="5000" />
        <div class="">
            {{-- Hero section here --}}

            <x-strip class="mx-auto max-w-7xl" />

            {{-- Rest of the home page --}}

        <x-coverage_area class="mx-auto max-w-7xl"/>

        <x-counters class="mx-auto max-w-7xl"/>
        <x-why_choose_us class="mx-auto max-w-7xl"/>
         <x-testimonials class="mx-auto max-w-7xl"/>
         <x-cta class="mx-auto max-w-7xl"/>

    </div>

</div>
