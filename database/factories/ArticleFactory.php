<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected static array $categoriesId = [
        'Industri & Konstruksi', 'Tips & Panduan', 'Produk & Material', 'Berita & Update',
    ];

    protected static array $categoriesZh = [
        '工业与建筑', '提示与指南', '产品与材料', '新闻与更新',
    ];

    public function configure(): static
    {
        return $this->afterCreating(function (Article $article): void {
            $category = ArticleCategory::findOrCreate($article->getTranslations('category'));

            $article->categories()->syncWithoutDetaching([$category->id]);
        });
    }

    public function definition(): array
    {
        $category = fake()->randomElement(self::$categoriesId);

        return [
            'category' => [
                'id' => $category,
                'en' => $category,
                'zh' => fake()->randomElement(self::$categoriesZh),
            ],
            'title' => [
                'id' => fake()->sentence(6),
                'en' => fake()->sentence(6),
                'zh' => fake()->randomElement([
                    '印度尼西亚钢铁行业发展趋势与未来展望',
                    '选择优质建筑钢材的实用指南',
                    '不锈钢相比其他材料的优势分析',
                    '了解钢铁生产过程：从原料到成品',
                    '延长钢材使用寿命的维护技巧',
                ]),
            ],
            'author' => fake()->name(),
            'image_url' => 'https://placehold.co/'.fake()->randomElement(['640x420', '720x480', '1180x560']).'/'.ltrim(fake()->hexColor(), '#').'/ffffff?text='.str_replace(' ', '+', $category),
            'excerpt' => [
                'id' => fake()->paragraph(2),
                'en' => fake()->paragraph(2),
                'zh' => fake()->randomElement([
                    '了解影响钢材项目成本和采购策略的关键因素。',
                    '深入了解建筑行业中钢材标准和质量要求。',
                    '探索现代建筑和工业应用中的钢材解决方案。',
                ]),
            ],
            'body' => [
                'id' => fake()->paragraphs(5, true),
                'en' => fake()->paragraphs(5, true),
                'zh' => fake()->paragraphs(5, true),
            ],
            'published_at' => fake()->dateTimeBetween('-3 months', 'now'),
            'is_featured' => fake()->boolean(30),
            'is_published' => true,
        ];
    }
}
