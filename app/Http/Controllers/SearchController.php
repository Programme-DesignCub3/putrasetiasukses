<?php

namespace App\Http\Controllers;

use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;

class SearchController extends Controller
{
    public function __invoke(SeoMetadataBuilder $metadata): View
    {
        $metadata->build(
            title: __('seo.search.title').' - '.__('site.company_name'),
            description: __('seo.search.description'),
        );

        return view('search.index');
    }
}
