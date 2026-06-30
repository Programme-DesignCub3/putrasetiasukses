<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Database\Seeders\Concerns\SeedsWithAssets;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use SeedsWithAssets;

    public function run(): void
    {
        $products = [
            [
                'name' => ['id' => 'Plat Hitam', 'en' => 'Black Steel Plate', 'zh' => '黑钢板'],
                'category' => ['id' => 'Plat Baja', 'en' => 'Steel Plate', 'zh' => '钢板'],
                'file' => 'PRODUK/PLAT HITAM.jpg',
            ],
            [
                'name' => ['id' => 'Plat Putih', 'en' => 'White Steel Plate', 'zh' => '白钢板'],
                'category' => ['id' => 'Plat Baja', 'en' => 'Steel Plate', 'zh' => '钢板'],
                'file' => 'PRODUK/PLAT PUTIH.jpg',
            ],
            [
                'name' => ['id' => 'Plat Galvanil', 'en' => 'Galvanil Plate', 'zh' => '镀锌板'],
                'category' => ['id' => 'Plat Baja', 'en' => 'Steel Plate', 'zh' => '钢板'],
                'file' => 'PRODUK/PLAT GALVANIL.jpg',
            ],
            [
                'name' => ['id' => 'Plat Galvanis', 'en' => 'Galvanized Plate', 'zh' => '镀锌钢板'],
                'category' => ['id' => 'Plat Baja', 'en' => 'Steel Plate', 'zh' => '钢板'],
                'file' => 'PRODUK/PLAT GALVANIS.jpg',
            ],
            [
                'name' => ['id' => 'Plat Bordes', 'en' => 'Checker Plate', 'zh' => '花纹板'],
                'category' => ['id' => 'Plat Baja', 'en' => 'Steel Plate', 'zh' => '钢板'],
                'file' => 'PRODUK/PLAT BORDES.jpg',
            ],
            [
                'name' => ['id' => 'Plat Stainless', 'en' => 'Stainless Steel Plate', 'zh' => '不锈钢板'],
                'category' => ['id' => 'Plat Baja', 'en' => 'Steel Plate', 'zh' => '钢板'],
                'file' => 'PRODUK/PLAT STAINLESS.jpg',
            ],
            [
                'name' => ['id' => 'Plat SS400', 'en' => 'SS400 Plate', 'zh' => 'SS400钢板'],
                'category' => ['id' => 'Plat Baja', 'en' => 'Steel Plate', 'zh' => '钢板'],
                'file' => 'PRODUK/PLAT SS400.jpg',
            ],
            [
                'name' => ['id' => 'Plat Kapal', 'en' => 'Ship Plate', 'zh' => '船用钢板'],
                'category' => ['id' => 'Plat Baja', 'en' => 'Steel Plate', 'zh' => '钢板'],
                'file' => 'PRODUK/PLAT KAPAL.jpg',
            ],
            [
                'name' => ['id' => 'Besi Beton Polos', 'en' => 'Plain Rebar', 'zh' => '光圆钢筋'],
                'category' => ['id' => 'Besi Beton', 'en' => 'Rebar', 'zh' => '钢筋'],
                'file' => 'PRODUK/BETON POLOS.jpg',
            ],
            [
                'name' => ['id' => 'Besi Beton Ulir', 'en' => 'Threaded Rebar', 'zh' => '螺纹钢筋'],
                'category' => ['id' => 'Besi Beton', 'en' => 'Rebar', 'zh' => '钢筋'],
                'file' => 'PRODUK/BETON ULIR.jpg',
            ],
            [
                'name' => ['id' => 'Wiremesh', 'en' => 'Wiremesh', 'zh' => '钢丝网'],
                'category' => ['id' => 'Besi Beton', 'en' => 'Rebar', 'zh' => '钢筋'],
                'file' => 'PRODUK/WIREMESH.jpg',
            ],
            [
                'name' => ['id' => 'Besi WF', 'en' => 'WF Beam', 'zh' => '工字钢'],
                'category' => ['id' => 'Baja Profil', 'en' => 'Profile Steel', 'zh' => '型钢'],
                'file' => 'PRODUK/WF.jpg',
            ],
            [
                'name' => ['id' => 'Besi H-Beam', 'en' => 'H-Beam', 'zh' => 'H型钢'],
                'category' => ['id' => 'Baja Profil', 'en' => 'Profile Steel', 'zh' => '型钢'],
                'file' => 'PRODUK/H-BEAM.jpg',
            ],
            [
                'name' => ['id' => 'Besi UNP', 'en' => 'UNP Channel', 'zh' => 'UNP槽钢'],
                'category' => ['id' => 'Baja Profil', 'en' => 'Profile Steel', 'zh' => '型钢'],
                'file' => 'PRODUK/UNP.jpg',
            ],
            [
                'name' => ['id' => 'Besi CNP', 'en' => 'CNP Channel', 'zh' => 'CNP槽钢'],
                'category' => ['id' => 'Baja Profil', 'en' => 'Profile Steel', 'zh' => '型钢'],
                'file' => 'PRODUK/CNP.webp',
            ],
            [
                'name' => ['id' => 'Besi Siku', 'en' => 'Angle Bar', 'zh' => '角钢'],
                'category' => ['id' => 'Baja Profil', 'en' => 'Profile Steel', 'zh' => '型钢'],
                'file' => 'PRODUK/SIKU.jpg',
            ],
            [
                'name' => ['id' => 'Besi Hollow', 'en' => 'Hollow Section', 'zh' => '方钢管'],
                'category' => ['id' => 'Baja Profil', 'en' => 'Profile Steel', 'zh' => '型钢'],
                'file' => 'PRODUK/HOLLOW.webp',
            ],
            [
                'name' => ['id' => 'Pipa Hitam', 'en' => 'Black Pipe', 'zh' => '黑管'],
                'category' => ['id' => 'Pipa Baja', 'en' => 'Steel Pipe', 'zh' => '钢管'],
                'file' => 'PRODUK/PIPA HITAM.jpg',
            ],
            [
                'name' => ['id' => 'Pipa Galvanis', 'en' => 'Galvanized Pipe', 'zh' => '镀锌管'],
                'category' => ['id' => 'Pipa Baja', 'en' => 'Steel Pipe', 'zh' => '钢管'],
                'file' => 'PRODUK/PIPA GALVANIS.jpg',
            ],
            [
                'name' => ['id' => 'Spandeck Galvalum', 'en' => 'Spandeck Galvalume', 'zh' => '屋面板'],
                'category' => ['id' => 'Atap', 'en' => 'Roofing', 'zh' => '屋顶'],
                'file' => 'PRODUK/SPANDECK GALVALUM.png',
            ],
            [
                'name' => ['id' => 'Bondek Galvalum', 'en' => 'Bondek Galvalume', 'zh' => '楼承板'],
                'category' => ['id' => 'Atap', 'en' => 'Roofing', 'zh' => '屋顶'],
                'file' => 'PRODUK/BONDEK GALVALUM.png',
            ],
        ];

        foreach ($products as $data) {
            $category = ProductCategory::findOrCreate($data['category']);
            $productData = [
                'category' => $data['category'],
                'name' => $data['name'],
                'description' => [
                    'id' => 'Produk berkualitas tinggi untuk berbagai kebutuhan konstruksi dan industri.',
                    'en' => 'High-quality product for various construction and industrial needs.',
                    'zh' => '适用于各种建筑和工业需求的高质量产品。',
                ],
                'main_image_url' => $data['file'],
                'is_published' => true,
            ];

            $product = Product::query()->create($productData);
            $product->categories()->syncWithoutDetaching([$category->id]);

            $path = $this->resolveAssetPath($data['file']);

            if ($path !== null) {
                $product
                    ->addMedia($path)
                    ->preservingOriginal()
                    ->toMediaCollection(Product::MainImageCollection);
            }
        }
    }
}
