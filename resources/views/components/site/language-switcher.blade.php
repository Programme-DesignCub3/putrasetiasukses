@php
    $locales = config('localizer.supported_locales', []);
@endphp

<div class="flex items-center gap-1" aria-label="Language switcher">
    @foreach ($locales as $locale)
        @php
            $isActive = app()->getLocale() === $locale;
        @endphp

        <a
            href="{{ Route::localizedSwitcherUrl($locale) }}"
            lang="{{ str_replace('_', '-', $locale) }}"
            @class([
                'px-2.5 py-2 text-xs font-black uppercase transition',
                'bg-brand-red text-white' => $isActive,
                'bg-zinc-100 text-brand-ink hover:bg-brand-red hover:text-white' => ! $isActive,
            ])
        >
            {{ __("site.language.{$locale}") }}
        </a>
    @endforeach
</div>
