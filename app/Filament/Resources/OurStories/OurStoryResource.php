<?php

namespace App\Filament\Resources\OurStories;

use App\Filament\Resources\OurStories\Pages\ManageOurStories;
use App\Models\OurStory;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OurStoryResource extends Resource
{
    protected static ?string $model = OurStory::class;
    protected static ?string $modelLabel = 'Our story';
    protected static ?string $pluralModelLabel = 'Our story';
    protected static ?string $navigationLabel = 'Our Story';
    protected static ?string $recordTitleAttribute = 'title';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Heading')->columns(2)->schema([
                TextInput::make('eyebrow')->placeholder('Our story'),
                TextInput::make('title')->placeholder('A family business built on care'),
                TextInput::make('lead')->label('Highlighted line')->columnSpanFull(),
            ]),
            Section::make('Story')->schema([
                Repeater::make('paragraphs')->addActionLabel('Add a paragraph')
                    ->simple(Textarea::make('paragraph')->rows(3)->required()),
                Textarea::make('quote')->label('Pull quote')->rows(2),
            ]),
            Section::make('Founder and photo')->columns(2)->schema([
                TextInput::make('founder')->placeholder('Maria Santos'),
                TextInput::make('role')->placeholder('Founder, iCargo'),
                TextInput::make('since')->label('Since (year)')->maxLength(10)->placeholder('2014'),
                TextInput::make('photo_alt')->label('Photo description'),
                FileUpload::make('photo')->label('Photo (one picture)')
                    ->image()->imageEditor()
                    ->disk('public')->directory('about')->visibility('public')->maxSize(4096)
                    ->columnSpanFull(),
            ]),
            Section::make('Milestones (optional)')->schema([
                Repeater::make('milestones')->label('')->addActionLabel('Add a milestone')
                    ->maxItems(3)->columns(2)->schema([
                        TextInput::make('year')->required()->placeholder('2018'),
                        TextInput::make('label')->required()->placeholder('Opened our own warehouse'),
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')->disk('public')->circular(),
                TextColumn::make('title')->weight('bold')->limit(40),
                TextColumn::make('founder'),
                TextColumn::make('updated_at')->since(),
            ])
            ->recordActions([EditAction::make()->modalWidth('5xl')])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return ['index' => ManageOurStories::route('/')];
    }
}
