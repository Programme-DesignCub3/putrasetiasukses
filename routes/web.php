<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SitemapController;
use App\Models\AboutPage;
use App\Support\SiteConfig;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::get('/robots.txt', function () {
    return response("User-agent: *\nAllow: /\nSitemap: ".route('sitemap')."\n", 200, [
        'Content-Type' => 'text/plain',
    ]);
})->name('robots');

Route::localize(function (): void {
    Route::get('/', function () {
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
    })->name('home');

    Route::get('/tentang-kami', function () {
        return view('about', [
            'site' => SiteConfig::current(),
            'aboutPage' => AboutPage::published(),
        ]);
    })->name('about');

    Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
    Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/kontak', [ContactController::class, 'create'])->name('contact');
    Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');
});
