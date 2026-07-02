@props(['article'])

<a class="group relative block overflow-hidden rounded-xl bg-zinc-900" href="{{ route('articles.show', $article) }}">
    <img class="aspect-16/10 w-full object-cover transition duration-300 group-hover:scale-105"
        src="{{ $article->image_url }}" alt="{{ $article->title }}"
        style="view-transition-name: article-image-{{ $article->id }}">
    <div class="bg-linear-to-t absolute inset-0 from-black/85 via-black/30 to-transparent"></div>
    <div class="absolute inset-x-0 bottom-0 p-5 text-white sm:p-7">
        <p class="text-xs font-black sm:text-sm">{{ $article->category_names }}</p>
        <h2 class="mt-1 text-base font-black leading-tight sm:mt-2 sm:text-xl lg:text-2xl">{{ $article->title }}</h2>
    </div>
</a>
