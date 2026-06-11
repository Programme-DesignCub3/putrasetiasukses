<?php

use App\Models\AboutPage;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('home page renders with shared site content', function () {
    SiteSetting::factory()->create();

    $this->withHeaders(['Accept-Language' => 'id'])->get('/')
        ->assertSuccessful()
        ->assertSee('PT Putra Setia Sukses Bersama')
        ->assertSee('Plat Lembaran');
});

test('about page renders managed content', function () {
    SiteSetting::factory()->create();
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
    SiteSetting::factory()->create();
    Product::factory()->create();

    $this->withHeaders(['Accept-Language' => 'id'])->get('/produk/plat-hitam')
        ->assertSuccessful()
        ->assertSee('Plat Hitam')
        ->assertSee('Deskripsi Barang')
        ->assertSee('Pesan & Hubungi');
});

test('article pages render managed content', function () {
    SiteSetting::factory()->create();
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

test('contact form stores messages', function () {
    SiteSetting::factory()->create();

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
    SiteSetting::factory()->create();
    Article::factory()->create();

    $this->get('/en/artikel')
        ->assertSuccessful()
        ->assertSee('Latest Articles');

    $this->get('/zh/artikel')
        ->assertSuccessful()
        ->assertSee('最新文章');
});

test('geoip detector redirects china visitors to chinese', function () {
    SiteSetting::factory()->create();

    $this->withHeaders(['CF-IPCountry' => 'CN'])
        ->get('/kontak')
        ->assertRedirect('/zh/kontak');
});

test('geoip detector redirects us visitors to english', function () {
    SiteSetting::factory()->create();

    $this->withHeaders(['CF-IPCountry' => 'US'])
        ->get('/kontak')
        ->assertRedirect('/en/kontak');
});

test('geoip detector keeps indonesia visitors on default locale', function () {
    SiteSetting::factory()->create();

    $this->withHeaders(['CF-IPCountry' => 'ID'])
        ->get('/kontak')
        ->assertSuccessful()
        ->assertSee('Kirimkan Pesan Anda');
});

test('geoip detector falls back to indonesia when country is missing or unsupported', function () {
    SiteSetting::factory()->create();

    $this->withHeaders(['Accept-Language' => 'en'])->get('/kontak')
        ->assertSuccessful()
        ->assertSee('Kirimkan Pesan Anda');

    $this->withHeaders(['CF-IPCountry' => 'DE'])->get('/kontak')
        ->assertSuccessful()
        ->assertSee('Kirimkan Pesan Anda');
});
