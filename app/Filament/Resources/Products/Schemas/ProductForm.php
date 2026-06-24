<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Support\FilamentTranslatableFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
                    ->description('Atur kategori, status, dan slug produk.')
                    ->schema([
                        Select::make('categories')
                            ->label('Kategori')
                            ->multiple()
                            ->relationship(
                                name: 'categories',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->where('is_active', true)->ordered(),
                            )
                            ->getOptionLabelFromRecordUsing(fn (ProductCategory $record): string => $record->name)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Kosongkan saat membuat produk agar slug dibuat otomatis.'),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                    ])
                    ->columns(3),

                Section::make('Konten Produk')
                    ->description('Bahasa Indonesia wajib diisi; bahasa lain boleh kosong.')
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('name', 'Name', $locale)
                                    ->maxLength(255),
                            ],
                            label: 'Nama Produk',
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('description', 'Description', $locale, 8)
                                    ->columnSpanFull(),
                            ],
                            label: 'Deskripsi Produk',
                        ),
                    ])
                    ->columns(3),

                Section::make('Media Produk')
                    ->description('Gunakan gambar WebP/JPEG/PNG teroptimasi untuk halaman publik.')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('main_image')
                            ->label('Gambar utama')
                            ->collection(Product::MainImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpan(1),
                        SpatieMediaLibraryFileUpload::make('gallery_media')
                            ->label('Galeri produk')
                            ->collection(Product::GalleryCollection)
                            ->multiple()
                            ->reorderable()
                            ->panelLayout('grid')
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
