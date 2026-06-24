<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Product;
use App\Models\Project;
use App\Observers\SitemapObserver;
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

        Product::observe(SitemapObserver::class);
        Article::observe(SitemapObserver::class);
        Project::observe(SitemapObserver::class);
    }
}
