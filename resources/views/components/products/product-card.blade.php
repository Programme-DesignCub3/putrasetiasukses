@props(['product'])

<article
    class="group flex h-full flex-col overflow-hidden border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
    <a class="block overflow-hidden" href="{{ route('products.show', $product) }}">
        <img class="aspect-4/3 w-full object-cover transition duration-300 group-hover:scale-105"
            src="{{ $product->main_image_url }}" alt="{{ $product->name }}">
    </a>

    <div class="flex flex-1 flex-col p-5">
        <p class="text-brand-red-dark text-sm font-black uppercase">{{ $product->category_names }}</p>
        <h2 class="mt-2 text-2xl font-black leading-tight text-black">{{ $product->name }}</h2>
        <p class="mt-4 line-clamp-4 text-sm font-medium leading-relaxed text-zinc-600">
            {{ $product->description }}
        </p>

        <a class="bg-brand-red hover:bg-brand-red-dark mt-6 inline-flex items-center justify-center rounded-full px-6 py-3 text-sm font-black uppercase text-white transition"
            href="{{ route('products.show', $product) }}">
            {{ __('products.view_detail') }}
        </a>
    </div>
</article>
