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
        <x-site.layout.page-hero :title="__('about.title')" :image="$aboutPage->hero_image_url" />

        <x-site.layout.container class="clamp-[py,56px,64px] grid gap-8 lg:grid-cols-[360px_1fr]">
            <img class="aspect-4/5 w-full max-w-md object-cover lg:max-w-none" src="{{ $aboutPage->intro_image_url }}"
                alt="Material baja {{ __('site.company_name') }}" loading="eager" decoding="async" fetchpriority="high">

            <div class="flex flex-col justify-center">
                <x-site.brand class="opacity-25" />

                @if ($aboutPage->intro_text)
                    <p class="mt-8 max-w-2xl text-base font-semibold leading-relaxed">
                        {{ $aboutPage->intro_text }}
                    </p>
                @endif
            </div>
        </x-site.layout.container>

        <x-site.layout.container class="clamp-[py,48px,64px] grid max-w-6xl gap-10 md:grid-cols-[1fr_auto_1fr]">
            <article class="text-center">
                <h2 class="text-brand-red text-3xl font-black uppercase">{{ __('about.vision') }}</h2>
                <p class="mt-6 text-sm font-semibold leading-relaxed sm:text-base">
                    {{ $aboutPage->vision_body }}</p>
            </article>

            <div class="bg-brand-red hidden w-2 md:block"></div>

            <article class="border-brand-red border-t-4 pt-10 text-center md:border-t-0 md:pt-0">
                <h2 class="text-brand-red text-3xl font-black uppercase">{{ __('about.mission') }}</h2>
                <p class="mt-6 text-sm font-semibold leading-relaxed sm:text-base">
                    {{ $aboutPage->mission_body }}</p>
            </article>
        </x-site.layout.container>

        <section class="clamp-[py,48px,64px]">
            <x-site.section-heading :label="__('about.gallery')" :prominent="true" />
            <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($aboutPage->gallery_images ?? [] as $image)
                    <img class="aspect-16/10 w-full object-cover" src="{{ $image['url'] ?? '' }}"
                        alt="{{ $image['alt'] ?? 'Galeri material baja' }}" loading="lazy" decoding="async">
                @endforeach
            </div>
        </section>

        <section class="pt-12">
            <x-site.section-heading :label="__('about.video')" :prominent="true" />
            <div class="bg-brand-red clamp-[py,40px,64px] mt-8 px-4 sm:px-8">
                <x-about.video-frame :url="$aboutPage->video_url" />
            </div>
        </section>
    </main>
</x-layouts.app>
