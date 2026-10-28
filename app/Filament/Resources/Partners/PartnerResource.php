<?php

namespace App\Filament\Resources\Partners;

use App\Filament\Resources\Partners\Pages\ManagePartners;
use App\Models\Partner;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;
    protected static ?string $modelLabel = 'Partner';
    protected static ?string $navigationLabel = 'Partners Abroad';
    protected static ?string $recordTitleAttribute = 'name';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(2)->components([
            TextInput::make('name')->required()->placeholder('Your Partner Cargo Store'),
            TextInput::make('country')->placeholder('Canada'),
            TextInput::make('url')->label('Website')->url()->placeholder('https://example.com'),
            FileUpload::make('logo')->image()->imageEditor()
                ->disk('public')->directory('partners')->visibility('public')->maxSize(2048)
                ->helperText('PNG with a transparent background looks best. Leave empty to show the initials badge.'),
            Toggle::make('is_active')->label('Show on the website')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')->disk('public')
                ->imageHeight(40),
               // ->square(),
                TextColumn::make('name')->weight('bold')->searchable(),
                TextColumn::make('country')->badge()->sortable(),
                ToggleColumn::make('is_active')->label('Visible'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([EditAction::make()->modalWidth('3xl'), DeleteAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return ['index' => ManagePartners::route('/')];
    }
}
