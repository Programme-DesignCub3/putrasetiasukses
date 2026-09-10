<x-layouts.app body-class="bg-white font-sans text-brand-ink antialiased">
    <main>
        <section class="relative -mt-1" id="beranda">
            <div class="home-hero swiper">
                <div class="swiper-wrapper">
                    @foreach ($heroSlides as $slide)
                        <div class="swiper-slide">
                            @if ($slide['link'])
                                <a class="home-hero-slide clamp-[min-h,240px,800px] flex items-center justify-center bg-cover bg-center px-4 text-center sm:px-5"
                                    href="{{ $slide['link'] }}"
                                    style="background-image: linear-gradient(rgba(0,0,0,0.25),rgba(0,0,0,0.25)),url('{{ $slide['image'] }}')">
                                </a>
                            @else
                                <div class="home-hero-slide clamp-[min-h,240px,800px] flex items-center justify-center bg-cover bg-center px-4 text-center sm:px-5"
                                    style="background-image: linear-gradient(rgba(0,0,0,0.25),rgba(0,0,0,0.25)),url('{{ $slide['image'] }}')">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button class="home-hero-button-prev" type="button" aria-label="{{ __('site.slider.prev') }}">
                    <x-lucide-chevron-left class="size-5" />
                </button>
                <button class="home-hero-button-next" type="button" aria-label="{{ __('site.slider.next') }}">
                    <x-lucide-chevron-right class="size-5" />
                </button>
                <div class="home-hero-pagination"></div>
            </div>
        </section>

        <x-site.layout.container class="my-8 text-center">
            <x-site.section-heading class="text-brand-red! uppercase" :title="__('home.about_title')" />

            <div class="flex flex-col justify-center">
                <div class="clamp-[text,xs,base] text-balance leading-relaxed">
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
                <x-site.section-heading :title="__('home.advantages_title')" :subtitle="__('home.advantages_subtitle')" />

                <div class="my-4 grid gap-4 pt-8 md:grid-cols-2">
                    @foreach ($advantages as $advantage)
                        <div class="flex items-center gap-4 rounded-xl bg-white p-5 py-4">

                            <div class="bg-brand-red rounded-lg p-2 text-white">
                                <x-dynamic-component class="size-6" component="lucide-{{ $advantage['icon'] }}" />
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
            <x-site.layout.container class="clamp-[px,7,14]! my-12 flex flex-col gap-4">
                <x-site.section-heading title="{{ __('home.partners_title') }}" titleClass="uppercase text-brand-red" />

                <div class="relative">
                    <div class="home-partners-swiper swiper clamp-[px,3,6]!">
                        <div class="swiper-wrapper py-4">
                            @foreach ($partners as $partner)
                                <div class="swiper-slide hover:[&_img]:opacity-100">
                                    <div
                                        class="hover:shadow-top shadow-top-center flex aspect-square items-center justify-center rounded-xl transition">
                                        <img class="clamp-[max-w,32,62] w-full object-contain opacity-70 transition duration-500"
                                            src="{{ $partner->logo }}" alt="{{ $partner->name }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <x-site.slider-nav class="home-partners-button-prev clamp-[left,-2,-12,@md]" direction="prev" />
                    <x-site.slider-nav class="home-partners-button-next clamp-[right,-2,-12,@md]" direction="next" />

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

        <section class="bg-brand-red clamp-[mt,12,24]">
            <div class="clamp-[py,8,16] clamp-[rounded-br,5rem,20rem] bg-[#fbf3f3]">
                <x-site.layout.container class="flex flex-wrap items-center justify-center gap-4" as="div">
                    <h2 class="text-brand-red clamp-[text,lg,xl] w-fit font-bold">{{ __('about.search_label') }}</h2>
                    <form class="relative max-w-sm grow" action="{{ route('search') }}" method="GET">
                        <div class="border-brand-red flex overflow-hidden rounded-full border">
                            <input
                                class="w-full rounded-l-full bg-zinc-200 px-3 py-2 font-semibold text-black placeholder-zinc-500"
                                type="search" name="query" placeholder="{{ __('about.search_placeholder') }}">
                            <button class="bg-brand-red px-2 py-1 pr-4" type="submit">
                                <x-lucide-search class="pointer-events-none size-6 text-white" />
                            </button>
                        </div>
                    </form>
                </x-site.layout.container>
            </div>
        </section>
    </main>
</x-layouts.app>
