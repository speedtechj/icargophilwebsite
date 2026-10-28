<?php

namespace App\Filament\Resources\TimelineSteps;

use App\Filament\Resources\TimelineSteps\Pages\ManageTimelineSteps;
use App\Models\TimelineStep;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TimelineStepResource extends Resource
{
    protected static ?string $model = TimelineStep::class;
    protected static ?string $modelLabel = 'Timeline step';
    protected static ?string $navigationLabel = 'Container Timeline';
    protected static ?string $recordTitleAttribute = 'title';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-queue-list';

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(2)->components([
            TextInput::make('title')->required()->placeholder('Careful unloading'),
            Select::make('icon')->options(TimelineStep::ICONS)->default('unload')->required(),
            Textarea::make('text')->required()->rows(2)->columnSpanFull(),
            TagsInput::make('points')->label('Bullet points (2-3)')
                ->placeholder('Type a point, press Enter')->columnSpanFull(),
            FileUpload::make('photo')->image()->imageEditor()
                ->disk('public')->directory('timeline')->visibility('public')->maxSize(4096)
                ->helperText('One real photo per step. Blur faces and address labels.'),
            TextInput::make('photo_alt')->label('Photo description'),
            TextInput::make('tag')->label('Small label')->placeholder('Leave empty for Step 1, Step 2...'),
            Toggle::make('is_active')->label('Show on the website')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')->disk('public')->square(),
                TextColumn::make('title')->weight('bold')->searchable(),
                TextColumn::make('icon')->badge(),
                ToggleColumn::make('is_active')->label('Visible'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([EditAction::make()->modalWidth('4xl'), DeleteAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return ['index' => ManageTimelineSteps::route('/')];
    }
}
