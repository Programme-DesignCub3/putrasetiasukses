<x-layouts.app body-class="bg-white font-sans text-brand-ink antialiased" active-section="products" :site="$site">
    <main>
        <x-site.layout.page-hero :title="__('products.title')" image="https://placehold.co/1400x320/2b2b2b/ffffff?text=Produk" />

        <x-site.layout.container class="clamp-[py,48px,72px]">
            <div class="max-w-3xl">
                <x-site.section-heading :level="1" :label="__('products.title')" />
                <p class="mt-6 text-base font-semibold leading-relaxed text-zinc-600 sm:text-lg">
                    {{ __('products.intro') }}
                </p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($products as $product)
                    <x-products.product-card :product="$product" />
                @endforeach
            </div>
        </x-site.layout.container>
    </main>
</x-layouts.app>
