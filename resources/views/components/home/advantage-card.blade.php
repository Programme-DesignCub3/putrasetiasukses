@props([
    'icon' => '',
    'title' => '',
    'copy' => '',
])

<article class="flex flex-col items-center text-center">
    <div class="brand-icon">
        @if ($icon === 'warehouse')
            <x-lucide-warehouse />
        @elseif ($icon === 'tag')
            <x-lucide-tag />
        @elseif ($icon === 'clock')
            <x-lucide-clock />
        @else
            <x-lucide-thumbs-up />
        @endif
    </div>
    <h2 class="mt-5 max-w-56 text-base font-black leading-tight">{{ $title }}</h2>
    <p class="mt-2 max-w-56 text-sm font-semibold leading-snug text-white/85">{{ $copy }}</p>
</article>
