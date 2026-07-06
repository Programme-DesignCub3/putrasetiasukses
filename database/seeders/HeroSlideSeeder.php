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
                'label' => ['id' => 'Material Baja Terpercaya', 'en' => 'Trusted Steel Material', 'zh' => '可信赖的钢材材料'],
                'title' => ['id' => 'Plat Lembaran Baja', 'en' => 'Steel Plate Sheets', 'zh' => '钢板板材'],
                'subtitle' => ['id' => 'Plat Hitam - Plat Putih - Plat Galvanil', 'en' => 'Black Plate - White Plate - Galvanized Plate', 'zh' => '黑钢板 - 白钢板 - 镀锌板'],
            ],
            [
                'image' => '1176.jpg',
                'label' => ['id' => 'Supplier & Distributor', 'en' => 'Supplier & Distributor', 'zh' => '供应商与经销商'],
                'title' => ['id' => 'Distributor Terpercaya', 'en' => 'Trusted Distributor', 'zh' => '值得信赖的分销商'],
                'subtitle' => ['id' => 'Pengiriman ke Seluruh Indonesia', 'en' => 'Delivery Throughout Indonesia', 'zh' => '配送至全印尼'],
            ],
            [
                'image' => '3285.jpg',
                'label' => ['id' => 'Kualitas Terjamin', 'en' => 'Guaranteed Quality', 'zh' => '品质保证'],
                'title' => ['id' => 'Kualitas Terbaik', 'en' => 'Best Quality', 'zh' => '最佳品质'],
                'subtitle' => ['id' => 'Standar Mutu Internasional', 'en' => 'International Quality Standards', 'zh' => '国际质量标准'],
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
                    ->withCustomProperties(['locale' => 'id'])
                    ->toMediaCollection(HeroSlide::ImageCollection);
            }
        }
    }
}
