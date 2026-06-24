<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Pesan')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama'),
                        TextEntry::make('company')
                            ->label('Perusahaan'),
                        TextEntry::make('phone')
                            ->label('Telepon'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('subject')
                            ->label('Subjek')
                            ->columnSpanFull(),
                        TextEntry::make('message')
                            ->label('Pesan')
                            ->columnSpanFull()
                            ->markdown(),
                        TextEntry::make('created_at')
                            ->label('Diterima')
                            ->dateTime(),
                        TextEntry::make('read_at')
                            ->label('Dibaca')
                            ->dateTime()
                            ->placeholder('Belum dibaca'),
                    ]),
            ]);
    }
}
