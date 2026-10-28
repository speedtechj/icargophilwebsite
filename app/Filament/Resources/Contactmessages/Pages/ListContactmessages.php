<?php

namespace App\Filament\Resources\Contactmessages\Pages;

use App\Filament\Resources\Contactmessages\ContactmessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactmessages extends ListRecords
{
    protected static string $resource = ContactmessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
     //      CreateAction::make(),
        ];
    }
}
