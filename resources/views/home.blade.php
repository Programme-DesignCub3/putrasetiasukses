<x-layouts.app body-class="bg-white font-sans text-brand-ink antialiased">
    <main>
        <section class="relative -mt-1" id="beranda" x-data="heroSlider()">
            <h1 class="sr-only text-3xl font-black uppercase leading-none text-white sm:text-5xl" x-text="activeTitle">
            </h1>

            <div class="home-hero swiper">
                <div class="swiper-wrapper">
                    @foreach ($heroSlides as $slide)
                        <div class="swiper-slide">
                            @if ($slide['link'])
                                <a class="home-hero-slide clamp-[min-h,240px,800px] flex items-center justify-center bg-cover bg-center px-4 text-center sm:px-5"
                                    href="{{ $slide['link'] }}"
                                    style="background-image: linear-gradient(rgba(0,0,0,0.25),rgba(0,0,0,0.25)),url('{{ $slide['image'] }}')">
                                    <div class="text-white drop-shadow-2xl">
                                        @if ($slide['label'])
                                            <p class="hero-slide-label text-xs font-black uppercase sm:text-sm">
                                                {{ $slide['label'] }}
                                            </p>
                                        @endif
                                        @if ($slide['title'])
                                            <span
                                                class="mt-2 block text-3xl font-black uppercase leading-none sm:text-5xl"
                                                data-hero-title>
                                                {{ $slide['title'] }}
                                            </span>
                                        @endif
                                        @if ($slide['subtitle'])
                                            <p class="mt-3 text-sm font-black uppercase sm:text-lg">
                                                {{ $slide['subtitle'] }}
                                            </p>
                                        @endif
                                    </div>
                                </a>
                            @else
                                <div class="home-hero-slide clamp-[min-h,240px,800px] flex items-center justify-center bg-cover bg-center px-4 text-center sm:px-5"
                                    style="background-image: linear-gradient(rgba(0,0,0,0.25),rgba(0,0,0,0.25)),url('{{ $slide['image'] }}')">
                                    <div class="text-white drop-shadow-2xl">
                                        @if ($slide['label'])
                                            <p class="hero-slide-label text-xs font-black uppercase sm:text-sm">
                                                {{ $slide['label'] }}
                                            </p>
                                        @endif
                                        @if ($slide['title'])
                                            <span
                                                class="mt-2 block text-3xl font-black uppercase leading-none sm:text-5xl"
                                                data-hero-title>
                                                {{ $slide['title'] }}
                                            </span>
                                        @endif
                                        @if ($slide['subtitle'])
                                            <p class="mt-3 text-sm font-black uppercase sm:text-lg">
                                                {{ $slide['subtitle'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button class="home-hero-button-prev" type="button" aria-label="Sebelumnya">
                    <x-lucide-chevron-left class="size-5" />
                </button>
                <button class="home-hero-button-next" type="button" aria-label="Selanjutnya">
                    <x-lucide-chevron-right class="size-5" />
                </button>
                <div class="home-hero-pagination"></div>
            </div>
        </section>

        <x-site.layout.container class="text-center">
            <div class="flex flex-col justify-center">
                <div class="mt-8 text-base leading-relaxed">
                    {!! __('about.section-1') !!}
                </div>
            </div>
        </x-site.layout.container>

        <x-site.layout.container class="clamp-[my,8,16] grid max-w-6xl gap-10 md:grid-cols-2">
            <x-about.visi-misi :title="__('about.vision.title')" :content="__('about.vision.content')" />
            <x-about.visi-misi :title="__('about.mission.title')" :content="__('about.mission.content')" />
        </x-site.layout.container>


        <section class="bg-brand-red my-12 py-8">
            <x-site.layout.container class="bg-brand-red" as="div">
                <x-site.section-heading title="OUR ADVANTAGES"
                    subtitle="Why Customers Choose PT Putra Setia Sukses
                    Bersama" />

                <div class="my-4 grid gap-4 pt-8 md:grid-cols-2">
                    @foreach ($advantages as $advantage)
                        <div class="flex items-center gap-4 rounded-xl bg-white p-5 py-4">

                            <div class="bg-brand-red rounded-lg p-2 text-white">
                                <x-dynamic-component class="size-6 fill-white"
                                    component="lucide-{{ $advantage['icon'] }}" />
                            </div>

                            <div class="text-brand-red">
                                <h3 class="text-lg font-bold">{{ $advantage['title'] }}</h3>
                                <p>{{ $advantage['copy'] }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </x-site.layout.container>
        </section>

        <x-site.layout.container class="my-12">
            <livewire:product-list :compact="true" />
        </x-site.layout.container>

        @if ($partners->isNotEmpty())
            <x-site.layout.container class="my-12 flex flex-col gap-4">
                <x-site.section-heading title="{{ __('home.partners_title') }}" titleClass="text-brand-red" />

                <div class="home-partners-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($partners as $partner)
                            <div class="swiper-slide hover:[&_img]:opacity-100">
                                <div
                                    class="hover:shadow-3xl flex aspect-square items-center justify-center shadow-xl transition">
                                    <img class="max-h-48 w-auto object-contain opacity-70 transition duration-500"
                                        src="{{ $partner->logo }}" alt="{{ $partner->name }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-site.layout.container>
        @endif

        <x-site.layout.container>
            <x-about.section.gallery :data="$aboutPage['gallery_images'] ?? []" />
        </x-site.layout.container>

        @if ($projects->isNotEmpty())
            <x-site.layout.container class="my-12">
                <div data-home-projects>
                    <x-site.section-heading title="{{ __('home.projects_title') }}" />

                    <div class="relative mt-4">
                        <x-site.slider-nav class="slider-nav-prev clamp-[left,2,-12,@md]" direction="prev" />

                        <div class="home-projects-swiper swiper min-w-0 flex-1 overflow-hidden">
                            <div class="swiper-wrapper">
                                @foreach ($projects as $project)
                                    <div class="swiper-slide">
                                        <x-projects.project-card :project="$project" />
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <x-site.slider-nav class="slider-nav-next clamp-[right,2,-12,@md]" direction="next" />
                    </div>
                </div>
            </x-site.layout.container>
        @endif

        <x-site.layout.container class="clamp-[my,12,24] flex items-center justify-center gap-4">
            <p class="text-brand-red w-fit text-xl font-bold">{{ __('about.search_label') }}</p>
            <form class="relative max-w-sm grow" action="{{ route('search') }}" method="GET">
                <div class="border-brand-red flex overflow-hidden rounded-full border">
                    <input class="w-full bg-zinc-200 px-3 py-2 font-semibold text-black placeholder-zinc-500"
                        type="search" name="query" placeholder="{{ __('about.search_placeholder') }}">
                    <button class="bg-brand-red px-2 py-1 pr-4" type="submit">
                        <x-lucide-search class="pointer-events-none size-6 text-white" />
                    </button>
                </div>
            </form>
        </x-site.layout.container>
    </main>
</x-layouts.app>
