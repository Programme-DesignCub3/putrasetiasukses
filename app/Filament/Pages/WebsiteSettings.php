<?php

namespace App\Filament\Pages;

use App\Support\FilamentTranslatableFields;
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
        return 'website';
    }

    /**
     * @return array<string, mixed>
     */
    public function getDefaultData(): array
    {
        return [
            'site' => [
                'company_name' => ['id' => __('site.company_name'), 'en' => __('site.company_name', [], 'en'), 'zh' => __('site.company_name', [], 'zh')],
                'tagline' => ['id' => __('site.tagline'), 'en' => __('site.tagline', [], 'en'), 'zh' => __('site.tagline', [], 'zh')],
            ],
            'contact' => [
                'website_url' => __('site.website_url'),
                'email' => __('site.email'),
                'whatsapp_number' => __('site.whatsapp_number'),
                'phones' => [
                    ['label' => 'Sales 1', 'number' => '0812-8438-805'],
                    ['label' => 'Sales 2', 'number' => '0813-1485-5403'],
                    ['label' => 'Sales 3', 'number' => '0812-8550-9009'],
                    ['label' => 'Office', 'number' => '(021) 6667-1597-599'],
                ],
                'head_office_address' => ['id' => __('site.head_office_address'), 'en' => __('site.head_office_address', [], 'en'), 'zh' => __('site.head_office_address', [], 'zh')],
                'warehouse_address' => ['id' => __('site.warehouse_address'), 'en' => __('site.warehouse_address', [], 'en'), 'zh' => __('site.warehouse_address', [], 'zh')],
            ],
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
