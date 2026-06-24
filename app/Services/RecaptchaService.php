<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RecaptchaService
{
    public function verify(string $token, ?string $ip = null): bool
    {
        $secret = config('services.recaptcha.secret_key');

        if (blank($secret)) {
            return false;
        }

        $payload = [
            'secret' => $secret,
            'response' => $token,
        ];

        if ($ip !== null) {
            $payload['remoteip'] = $ip;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', $payload);

        $body = $response->json();

        return (bool) ($body['success'] ?? false) && ($body['score'] ?? 0) >= 0.5;
    }
}
