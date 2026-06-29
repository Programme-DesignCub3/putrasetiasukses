<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use App\Models\Partner;
use App\Models\Testimonial;
use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class HomeController extends Controller
{
    public function __invoke(SeoMetadataBuilder $metadata): View
    {
        $metadata->build(
            title: __('seo.home.title'),
            description: __('seo.home.description'),
        );

        return view('home', [
            'heroSlides' => $this->heroSlides(),
            'advantages' => $this->advantages(),
            'sectors' => $this->sectors(),
            'testimonials' => Testimonial::query()
                ->where('is_active', true)
                ->ordered()
                ->get(),
            'partners' => Partner::query()
                ->where('is_active', true)
                ->ordered()
                ->get(),
        ]);
    }

    /**
     * @return Collection<int, HeroSlide>
     */
    private function heroSlides()
    {
        return HeroSlide::query()
            ->where('is_active', true)
            ->ordered()
            ->get();
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
}
