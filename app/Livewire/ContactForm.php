<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use App\Rules\Recaptcha;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate(['required', 'string', 'max:255'])]
    public string $name = '';

    #[Validate(['nullable', 'string', 'max:255'])]
    public string $company = '';

    #[Validate(['required', 'string', 'max:50'])]
    public string $phone = '';

    #[Validate(['nullable', 'email', 'max:255'])]
    public string $email = '';

    #[Validate(['required', 'string', 'max:255'])]
    public string $subject = '';

    #[Validate(['required', 'string', 'max:5000'])]
    public string $message = '';

    public string $recaptchaToken = '';

    public bool $success = false;

    public function submit(): void
    {
        $this->validate();

        $this->validateRecaptcha();

        ContactMessage::query()->create([
            'name' => $this->name,
            'company' => $this->company ?: null,
            'phone' => $this->phone,
            'email' => $this->email ?: null,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        $this->reset(['name', 'company', 'phone', 'email', 'subject', 'message', 'recaptchaToken']);

        $this->success = true;
    }

    protected function validateRecaptcha(): void
    {
        if (! config('services.recaptcha.site_key')) {
            return;
        }

        $rule = new Recaptcha;

        $rule->validate('recaptcha_token', $this->recaptchaToken, fn ($message) => $this->addError('recaptcha', $message));
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
