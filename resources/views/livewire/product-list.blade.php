<div class="list-container">
    @if (!$compact)
        <div class="relative flex-1">
            <input class="w-full bg-zinc-200 px-4 py-3 pr-10 text-sm font-semibold text-black placeholder-zinc-500"
                type="search" wire:model.live.debounce.300ms="search" placeholder="{{ __('products.search') }}">
            <x-lucide-search
                class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-zinc-500" />
        </div>
    @endif

    <div class="{{ $compact ? '' : 'mt-4' }} category-slider-nav" data-category-slider>
        <x-site.slider-nav class="slider-nav-prev" direction="prev" />
        <div class="category-slider-swiper swiper min-w-0 flex-1">
            <div class="swiper-wrapper">
                <div class="swiper-slide w-fit!">
                    <button @class([
                        'rounded-full px-4 py-2 text-sm font-semibold transition',
                        'bg-brand-red text-white' => $categorySlug === '',
                        'bg-zinc-200 text-zinc-700 hover:bg-zinc-300' => $categorySlug !== '',
                    ]) wire:click="$set('categorySlug', '')">
                        {{ __('products.all_categories') }}
                    </button>
                </div>
                @foreach ($this->categories as $category)
                    <div class="swiper-slide w-fit!">
                        <button @class([
                            'rounded-full px-4 py-2 text-sm font-semibold transition',
                            'bg-brand-red text-white' => $categorySlug == $category->slug,
                            'bg-zinc-200 text-zinc-700 hover:bg-zinc-300' =>
                                $categorySlug != $category->slug,
                        ]) wire:click="$set('categorySlug', '{{ $category->slug }}')">
                            {{ $category->name }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        <x-site.slider-nav class="slider-nav-next" direction="next" />
    </div>

    <div class="mt-6 flex items-center justify-center py-12" wire:loading.delay>
        <x-lucide-loader-circle class="text-brand-red h-8 w-8 animate-spin" />
    </div>

    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3" wire:loading.class="opacity-50"
        x-data="staggerList">
        @forelse ($products as $product)
            <div wire:key="product-{{ $product->id }}">
                <x-products.product-card :product="$product" />
            </div>
        @empty
            <p class="py-12 text-center text-base font-semibold text-zinc-500 sm:col-span-2 lg:col-span-3">
                {{ __('products.no_results') }}
            </p>
        @endforelse
    </div>

    @if ($compact)
        <div class="mt-8 text-center">
            <a class="bg-brand-red hover:bg-brand-red/90 inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-semibold text-white transition"
                href="{{ route('products.index') }}{{ $categorySlug ? '?category=' . $categorySlug : '' }}">
                {{ __('products.see_more') }}
                <x-lucide-arrow-right class="size-4" />
            </a>
        </div>
    @elseif ($products->hasPages())
        <div class="mt-10">
            {{ $products->onEachSide(1)->links() }}
        </div>
    @endif
</div>
