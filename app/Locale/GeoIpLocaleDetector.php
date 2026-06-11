<?php

declare(strict_types=1);

namespace App\Locale;

use Illuminate\Http\Request;
use NielsNumbers\LaravelLocalizer\Contracts\DetectorInterface;

class GeoIpLocaleDetector implements DetectorInterface
{
    /**
     * @var array<string, string>
     */
    private const COUNTRY_LOCALES = [
        'CN' => 'zh',
        'HK' => 'zh',
        'MO' => 'zh',
        'TW' => 'zh',
        'ID' => 'id',
        'MY' => 'id',
        'SG' => 'en',
        'AU' => 'en',
        'CA' => 'en',
        'GB' => 'en',
        'NZ' => 'en',
        'US' => 'en',
    ];

    public function detect(Request $request): ?string
    {
        $country = $this->countryCode($request);

        if ($country === null) {
            return null;
        }

        return self::COUNTRY_LOCALES[$country] ?? null;
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
        return [
            'CF-IPCountry',
            'CloudFront-Viewer-Country',
            'X-Appengine-Country',
            'X-Vercel-IP-Country',
            'X-Country-Code',
        ];
    }
}
