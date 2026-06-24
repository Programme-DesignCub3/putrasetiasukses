@props(['site', 'active' => 'home'])

@php
    $navigation = [
        ['label' => __('site.navigation.home'), 'key' => 'home', 'url' => route('home')],
        ['label' => __('site.navigation.about'), 'key' => 'about', 'url' => route('about')],
        ['label' => __('site.navigation.products'), 'key' => 'products', 'url' => route('products.index')],
        ['label' => __('site.navigation.projects'), 'key' => 'projects', 'url' => route('home') . '#our-project'],
        ['label' => __('site.navigation.articles'), 'key' => 'articles', 'url' => route('articles.index')],
        ['label' => __('site.navigation.contact'), 'key' => 'contact', 'url' => route('contact')],
    ];
@endphp

<header class="bg-white relative z-20">
    <div
        class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-5 sm:px-5 sm:py-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <div class="flex items-center justify-between gap-4">
            <x-site.brand :site="$site" />

            <details class="group relative md:hidden">
                <summary
                    class="bg-brand-red flex cursor-pointer list-none items-center gap-2 px-4 py-3 text-xs font-black uppercase text-white marker:hidden">
                    {{ __('site.navigation.menu') }}
                    <svg class="h-4 w-4 transition group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </summary>

                <div class="bg-brand-red absolute right-0 top-full z-40 mt-2 w-64 shadow-2xl shadow-black/30">
                    @foreach ($navigation as $item)
                        <a class="hover:bg-brand-ink {{ $active === $item['key'] ? 'bg-brand-ink' : '' }} block border-b border-white/10 px-5 py-4 text-sm font-black uppercase text-white transition last:border-b-0"
                            href="{{ $item['url'] }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </details>
        </div>

        <div class="flex flex-col gap-3 lg:items-end">
            <p class="text-brand-ink max-w-xl text-sm font-extrabold leading-snug lg:text-right">
                {{ $site->tagline }}
            </p>

            <x-site.language-switcher />
        </div>
    </div>

    <nav class="mx-auto hidden max-w-7xl px-5 md:block lg:px-8" aria-label="Navigasi utama">
        <div class="bg-brand-red grid grid-cols-6 shadow-xl shadow-black/10">
            @foreach ($navigation as $item)
                <a class="hover:bg-brand-ink {{ $active === $item['key'] ? 'bg-brand-ink' : '' }} px-4 py-5 text-center text-xs font-black uppercase text-white transition lg:px-7"
                    href="{{ $item['url'] }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </nav>
</header>
