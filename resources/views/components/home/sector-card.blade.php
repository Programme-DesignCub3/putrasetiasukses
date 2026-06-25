@props([
    'bgClass' => '',
    'title' => '',
    'copy' => '',
])

<article class="{{ $bgClass }} min-h-65 bg-cover bg-center sm:min-h-80">
    <div
        class="min-h-65 flex items-center justify-center bg-black/35 px-5 py-10 text-center text-white sm:min-h-80 sm:px-8">
        <div class="max-w-sm">
            <svg class="mx-auto h-14 w-14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                aria-hidden="true">
                <path d="M4 21V9l5-3v15" />
                <path d="M9 21V4l7 4v13" />
                <path d="M16 21v-8l4 2v6" />
                <path d="M6 12h1M6 15h1M6 18h1M11 9h2M11 12h2M11 15h2M11 18h2" />
            </svg>
            <h2 class="mt-5 text-lg font-black uppercase">{{ $title }}</h2>
            <p class="mt-2 text-sm font-semibold leading-relaxed">{{ $copy }}</p>
        </div>
    </div>
</article>
