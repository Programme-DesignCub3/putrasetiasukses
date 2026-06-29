<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'image' => 'https://placehold.co/1800x720/5f6872/ffffff?text=Plat+Lembaran+Baja',
                'label' => 'Material Baja Terpercaya',
                'title' => 'Plat Lembaran Baja',
                'subtitle' => 'Plat Hitam - Plat Putih - Plat Galvanil',
            ],
            [
                'image' => 'https://placehold.co/1800x720/4b5563/ffffff?text=Distributor+Terpercaya',
                'label' => 'Supplier & Distributor',
                'title' => 'Distributor Terpercaya',
                'subtitle' => 'Pengiriman ke Seluruh Indonesia',
            ],
            [
                'image' => 'https://placehold.co/1800x720/2b2b2b/ffffff?text=Kualitas+Terbaik',
                'label' => 'Kualitas Terjamin',
                'title' => 'Kualitas Terbaik',
                'subtitle' => 'Standar Mutu Internasional',
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::query()->create($slide);
        }
    }
}
