<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Inerba\DbConfig\AbstractPageSettings;
use UnitEnum;

class AboutPageSettings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected static ?string $title = 'Tentang Kami';

    protected static ?string $navigationLabel = 'Tentang Kami';

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?int $navigationSort = 2;

    protected function settingName(): string
    {
        return 'about-page';
    }

    /**
     * Provide default values.
     *
     * @return array<string, mixed>
     */
    public function getDefaultData(): array
    {
        return [
            'gallery_images' => [],
            'youtube_url' => null,
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Galeri Gambar')
                    ->description('Unggah gambar untuk galeri halaman tentang kami.')
                    ->schema([
                        FileUpload::make('gallery_images')
                            ->label('Gambar Galeri')
                            ->disk('public')
                            ->directory('about/gallery')
                            ->visibility('public')
                            ->multiple()
                            ->reorderable()
                            ->panelLayout('grid')
                            ->image()
                            ->automaticallyCropImagesToAspectRatio('16:10')
                            ->automaticallyResizeImagesMode('cover')
                            ->automaticallyResizeImagesToWidth('960')
                            ->automaticallyResizeImagesToHeight('600')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                    ]),

                Section::make('Video')
                    ->description('Tautan video YouTube untuk ditampilkan di halaman tentang kami.')
                    ->schema([
                        TextInput::make('youtube_url')
                            ->label('URL YouTube')
                            ->url()
                            ->maxLength(2048)
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }
}
