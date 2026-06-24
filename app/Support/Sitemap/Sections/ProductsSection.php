<?php

namespace App\Support\Sitemap\Sections;

use App\Models\Product;
use App\Support\Sitemap\Concerns\LocalizesUrls;
use App\Support\Sitemap\Contracts\SitemapSection;
use Spatie\Sitemap\Sitemap;

class ProductsSection implements SitemapSection
{
    use LocalizesUrls;

    public function __invoke(Sitemap $sitemap): void
    {
        Product::query()
            ->where('is_published', true)
            ->with('categories')
            ->ordered()
            ->get()
            ->each(fn (Product $product) => $this->addLocalizedUrl(
                $sitemap,
                'products.show',
                ['product' => $product],
                $product->updated_at,
                0.9
            ));
    }
}
