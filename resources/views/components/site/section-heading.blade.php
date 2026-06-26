@props([
    'level' => 2,
    'label' => '',
    'prominent' => false,
])

@if ($prominent)
    <h{{ $level }} class="text-center text-4xl font-black" x-data="scrollReveal">{{ $label }}</h{{ $level }}>
@else
    <h{{ $level }} class="section-title" x-data="scrollReveal">{{ $label }}</h{{ $level }}>
@endif
