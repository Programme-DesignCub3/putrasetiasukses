<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Support\SiteConfig;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact', [
            'site' => SiteConfig::current(),
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
        ]));

        return back()->with('status', __('site.contact.success'));
    }
}
