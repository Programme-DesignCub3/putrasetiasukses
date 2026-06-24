<?php

namespace App\Support\Sitemap\Sections;

use App\Models\Project;
use App\Support\Sitemap\Concerns\LocalizesUrls;
use App\Support\Sitemap\Contracts\SitemapSection;
use Spatie\Sitemap\Sitemap;

class ProjectsSection implements SitemapSection
{
    use LocalizesUrls;

    public function __invoke(Sitemap $sitemap): void
    {
        Project::query()
            ->where('is_published', true)
            ->with('categories')
            ->ordered()
            ->get()
            ->each(fn (Project $project) => $this->addLocalizedUrl(
                $sitemap,
                'projects.show',
                ['project' => $project],
                $project->updated_at,
                0.9
            ));
    }
}
