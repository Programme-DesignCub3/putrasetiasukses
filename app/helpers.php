<?php

use Illuminate\Support\Collection;

if (! function_exists('translated')) {
    /**
     * @param  array<string, string>|string|null  $value
     */
    function translated(array|string|null $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if ($value === null) {
            return '';
        }

        return (string) ($value[app()->getLocale()] ?? $value['id'] ?? Collection::make($value)->first() ?? '');
    }
}

if (! function_exists('site_config')) {
    function site_config(): stdClass
    {
        $site = safe_db_config('website.site', []);
        $contact = safe_db_config('website.contact', []);

        return (object) [
            'company_name' => translated($site['company_name'] ?? null) ?: __('site.company_name'),
            'tagline' => translated($site['tagline'] ?? null) ?: __('site.tagline'),
            'website_url' => (string) ($contact['website_url'] ?? __('site.website_url')),
            'email' => (string) ($contact['email'] ?? __('site.email')),
            'whatsapp_number' => (string) ($contact['whatsapp_number'] ?? __('site.whatsapp_number')),
            'head_office_address' => translated($contact['head_office_address'] ?? null) ?: __('site.head_office_address'),
            'warehouse_address' => translated($contact['warehouse_address'] ?? null) ?: __('site.warehouse_address'),
            'phones' => array_values($contact['phones'] ?? [
                ['label' => 'Sales 1', 'number' => '0812-8438-805'],
                ['label' => 'Sales 2', 'number' => '0813-1485-5403'],
                ['label' => 'Sales 3', 'number' => '0812-8550-9009'],
                ['label' => 'Office', 'number' => '(021) 6667-1597-599'],
            ]),
        ];
    }
}
