<?php

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('product list shows the description of the selected category', function () {
    $category = ProductCategory::factory()->create([
        'name' => ['id' => 'Baja Kapal', 'en' => 'Marine Steel', 'zh' => '船板'],
        'description' => [
            'id' => 'Kategori plat baja untuk kebutuhan proyek.',
            'en' => 'Steel plate category for project needs.',
            'zh' => '船舶用钢板类别。',
        ],
    ]);

    $product = Product::factory()->create();
    $product->categories()->syncWithoutDetaching([$category->id]);

    $this->withHeaders(['CF-IPCountry' => 'ID'])
        ->get('/products?category='.$category->slug)
        ->assertSuccessful()
        ->assertSee('Kategori plat baja untuk kebutuhan proyek.')
        ->assertDontSee('Steel plate category for project needs.');
});

test('product list hides category description when no category is selected', function () {
    $category = ProductCategory::factory()->create([
        'name' => ['id' => 'Baja Kapal', 'en' => 'Marine Steel', 'zh' => '船板'],
        'description' => [
            'id' => 'Kategori plat baja untuk kebutuhan proyek.',
            'en' => 'Steel plate category for project needs.',
            'zh' => '船舶用钢板类别。',
        ],
    ]);

    $this->withHeaders(['CF-IPCountry' => 'ID'])
        ->get('/products')
        ->assertSuccessful()
        ->assertDontSee('Kategori plat baja untuk kebutuhan proyek.')
        ->assertDontSee('Steel plate category for project needs.');
});

test('product list shows the selected category description in the active locale', function () {
    $category = ProductCategory::factory()->create([
        'name' => ['id' => 'Baja Kapal', 'en' => 'Marine Steel', 'zh' => '船板'],
        'description' => [
            'id' => 'Kategori plat baja untuk kebutuhan proyek.',
            'en' => 'Steel plate category for project needs.',
            'zh' => '船舶用钢板类别。',
        ],
    ]);

    $this->withHeaders(['Accept-Language' => 'en'])
        ->get('/en/products?category='.$category->slug)
        ->assertSuccessful()
        ->assertSee('Steel plate category for project needs.');
});

test('product list ignores an unknown category slug', function () {
    $this->withHeaders(['CF-IPCountry' => 'ID'])
        ->get('/products?category=tidak-ada')
        ->assertSuccessful()
        ->assertDontSee('Kategori plat baja untuk kebutuhan proyek.');
});
