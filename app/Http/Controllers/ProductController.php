<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function index(SeoMetadataBuilder $metadata): View
    {
        $site = site_config();

        $metadata->build(
            title: __('seo.products.title').' - '.$site->company_name,
            description: __('seo.products.description'),
            image: 'https://placehold.co/1400x320/2b2b2b/ffffff?text=Produk',
        );

        return view('products.index', [
            'site' => $site,
        ]);
    }

    public function show(Product $product, SeoMetadataBuilder $metadata): View
    {
        abort_unless($product->is_published, 404);

        $product->load('media');
        $product->loadMissing('categories');

        $site = site_config();

        $metadata->build(
            title: $product->name.' - '.$site->company_name,
            description: $product->description,
            image: $product->main_image_url,
        );

        return view('products.show', [
            'site' => $site,
            'product' => $product,
        ]);
    }
}
