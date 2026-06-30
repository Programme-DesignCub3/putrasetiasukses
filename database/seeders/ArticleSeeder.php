<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use Database\Seeders\Concerns\SeedsWithAssets;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    use SeedsWithAssets;

    public function run(): void
    {
        $articles = [
            [
                'category' => ['id' => 'Industri & Konstruksi', 'en' => 'Industry & Construction', 'zh' => '工业与建筑'],
                'title' => [
                    'id' => 'Perkembangan Industri Baja Indonesia Tahun Ini',
                    'en' => 'Indonesian Steel Industry Development This Year',
                    'zh' => '印尼钢铁行业发展趋势',
                ],
                'file' => 'PRODUK/PLAT HITAM.jpg',
                'excerpt' => [
                    'id' => 'Industri baja Indonesia terus menunjukkan pertumbuhan positif dengan peningkatan kapasitas produksi dan investasi baru.',
                    'en' => 'Indonesian steel industry continues to show positive growth with increased production capacity and new investments.',
                    'zh' => '印尼钢铁行业持续呈现积极增长，生产能力和新投资不断增加。',
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
                    'id' => 'Panduan lengkap memilih jenis plat baja yang tepat sesuai kebutuhan proyek konstruksi Anda.',
                    'en' => 'Complete guide to choosing the right type of steel plate for your construction project needs.',
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
                    'id' => 'Besi WF menawarkan kekuatan struktural yang unggul dengan efisiensi biaya yang optimal.',
                    'en' => 'WF beam offers superior structural strength with optimal cost efficiency.',
                    'zh' => '工字钢以最优的成本效益提供卓越的结构强度。',
                ],
            ],
            [
                'category' => ['id' => 'Produk & Material', 'en' => 'Products & Materials', 'zh' => '产品与材料'],
                'title' => [
                    'id' => 'Mengenal Berbagai Jenis Pipa Baja',
                    'en' => 'Introduction to Various Types of Steel Pipes',
                    'zh' => '各类钢管介绍',
                ],
                'file' => 'PRODUK/PIPA HITAM.jpg',
                'excerpt' => [
                    'id' => 'Pipa baja tersedia dalam berbagai jenis dan ukuran untuk memenuhi kebutuhan industri yang beragam.',
                    'en' => 'Steel pipes come in various types and sizes to meet diverse industrial needs.',
                    'zh' => '钢管有各种类型和尺寸，以满足不同的工业需求。',
                ],
            ],
            [
                'category' => ['id' => 'Berita & Update', 'en' => 'News & Updates', 'zh' => '新闻与更新'],
                'title' => [
                    'id' => 'PT Putra Setia Sukses Bersama Perluas Gudang',
                    'en' => 'PT Putra Setia Sukses Bersama Expands Warehouse',
                    'zh' => 'PT Putra Setia Sukses Bersama 扩建仓库',
                ],
                'file' => 'PRODUK/COIL GALVALUME.jpg',
                'excerpt' => [
                    'id' => 'Perusahaan terus memperluas kapasitas gudang untuk memenuhi permintaan pasar yang terus meningkat.',
                    'en' => 'The company continues to expand warehouse capacity to meet growing market demand.',
                    'zh' => '公司持续扩大仓储容量，以满足不断增长的市场需求。',
                ],
            ],
            [
                'category' => ['id' => 'Industri & Konstruksi', 'en' => 'Industry & Construction', 'zh' => '工业与建筑'],
                'title' => [
                    'id' => 'Penggunaan Baja Ringan dalam Konstruksi Modern',
                    'en' => 'Use of Light Steel in Modern Construction',
                    'zh' => '轻钢在现代建筑中的应用',
                ],
                'file' => 'PRODUK/CNP.webp',
                'excerpt' => [
                    'id' => 'Baja ringan semakin populer dalam konstruksi modern karena bobotnya yang ringan dan kekuatannya yang tinggi.',
                    'en' => 'Light steel is increasingly popular in modern construction due to its lightweight and high strength.',
                    'zh' => '轻钢因其重量轻、强度高而在现代建筑中越来越受欢迎。',
                ],
            ],
            [
                'category' => ['id' => 'Tips & Panduan', 'en' => 'Tips & Guides', 'zh' => '提示与指南'],
                'title' => [
                    'id' => 'Cara Merawat Material Baja Agar Tahan Lama',
                    'en' => 'How to Maintain Steel Materials for Longevity',
                    'zh' => '如何保养钢材以延长使用寿命',
                ],
                'file' => 'PRODUK/PLAT GALVANIS.jpg',
                'excerpt' => [
                    'id' => 'Perawatan yang tepat dapat memperpanjang umur material baja dan menjaga kualitasnya.',
                    'en' => 'Proper maintenance can extend the life of steel materials and maintain their quality.',
                    'zh' => '正确的维护可以延长钢材的使用寿命并保持其质量。',
                ],
            ],
            [
                'category' => ['id' => 'Berita & Update', 'en' => 'News & Updates', 'zh' => '新闻与更新'],
                'title' => [
                    'id' => 'Inovasi Terbaru dalam Teknologi Produksi Baja',
                    'en' => 'Latest Innovations in Steel Production Technology',
                    'zh' => '钢铁生产技术的最新创新',
                ],
                'file' => 'PRODUK/COIL GALVALUME.jpg',
                'excerpt' => [
                    'id' => 'Teknologi produksi baja terus berkembang dengan inovasi yang meningkatkan efisiensi dan kualitas.',
                    'en' => 'Steel production technology continues to evolve with innovations that improve efficiency and quality.',
                    'zh' => '钢铁生产技术不断创新，提高了效率和质量。',
                ],
            ],
        ];

        foreach ($articles as $data) {
            $category = ArticleCategory::findOrCreate($data['category']);

            $article = Article::query()->create([
                'category' => $data['category'],
                'title' => $data['title'],
                'author' => fake()->name(),
                'image_url' => $data['file'],
                'excerpt' => $data['excerpt'],
                'body' => [
                    'id' => fake()->paragraphs(5, true),
                    'en' => fake()->paragraphs(5, true),
                    'zh' => fake()->paragraphs(5, true),
                ],
                'published_at' => fake()->dateTimeBetween('-3 months', 'now'),
                'is_featured' => fake()->boolean(30),
                'is_published' => true,
            ]);

            $article->categories()->syncWithoutDetaching([$category->id]);

            $path = $this->resolveAssetPath($data['file']);

            if ($path !== null) {
                $article
                    ->addMedia($path)
                    ->preservingOriginal()
                    ->toMediaCollection(Article::ImageCollection);
            }
        }
    }
}
