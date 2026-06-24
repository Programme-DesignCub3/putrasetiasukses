<?php

namespace App\Http\Controllers;

use App\Support\AboutPageContent;
use App\Support\SeoMetadataBuilder;
use App\Support\SiteConfig;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function __invoke(SeoMetadataBuilder $metadata): View
    {
        $site = SiteConfig::current();
        $aboutPage = AboutPageContent::current();

        $metadata->build(
            title: __('about.title').' - '.$site->company_name,
            description: $aboutPage->intro_text,
            image: $aboutPage->hero_image_url,
        );

        return view('about', [
            'site' => $site,
            'aboutPage' => $aboutPage,
        ]);
    }
}
