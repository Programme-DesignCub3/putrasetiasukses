<?php

namespace App\Observers;

use App\Jobs\RegenerateSitemap;
use App\Models\Article;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class SitemapObserver
{
    private static bool $dispatched = false;

    public function saved(Model $model): void
    {
        if (app()->environment('testing')) {
            return;
        }

        if ($model->wasRecentlyCreated) {
            if ($this->isEffectivelyPublished($model)) {
                $this->dispatch();
            }

            return;
        }

        if ($model->wasChanged(array_merge(
            $model->translatable ?? [],
            ['is_published', 'slug'],
        ))) {
            $this->dispatch();
        }
    }

    public function deleted(Model $model): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $this->dispatch();
    }

    private function dispatch(): void
    {
        if (self::$dispatched) {
            return;
        }

        self::$dispatched = true;

        RegenerateSitemap::dispatch()->afterCommit();
    }

    private function isEffectivelyPublished(Model $model): bool
    {
        if ($model instanceof Product || $model instanceof Article || $model instanceof Project) {
            return (bool) $model->is_published;
        }

        return true;
    }
}
