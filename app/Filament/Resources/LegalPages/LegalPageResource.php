<?php

namespace App\Filament\Resources\LegalPages;

use App\Filament\Resources\LegalPages\Pages\ManageLegalPages;
use App\Models\LegalPage;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class LegalPageResource extends Resource
{
    protected static ?string $model = LegalPage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';
    // protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Privacy & Terms';
    protected static ?string $modelLabel = 'Privacy & Terms';
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('slug')->label('Page')
                ->options(LegalPage::SLUGS)->required()->unique(ignoreRecord: true)
                ->live()
                ->afterStateUpdated(fn ($state, $set) => $set('title', LegalPage::SLUGS[$state] ?? null)),
            TextInput::make('title')->required(),
            RichEditor::make('content')->required()->columnSpanFull()
                ->toolbarButtons(['h2', 'h3', 'bold', 'italic', 'link', 'bulletList', 'orderedList', 'undo', 'redo']),
            Toggle::make('is_published')->label('Published')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->weight('bold'),
                TextColumn::make('slug')->fontFamily('mono')->color('gray'),
                IconColumn::make('is_published')->boolean()->label('Live'),
                TextColumn::make('updated_at')->since()->label('Last edited'),
            ])
            ->recordActions([
                EditAction::make()->modalWidth(Width::SevenExtraLarge),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageLegalPages::route('/')];
    }
}
