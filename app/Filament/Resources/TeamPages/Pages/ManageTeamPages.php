<?php

namespace App\Filament\Resources\TeamPages\Pages;

use App\Filament\Resources\TeamPages\TeamPageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTeamPages extends ManageRecords
{
    protected static string $resource = TeamPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
             ->modalWidth('5xl')
            ->visible(fn () => \App\Models\TeamPage::count() === 0),
        ];
    }
}
