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

        return view('products.index');
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
