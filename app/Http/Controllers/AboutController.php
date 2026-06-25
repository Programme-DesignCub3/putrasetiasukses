<?php

namespace App\Http\Controllers;

use App\Support\AboutPageContent;
use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function __invoke(SeoMetadataBuilder $metadata): View
    {
        $site = site_config();
        $aboutPage = AboutPageContent::current();

        $metadata->build(
            title: __('seo.about.title').' - '.$site->company_name,
            description: $aboutPage->intro_text,
            image: $aboutPage->hero_image_url,
        );

        return view('about', [
            'site' => $site,
            'aboutPage' => $aboutPage,
        ]);
    }
}
