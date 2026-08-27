@props([
    'label' => '',
    'level' => 2,
    'subtitle' => null,
    'prominent' => false,
    'class' => '',
    'titleClass' => '',
    'subtitleClass' => '',
])

<div x-data="scrollReveal" {{ $attributes->class('text-center text-white')->class($class) }}>
    <h{{ $level }} @class([
        'text-2xl font-bold',
        'text-center text-4xl font-black' => $prominent,
        $titleClass,
    ])>
        {{ $label }}
        </h{{ $level }}>
        @if ($subtitle)
            <p @class([$subtitleClass])>{{ $subtitle }}</p>
        @endif
</div>
