@props([
    'article',
    'large' => false,
])

<a href="{{ route('articles.show', $article) }}" class="group relative block overflow-hidden bg-zinc-900">
    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full object-cover transition duration-300 group-hover:scale-105 {{ $large ? 'aspect-[16/8]' : 'aspect-[16/10]' }}">
    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>
    <div class="absolute inset-x-0 bottom-0 p-5 text-white sm:p-7">
        <p class="text-sm font-black">{{ $article->category }}</p>
        <h2 class="mt-2 font-black leading-tight {{ $large ? 'text-2xl sm:text-3xl' : 'text-xl' }}">{{ $article->title }}</h2>
    </div>
</a>
