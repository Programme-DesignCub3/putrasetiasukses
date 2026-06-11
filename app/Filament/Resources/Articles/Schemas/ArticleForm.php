<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Models\Article;
use App\Models\Category;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
                        Select::make('categories')
                            ->label('Kategori')
                            ->multiple()
                            ->relationship(
                                name: 'categories',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->where('type', Category::TypeArticle)->where('is_active', true),
                            )
                            ->getOptionLabelFromRecordUsing(fn (Category $record): string => $record->name)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('title.id')->label('Title (ID)')->required()->maxLength(255),
                        TextInput::make('title.en')->label('Title (EN)')->required()->maxLength(255),
                        TextInput::make('title.zh')->label('Title (ZH)')->required()->maxLength(255),
                        TextInput::make('slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Kosongkan saat membuat artikel agar slug dibuat otomatis.'),
                        TextInput::make('author')->required()->maxLength(255),
                        SpatieMediaLibraryFileUpload::make('article_image')
                            ->label('Image')
                            ->collection(Article::ImageCollection)
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpanFull(),
                        Textarea::make('excerpt.id')->label('Excerpt (ID)')->required()->rows(3)->columnSpanFull(),
                        Textarea::make('excerpt.en')->label('Excerpt (EN)')->required()->rows(3)->columnSpanFull(),
                        Textarea::make('excerpt.zh')->label('Excerpt (ZH)')->required()->rows(3)->columnSpanFull(),
                        Textarea::make('body.id')->label('Body (ID)')->required()->rows(12)->columnSpanFull(),
                        Textarea::make('body.en')->label('Body (EN)')->required()->rows(12)->columnSpanFull(),
                        Textarea::make('body.zh')->label('Body (ZH)')->required()->rows(12)->columnSpanFull(),
                        DateTimePicker::make('published_at'),
                        Toggle::make('is_featured')->default(false),
                        Toggle::make('is_published')->default(true),
                    ])
                    ->columns(3),
            ]);
    }
}
