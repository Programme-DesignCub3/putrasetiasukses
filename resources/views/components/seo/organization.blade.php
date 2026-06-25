@php
    try {
        $config = site_config();
    } catch (\Throwable) {
        return;
    }

    $phones = array_map(fn (array $phone): string => $phone['number'], $config->phones);
    $telephone = $phones[0] ?? $config->whatsapp_number;

    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $config->company_name,
        'url' => url('/'),
        'email' => $config->email,
        'telephone' => $telephone,
        'contactPoint' => [
            [
                '@type' => 'ContactPoint',
                'telephone' => $telephone,
                'contactType' => 'sales',
            ],
        ],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $config->head_office_address,
            'addressCountry' => 'ID',
        ],
    ];
@endphp

<script type="application/ld+json">{!! json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
