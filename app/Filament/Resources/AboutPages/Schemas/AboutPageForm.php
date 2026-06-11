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
                        TextInput::make('title.id')
                            ->label('Title (ID)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('title.en')
                            ->label('Title (EN)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('title.zh')
                            ->label('Title (ZH)')
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
                    ->columns(3),

                Section::make('Intro')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('intro_image')
                            ->label('Intro image')
                            ->collection(AboutPage::IntroImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                        Textarea::make('intro_text.id')
                            ->label('Intro text (ID)')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('intro_text.en')
                            ->label('Intro text (EN)')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('intro_text.zh')
                            ->label('Intro text (ZH)')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Visi & Misi')
                    ->schema([
                        TextInput::make('vision_title.id')
                            ->label('Vision title (ID)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('vision_title.en')
                            ->label('Vision title (EN)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('vision_title.zh')
                            ->label('Vision title (ZH)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('mission_title.id')
                            ->label('Mission title (ID)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('mission_title.en')
                            ->label('Mission title (EN)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('mission_title.zh')
                            ->label('Mission title (ZH)')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('vision_body.id')
                            ->label('Vision body (ID)')
                            ->required()
                            ->rows(5),
                        Textarea::make('vision_body.en')
                            ->label('Vision body (EN)')
                            ->required()
                            ->rows(5),
                        Textarea::make('vision_body.zh')
                            ->label('Vision body (ZH)')
                            ->required()
                            ->rows(5),
                        Textarea::make('mission_body.id')
                            ->label('Mission body (ID)')
                            ->required()
                            ->rows(5),
                        Textarea::make('mission_body.en')
                            ->label('Mission body (EN)')
                            ->required()
                            ->rows(5),
                        Textarea::make('mission_body.zh')
                            ->label('Mission body (ZH)')
                            ->required()
                            ->rows(5),
                    ])
                    ->columns(3),

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
                        TextInput::make('video_title.id')
                            ->label('Video title (ID)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('video_title.en')
                            ->label('Video title (EN)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('video_title.zh')
                            ->label('Video title (ZH)')
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
