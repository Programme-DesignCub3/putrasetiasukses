<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ \NielsNumbers\LaravelLocalizer\Facades\Localizer::currentLocaleDirection() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('site.about.title') }} - {{ $site->company_name }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-black font-sans text-white antialiased">
        <div class="min-h-screen overflow-hidden bg-black">
            <x-site.header :site="$site" active="about" />

            <main>
                <x-site.page-hero :title="__('site.about.title')" :image="$aboutPage->hero_image_url" />

                <section class="mx-auto grid max-w-7xl gap-8 px-4 clamp-[py,56px,64px] sm:px-5 lg:grid-cols-[360px_1fr] lg:px-8">
                    <img src="{{ $aboutPage->intro_image_url }}" alt="Material baja {{ $site->company_name }}" class="aspect-[4/5] w-full max-w-md object-cover lg:max-w-none">

                    <div class="flex flex-col justify-center">
                        <x-site.brand :site="$site" dark class="opacity-25" />

                        @if ($aboutPage->intro_text)
                            <p class="mt-8 max-w-2xl text-base font-semibold leading-relaxed text-white/70">
                                {{ $aboutPage->intro_text }}
                            </p>
                        @endif
                    </div>
                </section>

                <section class="mx-auto grid max-w-6xl gap-10 px-4 clamp-[py,48px,64px] sm:px-5 md:grid-cols-[1fr_auto_1fr] lg:px-8">
                    <article class="text-center">
                        <h2 class="text-3xl font-black uppercase text-brand-red">{{ __('site.about.vision') }}</h2>
                        <p class="mt-6 text-sm font-semibold leading-relaxed text-white/65 sm:text-base">{{ $aboutPage->vision_body }}</p>
                    </article>

                    <div class="hidden w-2 bg-brand-red md:block"></div>

                    <article class="border-t-4 border-brand-red pt-10 text-center md:border-t-0 md:pt-0">
                        <h2 class="text-3xl font-black uppercase text-brand-red">{{ __('site.about.mission') }}</h2>
                        <p class="mt-6 text-sm font-semibold leading-relaxed text-white/65 sm:text-base">{{ $aboutPage->mission_body }}</p>
                    </article>
                </section>

                <section class="clamp-[py,48px,64px]">
                    <h2 class="text-center text-4xl font-black text-white/25">{{ __('site.about.gallery') }}</h2>
                    <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($aboutPage->gallery_images ?? [] as $image)
                            <img src="{{ $image['url'] ?? '' }}" alt="{{ $image['alt'] ?? 'Galeri material baja' }}" class="aspect-[16/10] w-full object-cover">
                        @endforeach
                    </div>
                </section>

                <section class="pt-12">
                    <h2 class="text-center text-4xl font-black text-white/25">{{ __('site.about.video') }}</h2>
                    <div class="mt-8 bg-brand-red px-4 clamp-[py,40px,64px] sm:px-8">
                        <x-site.video-frame :url="$aboutPage->video_url" />
                    </div>
                </section>
            </main>

            <x-site.whatsapp-button :site="$site" />
            <x-site.footer :site="$site" />
        </div>
    </body>
</html>
