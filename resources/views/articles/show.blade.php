@php
    $breadcrumbs = [
        ['name' => __('Home'), 'url' => route('home')],
        ['name' => __('Artikel'), 'url' => route('articles.index')],
        ['name' => $article->title, 'url' => route('articles.show', $article)],
    ];
@endphp

@push('schemas')
    <x-seo.breadcrumbs :items="$breadcrumbs" />
@endpush

<x-app body-class="bg-white font-sans text-brand-ink antialiased" active-section="articles">
    <main class="clamp-[py,48px,72px] mx-auto max-w-6xl px-4 sm:px-5 lg:px-8">
        <a class="text-brand-red hover:text-brand-red-dark mb-6 inline-flex items-center gap-2 text-sm font-bold uppercase transition"
            href="{{ route('articles.index') }}">
            <x-lucide-arrow-left class="size-4" stroke-width="3" />
            {{ __('site.back') }}
        </a>

        <img class="aspect-16/7 w-full object-cover" src="{{ $article->image_url }}" alt="{{ $article->title }}"
            style="view-transition-name: article-image-{{ $article->id }}">

        <article class="mt-8">
            <p class="text-brand-red text-2xl font-black">{{ $article->category_names }}</p>
            <h1 class="mt-4 max-w-5xl text-4xl font-black leading-tight text-black sm:text-5xl">
                {{ $article->title }}</h1>
            <p class="mt-5 text-sm font-bold text-zinc-500">
                {{ __('articles.byline', ['author' => $article->author]) }} &middot;
                {{ $article->published_at?->translatedFormat('j F Y') }}
            </p>

            <div
                class="[&_a]:text-brand-red [&_blockquote]:border-brand-red mt-10 max-w-5xl text-base font-semibold leading-relaxed text-zinc-700 sm:text-lg [&_a]:font-black [&_blockquote]:border-l-4 [&_blockquote]:pl-5 [&_blockquote]:italic [&_h2]:mt-10 [&_h2]:text-3xl [&_h2]:font-black [&_h2]:text-black [&_h3]:mt-8 [&_h3]:text-2xl [&_h3]:font-black [&_h3]:text-black [&_li]:mb-2 [&_ol]:my-7 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:mb-7 [&_ul]:my-7 [&_ul]:list-disc [&_ul]:pl-6">
                {!! $article->renderRichContent('body') !!}
            </div>
        </article>
    </main>
</x-app>
