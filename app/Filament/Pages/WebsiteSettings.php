<?php

namespace App\Filament\Pages;

use App\Support\FilamentTranslatableFields;
use App\Support\SiteConfig;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Inerba\DbConfig\AbstractPageSettings;

class WebsiteSettings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    protected static ?string $title = 'Website Settings';

    protected static ?string $navigationLabel = 'Website Settings';

    protected static ?int $navigationSort = 90;

    protected function settingName(): string
    {
        return SiteConfig::Group;
    }

    /**
     * @return array<string, mixed>
     */
    public function getDefaultData(): array
    {
        $defaults = SiteConfig::defaults();

        $defaults['about']['hero_image'] = null;
        $defaults['about']['intro_image'] = null;
        $defaults['about']['gallery_images'] = [];

        return $defaults;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Brand')
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textInput('site.company_name', 'Company name', $locale)
                                    ->maxLength(255),
                                FilamentTranslatableFields::textInput('site.tagline', 'Tagline', $locale)
                                    ->maxLength(255),
                            ],
                            label: 'Brand Copy',
                        ),
                    ])
                    ->columns(3),

                Section::make('Kontak')
                    ->schema([
                        TextInput::make('contact.website_url')
                            ->label('Website')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('contact.email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('contact.whatsapp_number')
                            ->label('WhatsApp')
                            ->required()
                            ->maxLength(50),
                        Repeater::make('contact.phones')
                            ->label('Nomor Telepon')
                            ->schema([
                                TextInput::make('label')
                                    ->required()
                                    ->maxLength(50),
                                TextInput::make('number')
                                    ->required()
                                    ->maxLength(50),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('Alamat')
                    ->schema([
                        FilamentTranslatableFields::translate(
                            fn (string $locale): array => [
                                FilamentTranslatableFields::textarea('contact.head_office_address', 'Head Office', $locale, 3),
                                FilamentTranslatableFields::textarea('contact.warehouse_address', 'Warehouse', $locale, 3),
                            ],
                            label: 'Alamat',
                        ),
                    ])
                    ->columns(3),

                Section::make('Tentang Kami Media')
                    ->schema([
                        FileUpload::make('about.hero_image')
                            ->label('Hero image')
                            ->disk('public')
                            ->directory('about')
                            ->visibility('public')
                            ->image()
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1600')
                            ->imageResizeTargetHeight('900')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                        FileUpload::make('about.intro_image')
                            ->label('Intro image')
                            ->disk('public')
                            ->directory('about')
                            ->visibility('public')
                            ->image()
                            ->imageCropAspectRatio('4:5')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('960')
                            ->imageResizeTargetHeight('1200')
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
                            ->imageCropAspectRatio('16:10')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('960')
                            ->imageResizeTargetHeight('600')
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
