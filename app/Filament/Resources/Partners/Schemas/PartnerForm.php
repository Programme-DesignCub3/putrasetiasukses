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
                Section::make('Data Partner')
                    ->description('Informasi perusahaan mitra. Logo akan ditampilkan di halaman utama website.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Perusahaan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('PT. Contoh Perusahaan')
                            ->columnSpan(2),
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->label('Logo Perusahaan')
                            ->collection(Partner::LogoCollection)
                            ->image()
                            ->automaticallyResizeImagesMode('contain')
                            ->automaticallyCropImagesToAspectRatio('1:1')
                            ->automaticallyResizeImagesToWidth(200)
                            ->automaticallyResizeImagesToHeight(200)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->helperText('Format: JPG, PNG, WebP. Maks: 5MB. Ukuran ideal: 500×500px.')
                            ->columnSpan(1),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->inline(false)
                            ->default(true)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),
            ]);
    }
}
