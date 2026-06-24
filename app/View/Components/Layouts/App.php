<?php

declare(strict_types=1);

namespace App\View\Components\Layouts;

use Closure;
use Honeystone\Seo\Contracts\BuildsMetadata;
use Honeystone\Seo\OpenGraph\ArticleProperties;
use Honeystone\Seo\OpenGraph\ProfileProperties;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App as Locale;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class App extends Component
{
    /**
     * @var array<string, string>
     */
    public array $alternateUrls = [];

    public ?string $canonicalUrl = null;

    public function __construct(
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
        app()->forgetInstance(BuildsMetadata::class);

        $description = Str::limit(
            trim((string) ($description ?: config('seo.description'))),
            160,
            ''
        );

        $image ??= config('seo.image');
        $this->canonicalUrl = $this->canonicalUrl();
        $this->alternateUrls = $this->alternateUrls();

        seo()
            ->locale(str_replace('-', '_', app()->getLocale()))
            ->title($title, template: false)
            ->description($description)
            ->keywords(...config('seo.keywords', []))
            ->canonical($this->canonicalUrl)
            ->openGraphType($this->openGraphType())
            ->openGraphAlternateLocales($this->openGraphAlternateLocales())
            ->jsonLdType($type === 'article' ? 'Article' : 'WebPage')
            ->jsonLdProperty('inLanguage', app()->getLocale());

        if ($image) {
            seo()->images($image);
        }

        $this->addArticleStructuredData();
    }

    public function render(): View|Closure|string
    {
        return view('layouts.app');
    }

    private function canonicalUrl(): string
    {
        return $this->localizedUrlFor(app()->getLocale()) ?? url()->current();
    }

    /**
     * @return array<string, string>
     */
    private function alternateUrls(): array
    {
        $urls = collect(config('localizer.supported_locales', [app()->getLocale()]))
            ->mapWithKeys(fn (string $locale): array => [
                $this->hreflang($locale) => $this->localizedUrlFor($locale),
            ])
            ->filter()
            ->all();

        if ($urls !== []) {
            $defaultLocale = config('localizer.supported_locales.0', app()->getLocale());
            $urls['x-default'] = $this->localizedUrlFor($defaultLocale);
        }

        return array_filter($urls);
    }

    private function localizedUrlFor(string $locale): ?string
    {
        $route = request()->route();
        $routeName = $route?->getName();

        if (! $routeName) {
            return null;
        }

        $currentLocale = Locale::getLocale();
        $parameters = $this->localizedParameters($route->parameters(), $locale);

        try {
            Locale::setLocale($locale);

            return route($routeName, $parameters);
        } finally {
            Locale::setLocale($currentLocale);
        }
    }

    /**
     * @return array<int, string>
     */
    private function openGraphAlternateLocales(): array
    {
        return collect(config('localizer.supported_locales', []))
            ->reject(fn (string $locale): bool => $locale === app()->getLocale())
            ->map(fn (string $locale): string => str_replace('-', '_', $this->hreflang($locale)))
            ->values()
            ->all();
    }

    private function hreflang(string $locale): string
    {
        return match ($locale) {
            'zh' => 'zh-CN',
            default => str_replace('_', '-', $locale),
        };
    }

    private function openGraphType(): string|ArticleProperties
    {
        if ($this->type !== 'article') {
            return $this->type;
        }

        return new ArticleProperties(
            publishedTime: $this->publishedAt,
            modifiedTime: $this->modifiedAt,
            author: $this->author ? new ProfileProperties(username: $this->author) : null,
            section: $this->section,
            tag: $this->tags,
        );
    }

    private function addArticleStructuredData(): void
    {
        if ($this->type !== 'article') {
            return;
        }

        if ($this->publishedAt) {
            seo()->jsonLdProperty('datePublished', $this->dateForMetadata($this->publishedAt));
        }

        if ($this->modifiedAt) {
            seo()->jsonLdProperty('dateModified', $this->dateForMetadata($this->modifiedAt));
        }

        if ($this->author) {
            seo()->jsonLdProperty('author', [
                '@type' => 'Person',
                'name' => $this->author,
            ]);
        }

        if ($this->section) {
            seo()->jsonLdProperty('articleSection', $this->section);
        }

        if ($this->tags !== []) {
            seo()->jsonLdProperty('keywords', $this->tags);
        }
    }

    private function dateForMetadata(mixed $value): string
    {
        if (is_object($value) && method_exists($value, 'toAtomString')) {
            return $value->toAtomString();
        }

        return (string) $value;
    }

    /**
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    private function localizedParameters(array $parameters, string $locale): array
    {
        $defaultLocale = config('localizer.supported_locales.0', app()->getLocale());

        if ($locale === $defaultLocale && config('localizer.hide_default_locale', false)) {
            unset($parameters['locale']);

            return $parameters;
        }

        $parameters['locale'] = $locale;

        return $parameters;
    }
}
