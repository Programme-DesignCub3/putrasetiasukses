<?php

namespace App\Filament\Resources\AboutPages\Schemas;

use Filament\Forms\Components\Repeater;
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
                        TextInput::make('hero_image_url')
                            ->label('Hero image URL')
                            ->url()
                            ->required()
                            ->maxLength(2048),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Intro')
                    ->schema([
                        TextInput::make('intro_image_url')
                            ->label('Intro image URL')
                            ->url()
                            ->required()
                            ->maxLength(2048),
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
                        Repeater::make('gallery_images')
                            ->label('Gallery images')
                            ->schema([
                                TextInput::make('url')
                                    ->label('Image URL')
                                    ->url()
                                    ->required()
                                    ->maxLength(2048),
                                TextInput::make('alt')
                                    ->maxLength(255),
                            ])
                            ->defaultItems(4)
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
