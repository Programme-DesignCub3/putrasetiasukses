<?php

namespace App\Filament\Resources\HeroSlides\Schemas;

use App\Models\HeroSlide;
use App\Support\FilamentTranslatableFields;
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
                Section::make(__('admin.form.hero_slide.section_info'))
                    ->description(__('admin.form.hero_slide.section_info_desc'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('admin.form.hero_slide.active'))
                            ->default(true),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('label', 'Label', $locale)
                                    ->maxLength(255),
                            ],
                            label: __('admin.form.hero_slide.label'),
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('title', 'Judul', $locale)
                                    ->maxLength(255),
                            ],
                            label: __('admin.form.hero_slide.title'),
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('subtitle', 'Subjudul', $locale, 3)
                                    ->columnSpanFull(),
                            ],
                            label: __('admin.form.hero_slide.subtitle'),
                            columns: 1,
                        ),
                        TextInput::make('link')
                            ->label(__('admin.form.hero_slide.link'))
                            ->helperText(__('admin.form.hero_slide.link_helper'))
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make(__('admin.form.hero_slide.section_image'))
                    ->description(__('admin.form.hero_slide.section_image_desc'))
                    ->schema([
                        ...FilamentTranslatableFields::localeImageUploads(
                            name: 'hero_image',
                            label: __('admin.form.hero_slide.upload_image'),
                            collection: HeroSlide::ImageCollection,
                            required: true,
                        ),
                        TextInput::make('image')
                            ->label(__('admin.form.hero_slide.image_url'))
                            ->helperText(__('admin.form.hero_slide.image_url_helper'))
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }
}
