<?php

namespace App\Http\Controllers;

use App\Support\SiteConfig;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('welcome', [
            'site' => SiteConfig::current(),
            'advantages' => [
                ['title' => 'Stockist & Distributor Terpercaya', 'copy' => 'Kami memastikan ketersediaan stok plat selalu terjaga untuk memenuhi kebutuhan pelanggan.', 'icon' => 'warehouse'],
                ['title' => 'Harga Kompetitif', 'copy' => 'Kami menawarkan harga bersaing dengan kualitas plat terbaik.', 'icon' => 'tag'],
                ['title' => 'Pengiriman Tepat Waktu', 'copy' => 'Setiap pesanan dikirim sesuai jadwal yang telah disepakati.', 'icon' => 'clock'],
                ['title' => 'Kualitas Terbaik', 'copy' => 'Kami berkomitmen memberikan plat berkualitas tinggi dan pelayanan terbaik.', 'icon' => 'thumb'],
            ],
            'sectors' => [
                ['title' => 'Building Construction', 'copy' => 'Baja menjadi salah satu bahan utama dalam konstruksi dan pembangunan gedung, selain untuk pondasi juga digunakan pada atap.', 'class' => 'sector-construction'],
                ['title' => 'Automotive Industry', 'copy' => 'Material plat baja untuk kebutuhan fabrikasi, komponen, dan lini produksi industri otomotif.', 'class' => 'sector-automotive'],
                ['title' => 'Warehouse Supply', 'copy' => 'Dukungan stok material untuk distributor, kontraktor, dan kebutuhan gudang berskala besar.', 'class' => 'sector-warehouse'],
            ],
        ]);
    }
}
