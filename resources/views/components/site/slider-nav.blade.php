@props([
    'direction' => 'prev',
])

<button
    type="button"
    {{ $attributes->merge(['class' => 'slider-nav-button']) }}
    aria-label="{{ $direction === 'prev' ? __('site.slider.prev') : __('site.slider.next') }}"
>
    <span class="text-2xl font-black leading-none">{{ $direction === 'prev' ? '‹' : '›' }}</span>
</button>
