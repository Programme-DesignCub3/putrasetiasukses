<div>
    <div class="relative mx-auto max-w-2xl">
        <input
            type="search"
            wire:model.live.debounce.300ms="query"
            placeholder="{{ __('search.placeholder') }}"
            class="w-full bg-zinc-200 px-5 py-4 pr-14 text-lg font-semibold text-black placeholder-zinc-500"
            autofocus
        >
        <svg class="pointer-events-none absolute right-5 top-1/2 h-6 w-6 -translate-y-1/2 text-zinc-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
        </svg>
    </div>

    @if (strlen($query) > 0 && strlen($query) < 2)
        <p class="mt-8 text-center text-base font-semibold text-zinc-500">
            {{ __('search.min_chars') }}
        </p>
    @endif

    <div wire:loading.delay class="mt-12 flex items-center justify-center">
        <svg class="h-8 w-8 animate-spin text-brand-red" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z" />
        </svg>
    </div>

    @if (strlen($query) >= 2)
        <div
            wire:loading.class="opacity-50"
            class="mt-12 space-y-16"
        >
            @if (! $hasResults)
                <p class="text-center text-base font-semibold text-zinc-500">
                    {{ __('search.no_results', ['query' => $query]) }}
                </p>
            @endif

            @if ($products->isNotEmpty())
                <section>
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-2xl font-black text-black">{{ __('search.products') }}</h2>
                        <a href="{{ route('products.index') }}?search={{ urlencode($query) }}" class="text-sm font-bold uppercase text-brand-red hover:underline">
                            {{ __('search.view_all') }}
                        </a>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3" x-data="staggerList">
                        @foreach ($products as $product)
                            <div wire:key="search-product-{{ $product->id }}">
                                <x-products.product-card :product="$product" />
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($articles->isNotEmpty())
                <section>
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-2xl font-black text-black">{{ __('search.articles') }}</h2>
                        <a href="{{ route('articles.index') }}?search={{ urlencode($query) }}" class="text-sm font-bold uppercase text-brand-red hover:underline">
                            {{ __('search.view_all') }}
                        </a>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3" x-data="staggerList">
                        @foreach ($articles as $article)
                            <div wire:key="search-article-{{ $article->id }}">
                                <x-articles.article-card :article="$article" />
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($projects->isNotEmpty())
                <section>
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-2xl font-black text-black">{{ __('search.projects') }}</h2>
                        <a href="{{ route('projects.index') }}?search={{ urlencode($query) }}" class="text-sm font-bold uppercase text-brand-red hover:underline">
                            {{ __('search.view_all') }}
                        </a>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3" x-data="staggerList">
                        @foreach ($projects as $project)
                            <div wire:key="search-project-{{ $project->id }}">
                                <x-projects.project-card :project="$project" />
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    @endif
</div>
