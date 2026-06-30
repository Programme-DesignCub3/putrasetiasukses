<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ContactMessage;
use App\Models\Partner;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\Concerns\SeedsWithAssets;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    use SeedsWithAssets;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        ProductCategory::create([
            'name' => ['id' => 'Plat Baja', 'en' => 'Steel Plate', 'zh' => '钢板'],
        ]);

        ProductCategory::create([
            'name' => ['id' => 'Besi Beton', 'en' => 'Rebar', 'zh' => '钢筋'],
        ]);

        ArticleCategory::create([
            'name' => ['id' => 'Industri & Konstruksi', 'en' => 'Industry & Construction', 'zh' => '工业与建筑'],
        ]);

        ArticleCategory::create([
            'name' => ['id' => 'Tips & Panduan', 'en' => 'Tips & Guides', 'zh' => '提示与指南'],
        ]);

        ProjectCategory::create([
            'name' => ['id' => 'Konstruksi Gedung', 'en' => 'Building Construction', 'zh' => '建筑施工'],
        ]);

        $testProducts = [
            [
                'name' => ['id' => 'Plat Hitam', 'en' => 'Black Steel Plate', 'zh' => '黑钢板'],
                'category' => ['id' => 'Plat Baja', 'en' => 'Steel Plate', 'zh' => '钢板'],
                'file' => 'PRODUK/PLAT HITAM.jpg',
            ],
            [
                'name' => ['id' => 'Besi Beton Polos', 'en' => 'Plain Rebar', 'zh' => '光圆钢筋'],
                'category' => ['id' => 'Besi Beton', 'en' => 'Rebar', 'zh' => '钢筋'],
                'file' => 'PRODUK/BETON POLOS.jpg',
            ],
            [
                'name' => ['id' => 'Besi WF', 'en' => 'WF Beam', 'zh' => '工字钢'],
                'category' => ['id' => 'Baja Profil', 'en' => 'Profile Steel', 'zh' => '型钢'],
                'file' => 'PRODUK/WF.jpg',
            ],
            [
                'name' => ['id' => 'Pipa Hitam', 'en' => 'Black Pipe', 'zh' => '黑管'],
                'category' => ['id' => 'Pipa Baja', 'en' => 'Steel Pipe', 'zh' => '钢管'],
                'file' => 'PRODUK/PIPA HITAM.jpg',
            ],
        ];

        foreach ($testProducts as $data) {
            $category = ProductCategory::findOrCreate($data['category']);
            $product = Product::query()->create([
                'category' => $data['category'],
                'name' => $data['name'],
                'description' => [
                    'id' => 'Produk berkualitas tinggi untuk berbagai kebutuhan konstruksi dan industri.',
                    'en' => 'High-quality product for various construction and industrial needs.',
                    'zh' => '适用于各种建筑和工业需求的高质量产品。',
                ],
                'main_image_url' => $data['file'],
                'is_published' => true,
            ]);
            $product->categories()->syncWithoutDetaching([$category->id]);

            $path = $this->resolveAssetPath($data['file']);
            if ($path !== null) {
                $product->addMedia($path)->preservingOriginal()->toMediaCollection(Product::MainImageCollection);
            }
        }

        $testArticles = [
            [
                'category' => ['id' => 'Industri & Konstruksi', 'en' => 'Industry & Construction', 'zh' => '工业与建筑'],
                'title' => [
                    'id' => 'Perkembangan Industri Baja Indonesia',
                    'en' => 'Indonesian Steel Industry Development',
                    'zh' => '印尼钢铁行业发展趋势',
                ],
                'file' => 'PRODUK/PLAT HITAM.jpg',
                'excerpt' => [
                    'id' => 'Industri baja Indonesia terus menunjukkan pertumbuhan positif.',
                    'en' => 'Indonesian steel industry continues to show positive growth.',
                    'zh' => '印尼钢铁行业持续呈现积极增长。',
                ],
            ],
            [
                'category' => ['id' => 'Tips & Panduan', 'en' => 'Tips & Guides', 'zh' => '提示与指南'],
                'title' => [
                    'id' => 'Tips Memilih Plat Baja untuk Konstruksi',
                    'en' => 'Tips for Choosing Steel Plate for Construction',
                    'zh' => '建筑用钢板选择指南',
                ],
                'file' => 'PRODUK/PLAT PUTIH.jpg',
                'excerpt' => [
                    'id' => 'Panduan lengkap memilih jenis plat baja yang tepat.',
                    'en' => 'Complete guide to choosing the right type of steel plate.',
                    'zh' => '为您的建筑项目选择合适钢板类型的完整指南。',
                ],
            ],
            [
                'category' => ['id' => 'Produk & Material', 'en' => 'Products & Materials', 'zh' => '产品与材料'],
                'title' => [
                    'id' => 'Keunggulan Besi WF untuk Struktur Bangunan',
                    'en' => 'Advantages of WF Beam for Building Structures',
                    'zh' => '工字钢在建筑结构中的优势',
                ],
                'file' => 'PRODUK/WF.jpg',
                'excerpt' => [
                    'id' => 'Besi WF menawarkan kekuatan struktural yang unggul.',
                    'en' => 'WF beam offers superior structural strength.',
                    'zh' => '工字钢以最优的成本效益提供卓越的结构强度。',
                ],
            ],
        ];

        foreach ($testArticles as $data) {
            $category = ArticleCategory::findOrCreate($data['category']);
            $article = Article::query()->create([
                'category' => $data['category'],
                'title' => $data['title'],
                'author' => fake()->name(),
                'image_url' => $data['file'],
                'excerpt' => $data['excerpt'],
                'body' => [
                    'id' => fake()->paragraphs(3, true),
                    'en' => fake()->paragraphs(3, true),
                    'zh' => fake()->paragraphs(3, true),
                ],
                'published_at' => fake()->dateTimeBetween('-3 months', 'now'),
                'is_featured' => true,
                'is_published' => true,
            ]);
            $article->categories()->syncWithoutDetaching([$category->id]);

            $path = $this->resolveAssetPath($data['file']);
            if ($path !== null) {
                $article->addMedia($path)->preservingOriginal()->toMediaCollection(Article::ImageCollection);
            }
        }

        Project::factory()->count(2)->create();

        ContactMessage::factory()->create([
            'name' => 'Budi Santoso',
            'company' => 'PT Konstruksi Maju',
            'phone' => '081234567890',
            'email' => 'budi@example.com',
            'subject' => 'Permintaan Harga Plat Baja',
            'message' => 'Mohon info harga dan ketersediaan plat baja ukuran 10mm.',
        ]);

        ContactMessage::factory()->create([
            'name' => 'John Doe',
            'company' => 'Steel Works Inc',
            'phone' => '+628123456789',
            'email' => 'john@example.com',
            'subject' => 'Inquiry about Rebar',
            'message' => 'We need a quote for 500 tons of rebar.',
            'read_at' => now()->subDay(),
        ]);

        Testimonial::factory()->create([
            'name' => 'Jonathan Doe',
            'role' => 'Pemilik Rumah',
            'content' => 'PT Putra Setia Sukses Bersama merupakan mitra yang profesional dan dapat diandalkan.',
        ]);

        Testimonial::factory()->create([
            'name' => 'Andi Pratama',
            'role' => 'Kontraktor',
            'content' => 'Pelayanan responsif dan stok material sangat membantu kebutuhan proyek kami.',
        ]);

        Partner::factory()->create([
            'initial' => 'K',
            'name' => 'Krakatau Steel',
            'color' => '#0284c7',
        ]);

        Partner::factory()->create([
            'initial' => 'S',
            'name' => 'PT. Sahabat Baja Sejahtera',
            'color' => '#0891b2',
        ]);
    }
}
