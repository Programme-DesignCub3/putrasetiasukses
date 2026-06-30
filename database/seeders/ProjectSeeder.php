<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use Database\Seeders\Concerns\SeedsWithAssets;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    use SeedsWithAssets;

    public function run(): void
    {
        $projects = [
            [
                'name' => ['id' => 'Gedung Perkantoran Green Office', 'en' => 'Green Office Building', 'zh' => '绿色办公大楼'],
                'category' => ['id' => 'Konstruksi Gedung', 'en' => 'Building Construction', 'zh' => '建筑施工'],
                'client' => 'PT Wijaya Karya',
                'location' => ['id' => 'Jakarta Selatan, DKI Jakarta', 'en' => 'South Jakarta, Jakarta', 'zh' => '南雅加达，雅加达'],
                'file' => 'CAMPUR/COIL.jpg',
                'completion_date' => '2025-03-15',
            ],
            [
                'name' => ['id' => 'Pembangunan Jembatan Layang', 'en' => 'Flyover Construction', 'zh' => '高架桥建设'],
                'category' => ['id' => 'Infrastruktur', 'en' => 'Infrastructure', 'zh' => '基础设施'],
                'client' => 'PT Pembangunan Perumahan',
                'location' => ['id' => 'Bandung, Jawa Barat', 'en' => 'Bandung, West Java', 'zh' => '万隆，西爪哇'],
                'file' => 'CAMPUR/COIL 1.jpg',
                'completion_date' => '2025-06-20',
            ],
            [
                'name' => ['id' => 'Gudang Logistik Modern', 'en' => 'Modern Logistics Warehouse', 'zh' => '现代物流仓库'],
                'category' => ['id' => 'Gudang & Pabrik', 'en' => 'Warehouse & Factory', 'zh' => '仓库与工厂'],
                'client' => 'PT Adhi Karya',
                'location' => ['id' => 'Bekasi, Jawa Barat', 'en' => 'Bekasi, West Java', 'zh' => '勿加西，西爪哇'],
                'file' => 'CAMPUR/COIL 2.jpg',
                'completion_date' => '2024-11-30',
            ],
            [
                'name' => ['id' => 'Renovasi Fasad Hotel', 'en' => 'Hotel Facade Renovation', 'zh' => '酒店外立面翻新'],
                'category' => ['id' => 'Renovasi & Retrofit', 'en' => 'Renovation & Retrofit', 'zh' => '翻新与改造'],
                'client' => 'PT Waskita Karya',
                'location' => ['id' => 'Denpasar, Bali', 'en' => 'Denpasar, Bali', 'zh' => '登巴萨，巴厘岛'],
                'file' => 'CAMPUR/COIL 3.jpg',
                'completion_date' => '2025-01-10',
            ],
            [
                'name' => ['id' => 'Pabrik Pengolahan Makanan', 'en' => 'Food Processing Plant', 'zh' => '食品加工厂'],
                'category' => ['id' => 'Gudang & Pabrik', 'en' => 'Warehouse & Factory', 'zh' => '仓库与工厂'],
                'client' => 'PT Hutama Karya',
                'location' => ['id' => 'Sidoarjo, Jawa Timur', 'en' => 'Sidoarjo, East Java', 'zh' => '诗都阿佐，东爪哇'],
                'file' => 'CAMPUR/COIL 4.jpg',
                'completion_date' => '2025-08-05',
            ],
            [
                'name' => ['id' => 'Apartemen Mewah 20 Lantai', 'en' => '20-Story Luxury Apartment', 'zh' => '20层豪华公寓'],
                'category' => ['id' => 'Konstruksi Gedung', 'en' => 'Building Construction', 'zh' => '建筑施工'],
                'client' => 'PT Brantas Abipraya',
                'location' => ['id' => 'Surabaya, Jawa Timur', 'en' => 'Surabaya, East Java', 'zh' => '泗水，东爪哇'],
                'file' => 'CAMPUR/PLAT HITAM 2.jpg',
                'completion_date' => '2026-02-14',
            ],
            [
                'name' => ['id' => 'Proyek Infrastruktur Bendungan', 'en' => 'Dam Infrastructure Project', 'zh' => '水坝基础设施项目'],
                'category' => ['id' => 'Infrastruktur', 'en' => 'Infrastructure', 'zh' => '基础设施'],
                'client' => 'PT Wijaya Karya',
                'location' => ['id' => 'Ciamis, Jawa Barat', 'en' => 'Ciamis, West Java', 'zh' => '尖美士，西爪哇'],
                'file' => 'CAMPUR/PLAT.jpg',
                'completion_date' => '2025-10-01',
            ],
        ];

        foreach ($projects as $data) {
            $category = ProjectCategory::findOrCreate($data['category']);

            $project = Project::query()->create([
                'category' => $data['category'],
                'name' => $data['name'],
                'description' => [
                    'id' => 'Proyek ini dikerjakan dengan standar kualitas tinggi menggunakan material baja terbaik. Tim kami memastikan setiap tahap pengerjaan berjalan sesuai jadwal dan spesifikasi yang ditentukan.',
                    'en' => 'This project was completed with high-quality standards using the best steel materials. Our team ensured every phase of work proceeded according to schedule and specifications.',
                    'zh' => '该项目采用优质钢材，按照高标准完成。我们的团队确保每个工作阶段都按照计划和规范进行。',
                ],
                'client' => $data['client'],
                'location' => $data['location'],
                'main_image_url' => $data['file'],
                'completion_date' => $data['completion_date'],
                'is_published' => true,
            ]);

            $project->categories()->syncWithoutDetaching([$category->id]);

            $path = $this->resolveAssetPath($data['file']);

            if ($path !== null) {
                $project
                    ->addMedia($path)
                    ->preservingOriginal()
                    ->toMediaCollection(Project::MainImageCollection);
            }
        }
    }
}
