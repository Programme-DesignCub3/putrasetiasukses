<?php

namespace App\Support;

use Honeystone\Seo\Contracts\BuildsMetadata;
use Honeystone\Seo\OpenGraph\ArticleProperties;
use Honeystone\Seo\OpenGraph\ProfileProperties;
use Illuminate\Support\Facades\App as Locale;
use Illuminate\Support\Str;

class SeoMetadataBuilder
{
    /**
     * @param  array<int, string>  $tags
     * @return array{canonical_url: string, alternate_urls: array<string, string>}
     */
    public function build(
        string $title,
        ?string $description = null,
        ?string $image = null,
        string $type = 'website',
        mixed $publishedAt = null,
        mixed $modifiedAt = null,
        ?string $author = null,
        ?string $section = null,
        array $tags = [],
    ): array {
        app()->forgetInstance(BuildsMetadata::class);

        $description = Str::limit(
            trim((string) ($description ?: config('seo.description'))),
            160,
            ''
        );

        $image ??= config('seo.image');
        $canonicalUrl = $this->canonicalUrl();
        $alternateUrls = $this->alternateUrls();

        seo()
            ->locale(str_replace('-', '_', app()->getLocale()))
            ->title($title, template: false)
            ->description($description)
            ->keywords(...config('seo.keywords', []))
            ->canonical($canonicalUrl)
            ->openGraphType($this->openGraphType($type, $publishedAt, $modifiedAt, $author, $section, $tags))
            ->openGraphAlternateLocales($this->openGraphAlternateLocales())
            ->jsonLdType($type === 'article' ? 'Article' : 'WebPage')
            ->jsonLdProperty('inLanguage', app()->getLocale());

        if ($image) {
            seo()->images($image);
        }

        $this->addArticleStructuredData($type, $publishedAt, $modifiedAt, $author, $section, $tags);

        return [
            'canonical_url' => $canonicalUrl,
            'alternate_urls' => $alternateUrls,
        ];
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

    /**
     * @param  array<int, string>  $tags
     */
    private function openGraphType(
        string $type,
        mixed $publishedAt,
        mixed $modifiedAt,
        ?string $author,
        ?string $section,
        array $tags,
    ): string|ArticleProperties {
        if ($type !== 'article') {
            return $type;
        }

        return new ArticleProperties(
            publishedTime: $publishedAt,
            modifiedTime: $modifiedAt,
            author: $author ? new ProfileProperties(username: $author) : null,
            section: $section,
            tag: $tags,
        );
    }

    /**
     * @param  array<int, string>  $tags
     */
    private function addArticleStructuredData(
        string $type,
        mixed $publishedAt,
        mixed $modifiedAt,
        ?string $author,
        ?string $section,
        array $tags,
    ): void {
        if ($type !== 'article') {
            return;
        }

        if ($publishedAt) {
            seo()->jsonLdProperty('datePublished', $this->dateForMetadata($publishedAt));
        }

        if ($modifiedAt) {
            seo()->jsonLdProperty('dateModified', $this->dateForMetadata($modifiedAt));
        }

        if ($author) {
            seo()->jsonLdProperty('author', [
                '@type' => 'Person',
                'name' => $author,
            ]);
        }

        if ($section) {
            seo()->jsonLdProperty('articleSection', $section);
        }

        if ($tags !== []) {
            seo()->jsonLdProperty('keywords', $tags);
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
