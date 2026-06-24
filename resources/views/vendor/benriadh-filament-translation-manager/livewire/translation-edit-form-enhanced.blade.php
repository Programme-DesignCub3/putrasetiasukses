@php
    $stringPreviewLocales = ! empty($locales ?? []) ? $locales : array_keys($translations ?? []);
    $safeKey = md5($group.'|'.$translationKey);
@endphp

<tr
    class="tmx-row"
>
    <td class="tmx-cell-domain">
        {{ $group }}
    </td>

    <td class="tmx-cell-key">
        {{ $translationKey }}
    </td>

    <td class="tmx-cell-string">
        <div class="tmx-string-lines">
            @foreach($stringPreviewLocales as $stringLocale)
                @php
                    $inputId = 'tmx-'.$safeKey.'-'.$stringLocale;
                    $stringValue = $translations[$stringLocale] ?? null;
                    $isArrayValue = is_array($stringValue);
                    $stringDisplayValue = $isArrayValue
                        ? json_encode($stringValue, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                        : (string) ($stringValue ?? '');
                    $stringHasValue = filled(trim($stringDisplayValue));
                @endphp

                <div class="tmx-string-line">
                    <div
                        class="tmx-string-editor-inline"
                        x-data="{
                            editing: false,
                            open() {
                                this.editing = true;
                                this.$nextTick(() => this.$refs.editorTextarea?.focus());
                            },
                            cancelEdit() {
                                $wire.cancel();
                                this.editing = false;
                            },
                            saveEdit(locale) {
                                $wire.save(locale);
                                this.editing = false;
                            }
                        }"
                    >
                        @if($isArrayValue)
                            <pre class="tmx-array-preview">{{ $stringDisplayValue }}</pre>
                            <div class="tmx-missing">
                                Nested value detected (array). Inline edit is disabled for this key.
                            </div>
                        @else
                        <div class="tmx-editor-head">
                            <span>{{ strtoupper($stringLocale) }}</span>
                            <div class="tmx-editor-head-actions" x-show="editing" x-cloak>
                                <button
                                    type="button"
                                    class="tmx-btn tmx-btn-light"
                                    @click.prevent="cancelEdit()"
                                >
                                    @lang('benriadh-filament-translation-manager::messages.cancel')
                                </button>
                                <button
                                    type="button"
                                    class="tmx-btn tmx-btn-primary"
                                    @click.prevent="saveEdit('{{ $stringLocale }}')"
                                >
                                    @lang('benriadh-filament-translation-manager::messages.save')
                                </button>
                            </div>
                        </div>

                        <div class="tmx-editor-body">
                            <input
                                id="{{ $inputId }}-input"
                                type="text"
                                class="tmx-input tmx-input-trigger"
                                wire:model.defer="translations.{{ $stringLocale }}"
                                readonly
                                x-show="!editing"
                                @click.prevent="open()"
                                @keydown.enter.prevent="open()"
                                @keydown.space.prevent="open()"
                                placeholder="{{ $stringHasValue ? '' : trans('benriadh-filament-translation-manager::messages.missing_translation') }}"
                            >
                            <textarea
                                id="{{ $inputId }}-textarea"
                                rows="2"
                                class="tmx-input tmx-textarea"
                                wire:model.defer="translations.{{ $stringLocale }}"
                                x-ref="editorTextarea"
                                x-show="editing"
                                x-cloak
                                placeholder="{{ $stringHasValue ? '' : trans('benriadh-filament-translation-manager::messages.missing_translation') }}"
                            ></textarea>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </td>
</tr>
