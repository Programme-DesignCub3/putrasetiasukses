@props([
    'icon' => '',
    'title' => '',
    'copy' => '',
])

<article class="flex flex-col items-center text-center">
    <div class="brand-icon">
        @if ($icon === 'warehouse')
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 10.5 12 6l8 4.5V20H4z" />
                <path d="M7 20v-7h10v7" />
                <path d="M9 15h6M9 18h6M12 8v3" />
            </svg>
        @elseif ($icon === 'tag')
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m20 13-7 7-9-9V4h7z" />
                <path d="M8.5 8.5h.01" />
                <path d="M12 15.5 9 12.5" />
                <path d="M15 12.5 12 9.5" />
            </svg>
        @elseif ($icon === 'clock')
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="8" />
                <path d="M12 7v5l3 2" />
            </svg>
        @else
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M7 11v9H4v-9z" />
                <path d="M7 19h9.5a2 2 0 0 0 2-1.6l1.1-5.5A2 2 0 0 0 17.7 9H14V5.8A1.8 1.8 0 0 0 12.2 4L9 11H7z" />
            </svg>
        @endif
    </div>
    <h2 class="mt-5 max-w-56 text-base font-black leading-tight">{{ $title }}</h2>
    <p class="mt-2 max-w-56 text-sm font-semibold leading-snug text-white/85">{{ $copy }}</p>
</article>
