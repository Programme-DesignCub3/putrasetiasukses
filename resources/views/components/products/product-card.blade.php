@props([
    'product',
])

<article class="group flex h-full flex-col overflow-hidden border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
    <a href="{{ route('products.show', $product) }}" class="block overflow-hidden">
        <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="aspect-[4/3] w-full object-cover transition duration-300 group-hover:scale-105">
    </a>

    <div class="flex flex-1 flex-col p-5">
        <p class="text-sm font-black uppercase text-brand-red-dark">{{ $product->category_names }}</p>
        <h2 class="mt-2 text-2xl font-black leading-tight text-black">{{ $product->name }}</h2>
        <p class="mt-4 line-clamp-4 text-sm font-medium leading-relaxed text-zinc-600">
            {{ $product->description }}
        </p>

        <a href="{{ route('products.show', $product) }}" class="mt-6 inline-flex items-center justify-center rounded-full bg-brand-red px-6 py-3 text-sm font-black uppercase text-white transition hover:bg-brand-red-dark">
            {{ __('products.view_detail') }}
        </a>
    </div>
</article>
