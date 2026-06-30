<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Inerba\DbConfig\AbstractPageSettings;
use UnitEnum;

class WebsiteSettings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    protected static ?string $title = 'Website Settings';

    protected static ?string $navigationLabel = 'Website Settings';

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 1;

    protected function settingName(): string
    {
        return 'website';
    }

    /**
     * @return array<string, mixed>
     */
    public function getDefaultData(): array
    {
        return [
            'about' => [
                'hero_image' => null,
                'intro_image' => null,
                'gallery_images' => [],
                'video_url' => null,
            ],
            'analytics' => [
                'cookie_consent_enabled' => true,
                'google_measurement_id' => config('services.google_analytics.measurement_id'),
            ],
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tentang Kami Media')
                    ->schema([
                        FileUpload::make('about.hero_image')
                            ->label('Hero image')
                            ->disk('public')
                            ->directory('about')
                            ->visibility('public')
                            ->image()
                            ->automaticallyCropImagesToAspectRatio('16:9')
                            ->automaticallyResizeImagesMode('cover')
                            ->automaticallyResizeImagesToWidth('1600')
                            ->automaticallyResizeImagesToHeight('900')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                        FileUpload::make('about.intro_image')
                            ->label('Intro image')
                            ->disk('public')
                            ->directory('about')
                            ->visibility('public')
                            ->image()
                            ->automaticallyCropImagesToAspectRatio('4:5')
                            ->automaticallyResizeImagesMode('cover')
                            ->automaticallyResizeImagesToWidth('960')
                            ->automaticallyResizeImagesToHeight('1200')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                        FileUpload::make('about.gallery_images')
                            ->label('Gallery images')
                            ->disk('public')
                            ->directory('about/gallery')
                            ->visibility('public')
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->automaticallyCropImagesToAspectRatio('16:10')
                            ->automaticallyResizeImagesMode('cover')
                            ->automaticallyResizeImagesToWidth('960')
                            ->automaticallyResizeImagesToHeight('600')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpanFull(),
                        TextInput::make('about.video_url')
                            ->label('Video URL')
                            ->url()
                            ->maxLength(2048)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Cookie dan Analytics')
                    ->schema([
                        Toggle::make('analytics.cookie_consent_enabled')
                            ->label('Tampilkan cookie consent')
                            ->default(true),
                        TextInput::make('analytics.google_measurement_id')
                            ->label('Google Analytics Measurement ID')
                            ->placeholder('G-XXXXXXXXXX')
                            ->maxLength(50)
                            ->helperText('Script Google Analytics hanya dimuat setelah pengunjung menyetujui analitik.'),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }
}
