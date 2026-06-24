<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

// Route::get('/robots.txt', function () {
//     return response("User-agent: *\nAllow: /\nSitemap: ".route('sitemap')."\n", 200, [
//         'Content-Type' => 'text/plain',
//     ]);
// })->name('robots');

Route::localize(function (): void {
    Route::get('/', HomeController::class)->name('home');
    Route::get('/tentang-kami', AboutController::class)->name('about');
    Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
    Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/kontak', [ContactController::class, 'create'])->name('contact');
    Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/proyek', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/proyek/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/cari', SearchController::class)->name('search');
});
