@props(['site', 'active' => 'home'])

@php
    $navigation = [
        ['label' => __('site.navigation.home'), 'key' => 'home', 'url' => route('home')],
        ['label' => __('site.navigation.about'), 'key' => 'about', 'url' => route('about')],
        ['label' => __('site.navigation.products'), 'key' => 'products', 'url' => route('products.index')],
        ['label' => __('site.navigation.projects'), 'key' => 'projects', 'url' => route('projects.index')],
        ['label' => __('site.navigation.articles'), 'key' => 'articles', 'url' => route('articles.index')],
        ['label' => __('site.navigation.contact'), 'key' => 'contact', 'url' => route('contact')],
        ['label' => __('site.navigation.search'), 'key' => 'search', 'url' => route('search')],
    ];
@endphp

<header class="relative z-20 bg-white">
    <div
        class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-5 sm:px-5 sm:py-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <div class="flex items-center justify-between gap-4">
            <x-site.brand :site="$site" />

            <div class="md:hidden" x-data="{ open: false }" @keydown.escape.window="open = false">
                <button
                    class="bg-brand-red flex cursor-pointer items-center gap-2 px-4 py-3 text-xs font-black uppercase text-white"
                    type="button" @click="open = !open" :aria-expanded="open" aria-controls="mobile-menu"
                    aria-label="{{ __('site.navigation.menu') }}">
                    {{ __('site.navigation.menu') }}
                    <svg class="h-4 w-4 transition" :class="{ 'rotate-180': open }" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div class="bg-brand-red absolute right-0 top-full z-40 mt-2 w-64 shadow-2xl shadow-black/30"
                    id="mobile-menu" x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2" @click.outside="open = false">
                    @foreach ($navigation as $item)
                        <a href="{{ $item['url'] }}" @class([
                            'hover:bg-brand-ink block border-b border-white/10 px-5 py-4 text-sm font-black uppercase text-white transition last:border-b-0',
                            'bg-brand-ink' => url()->current() === $item['url'],
                        ]) @click="open = false">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-3 lg:items-end">
            <p class="text-brand-ink max-w-xl text-sm font-extrabold leading-snug lg:text-right">
                {{ $site->tagline }}
            </p>

            <x-site.language-switcher />
        </div>
    </div>

    <nav class="mx-auto hidden max-w-7xl px-5 md:block lg:px-8" aria-label="Navigasi utama">
        <div class="bg-brand-red flex flex-nowrap shadow-xl shadow-black/10">
            @foreach ($navigation as $item)
                <a @class([
                    'hover:bg-brand-ink flex-1 px-3 py-5 text-center text-xs font-black uppercase text-white transition lg:px-5',
                    'bg-brand-ink' => url()->current() === $item['url'],
                ]) href="{{ $item['url'] }}">

                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </nav>
</header>
