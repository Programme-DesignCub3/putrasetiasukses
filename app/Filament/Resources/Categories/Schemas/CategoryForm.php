<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kategori')
                    ->schema([
                        Select::make('type')
                            ->label('Tipe')
                            ->options([
                                Category::TypeProduct => 'Produk',
                                Category::TypeArticle => 'Artikel',
                                Category::TypeProject => 'Project',
                            ])
                            ->required(),
                        TextInput::make('slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Kosongkan saat membuat kategori agar slug dibuat otomatis.'),
                        TextInput::make('name.id')
                            ->label('Name (ID)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name.en')
                            ->label('Name (EN)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name.zh')
                            ->label('Name (ZH)')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description.id')
                            ->label('Description (ID)')
                            ->rows(5)
                            ->columnSpanFull(),
                        Textarea::make('description.en')
                            ->label('Description (EN)')
                            ->rows(5)
                            ->columnSpanFull(),
                        Textarea::make('description.zh')
                            ->label('Description (ZH)')
                            ->rows(5)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(3),
                Section::make('Media Kategori')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('category_image')
                            ->label('Image')
                            ->collection(Category::ImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpanFull(),
                        SpatieMediaLibraryFileUpload::make('category_gallery')
                            ->label('Gallery images')
                            ->collection(Category::GalleryCollection)
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
