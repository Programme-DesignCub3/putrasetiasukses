<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    use HasSlug;
    use HasTranslations;

    public const TypeProduct = 'product';

    public const TypeArticle = 'article';

    public const TypeProject = 'project';

    /**
     * @var list<string>
     */
    public array $translatable = [
        'name',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'name',
        'slug',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn (Category $category): string => $category->getTranslation('name', 'id', false) ?: '')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return BelongsToMany<Article, $this>
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    public static function findOrCreateForType(string $type, array|string $name): self
    {
        $translations = is_array($name) ? $name : self::translations($name);
        $slug = Str::slug($translations['id'] ?? $translations['en'] ?? $translations['zh'] ?? '');

        return self::query()->firstOrCreate(
            [
                'type' => $type,
                'slug' => $slug,
            ],
            [
                'name' => $translations,
                'is_active' => true,
            ],
        );
    }

    /**
     * @return array<string, string>
     */
    public static function translations(string $value): array
    {
        return [
            'id' => $value,
            'en' => $value,
            'zh' => $value,
        ];
    }
}
