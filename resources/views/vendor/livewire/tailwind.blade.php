@php
if (! isset($scrollTo)) {
    $scrollTo = false;
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav class="flex items-center justify-between" role="navigation" aria-label="Pagination Navigation">
            <div class="flex flex-1 justify-between sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span
                            class="relative inline-flex cursor-default items-center border border-zinc-300 bg-white px-4 py-2 text-sm font-bold leading-5 text-zinc-400">
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        <button
                            class="text-brand-ink hover:bg-brand-red relative inline-flex items-center border border-zinc-300 bg-white px-4 py-2 text-sm font-bold leading-5 transition duration-150 hover:text-white"
                            type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before">
                            {!! __('pagination.previous') !!}
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button
                            class="text-brand-ink hover:bg-brand-red relative ml-3 inline-flex items-center border border-zinc-300 bg-white px-4 py-2 text-sm font-bold leading-5 transition duration-150 hover:text-white"
                            type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before">
                            {!! __('pagination.next') !!}
                        </button>
                    @else
                        <span
                            class="relative ml-3 inline-flex cursor-default items-center border border-zinc-300 bg-white px-4 py-2 text-sm font-bold leading-5 text-zinc-400">
                            {!! __('pagination.next') !!}
                        </span>
                    @endif
                </span>
            </div>

            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-center sm:gap-6">

                {{-- <div>
                    <p class="text-sm leading-5 text-zinc-500">
                        <span>{!! __('Showing') !!}</span>
                        <span class="text-brand-ink font-black">{{ $paginator->firstItem() }}</span>
                        <span>{!! __('to') !!}</span>
                        <span class="text-brand-ink font-black">{{ $paginator->lastItem() }}</span>
                        <span>{!! __('of') !!}</span>
                        <span class="text-brand-ink font-black">{{ $paginator->total() }}</span>
                        <span>{!! __('results') !!}</span>
                    </p>
                </div> --}}

                <div>
                    <span class="relative z-0 inline-flex -space-x-px rtl:flex-row-reverse">
                        <span>
                            @if ($paginator->onFirstPage())
                                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                    <span
                                        class="relative inline-flex cursor-default items-center border border-zinc-300 bg-white px-3 py-2 text-sm font-bold leading-5 text-zinc-300"
                                        aria-hidden="true">
                                        <x-lucide-chevron-left class="h-5 w-5" />
                                    </span>
                                </span>
                            @else
                                <button
                                    class="text-brand-red hover:bg-brand-red relative inline-flex items-center border border-zinc-300 bg-white px-3 py-2 text-sm font-bold leading-5 transition duration-150 hover:text-white"
                                    type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                    dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                    aria-label="{{ __('pagination.previous') }}">
                                    <x-lucide-chevron-left class="h-5 w-5" />
                                </button>
                            @endif
                        </span>

                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span
                                        class="relative inline-flex cursor-default items-center border border-zinc-300 bg-white px-4 py-2 text-sm font-bold leading-5 text-zinc-400">{{ $element }}</span>
                                </span>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <span
                                        wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                        @if ($page == $paginator->currentPage())
                                            <span aria-current="page">
                                                <span
                                                    class="bg-brand-red border-brand-red relative inline-flex items-center border px-4 py-2 text-sm font-black leading-5 text-white">{{ $page }}</span>
                                            </span>
                                        @else
                                            <button
                                                class="text-brand-ink hover:bg-brand-red relative inline-flex items-center border border-zinc-300 bg-white px-4 py-2 text-sm font-bold leading-5 transition duration-150 hover:text-white"
                                                type="button"
                                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                                aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                                {{ $page }}
                                            </button>
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach

                        <span>
                            @if ($paginator->hasMorePages())
                                <button
                                    class="text-brand-red hover:bg-brand-red relative inline-flex items-center border border-zinc-300 bg-white px-3 py-2 text-sm font-bold leading-5 transition duration-150 hover:text-white"
                                    type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                    dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                    aria-label="{{ __('pagination.next') }}">
                                    <x-lucide-chevron-right class="h-5 w-5" />
                                </button>
                            @else
                                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                    <span
                                        class="relative inline-flex cursor-default items-center border border-zinc-300 bg-white px-3 py-2 text-sm font-bold leading-5 text-zinc-300"
                                        aria-hidden="true">
                                        <x-lucide-chevron-right class="h-5 w-5" />
                                    </span>
                                </span>
                            @endif
                        </span>
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
