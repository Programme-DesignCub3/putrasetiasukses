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
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Artikel')
                    ->description('Atur relasi, status publikasi, dan media utama artikel.')
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
                            ->columnSpan(2),
                        TextInput::make('author')
                            ->label('Penulis')
                            ->required()
                            ->maxLength(255),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal publikasi'),
                        Toggle::make('is_featured')
                            ->label('Artikel unggulan')
                            ->default(false),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                        SpatieMediaLibraryFileUpload::make('article_image')
                            ->label('Gambar utama')
                            ->collection(Article::ImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('Konten Artikel')
                    ->description('Bahasa Indonesia wajib diisi; bahasa lain boleh kosong.')
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('title', 'Title', $locale)
                                    ->maxLength(255),
                            ],
                            label: 'Konten Terjemahan',
                        ),
                        TextInput::make('slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Kosongkan saat membuat artikel agar slug dibuat otomatis.')
                            ->columnSpanFull(),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('excerpt', 'Excerpt', $locale, 3)
                                    ->columnSpanFull(),
                                FilamentTranslatableFields::richEditor('body', 'Body', $locale)
                                    ->columnSpanFull(),
                            ],
                            label: 'Isi Artikel',
                        ),
                    ])
                    ->columns(3),
            ]);
    }
}
