@props([
    'url' => null,
])

<div class="mx-auto flex aspect-video w-full max-w-3xl items-center justify-center bg-black">
    @if ($url)
        <iframe class="h-full w-full" src="{{ $url }}" title="Company video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    @else
        <div class="flex h-16 w-24 items-center justify-center rounded-2xl bg-red-600 text-white">
            <x-lucide-play class="h-10 w-10 translate-x-0.5" />
        </div>
    @endif
</div>
