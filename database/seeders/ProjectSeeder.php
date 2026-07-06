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
                'content' => [
                    'id' => '<h2>Latar Belakang Proyek</h2><p>Proyek ini merupakan bagian dari komitmen kami untuk memberikan solusi konstruksi terbaik di kawasan perkantoran Jakarta Selatan.</p><h3>Lingkup Pekerjaan</h3><ul><li>Pembangunan struktur utama 15 lantai</li><li>Sistem utilitas dan MEP terintegrasi</li><li>Fasad kaca modern dengan teknologi hemat energi</li><li>Area parkir basement 3 lantai</li></ul><h3>Hasil</h3><p>Gedung perkantoran ini berhasil diselesaikan tepat waktu dan menjadi salah satu ikon baru di kawasan bisnis Jakarta Selatan.</p>',
                    'en' => '<h2>Project Background</h2><p>This project is part of our commitment to provide the best construction solutions in the South Jakarta office district.</p><h3>Scope of Work</h3><ul><li>15-story main structure construction</li><li>Integrated utility and MEP systems</li><li>Modern glass facade with energy-efficient technology</li><li>3-level basement parking area</li></ul><h3>Result</h3><p>The office building was completed on time and has become a new landmark in the South Jakarta business district.</p>',
                    'zh' => '<h2>项目背景</h2><p>本项目是我们在南雅加达办公区提供最佳建筑解决方案的一部分。</p><h3>工作范围</h3><ul><li>15层主楼结构施工</li><li>综合公用设施和机电系统</li><li>采用节能技术的现代玻璃幕墙</li><li>3层地下停车场</li></ul><h3>成果</h3><p>办公楼按时完工，已成为南雅加达商业区的新地标。</p>',
                ],
            ],
            [
                'name' => ['id' => 'Pembangunan Jembatan Layang', 'en' => 'Flyover Construction', 'zh' => '高架桥建设'],
                'category' => ['id' => 'Infrastruktur', 'en' => 'Infrastructure', 'zh' => '基础设施'],
                'client' => 'PT Pembangunan Perumahan',
                'location' => ['id' => 'Bandung, Jawa Barat', 'en' => 'Bandung, West Java', 'zh' => '万隆，西爪哇'],
                'file' => 'CAMPUR/COIL 1.jpg',
                'completion_date' => '2025-06-20',
                'content' => [
                    'id' => '<h2>Tantangan Proyek</h2><p>Pembangunan jembatan layang di Bandung menghadapi tantangan geografis dan kepadatan lalu lintas yang tinggi.</p><h3>Solusi</h3><p>Tim kami merancang metode konstruksi bertahap dengan rekayasa lalu lintas yang meminimalkan gangguan.</p><ol><li>Analisis struktur tanah dan fondasi</li><li>Desain struktur baja tahan gempa</li><li>Konstruksi segmen demi segmen</li><li>Uji beban dan kelayakan</li></ol><h3>Manfaat</h3><p>Jembatan layang ini kini mengurangi kemacetan hingga 40% dan mempercepat waktu tempuh.</p>',
                    'en' => '<h2>Project Challenges</h2><p>The flyover construction in Bandung faced geographical challenges and high traffic density.</p><h3>Solution</h3><p>Our team designed a phased construction method with traffic engineering that minimized disruption.</p><ol><li>Soil structure and foundation analysis</li><li>Earthquake-resistant steel structure design</li><li>Segment-by-segment construction</li><li>Load and feasibility testing</li></ol><h3>Benefits</h3><p>The flyover now reduces congestion by up to 40% and shortens travel time.</p>',
                    'zh' => '<h2>项目挑战</h2><p>万隆的高架桥建设面临地理挑战和高交通密度。</p><h3>解决方案</h3><p>我们的团队设计了分阶段施工方法和交通管理方案，最大限度地减少干扰。</p><ol><li>土壤结构和基础分析</li><li>抗震钢结构设计</li><li>分段施工</li><li>荷载和可行性测试</li></ol><h3>效益</h3><p>高架桥现在减少了高达40%的拥堵，缩短了通行时间。</p>',
                ],
            ],
            [
                'name' => ['id' => 'Gudang Logistik Modern', 'en' => 'Modern Logistics Warehouse', 'zh' => '现代物流仓库'],
                'category' => ['id' => 'Gudang & Pabrik', 'en' => 'Warehouse & Factory', 'zh' => '仓库与工厂'],
                'client' => 'PT Adhi Karya',
                'location' => ['id' => 'Bekasi, Jawa Barat', 'en' => 'Bekasi, West Java', 'zh' => '勿加西，西爪哇'],
                'file' => 'CAMPUR/COIL 2.jpg',
                'completion_date' => '2024-11-30',
                'content' => [
                    'id' => '<h2>Spesifikasi Gudang</h2><p>Gudang logistik modern dengan luas 5.000 m² ini dirancang untuk efisiensi operasional maksimal.</p><h3>Fitur Utama</h3><ul><li>Struktur baja bentang lebar tanpa kolom tengah</li><li>Sistem ventilasi dan pencahayaan alami</li><li>Dermaga bongkar muat untuk 10 truk</li><li>Sistem manajemen gudang terintegrasi</li></ul><h3>Keunggulan</h3><p>Desain modular memungkinkan pengembangan di masa depan sesuai kebutuhan bisnis.</p>',
                    'en' => '<h2>Warehouse Specifications</h2><p>This 5,000 m² modern logistics warehouse is designed for maximum operational efficiency.</p><h3>Key Features</h3><ul><li>Wide-span steel structure without center columns</li><li>Natural ventilation and lighting system</li><li>Loading dock for 10 trucks</li><li>Integrated warehouse management system</li></ul><h3>Advantages</h3><p>The modular design allows future expansion according to business needs.</p>',
                    'zh' => '<h2>仓库规格</h2><p>这座5,000平方米的现代物流仓库旨在实现最大的运营效率。</p><h3>主要特点</h3><ul><li>无中柱的大跨度钢结构</li><li>自然通风和照明系统</li><li>可容纳10辆卡车的装卸码头</li><li>集成仓库管理系统</li></ul><h3>优势</h3><p>模块化设计允许根据业务需求进行未来扩展。</p>',
                ],
            ],
            [
                'name' => ['id' => 'Renovasi Fasad Hotel', 'en' => 'Hotel Facade Renovation', 'zh' => '酒店外立面翻新'],
                'category' => ['id' => 'Renovasi & Retrofit', 'en' => 'Renovation & Retrofit', 'zh' => '翻新与改造'],
                'client' => 'PT Waskita Karya',
                'location' => ['id' => 'Denpasar, Bali', 'en' => 'Denpasar, Bali', 'zh' => '登巴萨，巴厘岛'],
                'file' => 'CAMPUR/COIL 3.jpg',
                'completion_date' => '2025-01-10',
                'content' => [
                    'id' => '<h2>Proyek Renovasi</h2><p>Renovasi fasad hotel bintang 5 di kawasan wisata Denpasar dengan tetap mempertahankan operasional hotel.</p><h3>Tahapan Pengerjaan</h3><ol><li>Audit struktur fasad eksisting</li><li>Perancangan fasad baru bernuansa tropis modern</li><li>Pekerjaan malam hari untuk mengurangi gangguan tamu</li><li>Finishing dan quality control</li></ol><h3>Hasil Akhir</h3><p>Fasad baru berhasil meningkatkan daya tarik visual hotel dan mendapatkan respons positif dari tamu.</p>',
                    'en' => '<h2>Renovation Project</h2><p>Facade renovation of a 5-star hotel in the Denpasar tourist area while maintaining hotel operations.</p><h3>Work Stages</h3><ol><li>Existing facade structure audit</li><li>New modern tropical facade design</li><li>Night work to minimize guest disruption</li><li>Finishing and quality control</li></ol><h3>Final Result</h3><p>The new facade successfully enhanced the hotel\'s visual appeal and received positive responses from guests.</p>',
                    'zh' => '<h2>翻新项目</h2><p>登巴萨旅游区五星级酒店的外立面翻新，同时保持酒店正常运营。</p><h3>工作阶段</h3><ol><li>现有外墙结构审计</li><li>现代热带风格新外立面设计</li><li>夜间施工以最大程度减少对客人的干扰</li><li>收尾工作与质量控制</li></ol><h3>最终成果</h3><p>新外立面成功提升了酒店的视觉吸引力，并获得了客人的积极反馈。</p>',
                ],
            ],
            [
                'name' => ['id' => 'Pabrik Pengolahan Makanan', 'en' => 'Food Processing Plant', 'zh' => '食品加工厂'],
                'category' => ['id' => 'Gudang & Pabrik', 'en' => 'Warehouse & Factory', 'zh' => '仓库与工厂'],
                'client' => 'PT Hutama Karya',
                'location' => ['id' => 'Sidoarjo, Jawa Timur', 'en' => 'Sidoarjo, East Java', 'zh' => '诗都阿佐，东爪哇'],
                'file' => 'CAMPUR/COIL 4.jpg',
                'completion_date' => '2025-08-05',
                'content' => [
                    'id' => '<h2>Pabrik Berstandar Tinggi</h2><p>Pabrik pengolahan makanan ini dibangun dengan standar higienis internasional (HACCP dan GMP).</p><h3>Spesifikasi Bangunan</h3><ul><li>Dinding dan lantai berlapis epoxy anti-bakteri</li><li>Sistem HVAC dengan filter HEPA</li><li>Area produksi terpisah berdasarkan tingkat kebersihan</li><li>Sistem drainase dan pengelolaan limbah terpadu</li></ul><blockquote>"Keamanan pangan adalah prioritas yang tidak bisa ditawar."</blockquote><h3>Sertifikasi</h3><p>Pabrik telah memperoleh sertifikasi ISO 22000 dan BPOM.</p>',
                    'en' => '<h2>High-Standard Factory</h2><p>This food processing plant was built to international hygiene standards (HACCP and GMP).</p><h3>Building Specifications</h3><ul><li>Anti-bacterial epoxy-coated walls and floors</li><li>HVAC system with HEPA filters</li><li>Separate production areas by cleanliness level</li><li>Integrated drainage and waste management system</li></ul><blockquote>"Food safety is a non-negotiable priority."</blockquote><h3>Certifications</h3><p>The plant has obtained ISO 22000 and BPOM certifications.</p>',
                    'zh' => '<h2>高标准工厂</h2><p>该食品加工厂按照国际卫生标准（HACCP和GMP）建造。</p><h3>建筑规格</h3><ul><li>抗菌环氧树脂涂层墙壁和地板</li><li>带HEPA过滤器的暖通空调系统</li><li>按清洁度划分的独立生产区域</li><li>综合排水和废物管理系统</li></ul><blockquote>"食品安全是不可妥协的优先事项。"</blockquote><h3>认证</h3><p>工厂已获得ISO 22000和BPOM认证。</p>',
                ],
            ],
            [
                'name' => ['id' => 'Apartemen Mewah 20 Lantai', 'en' => '20-Story Luxury Apartment', 'zh' => '20层豪华公寓'],
                'category' => ['id' => 'Konstruksi Gedung', 'en' => 'Building Construction', 'zh' => '建筑施工'],
                'client' => 'PT Brantas Abipraya',
                'location' => ['id' => 'Surabaya, Jawa Timur', 'en' => 'Surabaya, East Java', 'zh' => '泗水，东爪哇'],
                'file' => 'CAMPUR/PLAT HITAM 2.jpg',
                'completion_date' => '2026-02-14',
                'content' => [
                    'id' => '<h2>Konsep Hunian Mewah</h2><p>Apartemen 20 lantai ini menawarkan konsep hunian vertikal dengan fasilitas premium di pusat kota Surabaya.</p><h3>Fasilitas</h3><ul><li>Kolam renang infinity di lantai atap</li><li>Gym dan spa eksklusif</li><li>Rooftop garden dengan view kota</li><li>Sistem keamanan 24 jam berbasis AI</li></ul><h3>Konstruksi</h3><p>Menggunakan struktur baja tahan gempa dengan teknologi peredam getaran terkini.</p><h3>Target Pasar</h3><p>Apartemen ini ditargetkan untuk profesional muda dan keluarga kecil.</p>',
                    'en' => '<h2>Luxury Living Concept</h2><p>This 20-story apartment offers a vertical living concept with premium facilities in downtown Surabaya.</p><h3>Facilities</h3><ul><li>Infinity pool on the rooftop</li><li>Exclusive gym and spa</li><li>Rooftop garden with city view</li><li>AI-based 24-hour security system</li></ul><h3>Construction</h3><p>Uses earthquake-resistant steel structure with the latest vibration damping technology.</p><h3>Target Market</h3><p>This apartment is targeted at young professionals and small families.</p>',
                    'zh' => '<h2>奢华生活概念</h2><p>这座20层公寓在泗水市中心提供垂直生活概念和顶级设施。</p><h3>设施</h3><ul><li>屋顶无边泳池</li><li>专属健身房和水疗中心</li><li>可欣赏城市景色的屋顶花园</li><li>基于人工智能的24小时安保系统</li></ul><h3>施工</h3><p>采用抗震钢结构，配备最新减震技术。</p><h3>目标市场</h3><p>该公寓面向年轻专业人士和小家庭。</p>',
                ],
            ],
            [
                'name' => ['id' => 'Proyek Infrastruktur Bendungan', 'en' => 'Dam Infrastructure Project', 'zh' => '水坝基础设施项目'],
                'category' => ['id' => 'Infrastruktur', 'en' => 'Infrastructure', 'zh' => '基础设施'],
                'client' => 'PT Wijaya Karya',
                'location' => ['id' => 'Ciamis, Jawa Barat', 'en' => 'Ciamis, West Java', 'zh' => '尖美士，西爪哇'],
                'file' => 'CAMPUR/PLAT.jpg',
                'completion_date' => '2025-10-01',
                'content' => [
                    'id' => '<h2>Proyek Strategis Nasional</h2><p>Bendungan ini merupakan proyek strategis nasional untuk mendukung ketahanan air dan irigasi di Jawa Barat.</p><h3>Spesifikasi Teknis</h3><ul><li>Tipe bendungan: urugan batu dengan inti tegak</li><li>Tinggi: 65 meter</li><li>Panjang puncak: 350 meter</li><li>Kapasitas tampung: 45 juta m³</li></ul><h3>Manfaat</h3><p>Bendungan ini mengairi 12.000 hektar sawah dan menyediakan air baku 1.500 liter/detik.</p><h3>Dampak Lingkungan</h3><p>Proyek dilengkapi dengan program reboisasi dan konservasi DAS.</p>',
                    'en' => '<h2>National Strategic Project</h2><p>This dam is a national strategic project to support water security and irrigation in West Java.</p><h3>Technical Specifications</h3><ul><li>Dam type: rockfill with vertical core</li><li>Height: 65 meters</li><li>Crest length: 350 meters</li><li>Storage capacity: 45 million m³</li></ul><h3>Benefits</h3><p>This dam irrigates 12,000 hectares of rice fields and provides 1,500 liters/second of raw water.</p><h3>Environmental Impact</h3><p>The project includes reforestation and watershed conservation programs.</p>',
                    'zh' => '<h2>国家战略项目</h2><p>该水坝是国家战略项目，旨在支持西爪哇的水安全和灌溉。</p><h3>技术规格</h3><ul><li>大坝类型：带垂直心墙的堆石坝</li><li>高度：65米</li><li>坝顶长度：350米</li><li>库容：4500万立方米</li></ul><h3>效益</h3><p>该水坝灌溉12,000公顷稻田并提供1,500升/秒的原水。</p><h3>环境影响</h3><p>项目包括重新造林和流域保护计划。</p>',
                ],
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
                'content' => $data['content'],
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
