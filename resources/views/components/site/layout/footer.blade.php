<x-site.layout.container class="from-brand-red clamp-[pt,6,12] bg-linear-[135deg] max-w-none to-white" as="footer">
    <x-site.layout.container
        class="rounded-t-4xl clamp-[p,6,12] clamp-[gap,10,20] relative mx-auto grid grid-cols-1 bg-white lg:grid-cols-2"
        as="div">

        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-2">
                <div class="clamp-[gap,2,4] flex flex-wrap sm:items-center">

                    <x-site.section-heading class="text-brand-red! m-0! font-black uppercase"
                        titleClass="clamp-[text,xl,3xl]!" :title="__('site.connect_title')" />

                    <div class="[&_svg,&_img]:clamp-[size,7,8] text-brand-red clamp-[gap,3,6] flex">
                        @php
                            $socialLinks = safe_db_config('website.social_links', []);
                        @endphp
                        @if ($socialLinks['facebook_show'] ?? true)
                            <a href="{{ $socialLinks['facebook'] ?? '#' }}"
                                @if ($socialLinks['facebook'] ?? null) target="_blank" rel="noopener" @endif>
                                <x-icons.facebook />
                            </a>
                        @endif
                        @if ($socialLinks['tiktok_show'] ?? true)
                            <a href="{{ $socialLinks['tiktok'] ?? '#' }}"
                                @if ($socialLinks['tiktok'] ?? null) target="_blank" rel="noopener" @endif>
                                <x-icons.tiktok />
                            </a>
                        @endif
                        @if ($socialLinks['footer_whatsapp_show'] ?? true)
                            <a href="{{ $socialLinks['footer_whatsapp'] ?? null ? 'https://wa.me/' . $socialLinks['footer_whatsapp'] : '#' }}"
                                @if ($socialLinks['footer_whatsapp'] ?? null) target="_blank" rel="noopener" @endif>
                                <x-icons.whatsapp />
                            </a>
                        @endif
                        @if ($socialLinks['email_show'] ?? true)
                            <a href="{{ $socialLinks['email'] ?? null ? 'mailto:' . $socialLinks['email'] : '#' }}">
                                <x-lucide-mail />
                            </a>
                        @endif
                        @if ($socialLinks['youtube_show'] ?? true)
                            <a href="{{ $socialLinks['youtube'] ?? '#' }}"
                                @if ($socialLinks['youtube'] ?? null) target="_blank" rel="noopener" @endif>
                                <x-icons.youtube />
                            </a>
                        @endif
                    </div>
                </div>
                <p class="md:max-w-3/4 clamp-[mt,2,4] clamp-[text,xs,sm] max-w-full">
                    {{ __('site.connect_text') }}
                </p>
            </div>

            <div class="text-label flex flex-col gap-3">

                <x-site.section-heading class="text-brand-red! text-left uppercase" titleClass="clamp-[text,lg,2xl]!"
                    :title="__('contact.title')" />

                @php
                    $phones = safe_db_config('website.footer_phones', []);
                @endphp

                @if (__('site.head_office_address'))
                    <p class="lg:max-w-2/3 flex items-center gap-4">
                        <span class="item-center bg-brand-red flex w-fit justify-center rounded-full p-1.5 text-white">
                            <x-lucide-map-pin class="size-6 shrink-0" />
                        </span>
                        <span>{{ __('site.head_office_label') }} {{ __('site.head_office_address') }}</span>
                    </p>
                @endif

                @if (__('site.warehouse_address'))
                    <p class="lg:max-w-2/3 flex items-center gap-4">
                        <span class="item-center bg-brand-red flex w-fit justify-center rounded-full p-1.5 text-white">
                            <x-lucide-map-pin class="size-6 shrink-0" />
                        </span>
                        <span>{{ __('site.warehouse_label') }} {{ __('site.warehouse_address') }}</span>
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


            {{-- ? share pill --}}
            @php
                $shareUrl = request()->url();
                $shareTitle = config('app.name');
            @endphp
            <div class="clamp-[px,2,3] clamp-[py,1,2] absolute left-1/2 top-0 mx-auto flex -translate-x-1/2 -translate-y-1/2 items-center justify-center gap-4 rounded-full bg-[#481203] text-white max-sm:w-max"
                x-data="{ canShare: !!navigator.share, async nativeShare() { try { await navigator.share({ title: '{{ $shareTitle }}', url: '{{ $shareUrl }}' }); } catch (e) {} } }">
                <span class="clamp-[text,xs,sm] flex items-center gap-2">
                    <x-lucide-share-2 class="size-4" />
                    {{ __('site.share_this_page') }}
                </span>

                <div class="[&_svg,&_img]:clamp-[size,4,6] flex items-center gap-2 text-white">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank"
                        rel="noopener">
                        <x-icons.facebook />
                    </a>

                    <a href="https://www.tiktok.com/share?url={{ urlencode($shareUrl) }}" target="_blank"
                        rel="noopener">
                        <x-icons.tiktok />
                    </a>

                    <a href="https://wa.me/?text={{ urlencode($shareTitle . ' ' . $shareUrl) }}" target="_blank"
                        rel="noopener">
                        <x-icons.whatsapp />
                    </a>

                    <a href="mailto:?subject={{ urlencode($shareTitle) }}&body={{ urlencode($shareUrl) }}">
                        <x-lucide-mail />
                    </a>

                    <button class="flex cursor-pointer items-center border-none bg-transparent p-0 text-white"
                        type="button" x-show="canShare" x-cloak @click="nativeShare()" aria-label="Share via system">
                        <x-lucide-square-arrow-out-up-right class="size-4" />
                    </button>
                </div>
            </div>
        </div>

        {{-- ? maps  --}}
        <div class="flex flex-col gap-4">
            <x-site.section-heading class="text-brand-red! m-0! uppercase" titleClass="clamp-[text,xl,3xl]!"
                :title="__('site.our_location')" />
            <iframe class="h-full w-auto"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.3821013320644!2d106.55837057499024!3d-6.213233293774708!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fe6d1e627e3d%3A0x6fe2d78a5b670e17!2skomplek%20Pergudangan%20Dan%20Industri%20PKT%20Bitung%20Curug%20Tangerang!5e0!3m2!1sen!2sid!4v1787890821025!5m2!1sen!2sid"
                style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="strict-origin-when-cross-origin"></iframe>

        </div>
    </x-site.layout.container>
</x-site.layout.container>
