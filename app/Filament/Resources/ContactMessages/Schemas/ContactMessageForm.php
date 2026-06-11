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
                    ->schema([
                        TextInput::make('name')->required()->maxLength(255),
                        TextInput::make('company')->maxLength(255),
                        TextInput::make('phone')->required()->maxLength(50),
                        TextInput::make('email')->email()->maxLength(255),
                        TextInput::make('subject')->required()->maxLength(255)->columnSpanFull(),
                        Textarea::make('message')->required()->rows(8)->columnSpanFull(),
                        DateTimePicker::make('read_at')->label('Dibaca pada'),
                    ])
                    ->columns(2),
            ]);
    }
}
