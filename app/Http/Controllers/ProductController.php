<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function index(SeoMetadataBuilder $metadata): View
    {
        $metadata->build(
            title: __('seo.products.title').' - '.__('site.company_name'),
            description: __('seo.products.description'),
            image: 'https://placehold.co/1400x320/2b2b2b/ffffff?text=Produk',
        );

        return view('products.index', [
            'faqs' => $this->faqs(),
        ]);
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    private function faqs(): array
    {
        return [
            [
                'question' => 'Apa saja produk plat baja yang tersedia?',
                'answer' => 'Kami menyediakan berbagai jenis plat baja seperti Plat Hitam (Hot Rolled), Plat Putih (Cold Rolled), Plat Galvanil, dan Plat Kapal. Semua produk berasal dari pabrikan terpercaya dengan kualitas terjamin.',
            ],
            [
                'question' => 'Apakah PT Putra Setia Sukses Bersama melayani pembelian eceran?',
                'answer' => 'Kami melayani pembelian dalam berbagai skala, baik eceran maupun partai besar. Silakan hubungi tim sales kami untuk informasi lebih lanjut mengenai minimal pembelian dan harga terbaru.',
            ],
            [
                'question' => 'Bagaimana proses pengiriman barang?',
                'answer' => 'Pengiriman dilakukan menggunakan armada sendiri maupun mitra logistik terpercaya. Kami memastikan barang sampai tepat waktu dan dalam kondisi baik sesuai jadwal yang telah disepakati.',
            ],
            [
                'question' => 'Berapa lama waktu pengiriman?',
                'answer' => 'Waktu pengiriman tergantung pada lokasi tujuan dan ketersediaan stok. Untuk wilayah Jabodetabek, pengiriman biasanya memakan waktu 1-2 hari kerja. Untuk luar pulau, kami akan menginformasikan estimasi pengiriman saat konfirmasi pesanan.',
            ],
            [
                'question' => 'Apakah ada garansi untuk produk yang dibeli?',
                'answer' => 'Semua produk yang kami jual adalah produk asli dari pabrikan resmi dengan sertifikat kualitas. Jika terdapat ketidaksesuaian spesifikasi atau kerusakan akibat proses produksi, kami akan memproses penggantian sesuai ketentuan yang berlaku.',
            ],
        ];
    }

    public function show(Product $product, SeoMetadataBuilder $metadata): View
    {
        abort_unless($product->is_published, 404);

        $product->load('media');
        $product->loadMissing('categories');

        $metadata->build(
            title: $product->name.' - '.__('site.company_name'),
            description: $product->description,
            image: $product->main_image_url,
        );

        return view('products.show', [
            'product' => $product,
        ]);
    }
}
