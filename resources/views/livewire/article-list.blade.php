<div>
    <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <input
                type="search"
                wire:model.live.debounce.300ms="search"
                placeholder="{{ __('articles.search') }}"
                class="w-full bg-zinc-200 px-4 py-3 pr-10 text-sm font-semibold text-black placeholder-zinc-500"
            >
            <svg class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-zinc-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
            </svg>
        </div>

        <select
            wire:model.live="categoryId"
            class="w-full bg-zinc-200 px-4 py-3 text-sm font-semibold text-black sm:w-56"
        >
            <option value="">{{ __('articles.all_categories') }}</option>
            @foreach ($this->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div wire:loading.delay class="mt-6 flex items-center justify-center py-12">
        <svg class="h-8 w-8 animate-spin text-brand-red" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z" />
        </svg>
    </div>

    <div
        wire:loading.class="opacity-50"
        class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
    >
        @forelse ($articles as $article)
            <x-articles.article-card :article="$article" />
        @empty
            <p class="sm:col-span-2 lg:col-span-3 py-12 text-center text-base font-semibold text-zinc-500">
                {{ __('articles.no_results') }}
            </p>
        @endforelse
    </div>

    @if ($articles->hasPages())
        <div class="mt-10">
            {{ $articles->onEachSide(1)->links() }}
        </div>
    @endif
</div>
