@php
    $breadcrumbs = [
        ['name' => __('Home'), 'url' => route('home')],
        ['name' => __('Tentang Kami'), 'url' => route('about')],
    ];
@endphp

@push('schemas')
    <x-seo.breadcrumbs :items="$breadcrumbs" />
@endpush

<x-layouts.app>
    <main>
        <x-site.layout.page-hero :title="__('about.title')" :image="asset('assets/about/about-header.png')" />

        <x-site.layout.container class="clamp-[py,56px,64px] grid grid-cols-1 gap-8 lg:grid-cols-[35%_1fr]">
            <div class="max-lg:aspect-4/3 lg:relative">
                <img class="h-full w-full object-cover lg:absolute lg:inset-0"
                    src="{{ asset('assets/about/about-1.jpg') }}" alt="Material baja {{ __('site.company_name') }}"
                    loading="eager" decoding="async" fetchpriority="high">
            </div>

            <div class="flex flex-col justify-center">
                <x-site.logo class="w-3/5 pt-8" />

                <div class="mt-8 flex max-w-2xl flex-col gap-4 text-base leading-relaxed">
                    {!! __('about.section-1') !!}
                </div>
            </div>
        </x-site.layout.container>

        <x-site.layout.container class="clamp-[py,48px,64px] grid max-w-6xl gap-10 md:grid-cols-[1fr_auto_1fr]">
            <article class="text-center">
                <h2 class="text-brand-red text-3xl font-black uppercase">{{ __('about.vision.title') }}</h2>
                <p class="mt-6 text-sm italic leading-relaxed sm:text-base">
                    {{ __('about.vision.content') }}</p>
            </article>

            <div class="bg-brand-red hidden w-2 md:block"></div>

            <article class="border-brand-red border-t-4 pt-10 text-center md:border-t-0 md:pt-0">
                <h2 class="text-brand-red text-3xl font-black uppercase">{{ __('about.mission.title') }}</h2>
                <p class="mt-6 text-sm italic leading-relaxed sm:text-base">
                    {{ __('about.mission.content') }}</p>
            </article>
        </x-site.layout.container>

        @php
            $aboutGallery = collect($aboutPage['gallery_images'] ?? [])
                ->map(fn($url) => ['url' => Storage::url($url), 'alt' => 'Galeri material baja'])
                ->values();

            $aboutGalleryJson = Illuminate\Support\Js::from($aboutGallery);
        @endphp

        <section class="clamp-[py,48px,64px]" x-data="aboutGallery({ images: {{ $aboutGalleryJson }} })">
            <x-site.section-heading :label="__('about.gallery')" :prominent="true" />
            <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($aboutGallery as $index => $image)
                    <button class="cursor-pointer" type="button"
                        @click="open($el.firstElementChild, {{ $index }})">
                        <img class="aspect-16/10 w-full object-cover" src="{{ $image['url'] }}"
                            alt="{{ $image['alt'] }}" loading="lazy" decoding="async">
                    </button>
                @endforeach
            </div>

            <div class="about-lb-overlay fixed inset-0 z-50 items-center justify-center bg-black/80"
                @click.self="close">
                <div class="z-1 relative flex max-h-[90vh] max-w-[95vw] items-center justify-center">
                    <button
                        class="absolute -right-3 -top-3 z-10 flex size-9 items-center justify-center rounded-full bg-white text-gray-800 shadow-lg hover:bg-gray-100"
                        type="button" @click="close">
                        <x-lucide-x class="size-4" stroke-width="3" />
                    </button>

                    <img class="about-lb-image max-h-[90vh] max-w-[95vw] rounded object-contain drop-shadow-2xl"
                        src="" alt="">
                </div>

                <template x-if="images.length > 1">
                    <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 gap-2">
                        <template x-for="(image, i) in images" :key="i">
                            <button class="size-2.5 rounded-full transition"
                                x-bind:class="i === currentIndex ? 'bg-white' : 'bg-white/40'" type="button"
                                @click="goTo(i)"></button>
                        </template>
                    </div>
                </template>

                <template x-if="images.length > 1">
                    <button
                        class="absolute left-4 top-1/2 z-10 flex size-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-gray-800 shadow-lg hover:bg-white"
                        type="button" @click="prev">
                        <x-lucide-chevron-left class="size-6" stroke-width="2.5" />
                    </button>
                </template>

                <template x-if="images.length > 1">
                    <button
                        class="absolute right-4 top-1/2 z-10 flex size-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-gray-800 shadow-lg hover:bg-white"
                        type="button" @click="next">
                        <x-lucide-chevron-right class="size-6" stroke-width="2.5" />
                    </button>
                </template>
            </div>
        </section>

        <section class="pt-12">
            <x-site.section-heading :label="__('about.video')" :prominent="true" />
            <div class="bg-brand-red clamp-[py,40px,64px] mt-8 px-4 sm:px-8">
                <x-about.video-frame :url="$aboutPage['youtube_url'] ?? null" />
            </div>
        </section>
    </main>
</x-layouts.app>
