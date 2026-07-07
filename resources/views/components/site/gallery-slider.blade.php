@props([
    'images' => [],
    'name' => '',
    'firstImageTransitionName' => null,
])

<section data-gallery {{ $attributes->merge(['class' => 'max-lg:max-w-[95vw]']) }}>
    <div class="gallery-main swiper">
        <div class="swiper-wrapper">
            @foreach ($images as $image)
                <div class="swiper-slide">
                    <button class="w-full cursor-pointer" type="button"
                        @click="open($el.firstElementChild, {{ $loop->index }})">
                        <img class="aspect-4/3 w-full object-cover" src="{{ $image['url'] }}"
                            alt="{{ $image['alt'] ?? $name }}"
                            @style([
                                'view-transition-name: ' . $firstImageTransitionName => $loop->first && $firstImageTransitionName,
                            ])>
                    </button>
                </div>
            @endforeach
        </div>

        @if (count($images) > 1)
            <x-site.slider-nav class="slider-nav-prev" direction="prev" />
            <x-site.slider-nav class="slider-nav-next" direction="next" />
            <div class="gallery-pagination"></div>
        @endif
    </div>

    @if (count($images) > 1)
        <div class="gallery-thumbs swiper mt-5">
            <div class="swiper-wrapper">
                @foreach ($images as $image)
                    <div class="swiper-slide">
                        <button class="gallery-thumb" type="button">
                            <img class="aspect-video w-full object-cover" src="{{ $image['url'] }}"
                                alt="{{ $image['alt'] ?? $name }}">
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        @foreach ($images as $image)
            <img class="mt-5 aspect-video w-full max-w-48 object-cover" src="{{ $image['url'] }}"
                alt="{{ $image['alt'] ?? $name }}">
        @endforeach
    @endif
</section>
