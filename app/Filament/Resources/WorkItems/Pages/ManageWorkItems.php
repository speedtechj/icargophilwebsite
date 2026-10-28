<?php

namespace App\Filament\Resources\WorkItems\Pages;

use App\Filament\Resources\WorkItems\WorkItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageWorkItems extends ManageRecords
{
    protected static string $resource = WorkItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
