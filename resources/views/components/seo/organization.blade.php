@php
    $companyName = __('site.company_name');
    $email = __('site.email');
    $whatsappNumber = safe_db_config('website.whatsapp') ?? __('site.whatsapp_number');
    $headOfficeAddress = __('site.head_office_address');

    $data = [
        '@context' => 'https://schema.org',
        '@type' => ['Organization', 'LocalBusiness'],
        'name' => $companyName,
        'url' => url('/'),
        'email' => $email,
        'telephone' => $whatsappNumber,
        'contactPoint' => [
            [
                '@type' => 'ContactPoint',
                'telephone' => $whatsappNumber,
                'contactType' => 'sales',
            ],
        ],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $headOfficeAddress,
            'addressCountry' => 'ID',
        ],
    ];
@endphp

<script type="application/ld+json">{!! json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
