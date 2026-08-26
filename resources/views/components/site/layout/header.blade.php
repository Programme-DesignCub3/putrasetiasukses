{{-- @props(['active' => 'home']) --}}

@php
    $navigation = [
        ['label' => __('site.navigation.home'), 'key' => 'home', 'url' => route('home')],
        ['label' => __('site.navigation.about'), 'key' => 'about', 'url' => route('about')],
        ['label' => __('site.navigation.products'), 'key' => 'products.*', 'url' => route('products.index')],
        ['label' => __('site.navigation.projects'), 'key' => 'projects.*', 'url' => route('projects.index')],
        ['label' => __('site.navigation.articles'), 'key' => 'articles.*', 'url' => route('articles.index')],
        ['label' => __('site.navigation.contact'), 'key' => 'contact', 'url' => route('contact')],
        ['label' => __('site.navigation.search'), 'key' => 'search', 'url' => route('search')],
    ];
@endphp

<header
    class="from-brand-red bg-linear-[135deg] z-20 mx-auto flex flex-col gap-4 to-white px-4 py-5 sm:px-5 sm:py-7 lg:flex-row lg:items-center lg:justify-between lg:px-8">

    <div class="flex items-center justify-between gap-6 text-white">
        <a class="basis-20" href="{{ route('home') }}">
            <x-site.logo />
        </a>

        <div class="flex flex-col uppercase">
            <p class="text-4xl font-semibold">
                PT PUTRA SETIA SUKSES BERSAMA
            </p>

            <p class="">
                {{ __('site.tagline') }}
            </p>

        </div>
    </div>

    <div class="flex flex-col gap-3 lg:items-end">

        <div class="flex items-end justify-between gap-3 md:flex-col">
            <x-site.language-switcher />

            {{-- ? mobile nav --}}
            <div class="md:hidden" x-data="{ menuFixed: false, open: false }" @keydown.escape.window="open = false" x-init="window.addEventListener('scroll', () => menuFixed = window.scrollY > 150, { passive: true })"
                :class="menuFixed ? 'fixed right-4 top-4 z-50' : 'relative'">
                <button
                    class="bg-brand-red flex cursor-pointer items-center gap-2 px-4 py-3 text-xs font-black uppercase text-white"
                    type="button" @click="open = !open" :aria-expanded="open" aria-controls="mobile-menu"
                    aria-label="{{ __('site.navigation.menu') }}">
                    {{ __('site.navigation.menu') }}
                    <x-lucide-chevron-down class="h-4 w-4 transition" x-bind:class="{ 'rotate-180': open }" />
                </button>

                <div class="bg-brand-red absolute right-0 top-full z-40 mt-2 w-64 shadow-2xl shadow-black/30"
                    id="mobile-menu" x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2" @click.outside="open = false"
                    x-data="staggerFade({ duration: 0.25 })">
                    @foreach ($navigation as $item)
                        <a href="{{ $item['url'] }}" @class([
                            'hover:bg-brand-ink block border-b border-white/10 px-5 py-4 text-sm font-black uppercase text-white transition last:border-b-0',
                            'bg-brand-ink' => request()->routeIs('*.' . $item['key']),
                        ]) @click="open = false">
                            {{ $item['label'] }}

                        </a>
                    @endforeach

                    <div class="bg-brand-ink border-t border-white/10 px-5 py-4">
                        <x-site.language-switcher />
                    </div>
                </div>
            </div>

            {{-- ? desktop nav --}}
            <nav class="mx-auto hidden overflow-hidden rounded-full xl:block" aria-label="Navigasi utama">
                <div class="text-brand-red flex flex-nowrap bg-white shadow-xl shadow-black/10" x-data="staggerFade({ duration: 0.3 })">
                    @foreach ($navigation as $item)
                        <div class="first:[&>a]:pl-8 last:[&>a]:pr-8 hover:[&_div.absolute]:block">
                            <a @class([
                                'hover:bg-brand-ink hover:text-white min-w-max max-w-50 flex justify-center items-center flex-1 clamp-[py,3,5] text-center text-xs font-black uppercase transition clamp-[pl,2,5] clamp-[pr,1.5,3.5]',
                                'bg-brand-ink text-white' => request()->routeIs('*.' . $item['key']),
                            ]) href="{{ $item['url'] }}">
                                <span class="flex gap-0.5">
                                    {{ $item['label'] }}

                                    <x-lucide-chevron-down class="h-4 w-4 transition" />

                                </span>
                            </a>

                            {{-- <div class="absolute z-50 hidden">
                                @for ($i = 0; $i < 3; $i++)
                                    <p>test</p>
                                @endfor
                            </div> --}}
                        </div>
                    @endforeach
                </div>
            </nav>
        </div>


    </div>
</header>
