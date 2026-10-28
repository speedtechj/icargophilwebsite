<?php

namespace App\Filament\Resources\Wcus\Pages;

use App\Filament\Resources\Wcus\WcuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageWcus extends ManageRecords
{
    protected static string $resource = WcuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->visible(fn () => \App\Models\Wcu::count() === 0),
        ];
    }
}
