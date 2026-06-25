@props([])

<a href="{{ route('home') }}" {{ $attributes->merge(['class' => 'flex min-w-0 items-center gap-3']) }}>
    <span class="brand-mark" aria-hidden="true">S</span>
    <span class="min-w-0 text-lg font-black uppercase leading-tight text-brand-ink sm:text-2xl">
        {{ __('site.company_name') }}
    </span>
</a>
