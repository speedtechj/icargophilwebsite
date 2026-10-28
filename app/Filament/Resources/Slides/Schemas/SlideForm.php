<?php

namespace App\Filament\Resources\Slides\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 FileUpload::make('image')
                ->image()
                ->disk('public')
                ->directory('slides')
                ->imageResizeTargetWidth('1600')
                ->required()
                ->columnSpanFull(),
            TextInput::make('title'),
            TextInput::make('button')->placeholder('Learn more'),
            Textarea::make('text')->columnSpanFull(),
            TextInput::make('link')
                ->helperText('Optional. Where the button goes, e.g. /services')
                ->columnSpanFull(),
            Toggle::make('is_active')->default(true),
            ]);
    }
}
