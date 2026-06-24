<?php

namespace App\Filament\Resources\ProductCategories\Schemas;

use App\Models\Category;
use App\Support\FilamentTranslatableFields;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kategori Produk')
                    ->description('Kelompokkan produk berdasarkan jenis material atau kegunaan.')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        TextInput::make('slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Kosongkan saat membuat kategori agar slug dibuat otomatis.'),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('name', 'Name', $locale)
                                    ->maxLength(255),
                                FilamentTranslatableFields::textarea('description', 'Description', $locale, 5, required: false)
                                    ->columnSpanFull(),
                            ],
                            label: 'Konten Kategori',
                        ),
                    ])
                    ->columns(3),
                Section::make('Media Kategori')
                    ->description('Gambar digunakan untuk kartu kategori dan halaman terkait.')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('category_image')
                            ->label('Gambar utama')
                            ->collection(Category::ImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpan(1),
                        SpatieMediaLibraryFileUpload::make('category_gallery')
                            ->label('Galeri kategori')
                            ->collection(Category::GalleryCollection)
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpan(2),
                    ])
                    ->columns(3),
            ]);
    }
}
