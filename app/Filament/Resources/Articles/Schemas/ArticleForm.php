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
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.form.article.section_info'))
                    ->description(__('admin.form.article.section_info_desc'))
                    ->schema([
                        Select::make('categories')
                            ->label(__('admin.form.article.category'))
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
                            ->columnSpanFull(),
                        Toggle::make('is_published')
                            ->label(__('admin.form.article.published'))
                            ->default(true),
                        Toggle::make('is_featured')
                            ->label(__('admin.form.article.featured'))
                            ->default(false),
                        TextInput::make('author')
                            ->label(__('admin.form.article.author'))
                            ->required()
                            ->maxLength(255),
                        DateTimePicker::make('published_at')
                            ->label(__('admin.form.article.published_at')),
                        TextInput::make('slug')
                            ->visible(fn (string $operation): bool => $operation === 'edit')
                            ->disabled(fn (Get $get): bool => ! $get('edit_slug'))
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText(__('admin.form.article.slug_helper'))
                            ->columnSpanFull(),
                        Toggle::make('edit_slug')
                            ->label(__('admin.form.article.edit_slug'))
                            ->default(false)
                            ->live()
                            ->dehydrated(false)
                            ->visible(fn (string $operation): bool => $operation === 'edit'),
                    ])
                    ->columns(2),

                Section::make(__('admin.form.article.section_content'))
                    ->description(__('admin.form.article.section_content_desc'))
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('title', 'Judul', $locale)
                                    ->maxLength(255),
                            ],
                            label: __('admin.form.article.title_label'),
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('excerpt', 'Ringkasan', $locale, 3)
                                    ->columnSpanFull(),
                            ],
                            label: __('admin.form.article.excerpt'),
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::richEditor('body', 'Isi', $locale)
                                    ->columnSpanFull(),
                            ],
                            label: __('admin.form.article.body_label'),
                            columns: 1,
                        ),
                    ]),

                Section::make(__('admin.form.article.section_media'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('article_image')
                            ->label(__('admin.form.article.main_image'))
                            ->collection(Article::ImageCollection)
                            ->required()
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                    ]),
            ]);
    }
}
