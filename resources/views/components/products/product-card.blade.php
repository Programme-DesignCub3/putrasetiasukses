@props(['product'])

<article
    class="group relative flex h-full flex-col overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl lg:mix-blend-multiply lg:hover:bg-black lg:hover:[&>div]:translate-y-0 lg:hover:[&>div]:opacity-100">
    <a class="block overflow-hidden" href="{{ route('products.show', $product) }}">
        <img class="aspect-4/3 w-full object-cover transition duration-300 group-hover:scale-105"
            src="{{ $product->main_image_url }}" alt="{{ $product->name }}"
            style="view-transition-name: product-image-{{ $product->id }}">
    </a>

    <div
        class="lg:bg-linear-to-b duration lg:max-h-4/5 bottom-0 flex w-full flex-1 flex-col gap-2 p-3 transition-[translate,opacity] duration-700 ease-in-out lg:absolute lg:translate-y-full lg:to-white lg:p-5 lg:opacity-0">
        <div class="flex flex-col gap-2">
            <p class="text-brand-red-dark text-xs font-black uppercase sm:text-sm">{{ $product->category_names }}</p>
            <h2 class="text-base font-black leading-tight text-black sm:mt-2 sm:text-xl lg:text-2xl">
                {{ $product->name }}</h2>
        </div>
        <p
            class="line-clamp-3 flex-1 text-xs font-medium leading-relaxed max-md:text-zinc-600 sm:mt-4 sm:line-clamp-4 sm:text-sm">
            {{ strip_tags($product->description) }}
        </p>

        <a class="bg-brand-red hover:bg-brand-red-dark inline-flex items-center justify-center rounded-full px-4 py-2 text-xs font-black uppercase text-white transition sm:mt-6 sm:px-6 sm:py-3 sm:text-sm"
            href="{{ route('products.show', $product) }}">
            {{ __('products.view_detail') }}
        </a>
    </div>
</article>
