<x-layouts.app body-class="bg-white font-sans text-brand-ink antialiased">
    <div class="min-h-screen overflow-hidden">
        <x-site.header :site="$site" active="home" />

        <main>
            <section class="relative -mt-1" id="beranda">
                <div class="hero-steel clamp-[min-h,360px,520px] min-h-[360px] bg-cover bg-center">
                    <div class="absolute inset-0 bg-black/25"></div>
                    <div
                        class="clamp-[min-h,360px,520px] relative mx-auto flex min-h-[360px] max-w-7xl items-center justify-center px-4 text-center sm:px-5">
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
                <div class="mx-auto grid max-w-5xl gap-10 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($advantages as $advantage)
                        <article class="flex flex-col items-center text-center">
                            <div class="brand-icon">
                                @if ($advantage['icon'] === 'warehouse')
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M4 10.5 12 6l8 4.5V20H4z" />
                                        <path d="M7 20v-7h10v7" />
                                        <path d="M9 15h6M9 18h6M12 8v3" />
                                    </svg>
                                @elseif ($advantage['icon'] === 'tag')
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="m20 13-7 7-9-9V4h7z" />
                                        <path d="M8.5 8.5h.01" />
                                        <path d="M12 15.5 9 12.5" />
                                        <path d="M15 12.5 12 9.5" />
                                    </svg>
                                @elseif ($advantage['icon'] === 'clock')
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="8" />
                                        <path d="M12 7v5l3 2" />
                                    </svg>
                                @else
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M7 11v9H4v-9z" />
                                        <path
                                            d="M7 19h9.5a2 2 0 0 0 2-1.6l1.1-5.5A2 2 0 0 0 17.7 9H14V5.8A1.8 1.8 0 0 0 12.2 4L9 11H7z" />
                                    </svg>
                                @endif
                            </div>
                            <h2 class="mt-5 max-w-56 text-base font-black leading-tight">{{ $advantage['title'] }}</h2>
                            <p class="mt-2 max-w-56 text-sm font-semibold leading-snug text-white/85">
                                {{ $advantage['copy'] }}</p>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="grid lg:grid-cols-3" id="produk">
                @foreach ($sectors as $sector)
                    <article class="{{ $sector['class'] }} min-h-[260px] bg-cover bg-center sm:min-h-[320px]">
                        <div
                            class="flex min-h-[260px] items-center justify-center bg-black/35 px-5 py-10 text-center text-white sm:min-h-[320px] sm:px-8">
                            <div class="max-w-sm">
                                <svg class="mx-auto h-14 w-14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" aria-hidden="true">
                                    <path d="M4 21V9l5-3v15" />
                                    <path d="M9 21V4l7 4v13" />
                                    <path d="M16 21v-8l4 2v6" />
                                    <path d="M6 12h1M6 15h1M6 18h1M11 9h2M11 12h2M11 15h2M11 18h2" />
                                </svg>
                                <h2 class="mt-5 text-lg font-black uppercase">{{ $sector['title'] }}</h2>
                                <p class="mt-2 text-sm font-semibold leading-relaxed">{{ $sector['copy'] }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>

            <section class="clamp-[py,56px,64px] mx-auto grid max-w-7xl gap-12 px-4 sm:px-5 lg:grid-cols-2 lg:px-8"
                id="tentang-kami">
                <div>
                    <h2 class="section-title">{{ __('home.testimonial_title') }}</h2>
                    <div class="home-slider home-testimonials-swiper swiper mt-8">
                        <div class="swiper-wrapper">
                            @foreach ($testimonials as $testimonial)
                                <div class="swiper-slide">
                                    <figure class="bg-brand-red relative p-6 text-white shadow-lg sm:p-8">
                                        <blockquote class="text-sm font-bold italic leading-relaxed sm:text-base">
                                            "{{ $testimonial['quote'] }}"
                                        </blockquote>
                                        <figcaption class="mt-6 text-sm font-bold">{{ $testimonial['name'] }},
                                            {{ $testimonial['role'] }}</figcaption>
                                        <span
                                            class="border-t-brand-red absolute -bottom-6 left-8 h-0 w-0 border-l-[28px] border-t-[28px] border-l-transparent"></span>
                                    </figure>
                                </div>
                            @endforeach
                        </div>
                        <div class="home-swiper-pagination home-testimonials-pagination mt-9"></div>
                    </div>
                </div>

                <div class="px-8">
                    <h2 class="section-title">{{ __('home.partners_title') }}</h2>
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
            </section>

            <section class="clamp-[pb,56px,64px] mx-auto max-w-7xl px-4 sm:px-5 lg:px-8" id="kontak">
                <div
                    class="cta-strip clamp-[py,32px,48px] flex min-h-32 items-center justify-center bg-cover bg-center px-5 text-center text-white sm:min-h-36 sm:px-6">
                    <p class="max-w-2xl text-xl font-black leading-tight sm:text-2xl">{{ __('site.cta.strip') }}</p>
                </div>
            </section>
        </main>

        <x-site.whatsapp-button :site="$site" />
        <x-site.footer :site="$site" />
    </div>
</x-layouts.app>
