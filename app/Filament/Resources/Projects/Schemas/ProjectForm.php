<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Support\FilamentTranslatableFields;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Project')
                    ->description('Atur kategori, klien, dan status publikasi.')
                    ->schema([
                        Select::make('categories')
                            ->label('Kategori')
                            ->multiple()
                            ->relationship(
                                name: 'categories',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->where('is_active', true)->ordered(),
                            )
                            ->getOptionLabelFromRecordUsing(fn (ProjectCategory $record): string => $record->name)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                        TextInput::make('slug')
                            ->visible(fn (string $operation): bool => $operation === 'edit')
                            ->disabled(fn (Get $get): bool => !$get('edit_slug'))
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Aktifkan "Edit slug" untuk mengubah.'),
                        Toggle::make('edit_slug')
                            ->label('Edit slug')
                            ->default(false)
                            ->live()
                            ->dehydrated(false)
                            ->visible(fn (string $operation): bool => $operation === 'edit'),
                        TextInput::make('client')
                            ->label('Klien')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        DatePicker::make('completion_date')
                            ->label('Tanggal selesai'),
                    ])
                    ->columns(2),

                Section::make('Konten Project')
                    ->description('Bahasa Indonesia wajib diisi; bahasa lain boleh kosong.')
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('name', 'Nama', $locale)
                                    ->maxLength(255),
                            ],
                            label: 'Nama Project',
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('description', 'Deskripsi', $locale, 8)
                                    ->columnSpanFull(),
                            ],
                            label: 'Deskripsi Project',
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('location', 'Lokasi', $locale)
                                    ->maxLength(255),
                            ],
                            label: 'Lokasi',
                            columns: 1,
                        ),
                    ]),

                Section::make('Media Project')
                    ->description('Gunakan gambar WebP/JPEG/PNG teroptimasi.')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('main_image')
                            ->label('Gambar utama')
                            ->collection(Project::MainImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                        SpatieMediaLibraryFileUpload::make('gallery_media')
                            ->label('Galeri project')
                            ->collection(Project::GalleryCollection)
                            ->multiple()
                            ->reorderable()
                            ->panelLayout('grid')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                    ])
                    ->columns(2),
            ]);
    }
}
