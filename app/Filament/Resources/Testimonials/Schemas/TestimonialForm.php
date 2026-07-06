<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use App\Support\FilamentTranslatableFields;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.form.testimonial.section_info'))
                    ->description(__('admin.form.testimonial.section_info_desc'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('admin.form.testimonial.active'))
                            ->default(true),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('name', 'Nama', $locale)
                                    ->maxLength(255),
                            ],
                            label: __('admin.form.testimonial.name'),
                            columns: 1,
                        ),
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('content', 'Testimonial', $locale, rows: 4)
                                    ->columnSpanFull(),
                            ],
                            label: __('admin.form.testimonial.content'),
                            columns: 1,
                        ),
                    ]),
            ]);
    }
}
