<?php

namespace App\Providers;

use App\Support\FilamentTranslatableFields;
use Illuminate\Support\ServiceProvider;
use SolutionForest\FilamentTranslateField\Facades\FilamentTranslateField;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentTranslateField::defaultLocales(FilamentTranslatableFields::locales())
            ->getLocaleLabelUsing(fn (string $locale): ?string => FilamentTranslatableFields::localeLabels()[$locale] ?? null);
    }
}
