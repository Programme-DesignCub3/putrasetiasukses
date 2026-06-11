<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
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

            $category = Category::findOrCreateForType(Category::TypeProduct, $product['category']);

            $record->categories()->syncWithoutDetaching([$category->id]);
        }
    }
}
