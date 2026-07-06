<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Support\FilamentTranslatableFields;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.form.product.section_info'))
                    ->description(__('admin.form.product.section_info_desc'))
                    ->schema([
                        Select::make('categories')
                            ->label(__('admin.form.product.category'))
                            ->multiple()
                            ->relationship(
                                name: 'categories',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->where('is_active', true)->ordered(),
                            )
                            ->getOptionLabelFromRecordUsing(fn (ProductCategory $record): string => $record->name)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),
                        Toggle::make('is_published')
                            ->label(__('admin.form.product.published'))
                            ->default(true),
                        TextInput::make('slug')
                            ->visible(fn (string $operation): bool => $operation === 'edit')
                            ->disabled(fn (Get $get): bool => ! $get('edit_slug'))
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText(__('admin.form.product.slug_helper')),
                        Toggle::make('edit_slug')
                            ->label(__('admin.form.product.edit_slug'))
                            ->default(false)
                            ->live()
                            ->dehydrated(false)
                            ->visible(fn (string $operation): bool => $operation === 'edit'),
                    ])
                    ->columns(2),

                Section::make(__('admin.form.product.section_content'))
                    ->description(__('admin.form.product.section_content_desc'))
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('name', 'Nama', $locale)
                                    ->maxLength(255),
                            ],
                            label: __('admin.form.product.name_label'),
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('description', 'Deskripsi', $locale, rows: 4)
                                    ->columnSpanFull(),
                            ],
                            label: __('admin.form.product.description_label'),
                            columns: 1,
                        ),
                    ]),

                Section::make(__('admin.form.product.section_media'))
                    ->description(__('admin.form.product.section_media_desc'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('main_image')
                            ->label(__('admin.form.product.main_image'))
                            ->collection(Product::MainImageCollection)
                            ->required()
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                        SpatieMediaLibraryFileUpload::make('gallery_media')
                            ->label(__('admin.form.product.gallery'))
                            ->collection(Product::GalleryCollection)
                            ->multiple()
                            ->reorderable()
                            ->panelLayout('grid')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                    ])
                    ->columns(2),
            ]);
    }
}
