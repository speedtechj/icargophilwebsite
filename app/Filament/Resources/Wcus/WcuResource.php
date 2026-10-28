<?php

namespace App\Filament\Resources\Wcus;

use App\Filament\Resources\Wcus\Pages\ManageWcus;
use App\Models\Wcu;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WcuResource extends Resource
{
    protected static ?string $model = Wcu::class;
    protected static ?string $navigationLabel = 'Why Choose Us';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('image')->image()->imageEditor()->required()
                ->disk('public')->directory('wcu')->visibility('public')->maxSize(4096),
            TextInput::make('alt')->label('Photo description'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->disk('public')->square(),
                TextColumn::make('alt')->limit(40),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageWcus::route('/'),
        ];
    }
}
