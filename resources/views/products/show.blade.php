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
            'description' => $product->description,
            'image' => $product->main_image_url,
            'category' => $product->category_names,
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
@endpush

@php
    $productGallery = $productImages->map(fn($img) => [
        'url' => $img['url'],
        'alt' => $img['alt'] ?? $product->name,
    ]);
@endphp

<x-app body-class="bg-white font-sans text-brand-ink antialiased" active-section="products"
    x-data="galleryLightbox({ images: {{ Illuminate\Support\Js::from($productGallery) }} })">
    <main class="clamp-[py,4px,80px] mx-auto max-w-7xl px-4 sm:px-5 lg:px-8">
        <a href="{{ route('products.index') }}"
            class="mb-6 inline-flex items-center gap-2 text-sm font-bold uppercase text-brand-red hover:text-brand-red-dark transition">
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
                <div class="max-h-115 mt-6 overflow-y-auto pr-4 text-lg font-medium leading-relaxed text-zinc-700">
                    @foreach (preg_split('/\R+/', $product->description) as $paragraph)
                        <p class="mb-6 last:mb-0">{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>

            <a class="bg-brand-red hover:bg-brand-red-dark mt-10 inline-flex w-full max-w-xl items-center justify-center gap-4 rounded-full px-8 py-5 text-2xl font-black uppercase text-white transition"
                href="{{ route('contact') }}">
                <x-lucide-phone class="h-8 w-8" />
                {{ __('products.order') }}
            </a>
        </section>
        </div>
    </main>
</x-app>
