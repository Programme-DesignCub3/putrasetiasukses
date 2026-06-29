<?php

namespace Database\Factories;

use App\Models\ProjectCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectCategory>
 */
class ProjectCategoryFactory extends Factory
{
    protected $model = ProjectCategory::class;

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
