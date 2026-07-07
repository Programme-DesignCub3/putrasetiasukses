<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

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

        foreach ($supportedLocales as $locale) {
            $hreflang = $locale === 'zh' ? 'zh-CN' : str_replace('_', '-', $locale);

            $links .= sprintf(
                '<link rel="alternate" hreflang="%s" href="%s" />',
                $hreflang,
                Route::localizedUrl($locale)
            )."\n                ";
        }

        $links .= sprintf(
            '<link rel="alternate" hreflang="x-default" href="%s" />',
            Route::localizedUrl($defaultLocale)
        );

        return $links;
    }
}
