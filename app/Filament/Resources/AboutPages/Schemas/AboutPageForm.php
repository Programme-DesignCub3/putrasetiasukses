<?php

namespace App\Filament\Resources\AboutPages\Schemas;

use App\Models\AboutPage;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        SpatieMediaLibraryFileUpload::make('hero_image')
                            ->label('Hero image')
                            ->collection(AboutPage::HeroImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Intro')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('intro_image')
                            ->label('Intro image')
                            ->collection(AboutPage::IntroImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                        Textarea::make('intro_text')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Visi & Misi')
                    ->schema([
                        TextInput::make('vision_title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('mission_title')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('vision_body')
                            ->required()
                            ->rows(5),
                        Textarea::make('mission_body')
                            ->required()
                            ->rows(5),
                    ])
                    ->columns(2),

                Section::make('Galeri & Video')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('gallery_media')
                            ->label('Gallery images')
                            ->collection(AboutPage::GalleryCollection)
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpanFull(),
                        TextInput::make('video_title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('video_url')
                            ->label('Video URL')
                            ->url()
                            ->maxLength(2048),
                    ])
                    ->columns(2),
            ]);
    }
}
