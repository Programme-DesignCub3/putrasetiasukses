<?php

namespace App\Console\Commands;

use App\Support\Sitemap\SitemapBuilder;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {--dir= : Output directory relative to public}';

    protected $description = 'Generate sitemap index + sub-sitemaps for all configured locales';

    public function handle(): int
    {
        $dir = $this->option('dir');

        if ($dir !== null) {
            $dir = public_path(trim($dir, '/\\'));
        }

        SitemapBuilder::default()->build($dir);

        $this->components->info('Sitemap index and sub-sitemaps generated.');

        return self::SUCCESS;
    }
}
