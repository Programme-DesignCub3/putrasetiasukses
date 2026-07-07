<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ \NielsNumbers\LaravelLocalizer\Facades\Localizer::currentLocaleDirection() }}">

<head prefix="@openGraphPrefix">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $analyticsSettings = safe_db_config('website.analytics', [
            'cookie_consent_enabled' => config('services.cookie_consent.enabled', true),
            'google_measurement_id' => config('services.google_analytics.measurement_id'),
        ]);

        $siteAnalytics = [
            'googleMeasurementId' => $analyticsSettings['google_measurement_id'] ?: null,
            'cookieConsentEnabled' => (bool) ($analyticsSettings['cookie_consent_enabled'] ?? true),
        ];
    @endphp

    {!! app(\App\Support\HreflangLinks::class)->render() !!}

    @metadata

    <x-seo.organization />

    @stack('schemas')

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="#ffffff">

    <script>
        window.siteAnalytics = {{ Illuminate\Support\Js::from($siteAnalytics) }};
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="{{ $bodyClass }} font-montserrat">
    <div class="min-h-screen overflow-x-clip">
        <x-site.layout.header />

        {{ $slot }}

        <x-site.whatsapp-button />
        <x-site.layout.footer />
    </div>

    <x-site.cookie-consent :enabled="$siteAnalytics['cookieConsentEnabled']" />

    @livewireScripts

    @stack('scripts')
</body>

</html>
