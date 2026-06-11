<?php

declare(strict_types=1);

use App\Locale\GeoIpLocaleDetector;
use NielsNumbers\LaravelLocalizer\Detectors\BrowserDetector;
use NielsNumbers\LaravelLocalizer\Detectors\UserDetector;

return [
    'supported_locales' => ['id', 'en', 'zh'],

    'hide_default_locale' => true,

    'redirect_enabled' => true,

    'persist_locale' => [
        'session' => true,
        'cookie' => true,
    ],

    'detectors' => [
        UserDetector::class,
        GeoIpLocaleDetector::class,
        BrowserDetector::class,
    ],

    'geoip' => [
        'fallback_locale' => 'id',

        'headers' => [
            'CF-IPCountry',
            'CloudFront-Viewer-Country',
            'X-Appengine-Country',
            'X-Vercel-IP-Country',
            'X-Country-Code',
        ],

        'country_locales' => [
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
        ],
    ],

    'locale_directions' => [
        'id' => 'ltr',
        'en' => 'ltr',
        'zh' => 'ltr',
    ],
];
