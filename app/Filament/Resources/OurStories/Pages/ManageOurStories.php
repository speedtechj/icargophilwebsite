<?php

namespace App\Filament\Resources\OurStories\Pages;

use App\Filament\Resources\OurStories\OurStoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageOurStories extends ManageRecords
{
    protected static string $resource = OurStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->modalWidth('5xl')
            ->visible(fn () => \App\Models\OurStory::count() === 0),
        ];
    }
}
