<?php

namespace App\Http\Controllers;

use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;
use Inerba\DbConfig\DbConfig;

class AboutController extends Controller
{
    public function __invoke(SeoMetadataBuilder $metadata): View
    {
        $metadata->build(
            title: __('seo.about.title').' - '.__('site.company_name'),
            description: __('seo.about.description'),
        );

        return view('about', [
            'aboutPage' => DbConfig::getGroup('about-page') ?? [
                'gallery_images' => [],
                'youtube_url' => null,
            ],
        ]);
    }
}
