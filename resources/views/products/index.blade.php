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

            <livewire:product-list />
        </x-site.layout.container>
    </main>
</x-layouts.app>
