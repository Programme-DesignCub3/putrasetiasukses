<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ \NielsNumbers\LaravelLocalizer\Facades\Localizer::currentLocaleDirection() }}">

<head prefix="@openGraphPrefix">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @metadata

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="{{ $bodyClass }}">
    {{ $slot }}

    @livewireScripts
</body>

</html>
