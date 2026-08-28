@props([])

<x-site.layout.container class="from-brand-red clamp-[pt,6,12] bg-linear-[135deg] max-w-none to-white" as="footer">
    <x-site.layout.container
        class="rounded-t-4xl clamp-[p,6,12] clamp-[gap,10,20] relative mx-auto grid grid-cols-1 bg-white lg:grid-cols-2"
        as="div">

        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-8">
                    <h2 class="clamp-[text,2xl,3xl] text-brand-red font-black uppercase">
                        Connect with us
                    </h2>
                    <div class="[&_svg,&_img]:clamp-[size,4,8] text-brand-red flex gap-6">
                        <a href="#">
                            <x-icons.facebook />
                        </a>
                        <a href="#">
                            <x-icons.tiktok />
                        </a>
                        <a href="#">
                            <x-icons.whatsapp />
                        </a>
                        <a href="">
                            <x-lucide-mail />
                        </a>
                        <a href="#">
                            <x-icons.youtube />
                        </a>
                    </div>
                </div>
                <p class="md:max-w-3/4 clamp-[text,xs,sm] max-w-full">
                    We're always looking tro connect witah those who share an interest in a sustainable future
                </p>
            </div>

            <div class="text-label flex flex-col gap-2">

                <x-site.section-heading class="text-brand-red! mb-1 text-left uppercase" :title="__('contact.title')" />

                @php
                    $phones = safe_db_config('website.footer_phones', []);
                @endphp

                @if (__('site.head_office_address'))
                    <p class="lg:max-w-2/3 flex items-center gap-2">
                        <span class="item-center bg-brand-red flex w-fit justify-center rounded-full p-1.5 text-white">
                            <x-lucide-map-pin class="size-6 shrink-0" />
                        </span>
                        <span>Head Office: {{ __('site.head_office_address') }}</span>
                    </p>
                @endif

                @if (__('site.warehouse_address'))
                    <p class="lg:max-w-2/3 flex items-center gap-4">
                        <span class="item-center bg-brand-red flex w-fit justify-center rounded-full p-1.5 text-white">
                            <x-lucide-map-pin class="size-6 shrink-0" />
                        </span>
                        <span>Warehouse: {{ __('site.warehouse_address') }}</span>
                    </p>
                @endif

                @if (__('site.email'))
                    <p class="lg:max-w-2/3 flex items-center gap-4">
                        <span class="item-center bg-brand-red flex w-fit justify-center rounded-full p-1.5 text-white">
                            <x-lucide-mail class="size-6 shrink-0" />
                        </span>
                        <span>{{ __('site.email') }}</span>
                    </p>
                @endif

                @foreach ($phones as $phone)
                    <p class="lg:max-w-2/3 flex items-center gap-4">
                        <span class="item-center bg-brand-red flex w-fit justify-center rounded-full p-1.5 text-white">
                            <x-lucide-phone class="size-6 shrink-0" />
                        </span>
                        <span>
                            {{ $phone['number'] }}
                            @if ($phone['label'])
                                ({{ $phone['label'] }})
                            @endif
                        </span>
                    </p>
                @endforeach

                @if (__('site.website_url'))
                    <p class="lg:max-w-2/3 flex items-center gap-4">
                        <span class="item-center bg-brand-red flex w-fit justify-center rounded-full p-1.5 text-white">
                            <x-lucide-globe class="size-6 shrink-0" />
                        </span>
                        <span>{{ __('site.website_url') }}</span>
                    </p>
                @endif
            </div>

            <div
                class="clamp-[px,2,3] clamp-[py,1,2] absolute left-1/2 top-0 mx-auto flex -translate-x-1/2 -translate-y-1/2 gap-4 rounded-full bg-[#481203] text-white">
                <span class="flex items-center gap-2 text-xs">
                    <x-lucide-share-2 class="size-4" />
                    Share this page
                </span>
                <div class="[&_svg,&_img]:size-4 flex gap-4 text-white">
                    <a href="#">
                        <x-icons.facebook />
                    </a>

                    <a href="#">
                        <x-icons.tiktok />
                    </a>

                    <a href="#">
                        <x-icons.whatsapp />
                    </a>

                    <a href="">
                        <x-lucide-mail />
                    </a>
                </div>
            </div>
        </div>

        {{-- ? maps  --}}
        <div class="flex flex-col gap-4">
            <x-site.section-heading class="text-brand-red! uppercase" title="Our Location" />
            <iframe class="h-full w-auto"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.3821013320644!2d106.55837057499024!3d-6.213233293774708!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fe6d1e627e3d%3A0x6fe2d78a5b670e17!2skomplek%20Pergudangan%20Dan%20Industri%20PKT%20Bitung%20Curug%20Tangerang!5e0!3m2!1sen!2sid!4v1787890821025!5m2!1sen!2sid"
                style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="strict-origin-when-cross-origin"></iframe>

        </div>
    </x-site.layout.container>
</x-site.layout.container>
