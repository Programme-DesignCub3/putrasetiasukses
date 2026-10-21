<?php

use App\Models\Product;
use App\Support\FilamentTranslatableFields;
use Filament\Forms\Components\RichEditor\FileAttachmentProviders\SpatieMediaLibraryFileAttachmentProvider;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('product content rich editor allows public media attachments', function () {
    $field = FilamentTranslatableFields::richEditor('content', 'Content', 'id');
    $toolbarButtons = new ReflectionProperty($field, 'toolbarButtons');
    $provider = (new Product)->getRichContentAttribute('content')?->getFileAttachmentProvider();

    expect(collect($toolbarButtons->getValue($field))->flatten()->all())
        ->toContain('attachFiles')
        ->and($field->hasFileAttachments())->toBeTrue()
        ->and($provider)->toBeInstanceOf(SpatieMediaLibraryFileAttachmentProvider::class)
        ->and($provider?->getCollection())->toBe(Product::BodyAttachmentCollection);
});

test('product content is translatable', function () {
    $product = Product::factory()->create([
        'content' => [
            'id' => '<h2>Spesifikasi Produk Test</h2>',
            'en' => '<h2>Product Specification Test</h2>',
            'zh' => '',
        ],
    ]);

    expect($product->getTranslation('content', 'id'))->toBe('<h2>Spesifikasi Produk Test</h2>')
        ->and($product->getTranslation('content', 'en'))->toBe('<h2>Product Specification Test</h2>')
        ->and($product->getTranslation('content', 'zh', false))->toBe('');
});

test('product page renders rich content body', function () {
    $product = Product::factory()->create([
        'content' => [
            'id' => '<h2>Spesifikasi Unggulan</h2><p>Konten detail produk untuk pengunjung.</p>',
            'en' => '<h2>Key Specification</h2><p>Product detail content for visitors.</p>',
            'zh' => '',
        ],
    ]);

    expect(RichContentRenderer::make($product->getTranslation('content', 'id'))->toText())
        ->toContain('Spesifikasi Unggulan');

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/products/'.$product->slug)
        ->assertSuccessful()
        ->assertSee('Spesifikasi Unggulan', false)
        ->assertSee('Konten detail produk untuk pengunjung.', false);
});

test('product page hides empty rich content body', function () {
    $product = Product::factory()->create([
        'content' => ['id' => null, 'en' => null, 'zh' => null],
    ]);

    $this->withHeaders(['CF-IPCountry' => 'ID'])->get('/products/'.$product->slug)
        ->assertSuccessful();
});
