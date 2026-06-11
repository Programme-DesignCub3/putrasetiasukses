<?php

namespace App\Models;

use Database\Factories\SiteSettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    /** @use HasFactory<SiteSettingFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'company_name',
        'tagline',
        'website_url',
        'email',
        'whatsapp_number',
        'phones',
        'head_office_address',
        'warehouse_address',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'phones' => 'array',
        ];
    }

    public static function current(): self
    {
        return self::query()->firstOrCreate([], self::defaults());
    }

    /**
     * @return array<string, mixed>
     */
    public static function defaults(): array
    {
        return [
            'company_name' => 'PT Putra Setia Sukses Bersama',
            'tagline' => 'Stockist dan Distributor Aneka Jenis Material Besi dan Baja',
            'website_url' => 'www.putrasetiasukses.com',
            'email' => 'putrasetiasukses@yahoo.com',
            'whatsapp_number' => '628128438805',
            'phones' => [
                ['label' => 'Sales 1', 'number' => '0812-8438-805'],
                ['label' => 'Sales 2', 'number' => '0813-1485-5403'],
                ['label' => 'Sales 3', 'number' => '0812-8550-9009'],
                ['label' => 'Office', 'number' => '(021) 6667-1597-599'],
            ],
            'head_office_address' => 'Komplek Permata Kota Blok A-1 Jl. Pangeran Tubagus Angke Jakarta Utara 11450, Indonesia',
            'warehouse_address' => 'Kawasan Industri PKT Bitung, Blok F6 & 7 Bitung Tangerang',
        ];
    }
}
