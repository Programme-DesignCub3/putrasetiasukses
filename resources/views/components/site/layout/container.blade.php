@props([
    'as' => 'section',
    'id' => null,
])

<{{ $as }} {{ $id ? "id=\"{$id}\"" : '' }}
    {{ $attributes->merge([
        'class' => 'mx-auto max-w-7xl px-4 sm:px-5 lg:px-8',
    ]) }}">
    {{ $slot }}
    </{{ $as }}>
