<?php

namespace App\Support;

use Illuminate\Support\Facades\App as Locale;

class HreflangLinks
{
    public function render(): string
    {
        $links = '';

        $route = request()->route();

        if (! $route || ! $route->getName()) {
            return '';
        }

        $supportedLocales = config('localizer.supported_locales', [app()->getLocale()]);
        $defaultLocale = $supportedLocales[0] ?? app()->getLocale();
        $currentLocale = Locale::getLocale();
        $routeName = $route->getName();
        $parameters = $route->parameters();
        $hideDefault = config('localizer.hide_default_locale', false);

        foreach ($supportedLocales as $locale) {
            $localeParams = $parameters;

            if ($locale === $defaultLocale && $hideDefault) {
                unset($localeParams['locale']);
            } else {
                $localeParams['locale'] = $locale;
            }

            try {
                Locale::setLocale($locale);
                $url = route($routeName, $localeParams);
            } finally {
                Locale::setLocale($currentLocale);
            }

            $hreflang = $locale === 'zh' ? 'zh-CN' : str_replace('_', '-', $locale);

            $links .= sprintf(
                '<link rel="alternate" hreflang="%s" href="%s" />',
                $hreflang,
                $url
            )."\n                ";
        }

        $defaultParams = $parameters;

        if ($hideDefault) {
            unset($defaultParams['locale']);
        } else {
            $defaultParams['locale'] = $defaultLocale;
        }

        try {
            Locale::setLocale($defaultLocale);
            $defaultUrl = route($routeName, $defaultParams);
        } finally {
            Locale::setLocale($currentLocale);
        }

        $links .= sprintf(
            '<link rel="alternate" hreflang="x-default" href="%s" />',
            $defaultUrl
        );

        return $links;
    }
}
