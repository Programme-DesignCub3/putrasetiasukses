<?php

namespace App\Support\Sitemap\Sections;

use App\Models\Article;
use App\Models\Product;
use App\Support\Sitemap\Concerns\LocalizesUrls;
use App\Support\Sitemap\Contracts\SitemapSection;
use Spatie\Sitemap\Sitemap;

class StaticPagesSection implements SitemapSection
{
    use LocalizesUrls;

    public function __invoke(Sitemap $sitemap): void
    {
        $this->addLocalizedUrl($sitemap, 'home', priority: 1.0);
        $this->addLocalizedUrl($sitemap, 'about', priority: 0.8);
        $this->addLocalizedUrl($sitemap, 'products.index', lastModificationDate: $this->latestTimestamp(Product::query()->max('updated_at')), priority: 0.8);
        $this->addLocalizedUrl($sitemap, 'articles.index', lastModificationDate: $this->latestTimestamp(Article::query()->max('updated_at')), priority: 0.7);
        $this->addLocalizedUrl($sitemap, 'contact', priority: 0.6);
        $this->addLocalizedUrl($sitemap, 'search', priority: 0.5);
    }
}
