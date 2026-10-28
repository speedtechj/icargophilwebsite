<?php

namespace App\Filament\Resources\BoxSizes;

use App\Filament\Resources\BoxSizes\Pages\ManageBoxSizes;
use App\Models\BoxSize;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class BoxSizeResource extends Resource
{
    protected static ?string $model = BoxSize::class;
    protected static ?string $modelLabel = 'Box size';
    protected static ?string $navigationLabel = 'Box Sizes & Rates';
    protected static ?string $recordTitleAttribute = 'name';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(2)->components([
            TextInput::make('name')->required()->placeholder('Medium'),
            TextInput::make('dimensions')->required()->placeholder('18 × 18 × 24 in'),
            TextInput::make('best_for')->label('Best for')->placeholder('Gifts and everyday essentials')->columnSpanFull(),
            TextInput::make('price')->label('Starting price')->numeric()->prefix('$')->minValue(0)->required(),
            Select::make('scale')->label('Box drawing size')->default(2)->required()->options([
                1 => '1 (smallest)', 2 => '2', 3 => '3', 4 => '4 (largest)',
            ]),
            TagsInput::make('points')->label('Bullet points (2-3)')->placeholder('Type a point, press Enter')->columnSpanFull(),
            Toggle::make('is_popular')->label('Show as "Most popular"'),
            Toggle::make('is_active')->label('Show on the website')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->weight('bold')->searchable(),
                TextColumn::make('dimensions'),
                TextColumn::make('price')->money('USD'),
                ToggleColumn::make('is_popular')->label('Popular'),
                ToggleColumn::make('is_active')->label('Visible'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([EditAction::make()->modalWidth('4xl'), DeleteAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return ['index' => ManageBoxSizes::route('/')];
    }
}
