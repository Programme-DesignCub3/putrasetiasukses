<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        abort_unless($product->is_published, 404);

        $product->load('media');

        return view('products.show', [
            'site' => SiteSetting::current(),
            'product' => $product,
        ]);
    }
}
