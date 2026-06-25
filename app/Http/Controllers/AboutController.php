<?php

namespace App\Http\Controllers;

use App\Support\AboutPageContent;
use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function __invoke(SeoMetadataBuilder $metadata): View
    {
        $aboutPage = AboutPageContent::current();

        $metadata->build(
            title: __('seo.about.title').' - '.__('site.company_name'),
            description: $aboutPage->intro_text,
            image: $aboutPage->hero_image_url,
        );

        return view('about', [
            'aboutPage' => $aboutPage,
        ]);
    }
}
