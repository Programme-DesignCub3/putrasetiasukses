<?php

use App\Enums\CategoryType;
use App\Models\Article;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\Project;
use App\Support\Sitemap\SitemapBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Inerba\DbConfig\DbConfig;

uses(RefreshDatabase::class);

test('home page renders with shared site content', function () {
    $this->withHeaders(['Accept-Language' => 'id'])->get('/')
        ->assertSuccessful()
        ->assertSee('PT Putra Setia Sukses Bersama')
        ->assertSee('Plat Lembaran')
        ->assertSee('home-testimonials-swiper')
        ->assertSee('home-partners-swiper');
});

test('about page renders hardcoded copy with settings media', function () {
    DbConfig::set('website.about', [
        'hero_image' => 'about/hero.jpg',
        'intro_image' => 'about/intro.jpg',
        'gallery_images' => [
            'about/gallery/warehouse.jpg',
        ],
        'video_url' => 'https://www.youtube.com/embed/test-video',
    ]);

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/tentang-kami')
        ->assertSuccessful()
        ->assertSee('Tentang Kami')
        ->assertSee('Visi')
        ->assertSee('Misi')
        ->assertSee('Galeri')
        ->assertSee('Video')
        ->assertSee('/storage/about/hero.jpg', false)
        ->assertSee('/storage/about/intro.jpg', false)
        ->assertSee('/storage/about/gallery/warehouse.jpg', false)
        ->assertSee('https://www.youtube.com/embed/test-video', false);
});

test('product page renders managed content', function () {
    $product = Product::factory()->create();

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/produk')
        ->assertSuccessful()
        ->assertSee('Produk')
        ->assertSee($product->getTranslation('name', 'id'))
        ->assertSee('Lihat Detail');

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/produk/'.$product->slug)
        ->assertSuccessful()
        ->assertSee($product->getTranslation('name', 'id'))
        ->assertSee('Deskripsi Barang')
        ->assertSee('Pesan & Hubungi')
        ->assertSee('gallery-main')
        ->assertSee('gallery-thumbs');
});

test('article pages render managed content', function () {
    $article = Article::factory()->create();
    $richArticle = Article::factory()->create([
        'title' => [
            'id' => 'Artikel Rich Text',
            'en' => '',
            'zh' => '',
        ],
        'slug' => 'artikel-rich-text',
        'body' => [
            'id' => '<h2>Subjudul Rich Text</h2><p><strong>Isi artikel tebal</strong></p>',
            'en' => '',
            'zh' => '',
        ],
    ]);

    $this->followingRedirects()->withHeaders(['Accept-Language' => 'id'])->get('/id/artikel')
        ->assertSuccessful()
        ->assertSee('Artikel Terbaru')
        ->assertSee($article->getTranslation('title', 'id'));

    $this->followingRedirects()->withHeaders(['Accept-Language' => 'id'])->get('/id/artikel/'.$article->slug)
        ->assertSuccessful()
        ->assertSee($article->author)
        ->assertSee($article->getTranslation('title', 'id'));

    $this->followingRedirects()->withHeaders(['Accept-Language' => 'id'])->get('/id/artikel/'.$richArticle->slug)
        ->assertSuccessful()
        ->assertSee('<h2>Subjudul Rich Text</h2>', false)
        ->assertSee('<strong>Isi artikel tebal</strong>', false);
});

test('public pages render seo metadata', function () {
    $site = site_config();
    $article = Article::factory()->create();

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/')
        ->assertSuccessful()
        ->assertSee('<title>'.__('seo.home.title').'</title>', false)
        ->assertSee('<link rel="canonical" href="'.route('home').'"', false)
        ->assertSee('property="og:locale" content="id"', false)
        ->assertSee('property="og:locale:alternate" content="en"', false)
        ->assertSee('property="og:locale:alternate" content="zh_CN"', false)
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
        ->assertSee('property="og:image" content="'.e($article->image_url).'"', false);
});

test('search page renders and accepts search query', function () {
    $product = Product::factory()->create();

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/cari')
        ->assertSuccessful()
        ->assertSee(__('search.title'));

    $this->withHeaders(['Accept-Language' => 'en'])->get('/en/cari')
        ->assertSuccessful()
        ->assertSee('Search');
});

test('cookie consent banner prepares google analytics without loading it immediately', function () {
    config(['services.google_analytics.measurement_id' => 'G-TEST123']);

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/')
        ->assertSuccessful()
        ->assertSee('x-data="cookieConsent"', false)
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
        'type' => CategoryType::Product,
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
    $product = Product::factory()->create();
    $article = Article::factory()->create();
    $project = Project::factory()->create();

    SitemapBuilder::default()->build();

    $products = File::get(public_path('sitemap_products.xml'));
    $articles = File::get(public_path('sitemap_articles.xml'));
    $projects = File::get(public_path('sitemap_projects.xml'));
    $static = File::get(public_path('sitemap_static.xml'));

    expect($static)->toContain(route('home'));
    expect($static)->toContain(route('about'));
    expect($static)->toContain(route('contact'));
    expect($products)->toContain(route('products.index'));
    expect($products)->toContain('/en/produk/'.$product->slug);
    expect($articles)->toContain('/zh/artikel/'.$article->slug);
    expect($projects)->toContain('/en/proyek/'.$project->slug);
    expect($static)->toContain('hreflang="x-default"');
});

test('sitemap can be generated as a static public file', function () {
    $product = Product::factory()->create();
    $article = Article::factory()->create();
    $project = Project::factory()->create();

    $dir = public_path('sitemap-test');
    File::deleteDirectory($dir);

    $this->artisan('sitemap:generate', ['--dir' => 'sitemap-test'])
        ->assertSuccessful();

    expect(File::exists($dir.'/sitemap.xml'))->toBeTrue();
    expect(File::exists($dir.'/sitemap_products.xml'))->toBeTrue();
    expect(File::exists($dir.'/sitemap_articles.xml'))->toBeTrue();
    expect(File::exists($dir.'/sitemap_projects.xml'))->toBeTrue();
    expect(File::exists($dir.'/sitemap_static.xml'))->toBeTrue();

    $products = File::get($dir.'/sitemap_products.xml');
    expect($products)->toContain('/en/produk/'.$product->slug);

    $articles = File::get($dir.'/sitemap_articles.xml');
    expect($articles)->toContain('/zh/artikel/'.$article->slug);

    $projects = File::get($dir.'/sitemap_projects.xml');
    expect($projects)->toContain('/en/proyek/'.$project->slug);

    File::deleteDirectory($dir);
});

test('sitemap builder generates valid xml with all static pages', function () {
    SitemapBuilder::default()->build();

    $static = File::get(public_path('sitemap_static.xml'));
    $index = File::get(public_path('sitemap.xml'));

    expect($index)->toContain('<sitemapindex');
    expect($index)->toContain('sitemap_static.xml');
    expect($static)->toContain('<urlset');
    expect($static)->toContain(route('home'));
    expect($static)->toContain(route('about'));
    expect($static)->toContain(route('contact'));
    expect($static)->toContain('hreflang="x-default"');
});

test('contact form stores messages', function () {
    config()->set('services.recaptcha.secret_key', 'test-secret');

    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response([
            'success' => true,
            'score' => 0.9,
        ]),
    ]);

    $this->post('/kontak', [
        'name' => 'Budi',
        'company' => 'PT Contoh',
        'phone' => '08123456789',
        'email' => 'budi@example.com',
        'subject' => 'Permintaan Plat',
        'message' => 'Mohon info harga plat hitam.',
        'recaptcha_token' => 'fake-token',
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
