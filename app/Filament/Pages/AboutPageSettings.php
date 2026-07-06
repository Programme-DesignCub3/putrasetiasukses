<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Inerba\DbConfig\AbstractPageSettings;
use Inerba\DbConfig\DbConfig;

class AboutPageSettings extends AbstractPageSettings
{
    public ?array $data = [];

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?int $navigationSort = 2;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan';

    public static function getNavigationLabel(): string
    {
        return __('admin.page.about_page_settings.navigation_label');
    }

    public function getTitle(): string
    {
        return __('admin.page.about_page_settings.title');
    }

    protected function settingName(): string
    {
        return 'about-page';
    }

    public function getDefaultData(): array
    {
        return [
            'gallery_images' => [],
            'youtube_url' => null,
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

        $oldGallery = $this->normalizeFiles($old['gallery_images'] ?? []);
        $newGallery = $this->normalizeFiles($new['gallery_images'] ?? []);

        foreach ($oldGallery as $file) {
            if (! in_array($file, $newGallery)) {
                Storage::disk($disk)->delete($file);
            }
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
                Section::make(__('admin.form.about_settings.section_gallery'))
                    ->description(__('admin.form.about_settings.section_gallery_desc'))
                    ->schema([
                        FileUpload::make('gallery_images')
                            ->label(__('admin.form.about_settings.gallery_images'))
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

                Section::make(__('admin.form.about_settings.section_video'))
                    ->description(__('admin.form.about_settings.section_video_desc'))
                    ->schema([
                        TextInput::make('youtube_url')
                            ->label(__('admin.form.about_settings.youtube_url'))
                            ->url()
                            ->maxLength(2048)
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }
}
