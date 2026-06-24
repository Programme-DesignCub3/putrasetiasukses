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
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Project')
                    ->description('Atur kategori, klien, dan status project.')
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
                            ->columnSpan(2),
                        TextInput::make('client')
                            ->label('Klien')
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Kosongkan saat membuat project agar slug dibuat otomatis.'),
                        DatePicker::make('completion_date')
                            ->label('Tanggal selesai'),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                    ])
                    ->columns(3),

                Section::make('Konten Project')
                    ->description('Bahasa Indonesia wajib diisi; bahasa lain boleh kosong.')
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('name', 'Name', $locale)
                                    ->maxLength(255),
                            ],
                            label: 'Nama Project',
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('description', 'Description', $locale, 8)
                                    ->columnSpanFull(),
                            ],
                            label: 'Deskripsi Project',
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('location', 'Location', $locale)
                                    ->maxLength(255),
                            ],
                            label: 'Lokasi',
                        ),
                    ])
                    ->columns(3),

                Section::make('Media Project')
                    ->description('Gunakan gambar WebP/JPEG/PNG teroptimasi untuk halaman publik.')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('main_image')
                            ->label('Gambar utama')
                            ->collection(Project::MainImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpan(1),
                        SpatieMediaLibraryFileUpload::make('gallery_media')
                            ->label('Galeri project')
                            ->collection(Project::GalleryCollection)
                            ->multiple()
                            ->reorderable()
                            ->panelLayout('grid')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpan(2),
                    ])
                    ->columns(3),
            ]);
    }
}
