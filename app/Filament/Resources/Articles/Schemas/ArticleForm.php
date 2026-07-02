<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Support\FilamentTranslatableFields;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Artikel')
                    ->description('Atur kategori, penulis, dan status publikasi.')
                    ->schema([
                        Select::make('categories')
                            ->label('Kategori')
                            ->multiple()
                            ->relationship(
                                name: 'categories',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->where('is_active', true)->ordered(),
                            )
                            ->getOptionLabelFromRecordUsing(fn (ArticleCategory $record): string => $record->name)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                        Toggle::make('is_featured')
                            ->label('Artikel unggulan')
                            ->default(false),
                        TextInput::make('author')
                            ->label('Penulis')
                            ->required()
                            ->maxLength(255),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal publikasi'),
                        TextInput::make('slug')
                            ->visible(fn (string $operation): bool => $operation === 'edit')
                            ->disabled(fn (Get $get): bool => !$get('edit_slug'))
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Aktifkan "Edit slug" untuk mengubah.')
                            ->columnSpanFull(),
                        Toggle::make('edit_slug')
                            ->label('Edit slug')
                            ->default(false)
                            ->live()
                            ->dehydrated(false)
                            ->visible(fn (string $operation): bool => $operation === 'edit'),
                    ])
                    ->columns(2),

                Section::make('Konten Artikel')
                    ->description('Bahasa Indonesia wajib diisi; bahasa lain boleh kosong.')
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('title', 'Judul', $locale)
                                    ->maxLength(255),
                            ],
                            label: 'Judul Artikel',
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('excerpt', 'Ringkasan', $locale, 3)
                                    ->columnSpanFull(),
                            ],
                            label: 'Ringkasan',
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::richEditor('body', 'Isi', $locale)
                                    ->columnSpanFull(),
                            ],
                            label: 'Isi Artikel',
                            columns: 1,
                        ),
                    ]),

                Section::make('Media')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('article_image')
                            ->label('Gambar utama')
                            ->collection(Article::ImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                    ]),
            ]);
    }
}
