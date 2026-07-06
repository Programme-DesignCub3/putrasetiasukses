<?php

namespace App\Filament\Resources\Partners\Schemas;

use App\Models\Partner;
use App\Support\FilamentTranslatableFields;
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
                Section::make('Informasi Partner')
                    ->description('Data perusahaan mitra yang ditampilkan di halaman utama.')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                        TextInput::make('name')
                            ->label('Nama Perusahaan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('PT. Contoh Perusahaan'),
                    ])
                    ->columns(2),

                Section::make('Logo')
                    ->description('Format: JPG, PNG, WebP. Maks: 5MB. Ukuran ideal: 500x500px.')
                    ->schema([
                        ...FilamentTranslatableFields::localeImageUploads(
                            name: 'logo',
                            label: 'Logo Perusahaan',
                            collection: Partner::LogoCollection,
                            required: true,
                        ),
                    ]),
            ]);
    }
}
