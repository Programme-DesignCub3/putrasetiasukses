<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Inerba\DbConfig\AbstractPageSettings;

class AboutPageSettings extends AbstractPageSettings
{
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    protected static ?string $title = 'About Page';

    // protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver'; // Uncomment if you want to set a custom navigation icon

    // protected ?string $subheading = ''; // Uncomment if you want to set a custom subheading

    // protected static ?string $slug = 'about-page-settings'; // Uncomment if you want to set a custom slug

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
        return [];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // You can delete these statements!
                Components\Text::make(new HtmlString(
                    View::make('db-config::filament.pages.settings-help', [
                        'group' => $this->settingName(),
                        'pageClass' => class_basename(self::class),
                    ])->render()
                )),
            ])
            ->statePath('data');
    }
}
