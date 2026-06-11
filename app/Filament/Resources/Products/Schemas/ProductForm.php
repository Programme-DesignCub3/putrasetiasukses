<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
                        SpatieMediaLibraryFileUpload::make('main_image')
                            ->label('Main image')
                            ->collection(Product::MainImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpanFull(),
                        Textarea::make('description')->required()->rows(8)->columnSpanFull(),
                        Toggle::make('is_published')->default(true),
                    ])
                    ->columns(2),
                Section::make('Galeri')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('gallery_media')
                            ->label('Gallery images')
                            ->collection(Product::GalleryCollection)
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                    ]),
            ]);
    }
}
