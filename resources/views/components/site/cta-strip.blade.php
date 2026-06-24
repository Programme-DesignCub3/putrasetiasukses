@props([
    'text' => null,
])

<div class="cta-strip clamp-[py,32px,48px] flex min-h-32 items-center justify-center bg-cover bg-center px-5 text-center text-white sm:min-h-36 sm:px-6">
    <p class="max-w-2xl text-xl font-black leading-tight sm:text-2xl">{{ $text ?? __('site.cta.strip') }}</p>
</div>
