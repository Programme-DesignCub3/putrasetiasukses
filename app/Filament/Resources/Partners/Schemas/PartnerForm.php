<?php

namespace App\Filament\Resources\Partners\Schemas;

use App\Models\Partner;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.form.partner.section_info'))
                    ->description(__('admin.form.partner.section_info_desc'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('admin.form.partner.active'))
                            ->default(true),
                        TextInput::make('name')
                            ->label(__('admin.form.partner.company_name'))
                            ->required()
                            ->maxLength(255)
                            ->placeholder(__('admin.form.partner.company_placeholder')),
                    ])
                    ->columns(2),

                Section::make(__('admin.form.partner.section_logo'))
                    ->description(__('admin.form.partner.section_logo_desc'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->label(__('admin.form.partner.logo'))
                            ->collection(Partner::LogoCollection)
                            ->required()
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                    ]),
            ]);
    }
}
