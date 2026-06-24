<div>
    @if ($success)
        <p class="bg-green-600 px-5 py-3 font-bold">{{ __('contact.success') }}</p>
    @else
        <form
            wire:submit="submit"
            x-data="{
                recaptchaToken: '',
                async handleSubmit() {
                    @if (config('services.recaptcha.site_key'))
                        try {
                            this.recaptchaToken = await grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'submit' });
                            $wire.set('recaptchaToken', this.recaptchaToken);
                        } catch {
                            //
                        }
                    @endif
                    $wire.submit();
                }
            }"
            @submit.prevent="handleSubmit"
            class="mt-6 grid gap-5 sm:grid-cols-3"
        >
            <x-contact.form-input name="name" :label="__('contact.name')" required
                wire:model.live.blur="name" />
            <x-contact.form-input name="company" :label="__('contact.company')"
                wire:model.live.blur="company" />
            <x-contact.form-input name="phone" :label="__('contact.phone')" required
                wire:model.live.blur="phone" />
            <x-contact.form-input name="email" type="email" :label="__('contact.email')"
                wire:model.live.blur="email" />
            <x-contact.form-input name="subject" :label="__('contact.subject')" col-span="sm:col-span-2" required
                wire:model.live.blur="subject" />
            <x-contact.form-textarea name="message" :label="__('contact.message')" :rows="6" col-span="sm:col-span-3" required
                wire:model.live.blur="message" />

            @error('recaptcha')
                <p class="sm:col-span-3 text-sm text-red-400">{{ $message }}</p>
            @enderror

            <div class="sm:col-span-3">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="submit"
                    class="bg-brand-red hover:bg-brand-red-dark rounded-full px-12 py-3 text-xl font-black transition disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="submit">{{ __('contact.send') }}</span>
                    <span wire:loading wire:target="submit">...</span>
                </button>
            </div>
        </form>

        @if (config('services.recaptcha.site_key'))
            <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        @endif
    @endif
</div>
