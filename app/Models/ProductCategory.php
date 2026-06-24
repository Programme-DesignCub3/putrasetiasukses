<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductCategory extends Category
{
    protected $table = 'categories';

    protected static function booted(): void
    {
        static::addGlobalScope(
            'product-category',
            fn (Builder $builder) => $builder->where('type', self::TypeProduct),
        );

        static::creating(function (ProductCategory $category): void {
            $category->type = self::TypeProduct;
        });
    }

    public static function findOrCreate(array|string $name): self
    {
        return self::findOrCreateForType(self::TypeProduct, $name);
    }

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }
}
