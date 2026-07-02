@props([
    'direction' => 'prev',
])

<button
    type="button"
    {{ $attributes->merge(['class' => 'slider-nav-button']) }}
    aria-label="{{ $direction === 'prev' ? __('site.slider.prev') : __('site.slider.next') }}"
>
    <span class="flex items-center justify-center">
        @if ($direction === 'prev')
            <x-lucide-chevron-left class="size-6" />
        @else
            <x-lucide-chevron-right class="size-6" />
        @endif
    </span>
</button>
