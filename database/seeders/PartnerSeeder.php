<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        Partner::query()->forceDelete();

        $items = [
            [
                'initial' => 'K',
                'name' => 'Krakatau Steel',
                'color' => '#0284c7',
            ],
            [
                'initial' => 'S',
                'name' => 'PT. Sahabat Baja Sejahtera',
                'color' => '#0891b2',
            ],
            [
                'initial' => 'P',
                'name' => 'Partner Industri Baja',
                'color' => '#b90000',
            ],
        ];

        foreach ($items as $item) {
            Partner::query()->create($item);
        }
    }
}
