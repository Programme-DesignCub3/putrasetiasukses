@php
    $breadcrumbs = [
        ['name' => __('Home'), 'url' => route('home')],
        ['name' => __('Artikel'), 'url' => route('articles.index')],
    ];
@endphp

@push('schemas')
    <x-seo.breadcrumbs :items="$breadcrumbs" />
@endpush

<x-app body-class="bg-white font-sans text-brand-ink antialiased" active-section="articles">
    <main>
        <x-site.layout.page-hero :title="__('articles.title')" image="https://placehold.co/1400x320/4b5563/ffffff?text=Artikel" />

        <x-site.layout.container class="clamp-[py,40px,56px]">
            <x-site.section-heading :level="1" :label="__('articles.latest')" />

            <div class="relative mt-8" data-featured-articles>
                <div class="featured-articles-swiper swiper">
                    <div class="swiper-wrapper">
                        @foreach ($latestArticles as $article)
                            <div class="swiper-slide">
                                <x-articles.article-card :article="$article" />
                            </div>
                        @endforeach
                    </div>
                </div>

                <x-site.slider-nav class="slider-nav-prev" direction="prev" />
                <x-site.slider-nav class="slider-nav-next" direction="next" />
            </div>
        </x-site.layout.container>

        <x-site.layout.container class="pb-16">
            <x-site.section-heading :label="__('articles.all')" />

            <livewire:article-list :excluded-ids="$latestArticleIds" />
        </x-site.layout.container>
    </main>
</x-app>
