@props([])

<x-site.layout.container class="from-brand-red clamp-[pt,6,12] bg-linear-[135deg] max-w-none to-white" as="footer">
    <x-site.layout.container class="rounded-t-4xl clamp-[p,6,12] relative mx-auto bg-white" as="div">

        <h2 class="clamp-[text,2xl,3xl] text-brand-red font-black uppercase">
            Connect with us
        </h2>

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

        <div
            class="clamp-[px,2,3] clamp-[py,1,2] absolute left-1/2 top-0 mx-auto flex -translate-x-1/2 -translate-y-1/2 gap-4 rounded-full bg-[#481203] text-white">
            <span class="flex items-center gap-2 text-xs">
                <x-lucide-share-2 class="size-4" />
                Share this page
            </span>
            <div class="**:size-4 flex gap-4">
                <a href="#">
                    <img class="text-white" src="{{ asset('assets/icons/facebook.svg') }}" alt="facebook logo">
                </a>
                <a href="#">
                    <img class="text-white" src="{{ asset('assets/icons/tiktok.svg') }}" alt="tiktok logo">
                </a>
                <a href="#">
                    <img class="text-white" src="{{ asset('assets/icons/whatsapp.svg') }}" alt="whatsapp logo">
                </a>
                <a href="">
                    <x-lucide-mail class="text-white" />
                </a>
            </div>
        </div>
    </x-site.layout.container>
</x-site.layout.container>
