<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Product::defaults() as $product) {
            $record = Product::query()->updateOrCreate(
                ['slug' => $product['slug']],
                $product,
            );

            $category = ProductCategory::findOrCreate($product['category']);

            $record->categories()->syncWithoutDetaching([$category->id]);
        }
    }
}
