@props(['article', 'large' => false])

<a class="group relative block overflow-hidden bg-zinc-900" href="{{ route('articles.show', $article) }}">
    <img class="{{ $large ? 'aspect-16/8' : 'aspect-16/10' }} w-full object-cover transition duration-300 group-hover:scale-105"
        src="{{ $article->image_url }}" alt="{{ $article->title }}">
    <div class="bg-linear-to-t absolute inset-0 from-black/85 via-black/30 to-transparent"></div>
    <div class="absolute inset-x-0 bottom-0 p-5 text-white sm:p-7">
        <p class="text-sm font-black">{{ $article->category_names }}</p>
        <h2 class="{{ $large ? 'text-2xl sm:text-3xl' : 'text-xl' }} mt-2 font-black leading-tight">{{ $article->title }}
        </h2>
    </div>
</a>
