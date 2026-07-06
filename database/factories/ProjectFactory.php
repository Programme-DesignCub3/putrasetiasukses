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
            'content' => [
                'id' => fake()->randomElement([
                    '<h2>Latar Belakang Proyek</h2><p>Proyek ini merupakan bagian dari komitmen kami untuk memberikan solusi konstruksi terbaik. Dengan pengalaman lebih dari 15 tahun, tim kami siap menghadapi tantangan teknis apapun.</p><h3>Proses Pelaksanaan</h3><p>Pelaksanaan proyek dimulai dengan persiapan lahan dan mobilisasi alat berat. Seluruh tahapan dikerjakan sesuai standar operasional prosedur yang ketat.</p><ul><li>Survei dan perencanaan lokasi</li><li>Pengadaan material berkualitas</li><li>Konstruksi dan perakitan</li><li>Pengujian kualitas dan commissioning</li></ul><h3>Hasil Akhir</h3><p>Proyek selesai tepat waktu dengan kualitas terbaik. Klien menyatakan kepuasan atas hasil kerja kami.</p>',
                    '<h2>Tantangan dan Solusi</h2><p>Setiap proyek memiliki tantangan tersendiri. Dalam proyek ini, kami menghadapi keterbatasan lahan dan jadwal yang ketat.</p><h3>Pendekatan Kami</h3><p>Tim kami mengembangkan strategi komprehensif yang mencakup manajemen risiko, alokasi sumber daya efisien, dan komunikasi yang transparan dengan semua pemangku kepentingan.</p><ol><li>Analisis risiko menyeluruh</li><li>Perencanaan kontingensi</li><li>Monitoring progres harian</li><li>Evaluasi dan penyesuaian berkala</li></ol><h3>Kesimpulan</h3><p>Dengan perencanaan yang matang dan eksekusi yang tepat, kami berhasil menyelesaikan proyek sesuai target.</p>',
                    '<h2>Spesifikasi Teknis</h2><p>Proyek ini menggunakan material baja berkualitas tinggi dengan spesifikasi teknis yang ketat.</p><h3>Material yang Digunakan</h3><p>Seluruh material baja yang digunakan telah melewati uji kualitas dan tersertifikasi SNI.</p><h3>Metode Konstruksi</h3><p>Kami mengadopsi metode konstruksi modern yang efisien dan ramah lingkungan, mengurangi limbah dan memaksimalkan produktivitas.</p><blockquote>"Kualitas adalah prioritas utama kami dalam setiap proyek."</blockquote><p>Hasil akhir menunjukkan bahwa investasi pada kualitas material dan tenaga kerja terlatih memberikan dampak positif pada durabilitas bangunan.</p>',
                ]),
                'en' => fake()->randomElement([
                    '<h2>Project Background</h2><p>This project is part of our commitment to provide the best construction solutions. With over 15 years of experience, our team is ready to face any technical challenges.</p><h3>Execution Process</h3><p>The project execution began with site preparation and heavy equipment mobilization. All stages were carried out according to strict standard operating procedures.</p><ul><li>Site survey and planning</li><li>Quality material procurement</li><li>Construction and assembly</li><li>Quality testing and commissioning</li></ul><h3>Final Result</h3><p>The project was completed on time with the highest quality. The client expressed satisfaction with our work.</p>',
                    '<h2>Challenges and Solutions</h2><p>Every project has its own challenges. In this project, we faced limited space and a tight schedule.</p><h3>Our Approach</h3><p>Our team developed a comprehensive strategy covering risk management, efficient resource allocation, and transparent communication with all stakeholders.</p><ol><li>Thorough risk analysis</li><li>Contingency planning</li><li>Daily progress monitoring</li><li>Periodic evaluation and adjustment</li></ol><h3>Conclusion</h3><p>With careful planning and precise execution, we successfully completed the project on target.</p>',
                    '<h2>Technical Specifications</h2><p>This project uses high-quality steel materials with strict technical specifications.</p><h3>Materials Used</h3><p>All steel materials used have passed quality testing and are SNI certified.</p><h3>Construction Methods</h3><p>We adopted modern, efficient, and environmentally friendly construction methods, reducing waste and maximizing productivity.</p><blockquote>"Quality is our top priority in every project."</blockquote><p>The final result shows that investment in quality materials and trained labor has a positive impact on building durability.</p>',
                ]),
                'zh' => fake()->randomElement([
                    '<h2>项目背景</h2><p>本项目是我们提供最佳建筑解决方案承诺的一部分。凭借超过15年的经验，我们的团队已准备好应对任何技术挑战。</p><h3>执行过程</h3><p>项目执行从现场准备和重型设备动员开始。所有阶段都按照严格的标准操作程序进行。</p><ul><li>现场勘测和规划</li><li>优质材料采购</li><li>施工和组装</li><li>质量测试和调试</li></ul><h3>最终成果</h3><p>项目按时高质量完成。客户对我们的工作表示满意。</p>',
                    '<h2>挑战与解决方案</h2><p>每个项目都有自己的挑战。在这个项目中，我们面临着空间有限和工期紧张的问题。</p><h3>我们的方法</h3><p>我们的团队制定了全面的策略，包括风险管理、高效的资源分配以及与所有利益相关者的透明沟通。</p><ol><li>全面的风险分析</li><li>应急计划</li><li>日常进度监控</li><li>定期评估和调整</li></ol><h3>结论</h3><p>通过精心的规划和精确的执行，我们成功按时完成了项目。</p>',
                ]),
            ],
            'completion_date' => fake()->dateTimeBetween('-2 years', 'now'),
            'is_published' => true,
        ];
    }
}
