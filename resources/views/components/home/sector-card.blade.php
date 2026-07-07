@props([
    'title' => '',
    'copy' => '',
    'icon' => 'building-2',
])

@php
    $iconMap = [
        'building-2' => 'lucide-building-2',
        'factory' => 'lucide-factory',
        'warehouse' => 'lucide-warehouse',
    ];
    $iconName = $iconMap[$icon] ?? 'lucide-building-2';
@endphp

<article
    {{ $attributes->merge([
        'class' =>
            'md:hover:[&>div]:opacity-100 min-h-65 bg-cover transition bg-center sm:min-h-80 md:hover:bg-brand-red max-md:bg-brand-red/70 bg-blend-multiply',
    ]) }}
    {{ $attributes }}>
    <div
        class="min-h-65 flex items-center justify-center bg-black/35 px-5 py-10 text-center text-white sm:min-h-80 sm:px-8 md:opacity-0">
        <div class="max-w-sm">
            <x-dynamic-component :component="$iconName" class="mx-auto h-14 w-14" stroke-width="1.8" />
            <p class="mt-2 text-sm font-semibold leading-relaxed">{{ $copy }}</p>
        </div>
    </div>
</article>
