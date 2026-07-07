@props([
    'level' => 2,
    'label' => '',
    'prominent' => false,
])

<h{{ $level }} @class([
    'section-title',
    'text-center text-4xl font-black' => $prominent,
]) x-data="scrollReveal">{{ $label }}</h{{ $level }}>
