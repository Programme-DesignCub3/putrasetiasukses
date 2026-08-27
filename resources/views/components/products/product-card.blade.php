@props(['product'])

<article
    class="hover:shadow-top group relative flex h-full flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-xl transition hover:-translate-y-1 lg:mix-blend-multiply lg:hover:bg-black lg:hover:[&>div]:translate-y-0">
    <a class="block" href="{{ route('products.show', $product) }}">
        <div class="shadow-top overflow-hidden rounded-2xl">
            <img class="aspect-video w-full object-cover transition duration-300 group-hover:scale-105"
                src="{{ $product->main_image_url }}" alt="{{ $product->name }}"
                style="view-transition-name: product-image-{{ $product->id }}">
        </div>

        <div class="mt-1 p-4 px-6">
            <div class="">
                <h2 class="text-base font-black leading-tight text-black sm:mt-2 sm:text-xl lg:text-2xl">
                    {{ $product->name }}</h2>
                <p class="clamp-[text,xs,sm,@sm] line-clamp-1 flex-1 font-medium leading-relaxed text-zinc-600">
                    {{ strip_tags($product->description) }}
                </p>
            </div>


            <p class="clamp-[text,xs,sm,@sm] mt-6 font-black uppercase text-zinc-600">
                Category: {{ $product->category_names }}
            </p>
        </div>
    </a>
</article>
