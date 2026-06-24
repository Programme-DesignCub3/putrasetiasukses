<?php

namespace App\Support\Sitemap\Concerns;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Facades\App;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

trait LocalizesUrls
{
    protected function addLocalizedUrl(
        Sitemap $sitemap,
        string $routeName,
        array $parameters = [],
        ?DateTimeInterface $lastModificationDate = null,
        float $priority = 0.5,
    ): void {
        $locales = config('localizer.supported_locales', ['id']);
        $defaultLocale = $locales[0] ?? 'id';
        $currentLocale = App::getLocale();
        $urls = [];

        foreach ($locales as $locale) {
            $urls[$locale] = $this->localizedRoute($routeName, $parameters, $locale);
        }

        $url = Url::create($urls[$defaultLocale])
            ->setPriority($priority)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY);

        if ($lastModificationDate instanceof DateTimeInterface) {
            $url->setLastModificationDate($lastModificationDate);
        }

        foreach ($urls as $locale => $localizedUrl) {
            $url->addAlternate($localizedUrl, $this->hreflang($locale));
        }

        $url->addAlternate($urls[$defaultLocale], 'x-default');
        $sitemap->add($url);

        App::setLocale($currentLocale);
    }

    protected function localizedRoute(string $routeName, array $parameters, string $locale): string
    {
        App::setLocale($locale);

        return route($routeName, $this->localizedParameters($parameters, $locale));
    }

    protected function hreflang(string $locale): string
    {
        return match ($locale) {
            'zh' => 'zh-CN',
            default => str_replace('_', '-', $locale),
        };
    }

    protected function localizedParameters(array $parameters, string $locale): array
    {
        $defaultLocale = config('localizer.supported_locales.0', 'id');

        if ($locale === $defaultLocale && config('localizer.hide_default_locale', false)) {
            unset($parameters['locale']);

            return $parameters;
        }

        $parameters['locale'] = $locale;

        return $parameters;
    }

    protected function latestTimestamp(mixed $value): ?DateTimeInterface
    {
        if ($value instanceof DateTimeInterface) {
            return $value;
        }

        if (is_string($value) && $value !== '') {
            return Carbon::parse($value);
        }

        return null;
    }
}
