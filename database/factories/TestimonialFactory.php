<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => fake()->randomElement([
                'Pemilik Rumah',
                'Kontraktor',
                'Purchasing',
                'Project Manager',
                'Direktur',
            ]),
            'content' => fake()->randomElement([
                'PT Putra Setia Sukses Bersama merupakan mitra yang profesional dan dapat diandalkan, dengan kualitas produk yang konsisten serta pengiriman yang tepat waktu.',
                'Pelayanan responsif dan stok material sangat membantu kebutuhan proyek kami saat jadwal sedang padat.',
                'Kualitas plat sesuai spesifikasi dan proses pengiriman berjalan rapi dari pemesanan sampai barang diterima.',
                'Harga kompetitif dengan kualitas terbaik. Sangat direkomendasikan untuk kebutuhan material konstruksi.',
                'Pengiriman tepat waktu dan barang sesuai pesanan. Tim sales sangat membantu dan responsif.',
            ]),
            'is_active' => true,
        ];
    }
}
