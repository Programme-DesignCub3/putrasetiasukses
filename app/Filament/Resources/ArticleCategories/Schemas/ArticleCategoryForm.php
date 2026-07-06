<?php

namespace App\Filament\Resources\ArticleCategories\Schemas;

use App\Models\ArticleCategory;
use App\Support\FilamentTranslatableFields;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ArticleCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.form.article_category.section_info'))
                    ->description(__('admin.form.article_category.section_info_desc'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('admin.form.article_category.active'))
                            ->default(true),
                        TextInput::make('slug')
                            ->visible(fn (string $operation): bool => $operation === 'edit')
                            ->disabled(fn (Get $get): bool => ! $get('edit_slug'))
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText(__('admin.form.article_category.slug_helper')),
                        Toggle::make('edit_slug')
                            ->label(__('admin.form.article_category.edit_slug'))
                            ->default(false)
                            ->live()
                            ->dehydrated(false)
                            ->visible(fn (string $operation): bool => $operation === 'edit'),
                    ])
                    ->columns(2),

                Section::make(__('admin.form.article_category.section_content'))
                    ->description(__('admin.form.article_category.section_content_desc'))
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('name', 'Nama', $locale)
                                    ->maxLength(255),
                            ],
                            label: __('admin.form.article_category.name_label'),
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('description', 'Deskripsi', $locale, 5, required: false)
                                    ->columnSpanFull(),
                            ],
                            label: __('admin.form.article_category.description'),
                            columns: 1,
                        ),
                    ]),

                Section::make(__('admin.form.article_category.section_media'))
                    ->description(__('admin.form.article_category.section_media_desc'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('category_image')
                            ->label(__('admin.form.article_category.image'))
                            ->collection(ArticleCategory::ImageCollection)
                            ->required()
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                        SpatieMediaLibraryFileUpload::make('category_gallery')
                            ->label(__('admin.form.article_category.gallery'))
                            ->collection(ArticleCategory::GalleryCollection)
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                    ])
                    ->columns(2),
            ]);
    }
}
