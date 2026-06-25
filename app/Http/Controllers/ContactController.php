<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Rules\Recaptcha;
use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create(SeoMetadataBuilder $metadata): View
    {
        $site = site_config();

        $metadata->build(
            title: __('seo.contact.title').' - '.$site->company_name,
            description: __('seo.contact.description'),
            image: 'https://placehold.co/1400x320/1f2937/ffffff?text=Kontak',
        );

        return view('contact', [
            'site' => $site,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        ContactMessage::query()->create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'recaptcha_token' => ['required', 'string', new Recaptcha],
        ]));

        return back()->with('status', __('contact.success'));
    }
}
