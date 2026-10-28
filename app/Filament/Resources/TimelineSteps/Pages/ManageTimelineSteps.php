<?php

namespace App\Filament\Resources\TimelineSteps\Pages;

use App\Filament\Resources\TimelineSteps\TimelineStepResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTimelineSteps extends ManageRecords
{
    protected static string $resource = TimelineStepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
