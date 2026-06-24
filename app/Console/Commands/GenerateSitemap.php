<?php

namespace App\Console\Commands;

use App\Support\Sitemap\SitemapBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {--path=sitemap.xml : Path relative to the public directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a static sitemap XML file for all configured locales';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $relativePath = trim((string) $this->option('path'), '/\\');
        $path = public_path($relativePath);

        File::ensureDirectoryExists(dirname($path));
        File::put($path, SitemapBuilder::default()->build()->render());

        $this->components->info("Sitemap generated at [{$path}].");

        return self::SUCCESS;
    }
}
