<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Resources\Testimonials\Pages\ManageTestimonials;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use UnitEnum;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    // protected static string|UnitEnum|null $navigationGroup = 'Website pages';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'Testimonials';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->placeholder('Maria Santos'),
            TextInput::make('detail')->placeholder('Balikbayan box · Cebu')
                ->helperText('Service and city, shown under the name.'),
            Textarea::make('quote')->required()->rows(4)->columnSpanFull(),
            Select::make('rating')
                ->options([5 => '★★★★★  5 stars', 4 => '★★★★☆  4 stars', 3 => '★★★☆☆  3 stars', 2 => '★★☆☆☆  2 stars', 1 => '★☆☆☆☆  1 star'])
                ->default(5)->required(),
            FileUpload::make('photo')->label('Photo (optional)')
                ->image()->avatar()->disk('public')->directory('testimonials')
                ->helperText('Without a photo, the customer\'s initials are shown.'),
            Toggle::make('is_active')->label('Visible on the website')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('photo')->disk('public')->circular()->label(''),
                TextColumn::make('name')->weight('bold')->searchable(),
                TextColumn::make('detail')->placeholder('—'),
                TextColumn::make('rating')->formatStateUsing(fn ($state) => str_repeat('★', (int) $state))->color('warning'),
                TextColumn::make('quote')->limit(50)->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('is_active')->label('Visible'),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageTestimonials::route('/')];
    }
}
