<?php

namespace App\Filament\Resources\StatCounters;

use App\Filament\Resources\StatCounters\Pages\ManageStatCounters;
use App\Models\StatCounter;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use UnitEnum;

class StatCounterResource extends Resource
{
    protected static ?string $model = StatCounter::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    // protected static string|UnitEnum|null $navigationGroup = 'Website pages';
    // use seprate menu into group
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Stats counters';
    protected static ?string $modelLabel = 'counter';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('icon')->options(StatCounter::ICONS)->default('box')->required(),
            TextInput::make('label')->required()->placeholder('Boxes delivered'),
            TextInput::make('value')->label('Number')->numeric()->minValue(0)->required()
                ->helperText('The number counts up to this value. Type 20000, not 20,000.'),
            TextInput::make('suffix')->placeholder('+')->maxLength(5)
                ->helperText('Shown after the number, for example + or k.'),
            TextInput::make('text')->label('Small text')->placeholder('Safely handed to families back home.')
                ->columnSpanFull(),
            Toggle::make('is_active')->label('Visible on the website')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('label')->weight('bold')->searchable(),
                TextColumn::make('value')->label('Number')->numeric()->fontFamily('mono')->color('warning'),
                TextColumn::make('suffix')->placeholder('—'),
                TextColumn::make('icon')->badge()->formatStateUsing(fn ($state) => StatCounter::ICONS[$state] ?? $state),
                ToggleColumn::make('is_active')->label('Visible'),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageStatCounters::route('/')];
    }
}
