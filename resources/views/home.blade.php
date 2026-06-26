<x-layouts.app body-class="bg-white font-sans text-brand-ink antialiased">
    <main>
        <section class="relative -mt-1" id="beranda">
            <div class="hero-steel clamp-[min-h,360px,520px] bg-cover bg-center">
                <div class="absolute inset-0 bg-black/25"></div>
                <div
                    class="clamp-[min-h,360px,520px] relative mx-auto flex max-w-7xl items-center justify-center px-4 text-center sm:px-5">
                    <div class="text-white drop-shadow-2xl">
                        <p class="text-xs font-black uppercase sm:text-sm">Material Baja Terpercaya</p>
                        <h1 class="mt-2 text-3xl font-black uppercase leading-none sm:text-5xl">
                            {{ __('home.hero_title') }}</h1>
                        <p class="mt-3 text-sm font-black uppercase sm:text-lg">{{ __('home.hero_subtitle') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="brand-panel clamp-[py,48px,56px] relative z-10 px-4 text-white sm:-mt-16 sm:px-5 lg:px-8">
            <div class="mx-auto grid max-w-5xl gap-10 sm:grid-cols-2 lg:grid-cols-4" x-data="staggerFade">
                @foreach ($advantages as $advantage)
                    <x-home.advantage-card :icon="$advantage['icon']" :title="$advantage['title']" :copy="$advantage['copy']" />
                @endforeach
            </div>
        </section>

        <section class="grid lg:grid-cols-3" id="produk" x-data="staggerFade({ duration: 0.5 })">
            @foreach ($sectors as $sector)
                <x-home.sector-card :bg-class="$sector['class']" :title="$sector['title']" :copy="$sector['copy']" />
            @endforeach
        </section>

        <x-site.layout.container class="clamp-[py,56px,64px] grid gap-12 lg:grid-cols-2" id="tentang-kami">
            <div>
                <x-site.section-heading :label="__('home.testimonial_title')" />
                <div class="home-slider home-testimonials-swiper swiper mt-8">
                    <div class="swiper-wrapper">
                        @foreach ($testimonials as $testimonial)
                            <div class="swiper-slide">
                                <figure class="bg-brand-red relative p-6 text-white shadow-lg sm:p-8">
                                    <blockquote class="text-sm font-bold italic leading-relaxed sm:text-base">
                                        "{{ $testimonial['content'] }}"
                                    </blockquote>
                                    <figcaption class="mt-6 text-sm font-bold">{{ $testimonial['name'] }},
                                        {{ $testimonial['role'] }}</figcaption>
                                    <span
                                        class="-bottom-7.5 border-b-30 border-r-30 absolute left-0 z-0 inline-block h-0 w-0 border-l-0 border-t-0 border-solid border-b-transparent border-l-transparent border-r-[#590802] border-t-transparent"></span>
                                </figure>
                            </div>
                        @endforeach
                    </div>
                    <div class="home-swiper-pagination home-testimonials-pagination mt-9"></div>
                </div>
            </div>

            <div class="px-8">
                <x-site.section-heading :label="__('home.partners_title')" />
                <div class="relative mt-8">
                    <div class="home-slider home-partners-swiper swiper border border-zinc-300">
                        <div class="swiper-wrapper">
                            @foreach ($partners as $partner)
                                <div class="swiper-slide">
                                    <div
                                        class="flex min-h-44 flex-col items-center justify-center border-zinc-300 p-8 sm:min-h-52">
                                        <span class="text-4xl font-black sm:text-5xl"
                                            style="color: {{ $partner['color'] }}">{{ $partner['initial'] }}</span>
                                        <span
                                            class="mt-3 text-center text-xs font-black uppercase text-zinc-700 sm:text-sm">{{ $partner['name'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-center gap-3">
                        {{-- <button class="home-swiper-button home-partners-prev" type="button" aria-label="Partner sebelumnya"></button> --}}
                        <div class="home-swiper-pagination home-partners-pagination"></div>
                        {{-- <button class="home-swiper-button home-partners-next" type="button" aria-label="Partner berikutnya"></button> --}}
                    </div>
                </div>
            </div>
        </x-site.layout.container>

        <x-site.layout.container class="clamp-[pb,56px,64px]" id="kontak" as="section">
            <x-site.cta-strip />
        </x-site.layout.container>
    </main>
</x-layouts.app>
