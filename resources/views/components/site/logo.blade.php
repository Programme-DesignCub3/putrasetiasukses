@props(['variant' => 'default'])

@php
    $src = match ($variant) {
        'white' => 'assets/logo-white-text.png',
        default => 'assets/logo-simbol-stroke.png',
    };
@endphp

<img src="{{ asset($src) }}" alt="{{ __('site.company_name') }} logo" {{ $attributes->merge(['class' => '']) }}>
