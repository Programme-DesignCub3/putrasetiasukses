<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Support\SiteConfig;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        return view('about', [
            'site' => SiteConfig::current(),
            'aboutPage' => AboutPage::published(),
        ]);
    }
}
