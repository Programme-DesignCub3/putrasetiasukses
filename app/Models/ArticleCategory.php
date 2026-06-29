<?php

namespace App\Models;

use Database\Factories\ArticleCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class ArticleCategory extends Category
{
    /** @use HasFactory<ArticleCategoryFactory> */
    use HasFactory;

    protected $table = 'article_categories';

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
     * @return BelongsToMany<Article, $this>
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_article_category', 'article_category_id', 'article_id');
    }
}
