<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement([
                Category::TypeProduct,
                Category::TypeArticle,
                Category::TypeProject,
            ]),
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
