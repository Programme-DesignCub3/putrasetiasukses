@props(['enabled' => true])

@if ($enabled)
    <section
        class="fixed inset-x-0 bottom-0 z-50 border-t border-white/10 bg-brand-ink px-4 py-4 text-white shadow-2xl shadow-black/30 sm:px-5 lg:px-8"
        data-cookie-consent
        aria-label="{{ __('site.cookie.title') }}"
    >
        <div class="mx-auto flex max-w-7xl flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-base font-black">{{ __('site.cookie.title') }}</p>
                <p class="mt-1 text-sm font-semibold leading-relaxed text-white/75">
                    {{ __('site.cookie.description') }}
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <button
                    class="border border-white/20 px-5 py-3 text-sm font-black uppercase text-white transition hover:bg-white hover:text-brand-ink"
                    type="button"
                    data-cookie-reject
                >
                    {{ __('site.cookie.reject') }}
                </button>
                <button
                    class="bg-brand-red px-5 py-3 text-sm font-black uppercase text-white transition hover:bg-brand-red-dark"
                    type="button"
                    data-cookie-accept
                >
                    {{ __('site.cookie.accept') }}
                </button>
            </div>
        </div>
    </section>
@endif
