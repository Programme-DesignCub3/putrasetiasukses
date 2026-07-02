@props([])

@if (__('site.whatsapp_number'))
    <div class="clamp-[pr,4,8] sticky bottom-0 z-30 -mb-14 flex -translate-y-6 justify-end">
        <a class="inline-flex max-w-[calc(100vw-2rem)] items-center gap-2 rounded-full bg-green-500 px-4 py-3 text-sm font-black uppercase text-white shadow-2xl shadow-green-900/30 transition hover:bg-green-600 sm:gap-3 sm:px-5 sm:text-lg"
            href="https://wa.me/{{ __('site.whatsapp_number') }}">
            <svg class="h-7 w-7 flex-none sm:h-8 sm:w-8" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path
                    d="M12.04 2C6.58 2 2.13 6.43 2.13 11.88c0 1.74.46 3.43 1.34 4.93L2 22l5.33-1.4a9.9 9.9 0 0 0 4.71 1.2h.01c5.46 0 9.91-4.43 9.91-9.88C21.96 6.46 17.51 2 12.04 2Zm5.77 14.14c-.25.7-1.46 1.34-2.01 1.39-.52.05-1.17.07-1.89-.12-.44-.14-1-.32-1.72-.63-3.02-1.3-4.99-4.33-5.14-4.53-.15-.2-1.23-1.64-1.23-3.13s.78-2.22 1.06-2.52c.28-.3.61-.37.81-.37h.58c.18 0 .44-.07.69.53.25.61.85 2.1.93 2.25.08.15.13.33.03.53-.1.2-.15.33-.3.51-.15.18-.32.4-.46.54-.15.15-.31.31-.13.61.18.3.78 1.28 1.67 2.07 1.15 1.02 2.12 1.34 2.42 1.49.3.15.48.13.66-.08.18-.2.76-.89.96-1.19.2-.3.41-.25.69-.15.28.1 1.79.84 2.1.99.31.15.51.23.59.36.08.13.08.75-.17 1.45Z" />
            </svg>
            <span class="truncate">{{ __('site.cta.contact_us') }}</span>
        </a>
    </div>
@endif
