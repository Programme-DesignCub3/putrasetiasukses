<?php

namespace App\Support\Sitemap\Sections;

use App\Models\Article;
use App\Support\Sitemap\Concerns\LocalizesUrls;
use App\Support\Sitemap\Contracts\SitemapSection;
use Spatie\Sitemap\Sitemap;

class ArticlesSection implements SitemapSection
{
    use LocalizesUrls;

    public function __invoke(Sitemap $sitemap): void
    {
        Article::query()
            ->where('is_published', true)
            ->with('categories')
            ->latest('published_at')
            ->get()
            ->each(fn (Article $article) => $this->addLocalizedUrl(
                $sitemap,
                'articles.show',
                ['article' => $article],
                $article->updated_at ?? $article->published_at,
                0.7
            ));
    }
}
