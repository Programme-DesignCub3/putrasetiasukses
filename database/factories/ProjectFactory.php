<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected static array $categoriesId = [
        'Konstruksi Gedung', 'Infrastruktur', 'Gudang & Pabrik', 'Renovasi & Retrofit',
    ];

    protected static array $categoriesZh = [
        '建筑施工', '基础设施', '仓库与工厂', '翻新与改造',
    ];

    protected static array $clients = [
        'PT Wijaya Karya', 'PT Pembangunan Perumahan', 'PT Adhi Karya',
        'PT Waskita Karya', 'PT Brantas Abipraya', 'PT Hutama Karya',
    ];

    public function configure(): static
    {
        return $this->afterCreating(function (Project $project): void {
            $category = ProjectCategory::findOrCreate($project->getTranslations('category'));

            $project->categories()->syncWithoutDetaching([$category->id]);
        });
    }

    public function definition(): array
    {
        $word = fake()->randomElement(self::$categoriesId);

        return [
            'category' => [
                'id' => $word,
                'en' => fake()->randomElement(self::$categoriesId),
                'zh' => fake()->randomElement(self::$categoriesZh),
            ],
            'name' => [
                'id' => 'Proyek '.fake()->city(),
                'en' => fake()->city().' Project',
                'zh' => fake()->city().' 项目',
            ],
            'description' => [
                'id' => fake()->paragraphs(3, true),
                'en' => fake()->paragraphs(3, true),
                'zh' => fake()->randomElement([
                    '优质钢结构施工，满足最高安全标准。项目按时交付，质量有保证。',
                    '采用先进施工技术和优质材料。项目管理团队经验丰富，确保工程质量。',
                ]),
            ],
            'client' => fake()->randomElement(self::$clients),
            'location' => [
                'id' => fake()->city().', '.fake()->randomElement(['Jawa Barat', 'Jawa Timur', 'DKI Jakarta', 'Banten', 'Sumatera Utara']),
                'en' => fake()->city().', Indonesia',
                'zh' => fake()->city().'，印度尼西亚',
            ],
            'main_image_url' => 'https://placehold.co/860x620/'.ltrim(fake()->hexColor(), '#').'/ffffff?text='.str_replace(' ', '+', $word),
            'gallery_images' => array_map(
                fn () => ['url' => 'https://placehold.co/320x180/'.ltrim(fake()->hexColor(), '#').'/ffffff?text=Project'],
                range(1, 3),
            ),
            'completion_date' => fake()->dateTimeBetween('-2 years', 'now'),
            'is_published' => true,
        ];
    }
}
