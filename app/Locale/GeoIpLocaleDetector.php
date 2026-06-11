<?php

declare(strict_types=1);

namespace App\Locale;

use Illuminate\Http\Request;
use NielsNumbers\LaravelLocalizer\Contracts\DetectorInterface;

class GeoIpLocaleDetector implements DetectorInterface
{
    public function detect(Request $request): ?string
    {
        $country = $this->countryCode($request);

        if ($country === null) {
            return $this->fallbackLocale();
        }

        return $this->countryLocales()[$country] ?? $this->fallbackLocale();
    }

    private function countryCode(Request $request): ?string
    {
        foreach ($this->countryHeaders() as $header) {
            $country = $request->headers->get($header);

            if (! is_string($country) || $country === '') {
                continue;
            }

            $country = strtoupper(substr($country, 0, 2));

            if (preg_match('/^[A-Z]{2}$/', $country) === 1) {
                return $country;
            }
        }

        return null;
    }

    /**
     * @return array<int, string>
     */
    private function countryHeaders(): array
    {
        return config('localizer.geoip.headers', []);
    }

    /**
     * @return array<string, string>
     */
    private function countryLocales(): array
    {
        return config('localizer.geoip.country_locales', []);
    }

    private function fallbackLocale(): ?string
    {
        return config('localizer.geoip.fallback_locale', config('app.fallback_locale'));
    }
}
