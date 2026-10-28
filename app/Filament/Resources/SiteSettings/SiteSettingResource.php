<?php

namespace App\Filament\Resources\SiteSettings;

use App\Filament\Resources\SiteSettings\Pages\ManageSiteSettings;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    protected static ?string $modelLabel = 'Contact details';
    protected static ?string $pluralModelLabel = 'Contact details';
    protected static ?string $navigationLabel = 'Contact Details';
    protected static ?string $recordTitleAttribute = 'email';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-phone';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Call and email')->columns(2)->schema([
                TextInput::make('phone')->tel()->placeholder('+1 403 555 0123'),
                TextInput::make('email')->email()->placeholder('hello@yourdomain.com'),
            ]),
            Section::make('Chat links (leave empty to hide a button)')->columns(3)->schema([
                TextInput::make('messenger_url')->label('Messenger')->url(),
                TextInput::make('viber_url')->label('Viber'),
                TextInput::make('whatsapp_url')->label('WhatsApp')->url(),
            ]),
            Section::make('Address')->schema([
                TextInput::make('address')->placeholder('123 Main St, Calgary, AB'),
                Textarea::make('directions')->rows(2),
            ]),
            Section::make('Office hours')->schema([
                Repeater::make('hours')->label('')->addActionLabel('Add hours row')->columns(2)->schema([
                    TextInput::make('label')->placeholder('Monday – Friday')->required(),
                    CheckboxList::make('days')->columns(7)->required()->options([
                        1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun',
                    ]),
                    TimePicker::make('open')->seconds(false),
                    TimePicker::make('close')->seconds(false),
                    Toggle::make('closed')->label('Closed on these days')->columnSpanFull(),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('phone'),
                TextColumn::make('email'),
                TextColumn::make('address')->limit(40),
                TextColumn::make('updated_at')->since(),
            ])
            ->recordActions([EditAction::make()->modalWidth('7xl')->slideOver()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return ['index' => ManageSiteSettings::route('/')];
    }
}
