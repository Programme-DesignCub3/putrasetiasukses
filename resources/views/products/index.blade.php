@php
    $breadcrumbs = [
        ['name' => __('Home'), 'url' => route('home')],
        ['name' => __('Produk'), 'url' => route('products.index')],
    ];
@endphp

@push('schemas')
    <x-seo.breadcrumbs :items="$breadcrumbs" />
@endpush

<x-app body-class="bg-white font-sans text-brand-ink antialiased" active-section="products">
    <main>
        <x-site.layout.page-hero :title="__('products.title')" :image="asset('assets/about/about-header.png')" />

        <x-site.layout.container>

        </x-site.layout.container>

        <x-site.layout.container class="clamp-[py,48px,72px]">
            <div class="max-w-3xl">
                <x-site.section-heading :level="1" :label="__('products.title')" />
                <p class="mt-6 text-base font-semibold leading-relaxed text-zinc-600 sm:text-lg">
                    {{ __('products.intro') }}
                </p>
            </div>

            <livewire:product-list />
        </x-site.layout.container>

        <x-site.layout.container class="clamp-[pb,56px,72px]">
            <x-site.section-heading :label="__('products.faq_title')" />
            <div class="mt-10">
                <x-faq.accordion :faqs="$faqs" />
            </div>
        </x-site.layout.container>
    </main>
</x-app>
