<x-layouts.app :title="$product->name.' - '.$site->company_name" body-class="bg-white font-sans text-brand-ink antialiased">
        <div class="min-h-screen overflow-hidden">
            <x-site.header :site="$site" active="products" />

            <main class="mx-auto grid max-w-7xl gap-10 px-4 clamp-[py,48px,80px] sm:px-5 lg:grid-cols-2 lg:px-8">
                <section>
                    <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" class="aspect-[4/3] w-full object-cover">

                    <div class="relative mt-6 grid grid-cols-3 gap-3 sm:gap-4">
                        @foreach ($product->gallery_images ?? [] as $image)
                            <img src="{{ $image['url'] ?? '' }}" alt="{{ $image['alt'] ?? $product->name }}" class="aspect-[16/9] w-full object-cover">
                        @endforeach

                        <button class="absolute left-0 top-1/2 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-md bg-brand-red text-white" type="button" aria-label="Gambar sebelumnya">
                            <span class="text-2xl font-black leading-none">&lsaquo;</span>
                        </button>
                        <button class="absolute right-0 top-1/2 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-md bg-brand-red text-white" type="button" aria-label="Gambar berikutnya">
                            <span class="text-2xl font-black leading-none">&rsaquo;</span>
                        </button>
                    </div>
                </section>

                <section class="flex flex-col">
                    <p class="text-2xl font-black text-brand-red-dark">{{ $product->category }}</p>
                    <h1 class="mt-3 text-5xl font-black leading-none text-black sm:text-6xl">{{ $product->name }}</h1>

                    <div class="mt-12">
                        <h2 class="section-title">{{ __('site.products.description') }}</h2>
                        <div class="mt-6 max-h-[460px] overflow-y-auto pr-4 text-lg font-medium leading-relaxed text-zinc-700">
                            @foreach (preg_split('/\R+/', $product->description) as $paragraph)
                                <p class="mb-6 last:mb-0">{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('contact') }}" class="mt-10 inline-flex w-full max-w-xl items-center justify-center gap-4 rounded-full bg-brand-red px-8 py-5 text-2xl font-black uppercase text-white transition hover:bg-brand-red-dark">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24c1.12.37 2.33.56 3.58.56a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.19 2.46.56 3.58a1 1 0 0 1-.25 1.01z"/></svg>
                        {{ __('site.products.order') }}
                    </a>
                </section>
            </main>

            <x-site.whatsapp-button :site="$site" />
            <x-site.footer :site="$site" />
        </div>
</x-layouts.app>
