<x-layouts.app active-section="contact" :site="$site">
    <main>
        <x-site.layout.page-hero :title="__('contact.title')" image="https://placehold.co/1400x320/1f2937/ffffff?text=Kontak" />

        <x-site.layout.container class="clamp-[py,32px,48px]">
            <x-site.section-heading :level="1" :label="__('contact.message_title')" />

            @if (session('status'))
                <p class="mt-6 bg-green-600 px-5 py-3 font-bold">{{ session('status') }}</p>
            @endif

            <form class="mt-6 grid gap-5 sm:grid-cols-3" id="contact-form" action="{{ route('contact.store') }}" method="POST">
                @csrf
                <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                <x-contact.form-input name="name" :label="__('contact.name')" required />
                <x-contact.form-input name="company" :label="__('contact.company')" />
                <x-contact.form-input name="phone" :label="__('contact.phone')" required />
                <x-contact.form-input name="email" type="email" :label="__('contact.email')" />
                <x-contact.form-input name="subject" :label="__('contact.subject')" col-span="sm:col-span-2" required />
                <x-contact.form-textarea name="message" :label="__('contact.message')" :rows="6" col-span="sm:col-span-3" required />
                <div class="sm:col-span-3">
                    <button id="contact-submit"
                        class="bg-brand-red hover:bg-brand-red-dark rounded-full px-12 py-3 text-xl font-black transition"
                        type="submit">{{ __('contact.send') }}</button>
                </div>
            </form>

            @push('scripts')
                @if (config('services.recaptcha.site_key'))
                    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
                    <script>
                        document.getElementById('contact-form').addEventListener('submit', function (e) {
                            e.preventDefault();
                            const form = this;
                            const submitBtn = document.getElementById('contact-submit');
                            submitBtn.disabled = true;
                            submitBtn.textContent = '...';

                            grecaptcha.ready(function () {
                                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'submit' }).then(function (token) {
                                    document.getElementById('recaptcha_token').value = token;
                                    form.submit();
                                });
                            });
                        });
                    </script>
                @endif
            @endpush
        </x-site.layout.container>

        <x-site.layout.container class="pb-8">
            <x-site.section-heading :label="__('contact.locations')" />

            <div class="mt-8 grid gap-6">
                <x-contact.location-card label="Head Office" :address="$site->head_office_address" />
                <x-contact.location-card label="Warehouse" :address="$site->warehouse_address" />
            </div>
        </x-site.layout.container>

        <x-site.layout.container class="pb-16">
            <x-site.cta-strip />
        </x-site.layout.container>
    </main>
</x-layouts.app>
