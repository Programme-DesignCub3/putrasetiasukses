@props(['product'])

<article
    class="group flex h-full flex-col overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
    <a class="block overflow-hidden" href="{{ route('products.show', $product) }}">
        <img class="aspect-4/3 w-full object-cover transition duration-300 group-hover:scale-105"
            src="{{ $product->main_image_url }}" alt="{{ $product->name }}"
            style="view-transition-name: product-image-{{ $product->id }}">
    </a>

    <div class="flex flex-1 flex-col p-3 sm:p-5">
        <p class="text-brand-red-dark text-xs font-black uppercase sm:text-sm">{{ $product->category_names }}</p>
        <h2 class="mt-1 text-base font-black leading-tight text-black sm:mt-2 sm:text-xl lg:text-2xl">{{ $product->name }}</h2>
        <p class="mt-2 flex-1 line-clamp-3 text-xs font-medium leading-relaxed text-zinc-600 sm:mt-4 sm:line-clamp-4 sm:text-sm">
            {{ $product->description }}
        </p>

        <a class="bg-brand-red hover:bg-brand-red-dark mt-3 inline-flex items-center justify-center rounded-full px-4 py-2 text-xs font-black uppercase text-white transition sm:mt-6 sm:px-6 sm:py-3 sm:text-sm"
            href="{{ route('products.show', $product) }}">
            {{ __('products.view_detail') }}
        </a>
    </div>
</article>
