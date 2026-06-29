<?php

namespace App\Filament\Resources\HeroSlides\Schemas;

use App\Models\HeroSlide;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
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
                Section::make('Hero Slide')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('hero_image')
                            ->label('Upload Gambar')
                            ->collection(HeroSlide::ImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpan(1),
                        TextInput::make('image')
                            ->label('URL Gambar (fallback)')
                            ->helperText('Isi jika tidak upload gambar. Akan terpakai jika tidak ada gambar yang diupload.')
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('label')
                            ->label('Label')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('subtitle')
                            ->label('Subjudul')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
