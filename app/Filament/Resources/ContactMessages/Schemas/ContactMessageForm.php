<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pesan')
                    ->description('Data pengirim dari form kontak website.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('company')
                            ->label('Perusahaan')
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Telepon')
                            ->required()
                            ->maxLength(50),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Isi Pesan')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Subjek')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('message')
                            ->label('Pesan')
                            ->required()
                            ->rows(8)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Status')
                    ->schema([
                        DateTimePicker::make('read_at')
                            ->label('Dibaca pada'),
                    ]),
            ]);
    }
}
