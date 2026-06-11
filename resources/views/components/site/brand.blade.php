@props([
    'site',
    'dark' => false,
])

<a href="{{ route('home') }}" {{ $attributes->merge(['class' => 'flex min-w-0 items-center gap-3']) }}>
    <span class="brand-mark {{ $dark ? 'brand-mark-dark' : '' }}" aria-hidden="true">S</span>
    <span class="min-w-0 text-lg font-black uppercase leading-tight {{ $dark ? 'text-white' : 'text-brand-ink' }} sm:text-2xl">
        {{ $site->company_name }}
    </span>
</a>
