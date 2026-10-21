@php
    $productImages = collect([
        [
            'url' => $product->main_image_url,
            'alt' => $product->name,
        ],
    ])
        ->merge($product->gallery_images ?? [])
        ->filter(fn(array $image): bool => filled($image['url'] ?? null))
        ->unique('url')
        ->values();

    $breadcrumbs = [
        ['name' => __('Home'), 'url' => route('home')],
        ['name' => __('Produk'), 'url' => route('products.index')],
        ['name' => $product->name, 'url' => route('products.show', $product)],
    ];
@endphp

@push('schemas')
    <x-seo.breadcrumbs :items="$breadcrumbs" />

    @php
        $productSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => strip_tags($product->description),
            'image' => $product->main_image_url,
            'category' => $product->category_names,
            'brand' => [
                '@type' => 'Brand',
                'name' => __('site.company_name'),
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
@endpush

@php
    $productGallery = $productImages->map(
        fn($img) => [
            'url' => $img['url'],
            'alt' => $img['alt'] ?? $product->name,
        ],
    );
@endphp

<x-layouts.app active-section="products" x-data="galleryLightbox({ images: {{ Illuminate\Support\Js::from($productGallery) }} })">
    <x-site.layout.container class="clamp-[py,4px,80px] px-4">
        <a class="text-brand-red hover:text-brand-red-dark mb-6 inline-flex items-center gap-2 text-sm font-bold uppercase transition"
            href="{{ route('products.index') }}">
            <x-lucide-arrow-left class="size-4" stroke-width="3" />
            {{ __('site.back') }}
        </a>

        <div class="grid gap-10 lg:grid-cols-2">
            <x-site.gallery-slider class="max-lg:max-w-[95vw]" :images="$productImages" :name="$product->name"
                firstImageTransitionName="product-image-{{ $product->id }}" />
            <x-site.gallery-lightbox />

            <section class="flex flex-col">
                <p class="text-brand-red-dark text-2xl font-black">{{ $product->category_names }}</p>
                <h1 class="mt-3 text-5xl font-black leading-none text-black sm:text-6xl">{{ $product->name }}</h1>

                <div class="mt-12">
                    <h2 class="section-title">{{ __('products.description') }}</h2>
                    <div class="prose prose-lg prose-zinc mt-6 max-w-none">
                        {!! $product->renderRichContent('description') !!}
                    </div>
                </div>

                <a class="bg-brand-red hover:bg-brand-red-dark mt-10 inline-flex w-full max-w-[1556px] max-w-xl items-center justify-center gap-4 rounded-full px-8 py-5 text-2xl font-black uppercase text-white transition"
                    href="{{ route('contact') }}">
                    <x-lucide-phone class="h-8 w-8" />
                    {{ __('products.order') }}
                </a>
            </section>
        </div>

        @if (filled($product->content))
            <div class="mx-auto mt-16 max-w-5xl">
                <div
                    class="prose prose-lg prose-zinc [&_a]:text-brand-red [&_blockquote]:border-brand-red max-w-none [&_a]:font-black [&_blockquote]:border-l-4 [&_blockquote]:pl-5 [&_blockquote]:italic [&_h2]:mt-10 [&_h2]:text-3xl [&_h2]:font-black [&_h2]:text-black [&_h3]:mt-8 [&_h3]:text-2xl [&_h3]:font-black [&_h3]:text-black [&_li]:mb-2 [&_ol]:my-7 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:mb-7 [&_ul]:my-7 [&_ul]:list-disc [&_ul]:pl-6">
                    {!! $product->renderRichContent('content') !!}
                </div>
            </div>
        @endif
    </x-site.layout.container>
</x-layouts.app>
