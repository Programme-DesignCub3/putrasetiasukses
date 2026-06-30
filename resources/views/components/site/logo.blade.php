@props(['variant' => 'default'])

@php
    $src = match ($variant) {
        'white' => 'assets/logo-white-text.png',
        default => 'assets/logo.png',
    };
@endphp

<img src="{{ asset($src) }}" alt="{{ __('site.company_name') }} logo" {{ $attributes->merge(['class' => '']) }}>
