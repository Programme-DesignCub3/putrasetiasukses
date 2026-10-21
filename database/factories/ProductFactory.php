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
            'content' => [
                'id' => fake()->randomElement([
                    '<h2>Spesifikasi Produk</h2><p>Produk ini diproduksi sesuai standar SNI dan melewati kontrol kualitas ketat sebelum dikirim ke pelanggan.</p><h3>Keunggulan</h3><ul><li>Material berkualitas tinggi</li><li>Tahan lama dan stabil</li><li>Tersedia dalam berbagai ukuran</li></ul>',
                    '<h2>Penggunaan</h2><p>Cocok untuk konstruksi bangunan, fabrikasi ringan, dan kebutuhan industri lainnya.</p><blockquote>Konsultasikan kebutuhan material Anda dengan tim kami.</blockquote>',
                ]),
                'en' => fake()->randomElement([
                    '<h2>Product Specification</h2><p>This product is manufactured to SNI standards and passes strict quality control before delivery.</p><h3>Advantages</h3><ul><li>High-quality material</li><li>Durable and stable</li><li>Available in various sizes</li></ul>',
                    '<h2>Usage</h2><p>Suitable for building construction, light fabrication, and other industrial needs.</p><blockquote>Consult your material needs with our team.</blockquote>',
                ]),
                'zh' => fake()->randomElement([
                    '<h2>产品规格</h2><p>本产品按照SNI标准生产，出厂前经过严格的质量检验。</p><h3>优势</h3><ul><li>高品质材料</li><li>耐用稳定</li><li>多种规格可选</li></ul>',
                    '<h2>用途</h2><p>适用于建筑施工、轻型制造及其他工业需求。</p><blockquote>请与我们的团队咨询您的材料需求。</blockquote>',
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
