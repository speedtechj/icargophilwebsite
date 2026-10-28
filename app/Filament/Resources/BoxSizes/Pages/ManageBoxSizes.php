<?php

namespace App\Filament\Resources\BoxSizes\Pages;

use App\Filament\Resources\BoxSizes\BoxSizeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageBoxSizes extends ManageRecords
{
    protected static string $resource = BoxSizeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
