@props([
    'title' => '',
    'level' => 2,
    'subtitle' => null,
    'prominent' => false,
    'class' => '',
    'titleClass' => '',
    'subtitleClass' => '',
])

<div x-data="scrollReveal" {{ $attributes->class('text-center text-white')->class($class) }}>
    <h{{ $level }} @class([
        'clamp-[text,xl,2xl] font-bold' => !$prominent,
        'clamp-[text,2xl,4xl] font-black' => $prominent,
        $titleClass,
    ])>
        {{ $title }}
        </h{{ $level }}>
        @if ($subtitle)
            <p @class([$subtitleClass])>{{ $subtitle }}</p>
        @endif
</div>
