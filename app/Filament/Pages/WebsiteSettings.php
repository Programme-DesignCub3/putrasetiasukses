<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Inerba\DbConfig\AbstractPageSettings;
use Inerba\DbConfig\DbConfig;

class WebsiteSettings extends AbstractPageSettings
{
    public ?array $data = [];

    protected static ?int $navigationSort = 1;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan';

    public static function getNavigationLabel(): string
    {
        return __('admin.page.website_settings.navigation_label');
    }

    public function getTitle(): string
    {
        return __('admin.page.website_settings.title');
    }

    protected function settingName(): string
    {
        return 'website';
    }

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
            'footer_phones' => [],
            'whatsapp' => null,
        ];
    }

    public function save(): void
    {
        $oldData = DbConfig::getGroup($this->settingName()) ?? [];
        $state = $this->form->getState();

        collect($state)->each(function ($setting, $key) {
            DbConfig::set($this->settingName().'.'.$key, $setting);
        });

        $this->cleanRemovedFiles($oldData, $state);

        Notification::make()
            ->success()
            ->title(__('db-config::db-config.saved_title'))
            ->body(__('db-config::db-config.saved_body'))
            ->send();
    }

    protected function cleanRemovedFiles(array $old, array $new): void
    {
        $disk = 'public';

        $oldAbout = $old['about'] ?? [];
        $newAbout = $new['about'] ?? [];

        $this->deleteIfChanged($oldAbout['hero_image'] ?? null, $newAbout['hero_image'] ?? null, $disk);
        $this->deleteIfChanged($oldAbout['intro_image'] ?? null, $newAbout['intro_image'] ?? null, $disk);

        $oldGallery = $this->normalizeFiles($oldAbout['gallery_images'] ?? []);
        $newGallery = $this->normalizeFiles($newAbout['gallery_images'] ?? []);

        foreach ($oldGallery as $file) {
            if (! in_array($file, $newGallery)) {
                Storage::disk($disk)->delete($file);
            }
        }
    }

    protected function deleteIfChanged(?string $old, ?string $new, string $disk): void
    {
        if ($old && $old !== $new && Storage::disk($disk)->exists($old)) {
            Storage::disk($disk)->delete($old);
        }
    }

    protected function normalizeFiles(mixed $files): array
    {
        if (is_string($files)) {
            return json_decode($files, true) ?? [];
        }

        return $files ?? [];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.form.website_settings.section_contact'))
                    ->schema([
                        Repeater::make('footer_phones')
                            ->label(__('admin.form.website_settings.footer_phones'))
                            ->schema([
                                TextInput::make('label')
                                    ->label(__('admin.form.website_settings.label'))
                                    ->placeholder('Sales 1')
                                    ->maxLength(100)
                                    ->required(),
                                TextInput::make('number')
                                    ->label(__('admin.form.website_settings.number'))
                                    ->placeholder('0812-8438-805')
                                    ->maxLength(50)
                                    ->required(),
                            ])
                            ->columns(2)
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                            ->addActionLabel(__('admin.form.website_settings.add_phone'))
                            ->defaultItems(0)
                            ->collapsible(),
                        TextInput::make('whatsapp')
                            ->label(__('admin.form.website_settings.whatsapp'))
                            ->placeholder('628128438805')
                            ->helperText(__('admin.form.website_settings.whatsapp_helper'))
                            ->maxLength(50)
                            ->prefix('+'),
                    ]),
                Section::make(__('admin.form.website_settings.section_cookie'))
                    ->schema([
                        Toggle::make('analytics.cookie_consent_enabled')
                            ->label(__('admin.form.website_settings.cookie_consent'))
                            ->default(true),
                        TextInput::make('analytics.google_measurement_id')
                            ->label(__('admin.form.website_settings.google_analytics_id'))
                            ->placeholder('G-XXXXXXXXXX')
                            ->maxLength(50)
                            ->helperText(__('admin.form.website_settings.analytics_helper')),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }
}
