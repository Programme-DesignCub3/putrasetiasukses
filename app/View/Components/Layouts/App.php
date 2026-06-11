<?php

declare(strict_types=1);

namespace App\View\Components\Layouts;

use Closure;
use Honeystone\Seo\Contracts\BuildsMetadata;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class App extends Component
{
    public function __construct(
        public string $title,
        public string $bodyClass = '',
        public ?string $description = null,
        public ?string $image = null,
        public string $type = 'website',
    ) {
        app()->forgetInstance(BuildsMetadata::class);

        $description = Str::limit(
            trim((string) ($description ?: config('seo.description'))),
            160,
            ''
        );

        $image ??= config('seo.image');

        seo()
            ->locale(str_replace('-', '_', app()->getLocale()))
            ->title($title, template: false)
            ->description($description)
            ->keywords(...config('seo.keywords', []))
            ->openGraphType($type)
            ->jsonLdType($type === 'article' ? 'Article' : 'WebPage');

        if ($image) {
            seo()->images($image);
        }
    }

    public function render(): View|Closure|string
    {
        return view('layouts.app');
    }
}
