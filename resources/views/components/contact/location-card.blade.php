@props([
    'label' => '',
    'address' => '',
])

<div class="flex gap-5">
    <span class="bg-brand-red flex h-16 w-16 flex-none items-center justify-center rounded-full">
        <svg class="h-9 w-9" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z" />
        </svg>
    </span>
    <p><strong>{{ $label }}</strong><br>{{ $address }}</p>
</div>
