<?php

namespace App\Filament\Resources\Contactmessages;

use App\Filament\Resources\Contactmessages\Pages\CreateContactmessage;
use App\Filament\Resources\Contactmessages\Pages\EditContactmessage;
use App\Filament\Resources\Contactmessages\Pages\ListContactmessages;
use App\Filament\Resources\Contactmessages\Schemas\ContactmessageForm;
use App\Filament\Resources\Contactmessages\Tables\ContactmessagesTable;
use App\Models\Contactmessage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactmessageResource extends Resource
{
    protected static ?string $model = Contactmessage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Contact Messages';



    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ContactmessageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactmessagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactmessages::route('/'),
            'create' => CreateContactmessage::route('/create'),
            'edit' => EditContactmessage::route('/{record}/edit'),
        ];
    }
}
