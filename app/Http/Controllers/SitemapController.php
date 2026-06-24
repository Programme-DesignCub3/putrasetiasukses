<?php

namespace App\Http\Controllers;

use App\Support\Sitemap\SitemapBuilder;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        return response(SitemapBuilder::default()->build()->render(), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
