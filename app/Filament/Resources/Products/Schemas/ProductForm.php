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
                        TextInput::make('category.id')->label('Category (ID)')->required()->maxLength(255),
                        TextInput::make('category.en')->label('Category (EN)')->required()->maxLength(255),
                        TextInput::make('category.zh')->label('Category (ZH)')->required()->maxLength(255),
                        TextInput::make('name.id')->label('Name (ID)')->required()->maxLength(255),
                        TextInput::make('name.en')->label('Name (EN)')->required()->maxLength(255),
                        TextInput::make('name.zh')->label('Name (ZH)')->required()->maxLength(255),
                        TextInput::make('slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Kosongkan saat membuat produk agar slug dibuat otomatis.'),
                        SpatieMediaLibraryFileUpload::make('main_image')
                            ->label('Main image')
                            ->collection(Product::MainImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpanFull(),
                        Textarea::make('description.id')->label('Description (ID)')->required()->rows(8)->columnSpanFull(),
                        Textarea::make('description.en')->label('Description (EN)')->required()->rows(8)->columnSpanFull(),
                        Textarea::make('description.zh')->label('Description (ZH)')->required()->rows(8)->columnSpanFull(),
                        Toggle::make('is_published')->default(true),
                    ])
                    ->columns(3),
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
