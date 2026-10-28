<?php

namespace App\Filament\Resources\Contactmessages\Pages;

use App\Filament\Resources\Contactmessages\ContactmessageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactmessage extends EditRecord
{
    protected static string $resource = ContactmessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
