<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Support\FilamentTranslatableFields;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.form.project.section_info'))
                    ->description(__('admin.form.project.section_info_desc'))
                    ->schema([
                        Select::make('categories')
                            ->label(__('admin.form.project.category'))
                            ->multiple()
                            ->relationship(
                                name: 'categories',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->where('is_active', true)->ordered(),
                            )
                            ->getOptionLabelFromRecordUsing(fn (ProjectCategory $record): string => $record->name)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),
                        Toggle::make('is_published')
                            ->label(__('admin.form.project.published'))
                            ->default(true),
                        TextInput::make('slug')
                            ->visible(fn (string $operation): bool => $operation === 'edit')
                            ->disabled(fn (Get $get): bool => ! $get('edit_slug'))
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText(__('admin.form.project.slug_helper')),
                        Toggle::make('edit_slug')
                            ->label(__('admin.form.project.edit_slug'))
                            ->default(false)
                            ->live()
                            ->dehydrated(false)
                            ->visible(fn (string $operation): bool => $operation === 'edit'),
                        TextInput::make('client')
                            ->label(__('admin.form.project.client'))
                            ->maxLength(255)
                            ->columnSpanFull(),
                        DatePicker::make('completion_date')
                            ->label(__('admin.form.project.completion_date')),
                    ])
                    ->columns(2),

                Section::make(__('admin.form.project.section_content'))
                    ->description(__('admin.form.project.section_content_desc'))
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('name', 'Nama', $locale)
                                    ->maxLength(255),
                            ],
                            label: __('admin.form.project.name_label'),
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('description', 'Deskripsi', $locale, 8)
                                    ->columnSpanFull(),
                            ],
                            label: __('admin.form.project.description_label'),
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('location', 'Lokasi', $locale)
                                    ->maxLength(255),
                            ],
                            label: __('admin.form.project.location'),
                            columns: 1,
                        ),
                    ]),

                Section::make(__('admin.form.project.section_media'))
                    ->description(__('admin.form.project.section_media_desc'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('main_image')
                            ->label(__('admin.form.project.main_image'))
                            ->collection(Project::MainImageCollection)
                            ->required()
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                        SpatieMediaLibraryFileUpload::make('gallery_media')
                            ->label(__('admin.form.project.gallery'))
                            ->collection(Project::GalleryCollection)
                            ->multiple()
                            ->reorderable()
                            ->panelLayout('grid')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                    ])
                    ->columns(2),

                Section::make(__('admin.form.project.section_body'))
                    ->description(__('admin.form.project.section_body_desc'))
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::richEditor('content', 'Konten', $locale)
                                    ->columnSpanFull(),
                            ],
                            label: __('admin.form.project.content_label'),
                            columns: 1,
                        ),
                    ]),
            ]);
    }
}
