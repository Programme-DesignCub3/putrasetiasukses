<?php

namespace App\Support\Sitemap;

use App\Support\Sitemap\Contracts\SitemapSection;
use App\Support\Sitemap\Sections\ArticlesSection;
use App\Support\Sitemap\Sections\ProductsSection;
use App\Support\Sitemap\Sections\ProjectsSection;
use App\Support\Sitemap\Sections\StaticPagesSection;
use Spatie\Sitemap\Sitemap;

class SitemapBuilder
{
    /** @var array<int, SitemapSection> */
    private array $sections;

    public function __construct(SitemapSection ...$sections)
    {
        $this->sections = $sections;
    }

    public static function default(): self
    {
        return new self(
            new StaticPagesSection,
            new ProductsSection,
            new ArticlesSection,
            new ProjectsSection,
        );
    }

    public function build(): Sitemap
    {
        $sitemap = Sitemap::create();

        foreach ($this->sections as $section) {
            $section($sitemap);
        }

        return $sitemap;
    }
}
