<?php

namespace App\Filament\Resources\TeamPages;

use App\Filament\Resources\TeamPages\Pages\ManageTeamPages;
use App\Models\TeamPage;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamPageResource extends Resource
{
    protected static ?string $model = TeamPage::class;
    protected static ?string $modelLabel = 'Team page';
    protected static ?string $pluralModelLabel = 'Team Page';
    protected static ?string $navigationLabel = 'Team page';
    protected static ?string $recordTitleAttribute = 'title';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Heading')->columns(2)->schema([
                TextInput::make('eyebrow')->placeholder('Meet our team'),
                TextInput::make('title')->placeholder('The people behind your boxes'),
                Textarea::make('subtitle')->rows(2)->columnSpanFull(),
            ]),
            Section::make('Whole-team photo (one picture)')->columns(2)->schema([
                FileUpload::make('team_photo')->label('Photo')->image()->imageEditor()
                    ->disk('public')->directory('team')->visibility('public')->maxSize(4096),
                TextInput::make('team_photo_caption')->label('Caption')->placeholder('The iCargo team, October 2026'),
            ]),
            Section::make('Owner card (leave the name empty to hide it)')->columns(2)->schema([
                TextInput::make('leader_name')->label('Name'),
                TextInput::make('leader_role')->label('Role')->placeholder('Owner & Manager'),
                Textarea::make('leader_text')->label('Message from the owner')->rows(3)->columnSpanFull(),
                FileUpload::make('leader_photo')->label('Photo')->image()->imageEditor()
                    ->disk('public')->directory('team')->visibility('public')->maxSize(3072)
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('team_photo')->disk('public')->square(),
                TextColumn::make('title')->weight('bold')->limit(40),
                TextColumn::make('leader_name')->label('Owner'),
                TextColumn::make('updated_at')->since(),
            ])
            ->recordActions([EditAction::make()->modalWidth('5xl')])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return ['index' => ManageTeamPages::route('/')];
    }
}
