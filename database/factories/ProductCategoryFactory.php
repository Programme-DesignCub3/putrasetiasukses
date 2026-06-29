<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductCategory>
 */
class ProductCategoryFactory extends Factory
{
    protected $model = ProductCategory::class;

    public function definition(): array
    {
        return [
            'name' => [
                'id' => $this->faker->words(2, true),
                'en' => $this->faker->words(2, true),
                'zh' => $this->faker->words(2, true),
            ],
            'description' => [
                'id' => $this->faker->paragraph(),
                'en' => $this->faker->paragraph(),
                'zh' => $this->faker->paragraph(),
            ],
            'image_url' => 'https://placehold.co/640x420/2b2b2b/ffffff?text=Category',
            'gallery_images' => [],
            'is_active' => true,
        ];
    }
}
