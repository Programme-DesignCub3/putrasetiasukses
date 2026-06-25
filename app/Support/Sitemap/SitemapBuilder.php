<?php

namespace App\Support\Sitemap;

use App\Support\Sitemap\Contracts\SitemapSection;
use App\Support\Sitemap\Sections\ArticlesSection;
use App\Support\Sitemap\Sections\ProductsSection;
use App\Support\Sitemap\Sections\ProjectsSection;
use App\Support\Sitemap\Sections\StaticPagesSection;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;

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

    public function build(?string $dir = null): SitemapIndex
    {
        $dir ??= public_path();

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $index = SitemapIndex::create();

        foreach ($this->sections as $section) {
            $sitemap = Sitemap::create();
            $section($sitemap);
            $filename = $this->filename($section);
            $sitemap->writeToFile($dir.'/'.$filename);
            $index->add(url($filename));
        }

        $index->writeToFile($dir.'/sitemap.xml');

        return $index;
    }

    public function render(): string
    {
        $index = SitemapIndex::create();

        foreach ($this->sections as $section) {
            $sitemap = Sitemap::create();
            $section($sitemap);
            $filename = $this->filename($section);
            $index->add(url($filename));
        }

        return $index->render();
    }

    private function filename(SitemapSection $section): string
    {
        return match ($section::class) {
            StaticPagesSection::class => 'sitemap_static.xml',
            ProductsSection::class => 'sitemap_products.xml',
            ArticlesSection::class => 'sitemap_articles.xml',
            ProjectsSection::class => 'sitemap_projects.xml',
        };
    }
}
