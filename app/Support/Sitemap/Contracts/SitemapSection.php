<?php

namespace App\Support\Sitemap\Contracts;

use Spatie\Sitemap\Sitemap;

interface SitemapSection
{
    public function __invoke(Sitemap $sitemap): void;
}
