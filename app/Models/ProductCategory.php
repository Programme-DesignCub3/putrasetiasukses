<?php

namespace App\Models;

use Database\Factories\ProductCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class ProductCategory extends Category
{
    /** @use HasFactory<ProductCategoryFactory> */
    use HasFactory;

    protected $table = 'product_categories';

    public static function findOrCreate(array|string $name): self
    {
        $translations = is_array($name) ? $name : static::translations($name);
        $slug = Str::slug($translations['id'] ?? $translations['en'] ?? $translations['zh'] ?? '');

        return static::query()->firstOrCreate(
            ['slug' => $slug],
            ['name' => $translations, 'is_active' => true],
        );
    }

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_product_category', 'product_category_id', 'product_id');
    }
}
