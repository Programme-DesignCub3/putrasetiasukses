<?php

use App\Models\AboutPage;
use App\Models\Article;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Support\SiteConfig;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('home page renders with shared site content', function () {
    $this->withHeaders(['Accept-Language' => 'id'])->get('/')
        ->assertSuccessful()
        ->assertSee('PT Putra Setia Sukses Bersama')
        ->assertSee('Plat Lembaran')
        ->assertSee('home-testimonials-swiper')
        ->assertSee('home-partners-swiper');
});

test('about page renders managed content', function () {
    AboutPage::factory()->create();

    $this->withHeaders(['Accept-Language' => 'id'])->get('/tentang-kami')
        ->assertSuccessful()
        ->assertSee('Tentang Kami')
        ->assertSee('Visi')
        ->assertSee('Misi')
        ->assertSee('Galeri')
        ->assertSee('Video');
});

test('product page renders managed content', function () {
    Product::factory()->create();

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/produk')
        ->assertSuccessful()
        ->assertSee('Produk')
        ->assertSee('Plat Hitam')
        ->assertSee('Lihat Detail');

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/produk/plat-hitam')
        ->assertSuccessful()
        ->assertSee('Plat Hitam')
        ->assertSee('Deskripsi Barang')
        ->assertSee('Pesan & Hubungi')
        ->assertSee('product-gallery-main')
        ->assertSee('product-gallery-thumbs');
});

test('article pages render managed content', function () {
    Article::factory()->create();

    $this->withHeaders(['Accept-Language' => 'id'])->get('/artikel')
        ->assertSuccessful()
        ->assertSee('Artikel Terbaru')
        ->assertSee('Perkembangan Industri Baja');

    $this->withHeaders(['Accept-Language' => 'id'])->get('/artikel/perkembangan-industri-baja-indonesia')
        ->assertSuccessful()
        ->assertSee('Heri Pradana')
        ->assertSee('Peluang Masa Depan');
});

test('public pages render seo metadata', function () {
    $site = SiteConfig::current();
    $article = Article::factory()->create();

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/')
        ->assertSuccessful()
        ->assertSee('<title>'.$site->company_name.'</title>', false)
        ->assertSee('<link rel="canonical" href="'.route('home').'"', false)
        ->assertSee('rel="alternate" hreflang="en"', false)
        ->assertSee('rel="alternate" hreflang="zh-CN"', false)
        ->assertSee('rel="alternate" hreflang="x-default"', false)
        ->assertSee('name="description"', false)
        ->assertSee($site->tagline)
        ->assertSee('property="og:type" content="website"', false);

    $this->withHeaders(['Accept-Language' => 'id'])->get('/artikel/'.$article->slug)
        ->assertSuccessful()
        ->assertSee('<title>'.$article->title.' - '.$site->company_name.'</title>', false)
        ->assertSee('property="og:type" content="article"', false)
        ->assertSee('property="article:published_time"', false)
        ->assertSee('"datePublished"', false)
        ->assertSee('"author"', false)
        ->assertSee('property="og:image" content="'.$article->image_url.'"', false);
});

test('cookie consent banner prepares google analytics without loading it immediately', function () {
    config(['services.google_analytics.measurement_id' => 'G-TEST123']);

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/')
        ->assertSuccessful()
        ->assertSee('data-cookie-consent', false)
        ->assertSee('Privasi dan Cookie')
        ->assertSee('G-TEST123')
        ->assertDontSee('googletagmanager.com/gtag/js', false);
});

test('cookie consent banner can be disabled while analytics remains configured', function () {
    config([
        'services.cookie_consent.enabled' => false,
        'services.google_analytics.measurement_id' => 'G-TEST123',
    ]);

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/')
        ->assertSuccessful()
        ->assertDontSee('data-cookie-consent', false)
        ->assertSee('cookieConsentEnabled', false)
        ->assertSee('G-TEST123');
});

test('media library images override legacy placeholder urls', function () {
    Storage::fake('public');

    $article = Article::factory()->create([
        'image_url' => 'https://placehold.co/640x420/000000/ffffff?text=Legacy',
    ]);

    $article
        ->addMedia(UploadedFile::fake()->image('article-cover.jpg'))
        ->toMediaCollection(Article::ImageCollection);

    $product = Product::factory()->create([
        'main_image_url' => 'https://placehold.co/640x420/000000/ffffff?text=Legacy',
    ]);

    $product
        ->addMedia(UploadedFile::fake()->image('product-main.jpg'))
        ->toMediaCollection(Product::MainImageCollection);

    expect($article->fresh()->image_url)->toContain('article-cover.jpg')
        ->and($product->fresh()->main_image_url)->toContain('product-main.jpg');

    $this->withHeaders(['Accept-Language' => 'id'])->get('/artikel/'.$article->slug)
        ->assertSuccessful()
        ->assertSee('article-cover.jpg');

    $this->withHeaders(['Accept-Language' => 'id'])->get('/produk/'.$product->slug)
        ->assertSuccessful()
        ->assertSee('product-main.jpg');
});

test('categories have their own translatable details and media', function () {
    Storage::fake('public');

    $category = Category::factory()->create([
        'type' => Category::TypeProduct,
        'description' => [
            'id' => 'Kategori plat baja untuk kebutuhan proyek.',
            'en' => 'Steel plate category for project needs.',
            'zh' => '项目用钢板类别。',
        ],
        'image_url' => 'https://placehold.co/640x420/000000/ffffff?text=Legacy',
    ]);

    $category
        ->addMedia(UploadedFile::fake()->image('category-cover.jpg'))
        ->toMediaCollection(Category::ImageCollection);

    $category
        ->addMedia(UploadedFile::fake()->image('category-gallery.jpg'))
        ->toMediaCollection(Category::GalleryCollection);

    expect($category->fresh()->description)->toBe('Kategori plat baja untuk kebutuhan proyek.')
        ->and($category->fresh()->image_url)->toContain('category-cover.jpg')
        ->and($category->fresh()->gallery_images)
        ->toHaveCount(1)
        ->and($category->fresh()->gallery_images[0]['url'])
        ->toContain('category-gallery.jpg');
});

test('sitemap exposes localized public urls', function () {
    Product::factory()->create();
    Article::factory()->create();

    $this->get('/sitemap.xml')
        ->assertSuccessful()
        ->assertHeader('content-type', 'application/xml')
        ->assertSee(route('home'), false)
        ->assertSee(route('products.index'), false)
        ->assertSee(route('products.show', ['product' => 'plat-hitam']), false)
        ->assertSee('/en/produk/plat-hitam', false)
        ->assertSee('/zh/artikel/perkembangan-industri-baja-indonesia', false)
        ->assertSee('hreflang="x-default"', false);
});

test('sitemap can be generated as a static public file', function () {
    Product::factory()->create();
    Article::factory()->create();

    $path = public_path('sitemap-test.xml');
    File::delete($path);

    $this->artisan('sitemap:generate', ['--path' => 'sitemap-test.xml'])
        ->assertSuccessful();

    expect(File::exists($path))->toBeTrue();

    $contents = File::get($path);

    expect($contents)
        ->toContain(route('home'))
        ->toContain('/en/produk/plat-hitam')
        ->toContain('/zh/artikel/perkembangan-industri-baja-indonesia')
        ->toContain('hreflang="x-default"');

    File::delete($path);
});

test('robots file points crawlers to the sitemap', function () {
    $this->get('/robots.txt')
        ->assertSuccessful()
        ->assertHeader('content-type', 'text/plain; charset=UTF-8')
        ->assertSee('User-agent: *')
        ->assertSee(route('sitemap'));
});

test('contact form stores messages', function () {
    $this->post('/kontak', [
        'name' => 'Budi',
        'company' => 'PT Contoh',
        'phone' => '08123456789',
        'email' => 'budi@example.com',
        'subject' => 'Permintaan Plat',
        'message' => 'Mohon info harga plat hitam.',
    ])->assertRedirect();

    expect(ContactMessage::query()->where('phone', '08123456789')->exists())->toBeTrue();
});

test('localized public routes render in english and chinese', function () {
    Article::factory()->create();

    $this->get('/en/artikel')
        ->assertSuccessful()
        ->assertSee('Latest Articles');

    $this->get('/zh/artikel')
        ->assertSuccessful()
        ->assertSee('最新文章');
});

test('geoip detector redirects china visitors to chinese', function () {
    $this->withHeaders(['CF-IPCountry' => 'CN'])
        ->get('/kontak')
        ->assertRedirect('/zh/kontak');
});

test('geoip detector redirects us visitors to english', function () {
    $this->withHeaders(['CF-IPCountry' => 'US'])
        ->get('/kontak')
        ->assertRedirect('/en/kontak');
});

test('geoip detector keeps indonesia visitors on default locale', function () {
    $this->withHeaders(['CF-IPCountry' => 'ID'])
        ->get('/kontak')
        ->assertSuccessful()
        ->assertSee('Kirimkan Pesan Anda');
});

test('geoip detector falls back to indonesia when country is missing or unsupported', function () {
    $this->withHeaders(['Accept-Language' => 'en'])->get('/kontak')
        ->assertSuccessful()
        ->assertSee('Kirimkan Pesan Anda');

    $this->withHeaders(['CF-IPCountry' => 'DE'])->get('/kontak')
        ->assertSuccessful()
        ->assertSee('Kirimkan Pesan Anda');
});
