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

        <x-site.layout.container class="clamp-[py,56px,64px] grid gap-8 lg:grid-cols-[360px_1fr]">
            <img class="aspect-4/5 w-full max-w-md object-cover lg:max-w-none"
                src="{{ asset('assets/about/about-1.jpg') }}" alt="Material baja {{ __('site.company_name') }}"
                loading="eager" decoding="async" fetchpriority="high">

            <div class="flex flex-col justify-center">
                <x-site.logo class="" />

                <p class="mt-8 max-w-2xl text-base font-semibold leading-relaxed">
                    {!! __('about.section-1') !!}
                </p>
            </div>
        </x-site.layout.container>

        <x-site.layout.container class="clamp-[py,48px,64px] grid max-w-6xl gap-10 md:grid-cols-[1fr_auto_1fr]">
            <article class="text-center">
                <h2 class="text-brand-red text-3xl font-black uppercase">{{ __('about.vision.title') }}</h2>
                <p class="mt-6 text-sm font-light italic leading-relaxed sm:text-base">
                    {{ __('about.vision.content') }}</p>
            </article>

            <div class="bg-brand-red hidden w-2 md:block"></div>

            <article class="border-brand-red border-t-4 pt-10 text-center md:border-t-0 md:pt-0">
                <h2 class="text-brand-red text-3xl font-black uppercase">{{ __('about.mission.title') }}</h2>
                <p class="mt-6 text-sm font-light italic leading-relaxed sm:text-base">
                    {{ __('about.mission.content') }}</p>
            </article>
        </x-site.layout.container>

        <section class="clamp-[py,48px,64px]"
            x-data="{ active: null }"
            @keydown.escape.window="active = null"
            @click.self="active = null">
            <x-site.section-heading :label="__('about.gallery')" :prominent="true" />
            <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($aboutPage['gallery_images'] as $image)
                    <button type="button" class="cursor-pointer" @click="active = '{{ Storage::url($image) }}'">
                        <img class="aspect-16/10 w-full object-cover"
                            src="{{ Storage::url($image) }}"
                            alt="Galeri material baja" loading="lazy" decoding="async">
                    </button>
                @endforeach
            </div>

            <template x-teleport="body">
                <div x-show="active"
                    x-cloak
                    x-transition.opacity.duration.200ms
                    @click.self="active = null"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4">
                    <div class="relative">
                        <button type="button" class="absolute -right-3 -top-3 z-10 flex size-8 items-center justify-center rounded-full bg-white text-gray-800 shadow-lg hover:bg-gray-100" @click="active = null">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6 6 18M6 6l12 12"/></svg>
                        </button>
                        <img :src="active" class="max-h-[90vh] max-w-full rounded object-contain" alt="Galeri material baja">
                    </div>
                </div>
            </template>
        </section>

        <section class="pt-12">
            <x-site.section-heading :label="__('about.video')" :prominent="true" />
            <div class="bg-brand-red clamp-[py,40px,64px] mt-8 px-4 sm:px-8">
                <x-about.video-frame :url="$aboutPage['youtube_url'] ?? null" />
            </div>
        </section>
    </main>
</x-layouts.app>
