<?php

declare(strict_types=1);

namespace App\View\Components\Layouts;

use App\Support\SeoMetadataBuilder;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class App extends Component
{
    /**
     * @var array<string, string>
     */
    public array $alternateUrls = [];

    public ?string $canonicalUrl = null;

    public function __construct(
        SeoMetadataBuilder $metadata,
        public string $title,
        public string $bodyClass = '',
        public ?string $description = null,
        public ?string $image = null,
        public string $type = 'website',
        public mixed $publishedAt = null,
        public mixed $modifiedAt = null,
        public ?string $author = null,
        public ?string $section = null,
        public array $tags = [],
    ) {
        $result = $metadata->build(
            title: $title,
            description: $description,
            image: $image,
            type: $type,
            publishedAt: $publishedAt,
            modifiedAt: $modifiedAt,
            author: $author,
            section: $section,
            tags: $tags,
        );

        $this->canonicalUrl = $result['canonical_url'];
        $this->alternateUrls = $result['alternate_urls'];
    }

    public function render(): View|Closure|string
    {
        return view('layouts.app');
    }
}
