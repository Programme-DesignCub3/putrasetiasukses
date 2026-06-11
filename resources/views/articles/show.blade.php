<x-layouts.app :title="$article->title.' - '.$site->company_name" body-class="bg-black font-sans text-white antialiased">
        <div class="min-h-screen overflow-hidden bg-black">
            <x-site.header :site="$site" active="articles" />

            <main class="mx-auto max-w-6xl px-4 clamp-[py,48px,72px] sm:px-5 lg:px-8">
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="aspect-[16/7] w-full object-cover">

                <article class="mt-8">
                    <p class="text-2xl font-black text-brand-red">{{ $article->category }}</p>
                    <h1 class="mt-4 max-w-5xl text-4xl font-black leading-tight text-white sm:text-5xl">{{ $article->title }}</h1>
                    <p class="mt-5 text-sm font-bold text-white/35">
                        {{ __('site.articles.byline', ['author' => $article->author]) }} &middot; {{ $article->published_at?->translatedFormat('j F Y') }}
                    </p>

                    <div class="mt-10 max-w-5xl space-y-7 text-base font-semibold leading-relaxed text-white/35 sm:text-lg">
                        @foreach (preg_split('/\R+/', $article->body) as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </article>
            </main>

            <x-site.whatsapp-button :site="$site" />
            <x-site.footer :site="$site" />
        </div>
</x-layouts.app>
