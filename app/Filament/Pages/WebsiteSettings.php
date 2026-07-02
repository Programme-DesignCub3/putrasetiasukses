<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Inerba\DbConfig\AbstractPageSettings;
use Inerba\DbConfig\DbConfig;
use UnitEnum;

class WebsiteSettings extends AbstractPageSettings
{
    public ?array $data = [];

    protected static ?string $title = 'Website Settings';

    protected static ?string $navigationLabel = 'Website Settings';

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 1;

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
