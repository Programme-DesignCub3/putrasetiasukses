@props([
    'as' => 'section',
    'id' => null,
    'class' => '',
])

<{{ $as }}
    {{ $id ? "id=\"{$id}\"" : '' }}
    class="mx-auto max-w-7xl px-4 sm:px-5 lg:px-8 {{ $class }}"
>
    {{ $slot }}
</{{ $as }}>
