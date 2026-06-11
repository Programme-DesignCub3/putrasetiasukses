<x-layouts.app :title="__('site.articles.title').' - '.$site->company_name" :description="$site->tagline" image="https://placehold.co/1400x320/4b5563/ffffff?text=Artikel" body-class="bg-black font-sans text-white antialiased">
        <div class="min-h-screen overflow-hidden bg-black">
            <x-site.header :site="$site" active="articles" />

            <main>
                <x-site.page-hero :title="__('site.articles.title')" image="https://placehold.co/1400x320/4b5563/ffffff?text=Artikel" />

                <section class="mx-auto max-w-7xl px-4 clamp-[py,40px,56px] sm:px-5 lg:px-8">
                    <h1 class="section-title section-title-dark">{{ __('site.articles.latest') }}</h1>

                    <div class="relative mt-8 grid gap-6 lg:grid-cols-[2fr_1fr]">
                        @foreach ($featuredArticles as $article)
                            <x-site.article-card :article="$article" :large="$loop->first" />
                        @endforeach

                        <button class="absolute left-0 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-md bg-brand-red text-white" type="button" aria-label="Artikel sebelumnya">
                            <span class="text-4xl font-black leading-none">&lsaquo;</span>
                        </button>
                        <button class="absolute right-0 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-md bg-brand-red text-white" type="button" aria-label="Artikel berikutnya">
                            <span class="text-4xl font-black leading-none">&rsaquo;</span>
                        </button>
                    </div>
                </section>

                <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-5 lg:px-8">
                    <h2 class="section-title section-title-dark">{{ __('site.articles.all') }}</h2>

                    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($articles as $article)
                            <x-site.article-card :article="$article" />
                        @endforeach
                    </div>

                    <nav class="mt-10 flex justify-center gap-5" aria-label="Halaman artikel">
                        <a class="flex h-12 w-12 items-center justify-center rounded-md bg-brand-red text-2xl font-black text-white" href="#">&lsaquo;</a>
                        @foreach ([1, 2, 3, 4] as $page)
                            <a class="flex h-12 w-12 items-center justify-center rounded-md bg-brand-red text-xl font-black text-white" href="#">{{ $page }}</a>
                        @endforeach
                        <a class="flex h-12 w-12 items-center justify-center rounded-md bg-brand-red text-2xl font-black text-white" href="#">&rsaquo;</a>
                    </nav>
                </section>
            </main>

            <x-site.whatsapp-button :site="$site" />
            <x-site.footer :site="$site" />
        </div>
</x-layouts.app>
