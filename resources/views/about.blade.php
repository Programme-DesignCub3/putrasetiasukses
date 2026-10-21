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
        <x-site.layout.page-hero :title="__('about.title')" :headline="__('about.headline')" :subheadline="__('about.subheadline')" :image="asset('assets/about/about-header.png')" />

        <x-site.layout.container class="clamp-[py,56px,64px] grid grid-cols-1 gap-8 lg:grid-cols-[35%_1fr]">
            <div class="max-lg:aspect-4/3 lg:relative">
                <img class="h-full w-full object-cover lg:absolute lg:inset-0"
                    src="{{ asset('assets/about/about-1.jpg') }}" alt="Material baja {{ __('site.company_name') }}"
                    loading="eager" decoding="async" fetchpriority="high">
            </div>

            <div class="flex flex-col justify-center">
                <img class="w-3/5 pt-8" src="{{ asset('assets/logo.png') }}" alt="{{ __('site.company_name') }} logo">

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

        <section class="pt-12">
            <x-site.section-heading :title="__('about.video')" :prominent="true" />
            <div class="bg-brand-red clamp-[py,40px,64px] mt-8 px-4 sm:px-8">
                <x-about.video-frame :url="$aboutPage['youtube_url'] ?? null" />
            </div>
        </section>
    </main>
</x-layouts.app>
