<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ArticleCategory extends Category
{
    protected $table = 'categories';

    protected static function booted(): void
    {
        static::addGlobalScope(
            'article-category',
            fn (Builder $builder) => $builder->where('type', self::TypeArticle),
        );

        static::creating(function (ArticleCategory $category): void {
            $category->type = self::TypeArticle;
        });
    }

    public static function findOrCreate(array|string $name): self
    {
        return self::findOrCreateForType(self::TypeArticle, $name);
    }

    /**
     * @return BelongsToMany<Article, $this>
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_category', 'category_id', 'article_id');
    }
}
