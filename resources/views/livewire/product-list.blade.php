<div class="list-container">
    <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <input class="w-full bg-zinc-200 px-4 py-3 pr-10 text-sm font-semibold text-black placeholder-zinc-500"
                type="search" wire:model.live.debounce.300ms="search" placeholder="{{ __('products.search') }}">
            <x-lucide-search class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-zinc-500" />
        </div>

        <select class="w-full bg-zinc-200 px-4 py-3 text-sm font-semibold text-black sm:w-56"
            wire:model.live="categoryId">
            <option value="">{{ __('products.all_categories') }}</option>
            @foreach ($this->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-6 flex items-center justify-center py-12" wire:loading.delay>
        <x-lucide-loader-circle class="text-brand-red h-8 w-8 animate-spin" />
    </div>

    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3" wire:loading.class="opacity-50" x-data="staggerList">
        @forelse ($products as $product)
            <div wire:key="product-{{ $product->id }}" >
                <x-products.product-card :product="$product" />
            </div>
        @empty
            <p class="py-12 text-center text-base font-semibold text-zinc-500 sm:col-span-2 lg:col-span-3">
                {{ __('products.no_results') }}
            </p>
        @endforelse
    </div>

    @if ($products->hasPages())
        <div class="mt-10">
            {{ $products->onEachSide(1)->links() }}
        </div>
    @endif
</div>
