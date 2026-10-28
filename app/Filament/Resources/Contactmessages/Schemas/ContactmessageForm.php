<?php

namespace App\Filament\Resources\Contactmessages\Schemas;

use App\Models\ContactMessage;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactmessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ---------- Handling (what your team does) ----------
                Section::make('Handling')
                    ->description('Update the status and keep private notes for your team.')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('status')
                            ->options(ContactMessage::statuses())
                            ->required()
                            ->default('new')
                            ->native(false),
                        Textarea::make('internal_notes')
                            ->label('Internal notes')
                            ->helperText('Only your team can see these.')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                // ---------- Customer ----------
                Section::make('Customer')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('phone')
                            ->tel(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email(),
                        Select::make('reply_via')
                            ->label('Prefers to be contacted by')
                            ->options(ContactMessage::replyOptions())
                            ->required()
                            ->default('any')
                            ->native(false),
                    ]),

                // ---------- Request ----------
                Section::make('Request')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('topic')
                            ->options(ContactMessage::topics())
                            ->required()
                            ->native(false),
                        Select::make('destination')
                            ->options(ContactMessage::destinations())
                            ->native(false),
                        TextInput::make('pickup_city')
                            ->label('Pickup city'),
                        Select::make('box_size')
                            ->label('Box size')
                            ->options(ContactMessage::boxSizes())
                            ->native(false),
                        Textarea::make('message')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),

                // ---------- Technical ----------
                Section::make('Technical details')
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        TextInput::make('ip_address')
                            ->label('IP address')
                            ->disabled()
                            ->dehydrated(false),
                    ]),
            ]);
    }
}
