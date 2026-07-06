<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        Testimonial::query()->forceDelete();

        $items = [
            [
                'name' => ['id' => 'Jonathan Doe', 'en' => 'Jonathan Doe', 'zh' => '乔纳森·多伊'],
                'content' => [
                    'id' => 'PT Putra Setia Sukses Bersama merupakan mitra yang profesional dan dapat diandalkan, dengan kualitas produk yang konsisten serta pengiriman yang tepat waktu.',
                    'en' => 'PT Putra Setia Sukses Bersama is a professional and reliable partner with consistent product quality and on-time delivery.',
                    'zh' => 'PT Putra Setia Sukses Bersama 是一家专业可靠的合作伙伴，产品质量稳定，交货准时。',
                ],
            ],
            [
                'name' => ['id' => 'Andi Pratama', 'en' => 'Andi Pratama', 'zh' => '安迪·普拉塔马'],
                'content' => [
                    'id' => 'Pelayanan responsif dan stok material sangat membantu kebutuhan proyek kami saat jadwal sedang padat.',
                    'en' => 'Responsive service and material stock greatly helped our project needs during tight schedules.',
                    'zh' => '响应式服务和材料库存在我们工期紧张时极大地帮助了我们的项目需求。',
                ],
            ],
            [
                'name' => ['id' => 'Rina Wijaya', 'en' => 'Rina Wijaya', 'zh' => '里娜·维贾亚'],
                'content' => [
                    'id' => 'Kualitas plat sesuai spesifikasi dan proses pengiriman berjalan rapi dari pemesanan sampai barang diterima.',
                    'en' => 'Plate quality meets specifications and the delivery process runs smoothly from order to receipt.',
                    'zh' => '板材质量符合规格，从下单到收货的交付过程井然有序。',
                ],
            ],
        ];

        foreach ($items as $item) {
            Testimonial::query()->create($item);
        }
    }
}
