<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['en' => 'Wire Rod', 'id' => 'Kawat Baja', 'zh' => '线材'],
            ['en' => 'H-Beam', 'id' => 'H-Beam', 'zh' => 'H型钢'],
            ['en' => 'Angle Bar', 'id' => 'Siku', 'zh' => '角钢'],
            ['en' => 'Flat Bar', 'id' => 'Flat Bar', 'zh' => '扁钢'],
            ['en' => 'Galvanized Sheet', 'id' => 'Pelvel Galvalum', 'zh' => '镀锌板'],
            ['en' => 'Wire Mesh', 'id' => 'Wire Mesh', 'zh' => '钢丝网'],
            ['en' => 'C-Channel', 'id' => 'CNP', 'zh' => 'C型钢'],
            ['en' => 'Bolt & Nut', 'id' => 'Baut & Mur', 'zh' => '螺栓螺母'],
            ['en' => 'I-Beam', 'id' => 'IWF', 'zh' => 'I型钢'],
            ['en' => 'Sheet Pile', 'id' => 'Sheet Pile', 'zh' => '钢板桩'],
            ['en' => 'Tube & Pipe', 'id' => 'Tube & Pipa', 'zh' => '管材'],
            ['en' => 'Coil & Sheet', 'id' => 'Coil & Plat', 'zh' => '卷板'],
            ['en' => 'Checkered Plate', 'id' => 'Plat Bordes', 'zh' => '花纹板'],
            ['en' => 'Empty Barrel', 'id' => 'Tong Kosong', 'zh' => '空桶'],
            ['en' => 'Steel Fence', 'id' => 'Pagar Baja', 'zh' => '钢围栏'],
        ];

        foreach ($categories as $name) {
            ProductCategory::updateOrCreate(
                ['slug' => \Str::slug($name['id'])],
                [
                    'name' => $name,
                    'is_active' => true,
                ],
            );
        }
    }
}
