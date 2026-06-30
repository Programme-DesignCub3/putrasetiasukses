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

<x-app body-class="bg-white font-sans text-brand-ink antialiased" active-section="products">
    <main class="clamp-[py,4px,80px] mx-auto grid max-w-7xl gap-10 px-4 sm:px-5 lg:grid-cols-2 lg:px-8">
        <x-site.gallery-slider class="max-lg:max-w-[95vw]" :images="$productImages" :name="$product->name" />

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
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path
                        d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24c1.12.37 2.33.56 3.58.56a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.19 2.46.56 3.58a1 1 0 0 1-.25 1.01z" />
                </svg>
                {{ __('products.order') }}
            </a>
        </section>
    </main>
</x-app>
