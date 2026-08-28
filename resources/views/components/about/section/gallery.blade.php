@props(['data'])

@php
    $aboutGallery = collect($data)
        ->map(fn($url) => ['url' => Storage::url($url), 'alt' => 'Galeri material baja'])
        ->values();

    $aboutGalleryJson = Illuminate\Support\Js::from($aboutGallery);
    $slides = $aboutGallery->chunk(8)->values();
@endphp

<div class="clamp-[px,10,16] clamp-[py,3,6] shadow-top clamp-[gap,6,12] grid grid-cols-1 rounded-2xl md:grid-cols-[1fr_35%] md:content-center md:items-center"
    x-data="aboutGallery({ images: {{ $aboutGalleryJson }} })">

    <div class="text-brand-red uppercase">
        <h2 class="clamp-[text,2xl,4xl] font-bold">Our Gallery</h2>
        <p class="clamp-[text,sm,xl]">More Than Steel, We Deliver Confidence</p>
    </div>

    <div class="about-gallery-nav clamp-[mr,0,24] relative">
        <div class="gallery-slider swiper relative">
            <div class="swiper-wrapper">
                @foreach ($slides as $slideImages)
                    <div class="swiper-slide">
                        <div class="grid grid-cols-2 gap-2 md:grid-cols-4">
                            @foreach ($slideImages as $image)
                                @php $globalIndex = $loop->parent->iteration * 8 - 8 + $loop->iteration - 1; @endphp
                                <button class="cursor-pointer overflow-clip rounded-xl" type="button"
                                    @click="open($el.firstElementChild, {{ $globalIndex }})">
                                    <img class="aspect-square w-full object-cover" src="{{ $image['url'] }}"
                                        alt="{{ $image['alt'] }}" loading="lazy" decoding="async">
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <x-site.slider-nav class="slider-nav-prev clamp-[left,-8,-12,@md]" direction="prev" />
        <x-site.slider-nav class="slider-nav-next clamp-[right,-8,-12,@md]" direction="next" />

        <div class="about-lb-overlay fixed inset-0 z-50 items-center justify-center bg-black/80" @click.self="close">
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
    </div>
</div>
