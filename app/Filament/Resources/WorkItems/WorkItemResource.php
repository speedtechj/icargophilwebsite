<?php

namespace App\Filament\Resources\WorkItems;

use App\Filament\Resources\WorkItems\Pages\ManageWorkItems;
use App\Models\WorkItem;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WorkItemResource extends Resource
{
    protected static ?string $model = WorkItem::class;
    protected static ?string $modelLabel = 'Photo or video';
    protected static ?string $navigationLabel = 'Our Work Gallery';
    protected static ?string $recordTitleAttribute = 'caption';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(2)->components([
            Select::make('type')->options(['photo' => 'Photo', 'video' => 'Video'])
                ->default('photo')->required()->live(),
            Select::make('category')->options(WorkItem::CATEGORIES)->required(),

            TextInput::make('caption')->required()->placeholder('Unloading boxes from the container')->columnSpanFull(),
            TextInput::make('meta')->label('Place and date')->placeholder('Manila warehouse · Oct 2026')->columnSpanFull(),

            FileUpload::make('image')
                ->label(fn (Get $get) => $get('type') === 'video' ? 'Video thumbnail' : 'Photo')
                ->image()->imageEditor()
                ->disk('public')->directory('work')->visibility('public')->maxSize(4096)
                ->helperText('Resize to about 1600 px wide. Blur faces, house numbers and address labels.')
                ->columnSpanFull(),

            TextInput::make('video_url')->label('Video link')->url()
                ->placeholder('https://www.youtube.com/watch?v=XXXXXXXXXXX')
                ->helperText('Paste a YouTube link, a Facebook embed link or a .mp4 file URL.')
                ->visible(fn (Get $get) => $get('type') === 'video' || $get('is_featured'))
                ->columnSpanFull(),

            Toggle::make('is_featured')->label('Featured video at the top of the page')->live(),
            Toggle::make('is_active')->label('Show on the website')->default(true),

            Textarea::make('description')->label('Featured video description')->rows(2)
                ->visible(fn (Get $get) => (bool) $get('is_featured'))->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->disk('public')->square(),
                TextColumn::make('caption')->weight('bold')->limit(40)->searchable(),
                TextColumn::make('type')->badge(),
                TextColumn::make('category')->badge()
                    ->formatStateUsing(fn ($state) => WorkItem::CATEGORIES[$state] ?? $state),
                ToggleColumn::make('is_featured')->label('Featured'),
                ToggleColumn::make('is_active')->label('Visible'),
            ])
            ->filters([
                SelectFilter::make('category')->options(WorkItem::CATEGORIES),
                SelectFilter::make('type')->options(['photo' => 'Photo', 'video' => 'Video']),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([EditAction::make()->modalWidth('4xl'), DeleteAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return ['index' => ManageWorkItems::route('/')];
    }
}
