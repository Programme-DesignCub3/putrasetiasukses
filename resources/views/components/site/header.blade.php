@props([
    'site',
    'active' => 'home',
])

@php
    $isDarkHeader = in_array($active, ['about', 'articles', 'contact'], true);

    $navigation = [
        ['label' => __('site.navigation.home'), 'key' => 'home', 'url' => route('home')],
        ['label' => __('site.navigation.about'), 'key' => 'about', 'url' => route('about')],
        ['label' => __('site.navigation.products'), 'key' => 'products', 'url' => route('products.show', 'plat-hitam')],
        ['label' => __('site.navigation.projects'), 'key' => 'projects', 'url' => route('home').'#our-project'],
        ['label' => __('site.navigation.articles'), 'key' => 'articles', 'url' => route('articles.index')],
        ['label' => __('site.navigation.contact'), 'key' => 'contact', 'url' => route('contact')],
    ];
@endphp

<header class="relative z-20 {{ $isDarkHeader ? 'bg-black' : 'bg-white' }}">
    <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-5 sm:px-5 sm:py-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <div class="flex items-center justify-between gap-4">
            <x-site.brand :site="$site" :dark="$isDarkHeader" />

            <details class="group relative md:hidden">
                <summary class="flex cursor-pointer list-none items-center gap-2 bg-brand-red px-4 py-3 text-xs font-black uppercase text-white marker:hidden">
                    {{ __('site.navigation.menu') }}
                    <svg class="h-4 w-4 transition group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                    </svg>
                </summary>

                <div class="absolute right-0 top-full z-40 mt-2 w-64 bg-brand-red shadow-2xl shadow-black/30">
                    @foreach ($navigation as $item)
                        <a
                            href="{{ $item['url'] }}"
                            class="block border-b border-white/10 px-5 py-4 text-sm font-black uppercase text-white transition last:border-b-0 hover:bg-brand-ink {{ $active === $item['key'] ? 'bg-brand-ink' : '' }}"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </details>
        </div>

        <div class="flex flex-col gap-3 lg:items-end">
            <p class="max-w-xl text-sm font-extrabold leading-snug {{ $isDarkHeader ? 'text-white/75' : 'text-brand-ink' }} lg:text-right">
                {{ $site->tagline }}
            </p>

            <x-site.language-switcher :is-dark="$isDarkHeader" />
        </div>
    </div>

    <nav class="mx-auto hidden max-w-7xl px-5 md:block lg:px-8" aria-label="Navigasi utama">
        <div class="grid grid-cols-6 bg-brand-red shadow-xl shadow-black/10">
            @foreach ($navigation as $item)
                <a
                    href="{{ $item['url'] }}"
                    class="px-4 py-5 text-center text-xs font-black uppercase text-white transition hover:bg-brand-ink lg:px-7 {{ $active === $item['key'] ? 'bg-brand-ink' : '' }}"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </nav>
</header>
