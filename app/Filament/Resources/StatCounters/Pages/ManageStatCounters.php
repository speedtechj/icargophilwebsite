<?php

namespace App\Filament\Resources\StatCounters\Pages;

use App\Filament\Resources\StatCounters\StatCounterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageStatCounters extends ManageRecords
{
    protected static string $resource = StatCounterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
