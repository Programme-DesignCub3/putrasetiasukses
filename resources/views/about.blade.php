<x-layouts.app>
    <div class="min-h-screen overflow-hidden">
        <x-site.header :site="$site" active="about" />

        <main>
            <x-site.page-hero :title="__('about.title')" :image="$aboutPage->hero_image_url" />

            <section
                class="clamp-[py,56px,64px] mx-auto grid max-w-7xl gap-8 px-4 sm:px-5 lg:grid-cols-[360px_1fr] lg:px-8">
                <img class="aspect-[4/5] w-full max-w-md object-cover lg:max-w-none"
                    src="{{ $aboutPage->intro_image_url }}" alt="Material baja {{ $site->company_name }}"
                    loading="eager" decoding="async" fetchpriority="high">

                <div class="flex flex-col justify-center">
                    <x-site.brand class="opacity-25" :site="$site" dark />

                    @if ($aboutPage->intro_text)
                        <p class="mt-8 max-w-2xl text-base font-semibold leading-relaxed">
                            {{ $aboutPage->intro_text }}
                        </p>
                    @endif
                </div>
            </section>

            <section
                class="clamp-[py,48px,64px] mx-auto grid max-w-6xl gap-10 px-4 sm:px-5 md:grid-cols-[1fr_auto_1fr] lg:px-8">
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
            </section>

            <section class="clamp-[py,48px,64px]">
                <h2 class="text-center text-4xl font-black">{{ __('about.gallery') }}</h2>
                <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($aboutPage->gallery_images ?? [] as $image)
                        <img class="aspect-[16/10] w-full object-cover" src="{{ $image['url'] ?? '' }}"
                            alt="{{ $image['alt'] ?? 'Galeri material baja' }}" loading="lazy" decoding="async">
                    @endforeach
                </div>
            </section>

            <section class="pt-12">
                <h2 class="text-center text-4xl font-black">{{ __('about.video') }}</h2>
                <div class="bg-brand-red clamp-[py,40px,64px] mt-8 px-4 sm:px-8">
                    <x-site.video-frame :url="$aboutPage->video_url" />
                </div>
            </section>
        </main>

        <x-site.whatsapp-button :site="$site" />
        <x-site.footer :site="$site" />
    </div>
</x-layouts.app>
