@props([
    'level' => 2,
    'label' => '',
    'prominent' => false,
])

@if ($prominent)
    <h{{ $level }} class="text-center text-4xl font-black">{{ $label }}</h{{ $level }}>
@else
    <h{{ $level }} class="section-title">{{ $label }}</h{{ $level }}>
@endif
