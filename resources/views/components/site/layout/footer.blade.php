@props([])

<footer class="bg-black px-4 py-12 text-white sm:px-5 sm:py-14 lg:px-8">
    <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[1fr_1.35fr]">
        <div>
            <x-site.brand />
            <p class="mt-8 max-w-sm text-lg font-black leading-snug sm:text-xl">{{ __('site.tagline') }}</p>
        </div>

        <div>
            <h2 class="text-2xl font-black sm:text-3xl">{{ __('site.cta.contact_us') }}</h2>
            <div class="wrap-break-word mt-6 grid gap-5 text-sm font-semibold sm:grid-cols-2">
                @php
    $phones = [
        ['label' => 'Sales 1', 'number' => '0812-8438-805'],
        ['label' => 'Sales 2', 'number' => '0813-1485-5403'],
        ['label' => 'Sales 3', 'number' => '0812-8550-9009'],
        ['label' => 'Office', 'number' => '(021) 6667-1597-599'],
    ];
@endphp

                @foreach ($phones as $phone)
                    <p>{{ $phone['number'] }} @if ($phone['label'])
                            ({{ $phone['label'] }})
                        @endif
                    </p>
                @endforeach

                @if (__('site.website_url'))
                    <p>{{ __('site.website_url') }}</p>
                @endif

                @if (__('site.email'))
                    <p>{{ __('site.email') }}</p>
                @endif

                @if (__('site.head_office_address'))
                    <p>Head Office<br>{{ __('site.head_office_address') }}</p>
                @endif

                @if (__('site.warehouse_address'))
                    <p>Warehouse<br>{{ __('site.warehouse_address') }}</p>
                @endif
            </div>
        </div>
    </div>
</footer>
