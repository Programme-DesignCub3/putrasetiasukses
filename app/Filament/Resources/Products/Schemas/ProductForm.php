<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Produk')
                    ->schema([
                        TextInput::make('category')->required()->maxLength(255),
                        TextInput::make('name')->required()->maxLength(255),
                        TextInput::make('slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                        TextInput::make('main_image_url')->label('Main image URL')->url()->required()->maxLength(2048),
                        Textarea::make('description')->required()->rows(8)->columnSpanFull(),
                        Toggle::make('is_published')->default(true),
                    ])
                    ->columns(2),
                Section::make('Galeri')
                    ->schema([
                        Repeater::make('gallery_images')
                            ->schema([
                                TextInput::make('url')->url()->required()->maxLength(2048),
                                TextInput::make('alt')->maxLength(255),
                            ])
                            ->defaultItems(3)
                            ->columns(2),
                    ]),
            ]);
    }
}
