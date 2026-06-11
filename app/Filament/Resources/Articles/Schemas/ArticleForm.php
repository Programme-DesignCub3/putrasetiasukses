<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
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
                    ->schema([
                        TextInput::make('category')->required()->maxLength(255),
                        TextInput::make('title')->required()->maxLength(255),
                        TextInput::make('slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                        TextInput::make('author')->required()->maxLength(255),
                        TextInput::make('image_url')->label('Image URL')->url()->required()->maxLength(2048),
                        Textarea::make('excerpt')->required()->rows(3)->columnSpanFull(),
                        Textarea::make('body')->required()->rows(12)->columnSpanFull(),
                        DateTimePicker::make('published_at'),
                        Toggle::make('is_featured')->default(false),
                        Toggle::make('is_published')->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
