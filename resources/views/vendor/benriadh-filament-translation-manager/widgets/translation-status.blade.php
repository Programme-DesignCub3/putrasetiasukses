<x-filament::widget class="filament-filament-info-widget">
    <x-filament::card class="relative">
        <div class="relative flex h-12 flex-col space-y-2">
            <div @class([
                'flex items-center space-x-2 text-sm font-medium text-gray-500 rtl:space-x-reverse',
                'dark:text-gray-200' => config('filament.dark_mode'),
            ])>
                <span>@lang('benriadh-filament-translation-manager::messages.title')</span>
            </div>
            <div class="flex space-x-2 text-sm rtl:space-x-reverse">
                @lang('benriadh-filament-translation-manager::messages.widget_missing_translations', ['count' => $missingTranslations])
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
