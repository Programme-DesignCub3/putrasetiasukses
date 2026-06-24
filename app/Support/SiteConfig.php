<?php

namespace App\Support;

class SiteConfig
{
    public const Group = 'website';

    /**
     * @param  array<int, array{label: string, number: string}>  $phones
     */
    public function __construct(
        public string $company_name,
        public string $tagline,
        public string $website_url,
        public string $email,
        public string $whatsapp_number,
        public string $head_office_address,
        public string $warehouse_address,
        public array $phones,
    ) {}

    public static function current(): self
    {
        $defaults = self::defaults();
        $site = safe_db_config(self::Group.'.site', $defaults['site']);
        $contact = safe_db_config(self::Group.'.contact', $defaults['contact']);

        return new self(
            company_name: self::translated($site['company_name'] ?? null),
            tagline: self::translated($site['tagline'] ?? null),
            website_url: (string) ($contact['website_url'] ?? $defaults['contact']['website_url']),
            email: (string) ($contact['email'] ?? $defaults['contact']['email']),
            whatsapp_number: (string) ($contact['whatsapp_number'] ?? $defaults['contact']['whatsapp_number']),
            head_office_address: self::translated($contact['head_office_address'] ?? null),
            warehouse_address: self::translated($contact['warehouse_address'] ?? null),
            phones: array_values($contact['phones'] ?? $defaults['contact']['phones']),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public static function defaults(): array
    {
        return [
            'site' => [
                'company_name' => self::translations('PT Putra Setia Sukses Bersama'),
                'tagline' => [
                    'id' => 'Stockist dan Distributor Aneka Jenis Material Besi dan Baja',
                    'en' => 'Stockist and Distributor of Various Iron and Steel Materials',
                    'zh' => '各类钢铁材料库存商与经销商',
                ],
            ],
            'contact' => [
                'website_url' => 'www.putrasetiasukses.com',
                'email' => 'putrasetiasukses@yahoo.com',
                'whatsapp_number' => '08128438805',
                'phones' => [
                    ['label' => 'Sales 1', 'number' => '0812-8438-805'],
                    ['label' => 'Sales 2', 'number' => '0813-1485-5403'],
                    ['label' => 'Sales 3', 'number' => '0812-8550-9009'],
                    ['label' => 'Office', 'number' => '(021) 6667-1597-599'],
                ],
                'head_office_address' => [
                    'id' => 'Komplek Permata Kota Blok A-1 Jl. Pangeran Tubagus Angke Jakarta Utara 11450, Indonesia',
                    'en' => 'Komplek Permata Kota Block A-1, Jl. Pangeran Tubagus Angke, North Jakarta 11450, Indonesia',
                    'zh' => '印度尼西亚雅加达北区 Pangeran Tubagus Angke 路 Permata Kota A-1 座 11450',
                ],
                'warehouse_address' => [
                    'id' => 'Kawasan Industri PKT Bitung, Blok F6 & 7 Bitung Tangerang',
                    'en' => 'PKT Bitung Industrial Area, Block F6 & 7, Bitung Tangerang',
                    'zh' => '坦格朗 Bitung PKT 工业区 F6 & 7 区',
                ],
            ],
            'analytics' => [
                'cookie_consent_enabled' => true,
                'google_measurement_id' => config('services.google_analytics.measurement_id'),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function translations(string $value): array
    {
        return [
            'id' => $value,
            'en' => $value,
            'zh' => $value,
        ];
    }

    /**
     * @param  array<string, string>|string|null  $value
     */
    private static function translated(array|string|null $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if ($value === null) {
            return '';
        }

        return (string) ($value[app()->getLocale()] ?? $value['id'] ?? collect($value)->first() ?? '');
    }
}
