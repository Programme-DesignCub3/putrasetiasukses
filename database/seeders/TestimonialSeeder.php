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
                'name' => 'Jonathan Doe',
                'content' => 'PT Putra Setia Sukses Bersama merupakan mitra yang profesional dan dapat diandalkan, dengan kualitas produk yang konsisten serta pengiriman yang tepat waktu.',
            ],
            [
                'name' => 'Andi Pratama',
                'content' => 'Pelayanan responsif dan stok material sangat membantu kebutuhan proyek kami saat jadwal sedang padat.',
            ],
            [
                'name' => 'Rina Wijaya',
                'content' => 'Kualitas plat sesuai spesifikasi dan proses pengiriman berjalan rapi dari pemesanan sampai barang diterima.',
            ],
        ];

        foreach ($items as $item) {
            Testimonial::query()->create($item);
        }
    }
}
