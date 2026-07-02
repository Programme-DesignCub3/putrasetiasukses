@props([
    'url' => null,
])

@php
    $embedUrl = null;

    if ($url) {
        $parsed = parse_url($url);
        $host = $parsed['host'] ?? '';
        $path = $parsed['path'] ?? '';
        $query = $parsed['query'] ?? '';

        if (str_contains($host, 'youtu.be')) {
            $id = trim($path, '/');
        } elseif (str_contains($host, 'youtube.com') || str_contains($host, 'youtube-nocookie.com')) {
            if (str_starts_with($path, '/embed/')) {
                $id = explode('/', $path)[2] ?? null;
            } else {
                parse_str($query, $params);
                $id = $params['v'] ?? null;
            }
        }

        if ($id) {
            $embedUrl = 'https://www.youtube-nocookie.com/embed/' . $id;
        }
    }
@endphp

<div class="mx-auto flex aspect-video w-full max-w-3xl items-center justify-center bg-black">
    @if ($embedUrl)
        <iframe
            class="h-full w-full"
            src="{{ $embedUrl }}"
            title="Company video"
            loading="lazy"
            referrerpolicy="strict-origin-when-cross-origin"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
        ></iframe>
    @else
        <div class="flex h-16 w-24 items-center justify-center rounded-2xl bg-red-600 text-white">
            <x-lucide-play class="h-10 w-10 translate-x-0.5" />
        </div>
    @endif
</div>
