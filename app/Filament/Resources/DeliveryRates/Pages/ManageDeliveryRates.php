<?php

namespace App\Filament\Resources\DeliveryRates\Pages;

use App\Filament\Resources\DeliveryRates\DeliveryRateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageDeliveryRates extends ManageRecords
{
    protected static string $resource = DeliveryRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->visible(fn () => \App\Models\DeliveryRate::count() !== 3)
        ];
    }
}
