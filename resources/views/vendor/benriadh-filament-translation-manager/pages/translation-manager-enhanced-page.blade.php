<x-filament::page>
    <div class="tmx-shell space-y-4">
        <section class="tmx-filters">
            <form wire:submit.prevent="submitFilters">
                <div class="tmx-filters-row flex flex-col gap-4 lg:flex-row">
                    <div class="w-full">
                        {{ $this->form }}
                    </div>
                    <div class="tmx-filters-submit flex flex-col justify-end">
                        <x-filament::button
                            type="submit"
                            alias="benriadh-filament-translation-manager::filter-translations"
                            icon="heroicon-o-funnel"
                            class="tmx-filters-submit-btn"
                        >
                            @lang('benriadh-filament-translation-manager::messages.filter_action')
                        </x-filament::button>
                    </div>
                </div>
            </form>
        </section>

        <div class="tmx-results-bar">
            <span class="tmx-chip">
                {{ $totalFilteredTranslations }} / {{ $totalTranslations }} @lang('benriadh-filament-translation-manager::messages.total_keys')
            </span>
            <span class="tmx-chip tmx-chip-warning">
                {{ $totalMissingFilteredTranslations }} @lang('benriadh-filament-translation-manager::messages.missing')
            </span>
        </div>

        @if(count($availablePrefixTabs) > 0)
            <div class="tmx-tabs-wrap">
                <button
                    type="button"
                    wire:click="setPrefixTab('all')"
                    class="tmx-tab-btn {{ $activePrefixTab === 'all' ? 'tmx-tab-btn-active' : '' }}"
                >
                    <span>@lang('benriadh-filament-translation-manager::messages.all')</span>
                    <span class="tmx-tab-count">{{ $totalFilteredBeforeTab }}</span>
                    @if($totalMissingBeforeTab > 0)
                        <span class="tmx-tab-missing">{{ $totalMissingBeforeTab }}</span>
                    @endif
                </button>

                @foreach($availablePrefixTabs as $tab)
                    <button
                        type="button"
                        wire:click="setPrefixTab('{{ $tab['key'] }}')"
                        class="tmx-tab-btn {{ $activePrefixTab === $tab['key'] ? 'tmx-tab-btn-active' : '' }}"
                    >
                        <span>{{ $tab['label'] }}</span>
                        <span class="tmx-tab-count">{{ $tab['total'] }}</span>
                        @if(($tab['missing'] ?? 0) > 0)
                            <span class="tmx-tab-missing">{{ $tab['missing'] }}</span>
                        @endif
                    </button>
                @endforeach
            </div>
        @endif

        @php
            $tableLocales = ! empty($selectedLocales) ? array_values($selectedLocales) : $locales;
            $previewLocale = $tableLocales[0] ?? null;
        @endphp

        <p class="tmx-caption">@lang('benriadh-filament-translation-manager::messages.caption')</p>

        <section class="tmx-table-wrap">
            <table class="tmx-table">
                <thead>
                    <tr>
                        <th>@lang('benriadh-filament-translation-manager::messages.module_group')</th>
                        <th>@lang('benriadh-filament-translation-manager::messages.name')</th>
                        <th>@lang('benriadh-filament-translation-manager::messages.string')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($filteredTranslations as $translation)
                        <livewire:translation-edit-form-enhanced
                            wire:key="{{ $translation['title'] }}.{{ implode('-', $tableLocales) }}"
                            :group="$translation['group']"
                            :translation-key="$translation['translation_key']"
                            :translations="$translation['translations']"
                            :locales="$tableLocales"
                            :primary-locale="$previewLocale"
                        />
                    @empty
                        <tr>
                            <td class="tmx-empty-state" colspan="3">
                                @lang('benriadh-filament-translation-manager::messages.error_no_translations_for_filters')
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        @php
            $pageSize = \Benriadh1\FilamentTranslationManager\Pages\TranslationManagerEnhancedPage::PAGE_LIMIT;
            $totalPages = max(1, (int) ceil($totalFilteredTranslations / $pageSize));
            $currentPage = max(1, min($pageCounter, $totalPages));
            $startItem = $totalFilteredTranslations === 0 ? 0 : (($currentPage - 1) * $pageSize) + 1;
            $endItem = min($currentPage * $pageSize, $totalFilteredTranslations);
            $windowStart = max(1, $currentPage - 2);
            $windowEnd = min($totalPages, $currentPage + 2);
        @endphp

        <div id="pagination" class="tmx-pagination">
            <p class="tmx-pagination-summary">
                @if($totalFilteredTranslations > 0)
                    {{ trans('benriadh-filament-translation-manager::messages.showing', ['from' => $startItem, 'to' => $endItem, 'total' => $totalFilteredTranslations]) }}
                @else
                    @lang('benriadh-filament-translation-manager::messages.no_results')
                @endif
            </p>

            <div class="tmx-pagination-controls">
                <button
                    type="button"
                    class="tmx-page-btn"
                    wire:click="goToFirstPage"
                    @disabled($currentPage === 1)
                >
                    @lang('benriadh-filament-translation-manager::messages.first')
                </button>
                <button
                    type="button"
                    class="tmx-page-btn"
                    wire:click="previousPage"
                    @disabled($currentPage === 1)
                >
                    @lang('benriadh-filament-translation-manager::messages.previous_page')
                </button>

                @if($windowStart > 1)
                    <span class="tmx-page-gap">...</span>
                @endif

                @for($page = $windowStart; $page <= $windowEnd; $page++)
                    <button
                        type="button"
                        wire:click="goToPage({{ $page }})"
                        @disabled($page === $currentPage)
                        class="tmx-page-btn {{ $page === $currentPage ? 'tmx-page-btn-active' : '' }}"
                    >
                        {{ $page }}
                    </button>
                @endfor

                @if($windowEnd < $totalPages)
                    <span class="tmx-page-gap">...</span>
                @endif

                <button
                    type="button"
                    class="tmx-page-btn"
                    wire:click="nextPage"
                    @disabled($currentPage === $totalPages || $totalFilteredTranslations === 0)
                >
                    @lang('benriadh-filament-translation-manager::messages.next_page')
                </button>
                <button
                    type="button"
                    class="tmx-page-btn"
                    wire:click="goToLastPage"
                    @disabled($currentPage === $totalPages || $totalFilteredTranslations === 0)
                >
                    @lang('benriadh-filament-translation-manager::messages.last')
                </button>
            </div>
        </div>
    </div>
</x-filament::page>
