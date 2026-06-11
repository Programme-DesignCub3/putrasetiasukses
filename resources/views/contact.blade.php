<x-layouts.app :title="__('site.contact.title') . ' - ' . $site->company_name" :description="$site->tagline" image="https://placehold.co/1400x320/1f2937/ffffff?text=Kontak">
    <div class="min-h-screen overflow-hidden">
        <x-site.header :site="$site" active="contact" />

        <main>
            <x-site.page-hero :title="__('site.contact.title')" image="https://placehold.co/1400x320/1f2937/ffffff?text=Kontak" />

            <section class="clamp-[py,32px,48px] mx-auto max-w-7xl px-4 sm:px-5 lg:px-8">
                <h1 class="section-title">{{ __('site.contact.message_title') }}</h1>

                @if (session('status'))
                    <p class="mt-6 bg-green-600 px-5 py-3 font-bold">{{ session('status') }}</p>
                @endif

                <form class="mt-6 grid gap-5 sm:grid-cols-3" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <label class="block text-sm font-bold">
                        {{ __('site.contact.name') }}
                        <input class="mt-2 w-full bg-zinc-200 px-4 py-3 text-black" name="name"
                            value="{{ old('name') }}" required>
                    </label>
                    <label class="block text-sm font-bold">
                        {{ __('site.contact.company') }}
                        <input class="mt-2 w-full bg-zinc-200 px-4 py-3 text-black" name="company"
                            value="{{ old('company') }}">
                    </label>
                    <label class="block text-sm font-bold">
                        {{ __('site.contact.phone') }}
                        <input class="mt-2 w-full bg-zinc-200 px-4 py-3 text-black" name="phone"
                            value="{{ old('phone') }}" required>
                    </label>
                    <label class="block text-sm font-bold">
                        {{ __('site.contact.email') }}
                        <input class="mt-2 w-full bg-zinc-200 px-4 py-3 text-black" type="email" name="email"
                            value="{{ old('email') }}">
                    </label>
                    <label class="block text-sm font-bold sm:col-span-2">
                        {{ __('site.contact.subject') }}
                        <input class="mt-2 w-full bg-zinc-200 px-4 py-3 text-black" name="subject"
                            value="{{ old('subject') }}" required>
                    </label>
                    <label class="block text-sm font-bold sm:col-span-3">
                        {{ __('site.contact.message') }}
                        <textarea class="mt-2 w-full bg-zinc-200 px-4 py-3 text-black" name="message" rows="6" required>{{ old('message') }}</textarea>
                    </label>
                    <div class="sm:col-span-3">
                        <button
                            class="bg-brand-red hover:bg-brand-red-dark rounded-full px-12 py-3 text-xl font-black transition"
                            type="submit">{{ __('site.contact.send') }}</button>
                    </div>
                </form>
            </section>

            <section class="mx-auto max-w-7xl px-4 pb-8 sm:px-5 lg:px-8">
                <h2 class="section-title">{{ __('site.contact.locations') }}</h2>

                <div class="mt-8 grid gap-6">
                    <div class="flex gap-5">
                        <span class="bg-brand-red flex h-16 w-16 flex-none items-center justify-center rounded-full">
                            <svg class="h-9 w-9" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z" />
                            </svg>
                        </span>
                        <p><strong>Head Office</strong><br>{{ $site->head_office_address }}</p>
                    </div>
                    <div class="flex gap-5">
                        <span class="bg-brand-red flex h-16 w-16 flex-none items-center justify-center rounded-full">
                            <svg class="h-9 w-9" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z" />
                            </svg>
                        </span>
                        <p><strong>Warehouse</strong><br>{{ $site->warehouse_address }}</p>
                    </div>
                </div>
            </section>

            <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-5 lg:px-8">
                <div
                    class="cta-strip clamp-[py,32px,48px] flex min-h-32 items-center justify-center bg-cover bg-center px-5 text-center sm:min-h-36 sm:px-6">
                    <p class="max-w-2xl text-xl font-black leading-tight sm:text-2xl">{{ __('site.cta.strip') }}</p>
                </div>
            </section>
        </main>

        <x-site.whatsapp-button :site="$site" />
        <x-site.footer :site="$site" />
    </div>
</x-layouts.app>
