<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ \NielsNumbers\LaravelLocalizer\Facades\Localizer::currentLocaleDirection() }}">

<head prefix="@openGraphPrefix">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $analyticsSettings = safe_db_config(\App\Support\SiteConfig::Group.'.analytics', [
            'cookie_consent_enabled' => config('services.cookie_consent.enabled', true),
            'google_measurement_id' => config('services.google_analytics.measurement_id'),
        ]);

        $siteAnalytics = [
            'googleMeasurementId' => $analyticsSettings['google_measurement_id'] ?: null,
            'cookieConsentEnabled' => (bool) ($analyticsSettings['cookie_consent_enabled'] ?? true),
        ];
    @endphp

    @metadata

    <script>
        window.siteAnalytics = {{ Illuminate\Support\Js::from($siteAnalytics) }};
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="{{ $bodyClass }}">
    {{ $slot }}

    <x-site.cookie-consent :enabled="$siteAnalytics['cookieConsentEnabled']" />

    @livewireScripts

    @stack('scripts')
</body>

</html>
