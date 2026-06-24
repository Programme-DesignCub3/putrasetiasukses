<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected static array $products = [
        'Plat Hitam', 'Besi Beton', 'Baja Ringan', 'Pipa Baja',
        'Wiremesh', 'Siku Baja', 'H-Beam', 'I-Beam',
        'Baja Kanal', 'Plat Bordes', 'Besi UNP', 'Besi CNP',
    ];

    protected static array $categoriesId = [
        'Steel Plate', 'Rebar', 'Light Steel', 'Steel Pipe',
        'Wiremesh', 'Angle Bar', 'H-Beam', 'I-Beam',
    ];

    protected static array $categoriesZh = [
        '钢板', '钢筋', '轻钢', '钢管', '钢丝网', '角钢', 'H型钢', '工字钢',
    ];

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product): void {
            $category = ProductCategory::findOrCreate($product->getTranslations('category'));

            $product->categories()->syncWithoutDetaching([$category->id]);
        });
    }

    public function definition(): array
    {
        $word = fake()->randomElement(self::$products);

        return [
            'category' => [
                'id' => $word,
                'en' => fake()->randomElement(self::$categoriesId),
                'zh' => fake()->randomElement(self::$categoriesZh),
            ],
            'name' => [
                'id' => $word,
                'en' => fake()->randomElement(self::$categoriesId),
                'zh' => fake()->randomElement(self::$categoriesZh),
            ],
            'description' => [
                'id' => fake()->paragraphs(3, true),
                'en' => fake()->paragraphs(3, true),
                'zh' => fake()->randomElement([
                    '优质钢材，适用于各种建筑和工业应用。具有高强度、耐腐蚀和良好的加工性能。',
                    '高品质结构钢材，具有优异的机械性能和耐久性。广泛用于建筑和制造行业。',
                ]),
            ],
            'main_image_url' => 'https://placehold.co/860x620/'.ltrim(fake()->hexColor(), '#').'/ffffff?text='.str_replace(' ', '+', $word),
            'gallery_images' => array_map(
                fn () => ['url' => 'https://placehold.co/320x180/'.ltrim(fake()->hexColor(), '#').'/ffffff?text=Product'],
                range(1, 3),
            ),
            'is_published' => true,
        ];
    }
}
