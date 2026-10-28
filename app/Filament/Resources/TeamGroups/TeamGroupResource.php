<?php

namespace App\Filament\Resources\TeamGroups;

use App\Filament\Resources\TeamGroups\Pages\ManageTeamGroups;
use App\Models\TeamGroup;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TeamGroupResource extends Resource
{
    protected static ?string $model = TeamGroup::class;
    protected static ?string $modelLabel = 'Team group';
    protected static ?string $navigationLabel = 'Team Groups';
    protected static ?string $recordTitleAttribute = 'name';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(2)->components([
            TextInput::make('name')->required()->placeholder('Warehouse'),
            Select::make('icon')->options(TeamGroup::ICONS)->default('briefcase')->required(),
            TextInput::make('text')->label('Short line under the name')
                ->placeholder('The hands that check and pack every box.')->columnSpanFull(),

            Repeater::make('members')->label('Members')->addActionLabel('Add a member')
                ->collapsible()->reorderable()->columns(2)->columnSpanFull()
                ->itemLabel(fn (array $state) => $state['name'] ?? 'New member')
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('role')->required()->placeholder('Warehouse Supervisor'),
                    Textarea::make('text')->label('Friendly line')->rows(2)->columnSpanFull(),
                    FileUpload::make('photo')->image()->imageEditor()
                        ->disk('public')->directory('team')->visibility('public')->maxSize(3072)
                        ->helperText('Portrait photo with a plain background. Get the person\'s permission first.')
                        ->columnSpanFull(),
                ]),

            Toggle::make('is_active')->label('Show on the website')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->weight('bold')->searchable(),
                TextColumn::make('icon')->badge(),
                TextColumn::make('members')->label('Members')
                    ->getStateUsing(fn ($record) => count($record->members ?? [])),
                ToggleColumn::make('is_active')->label('Visible'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([EditAction::make()->modalWidth('5xl'), DeleteAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return ['index' => ManageTeamGroups::route('/')];
    }
}
