<x-layouts.app :title="__('site.products.title').' - '.$site->company_name" :description="__('site.products.intro')" image="https://placehold.co/1400x320/2b2b2b/ffffff?text=Produk" body-class="bg-white font-sans text-brand-ink antialiased">
        <div class="min-h-screen overflow-hidden">
            <x-site.header :site="$site" active="products" />

            <main>
                <x-site.page-hero :title="__('site.products.title')" image="https://placehold.co/1400x320/2b2b2b/ffffff?text=Produk" />

                <section class="mx-auto max-w-7xl px-4 clamp-[py,48px,72px] sm:px-5 lg:px-8">
                    <div class="max-w-3xl">
                        <h1 class="section-title">{{ __('site.products.title') }}</h1>
                        <p class="mt-6 text-base font-semibold leading-relaxed text-zinc-600 sm:text-lg">
                            {{ __('site.products.intro') }}
                        </p>
                    </div>

                    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($products as $product)
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
                                        {{ __('site.products.view_detail') }}
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            </main>

            <x-site.whatsapp-button :site="$site" />
            <x-site.footer :site="$site" />
        </div>
</x-layouts.app>
