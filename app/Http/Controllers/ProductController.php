<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\SiteConfig;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->with(['categories', 'media'])
            ->where('is_published', true)
            ->ordered()
            ->get();

        return view('products.index', [
            'site' => SiteConfig::current(),
            'products' => $products,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_published, 404);

        $product->load('media');
        $product->loadMissing('categories');

        return view('products.show', [
            'site' => SiteConfig::current(),
            'product' => $product,
        ]);
    }
}
