@props([
    'url' => null,
])

<div class="mx-auto flex aspect-video w-full max-w-3xl items-center justify-center bg-black">
    @if ($url)
        <iframe class="h-full w-full" src="{{ $url }}" title="Company video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    @else
        <div class="flex h-16 w-24 items-center justify-center rounded-2xl bg-red-600 text-white">
            <svg class="h-10 w-10 translate-x-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
        </div>
    @endif
</div>
