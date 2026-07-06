<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function index(SeoMetadataBuilder $metadata): View
    {
        $metadata->build(
            title: __('seo.products.title').' - '.__('site.company_name'),
            description: __('seo.products.description'),
            image: 'https://placehold.co/1400x320/2b2b2b/ffffff?text=Produk',
        );

        return view('products.index', [
            'faqs' => $this->faqs(),
        ]);
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    private function faqs(): array
    {
        $keys = range(1, 5);

        return array_map(fn (int $i): array => [
            'question' => __("products.faq_q{$i}"),
            'answer' => __("products.faq_a{$i}"),
        ], $keys);
    }

    public function show(Product $product, SeoMetadataBuilder $metadata): View
    {
        abort_unless($product->is_published, 404);

        $product->load('media');
        $product->loadMissing('categories');

        $metadata->build(
            title: $product->name.' - '.__('site.company_name'),
            description: $product->description,
            image: $product->main_image_url,
        );

        return view('products.show', [
            'product' => $product,
        ]);
    }
}
