<?php

namespace App\Http\Controllers;

use App\Support\SitemapBuilder;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(SitemapBuilder $sitemapBuilder): Response
    {
        return response($sitemapBuilder->build()->render(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
