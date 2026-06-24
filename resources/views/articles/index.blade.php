<x-layouts.app body-class="bg-white font-sans text-brand-ink antialiased" active-section="articles" :site="$site">
    <main>
        <x-site.layout.page-hero :title="__('articles.title')" image="https://placehold.co/1400x320/4b5563/ffffff?text=Artikel" />

        <x-site.layout.container class="clamp-[py,40px,56px]">
            <x-site.section-heading :level="1" :label="__('articles.latest')" />

            <div class="relative mt-8 grid gap-6 lg:grid-cols-[2fr_1fr]">
                @foreach ($featuredArticles as $article)
                    <x-articles.article-card :article="$article" :large="$loop->first" />
                @endforeach

                <button class="absolute left-0 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-md bg-brand-red text-white" type="button" aria-label="Artikel sebelumnya">
                    <span class="text-4xl font-black leading-none">&lsaquo;</span>
                </button>
                <button class="absolute right-0 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-md bg-brand-red text-white" type="button" aria-label="Artikel berikutnya">
                    <span class="text-4xl font-black leading-none">&rsaquo;</span>
                </button>
            </div>
        </x-site.layout.container>

        <x-site.layout.container class="pb-16">
            <x-site.section-heading :label="__('articles.all')" />

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <x-articles.article-card :article="$article" />
                @endforeach
            </div>

            <nav class="mt-10 flex justify-center gap-5" aria-label="Halaman artikel">
                <a class="flex h-12 w-12 items-center justify-center rounded-md bg-brand-red text-2xl font-black text-white" href="#">&lsaquo;</a>
                @foreach ([1, 2, 3, 4] as $page)
                    <a class="flex h-12 w-12 items-center justify-center rounded-md bg-brand-red text-xl font-black text-white" href="#">{{ $page }}</a>
                @endforeach
                <a class="flex h-12 w-12 items-center justify-center rounded-md bg-brand-red text-2xl font-black text-white" href="#">&rsaquo;</a>
            </nav>
        </x-site.layout.container>
    </main>
</x-layouts.app>
