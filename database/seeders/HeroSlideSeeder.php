<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Database\Seeders\Concerns\SeedsWithAssets;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    use SeedsWithAssets;

    public function run(): void
    {
        $slides = [
            [
                'image' => '120.jpg',
                'label' => 'Material Baja Terpercaya',
                'title' => 'Plat Lembaran Baja',
                'subtitle' => 'Plat Hitam - Plat Putih - Plat Galvanil',
            ],
            [
                'image' => '1176.jpg',
                'label' => 'Supplier & Distributor',
                'title' => 'Distributor Terpercaya',
                'subtitle' => 'Pengiriman ke Seluruh Indonesia',
            ],
            [
                'image' => '3285.jpg',
                'label' => 'Kualitas Terjamin',
                'title' => 'Kualitas Terbaik',
                'subtitle' => 'Standar Mutu Internasional',
            ],
        ];

        foreach ($slides as $slide) {
            $heroSlide = HeroSlide::query()->create([
                'image' => $slide['image'],
                'label' => $slide['label'],
                'title' => $slide['title'],
                'subtitle' => $slide['subtitle'],
            ]);

            $path = $this->resolveAssetPath($slide['image']);

            if ($path !== null) {
                $heroSlide
                    ->addMedia($path)
                    ->preservingOriginal()
                    ->toMediaCollection(HeroSlide::ImageCollection);
            }
        }
    }
}
