<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ \NielsNumbers\LaravelLocalizer\Facades\Localizer::currentLocaleDirection() }}">

<head prefix="@openGraphPrefix">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @metadata

    @foreach ($alternateUrls as $hreflang => $url)
        <link rel="alternate" hreflang="{{ $hreflang }}" href="{{ $url }}">
    @endforeach

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="{{ $bodyClass }}">
    {{ $slot }}

    @livewireScripts
</body>

</html>
