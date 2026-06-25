<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;

class ProjectController extends Controller
{
    public function index(SeoMetadataBuilder $metadata): View
    {
        $metadata->build(
            title: __('seo.projects.title').' - '.__('site.company_name'),
            description: __('seo.projects.description'),
            image: 'https://placehold.co/1400x320/2b2b2b/ffffff?text=Proyek',
        );

        $projects = Project::query()
            ->with(['categories', 'media'])
            ->where('is_published', true)
            ->ordered()
            ->get();

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    public function show(Project $project, SeoMetadataBuilder $metadata): View
    {
        abort_unless($project->is_published, 404);

        $project->load('media');
        $project->loadMissing('categories');

        $metadata->build(
            title: $project->name.' - '.__('site.company_name'),
            description: $project->description,
            image: $project->main_image_url,
        );

        return view('projects.show', [
            'project' => $project,
        ]);
    }
}
