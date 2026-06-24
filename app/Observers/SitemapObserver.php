<?php

namespace App\Observers;

use App\Models\Article;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class SitemapObserver
{
    public function saved(Model $model): void
    {
        if (app()->environment('testing')) {
            return;
        }

        if ($model->wasRecentlyCreated) {
            if ($this->isEffectivelyPublished($model)) {
                Artisan::call('sitemap:generate');
            }

            return;
        }

        if ($model->wasChanged(array_merge(
            $model->translatable ?? [],
            ['is_published', 'slug'],
        ))) {
            Artisan::call('sitemap:generate');
        }
    }

    public function deleted(Model $model): void
    {
        if (app()->environment('testing')) {
            return;
        }

        Artisan::call('sitemap:generate');
    }

    private function isEffectivelyPublished(Model $model): bool
    {
        if ($model instanceof Product || $model instanceof Article || $model instanceof Project) {
            return (bool) $model->is_published;
        }

        return true;
    }
}
