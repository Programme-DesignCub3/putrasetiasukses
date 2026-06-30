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
            ['name' => 'Krakatau Steel'],
            ['name' => 'PT. Sahabat Baja Sejahtera'],
            ['name' => 'Partner Industri Baja'],
        ];

        foreach ($items as $item) {
            Partner::query()->create($item);
        }
    }
}
