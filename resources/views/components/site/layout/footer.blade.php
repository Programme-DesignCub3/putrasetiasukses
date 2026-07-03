@props([])

<footer class="bg-black px-4 py-12 text-white sm:px-5 sm:py-14 lg:px-8">
    <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[1fr_1.35fr]">
        <div>
            <x-site.logo variant="white" />
            <p class="mt-8 max-w-sm text-lg font-semibold leading-snug sm:text-xl">{{ __('site.tagline') }}</p>
        </div>

        <div>
            <h2 class="text-2xl font-black sm:text-3xl">{{ __('site.cta.contact_us') }}</h2>
            <div class="wrap-break-word mt-6 grid gap-5 text-sm font-semibold sm:grid-cols-2">
                @php
                    $phones = safe_db_config('website.footer_phones', []);
                @endphp

                @foreach ($phones as $phone)
                    <p class="flex items-center gap-2">
                        <x-lucide-phone class="size-4 shrink-0" />
                        <span>{{ $phone['number'] }} @if ($phone['label'])
                                ({{ $phone['label'] }})
                            @endif
                        </span>
                    </p>
                @endforeach

                @if (__('site.website_url'))
                    <p class="flex items-center gap-2">
                        <x-lucide-globe class="size-4 shrink-0" />
                        <span>{{ __('site.website_url') }}</span>
                    </p>
                @endif

                @if (__('site.email'))
                    <p class="flex items-center gap-2">
                        <x-lucide-mail class="size-4 shrink-0" />
                        <span>{{ __('site.email') }}</span>
                    </p>
                @endif

                @if (__('site.head_office_address'))
                    <p class="flex items-center gap-2">
                        <x-lucide-building class="size-4 shrink-0" />
                        <span>Head Office<br>{{ __('site.head_office_address') }}</span>
                    </p>
                @endif

                @if (__('site.warehouse_address'))
                    <p class="flex items-center gap-2">
                        <x-lucide-warehouse class="size-4 shrink-0" />
                        <span>Warehouse<br>{{ __('site.warehouse_address') }}</span>
                    </p>
                @endif
            </div>
        </div>
    </div>
</footer>
