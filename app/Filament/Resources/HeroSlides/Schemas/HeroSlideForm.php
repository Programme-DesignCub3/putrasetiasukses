<?php

namespace App\Filament\Resources\HeroSlides\Schemas;

use App\Models\HeroSlide;
use App\Support\FilamentTranslatableFields;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HeroSlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Slide')
                    ->description('Atur konten dan status hero slide.')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('label', 'Label', $locale)
                                    ->maxLength(255),
                            ],
                            label: 'Label',
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('title', 'Judul', $locale)
                                    ->maxLength(255),
                            ],
                            label: 'Judul',
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('subtitle', 'Subjudul', $locale, 3)
                                    ->columnSpanFull(),
                            ],
                            label: 'Subjudul',
                            columns: 1,
                        ),
                        TextInput::make('link')
                            ->label('Tautan (opsional)')
                            ->helperText('Jika diisi, slide akan menjadi link yang bisa diklik.')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Gambar')
                    ->description('Upload gambar atau isi URL fallback.')
                    ->schema([
                        ...FilamentTranslatableFields::localeImageUploads(
                            name: 'hero_image',
                            label: 'Upload Gambar',
                            collection: HeroSlide::ImageCollection,
                            required: true,
                        ),
                        TextInput::make('image')
                            ->label('URL Gambar (fallback)')
                            ->helperText('Terpakai jika tidak ada gambar yang diupload.')
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }
}
