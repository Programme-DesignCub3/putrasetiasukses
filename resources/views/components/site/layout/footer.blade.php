@props(['site'])

<footer class="bg-black px-4 py-12 text-white sm:px-5 sm:py-14 lg:px-8">
    <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[1fr_1.35fr]">
        <div>
            <x-site.brand :site="$site" />
            <p class="mt-8 max-w-sm text-lg font-black leading-snug sm:text-xl">{{ $site->tagline }}</p>
        </div>

        <div>
            <h2 class="text-2xl font-black sm:text-3xl">{{ __('site.cta.contact_us') }}</h2>
            <div class="wrap-break-word mt-6 grid gap-5 text-sm font-semibold sm:grid-cols-2">
                @foreach ($site->phones ?? [] as $phone)
                    <p>{{ $phone['number'] ?? '' }} @if (!empty($phone['label']))
                            ({{ $phone['label'] }})
                        @endif
                    </p>
                @endforeach

                @if ($site->website_url)
                    <p>{{ $site->website_url }}</p>
                @endif

                @if ($site->email)
                    <p>{{ $site->email }}</p>
                @endif

                @if ($site->head_office_address)
                    <p>Head Office<br>{{ $site->head_office_address }}</p>
                @endif

                @if ($site->warehouse_address)
                    <p>Warehouse<br>{{ $site->warehouse_address }}</p>
                @endif
            </div>
        </div>
    </div>
</footer>
