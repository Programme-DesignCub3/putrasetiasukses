<?php

namespace App\Filament\Pages;

use App\Support\SiteConfig;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
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
        return SiteConfig::defaults();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Brand')
                    ->schema([
                        TextInput::make('site.company_name.id')
                            ->label('Company name (ID)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('site.company_name.en')
                            ->label('Company name (EN)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('site.company_name.zh')
                            ->label('Company name (ZH)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('site.tagline.id')
                            ->label('Tagline (ID)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('site.tagline.en')
                            ->label('Tagline (EN)')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('site.tagline.zh')
                            ->label('Tagline (ZH)')
                            ->required()
                            ->maxLength(255),
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
                        Textarea::make('contact.head_office_address.id')
                            ->label('Head Office (ID)')
                            ->required()
                            ->rows(3),
                        Textarea::make('contact.head_office_address.en')
                            ->label('Head Office (EN)')
                            ->required()
                            ->rows(3),
                        Textarea::make('contact.head_office_address.zh')
                            ->label('Head Office (ZH)')
                            ->required()
                            ->rows(3),
                        Textarea::make('contact.warehouse_address.id')
                            ->label('Warehouse (ID)')
                            ->required()
                            ->rows(3),
                        Textarea::make('contact.warehouse_address.en')
                            ->label('Warehouse (EN)')
                            ->required()
                            ->rows(3),
                        Textarea::make('contact.warehouse_address.zh')
                            ->label('Warehouse (ZH)')
                            ->required()
                            ->rows(3),
                    ])
                    ->columns(3),

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
