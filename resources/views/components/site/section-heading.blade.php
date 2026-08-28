@props([
    'title' => '',
    'level' => 2,
    'subtitle' => null,
    'prominent' => false,
    'class' => '',
    'titleClass' => '',
    'subtitleClass' => '',
])

<div x-data="scrollReveal" {{ $attributes->class('text-center mb-4 text-white')->class($class) }}>
    <h{{ $level }} @class([
        'clamp-[text,2xl,4xl] font-bold' => !$prominent,
        'clamp-[text,4xl,6xl] font-black' => $prominent,
        $titleClass,
    ])>
        {{ $title }}
        </h{{ $level }}>
        @if ($subtitle)
            <p @class([$subtitleClass])>{{ $subtitle }}</p>
        @endif
</div>
