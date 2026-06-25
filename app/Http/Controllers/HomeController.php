<?php

namespace App\Http\Controllers;

use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(SeoMetadataBuilder $metadata): View
    {
        $site = site_config();

        $metadata->build(
            title: __('seo.home.title'),
            description: __('seo.home.description'),
        );

        return view('home', [
            'site' => $site,
            'advantages' => $this->advantages(),
            'sectors' => $this->sectors(),
            'testimonials' => $this->testimonials(),
            'partners' => $this->partners(),
        ]);
    }

    /**
     * @return array<int, array{title: string, copy: string, icon: string}>
     */
    private function advantages(): array
    {
        return [
            ['title' => 'Stockist & Distributor Terpercaya', 'copy' => 'Kami memastikan ketersediaan stok plat selalu terjaga untuk memenuhi kebutuhan pelanggan.', 'icon' => 'warehouse'],
            ['title' => 'Harga Kompetitif', 'copy' => 'Kami menawarkan harga bersaing dengan kualitas plat terbaik.', 'icon' => 'tag'],
            ['title' => 'Pengiriman Tepat Waktu', 'copy' => 'Setiap pesanan dikirim sesuai jadwal yang telah disepakati.', 'icon' => 'clock'],
            ['title' => 'Kualitas Terbaik', 'copy' => 'Kami berkomitmen memberikan plat berkualitas tinggi dan pelayanan terbaik.', 'icon' => 'thumb'],
        ];
    }

    /**
     * @return array<int, array{title: string, copy: string, class: string}>
     */
    private function sectors(): array
    {
        return [
            ['title' => 'Building Construction', 'copy' => 'Baja menjadi salah satu bahan utama dalam konstruksi dan pembangunan gedung, selain untuk pondasi juga digunakan pada atap.', 'class' => 'sector-construction'],
            ['title' => 'Automotive Industry', 'copy' => 'Material plat baja untuk kebutuhan fabrikasi, komponen, dan lini produksi industri otomotif.', 'class' => 'sector-automotive'],
            ['title' => 'Warehouse Supply', 'copy' => 'Dukungan stok material untuk distributor, kontraktor, dan kebutuhan gudang berskala besar.', 'class' => 'sector-warehouse'],
        ];
    }

    /**
     * @return array<int, array{quote: string, name: string, role: string}>
     */
    private function testimonials(): array
    {
        return [
            [
                'quote' => 'PT Putra Setia Sukses Bersama merupakan mitra yang profesional dan dapat diandalkan, dengan kualitas produk yang konsisten serta pengiriman yang tepat waktu.',
                'name' => 'Jonathan Doe',
                'role' => 'Pemilik Rumah',
            ],
            [
                'quote' => 'Pelayanan responsif dan stok material sangat membantu kebutuhan proyek kami saat jadwal sedang padat.',
                'name' => 'Andi Pratama',
                'role' => 'Kontraktor',
            ],
            [
                'quote' => 'Kualitas plat sesuai spesifikasi dan proses pengiriman berjalan rapi dari pemesanan sampai barang diterima.',
                'name' => 'Rina Wijaya',
                'role' => 'Purchasing',
            ],
        ];
    }

    /**
     * @return array<int, array{initial: string, name: string, color: string}>
     */
    private function partners(): array
    {
        return [
            [
                'initial' => 'K',
                'name' => 'Krakatau Steel',
                'color' => '#0284c7',
            ],
            [
                'initial' => 'S',
                'name' => 'PT. Sahabat Baja Sejahtera',
                'color' => '#0891b2',
            ],
            [
                'initial' => 'P',
                'name' => 'Partner Industri Baja',
                'color' => '#b90000',
            ],
        ];
    }
}
