<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Brand')
                    ->schema([
                        TextInput::make('company_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('tagline')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('website_url')
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('whatsapp_number')
                            ->tel()
                            ->maxLength(32),
                    ])
                    ->columns(2),

                Section::make('Contact')
                    ->schema([
                        Repeater::make('phones')
                            ->schema([
                                TextInput::make('label')
                                    ->required()
                                    ->maxLength(100),
                                TextInput::make('number')
                                    ->required()
                                    ->maxLength(100),
                            ])
                            ->defaultItems(4)
                            ->columns(2)
                            ->columnSpanFull(),
                        Textarea::make('head_office_address')
                            ->rows(4),
                        Textarea::make('warehouse_address')
                            ->rows(4),
                    ])
                    ->columns(2),
            ]);
    }
}
