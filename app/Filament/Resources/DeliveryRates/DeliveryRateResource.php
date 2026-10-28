<?php

namespace App\Filament\Resources\DeliveryRates;

use App\Filament\Resources\DeliveryRates\Pages\ManageDeliveryRates;
use App\Models\DeliveryRate;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeliveryRateResource extends Resource
{
    protected static ?string $model = DeliveryRate::class;



    protected static ?string $recordTitleAttribute = 'key';

    protected static ?string $modelLabel = 'Delivery days & rates';
    protected static ?string $navigationLabel = 'Delivery Days & Rates';
       protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-truck';
    public static function form(Schema $schema): Schema
    {
        return $schema->columns(3)->components([
            Select::make('key')->label('Island group')
                ->options(DeliveryRate::KEYS)->required()->unique(ignoreRecord: true)->columnSpanFull(),
            TextInput::make('days_min')->label('Days (from)')->numeric()->minValue(1)->required(),
            TextInput::make('days_max')->label('Days (to)')->numeric()->minValue(1)->required()->gte('days_min'),
            TextInput::make('starting_rate')->label('Starting rate')->numeric()->prefix('$')->minValue(0)->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')->label('Island group')
                    ->formatStateUsing(fn ($state) => DeliveryRate::KEYS[$state] ?? $state)->weight('bold'),
                TextColumn::make('days_min')->label('Days')
                    ->formatStateUsing(fn ($state, $record) => $record->days_min . '–' . $record->days_max . ' days'),
                TextColumn::make('starting_rate')->label('Starting rate')->money('USD'),
            ])
            ->recordActions([EditAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageDeliveryRates::route('/'),
        ];
    }
}
