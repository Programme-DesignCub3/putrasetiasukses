<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Terjadi Kesalahan') }} - {{ translated($site['company_name'] ?? null) ?: config('app.name') }}</title>
    <meta name="robots" content="noindex, nofollow">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center">
            <h1 class="text-8xl font-bold text-brand-red mb-4">500</h1>
            <p class="text-xl text-gray-600 mb-8">{{ __('Maaf, terjadi kesalahan pada server. Silakan coba lagi nanti.') }}</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-brand-red text-white font-semibold rounded-lg hover:bg-brand-red/90 transition-colors">
                {{ __('Kembali ke Beranda') }}
            </a>
        </div>
    </div>
</body>
</html>
