<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia, Sortable
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    use HasSlug;
    use HasTranslations;
    use InteractsWithMedia;
    use SortableTrait;

    public const TypeProduct = 'product';

    public const TypeArticle = 'article';

    public const TypeProject = 'project';

    public const ImageCollection = 'category_image';

    public const GalleryCollection = 'category_gallery';

    /**
     * @var list<string>
     */
    public array $translatable = [
        'name',
        'description',
    ];

    /**
     * @var array<string, mixed>
     */
    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'name',
        'description',
        'slug',
        'image_url',
        'gallery_images',
        'is_active',
        'order_column',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
            'is_active' => 'boolean',
            'order_column' => 'integer',
        ];
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->where('type', $this->type);
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::ImageCollection)
            ->singleFile();

        $this->addMediaCollection(self::GalleryCollection);
    }

    public function getImageUrlAttribute(?string $value): string
    {
        return $this->getFirstMediaUrl(self::ImageCollection) ?: (string) $value;
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getGalleryImagesAttribute(?string $value): array
    {
        if ($this->hasMedia(self::GalleryCollection)) {
            return $this->getMedia(self::GalleryCollection)
                ->map(fn (Media $media): array => [
                    'url' => $media->getUrl(),
                    'alt' => $media->name,
                ])
                ->all();
        }

        return json_decode((string) $value, true) ?: [];
    }

    public static function findOrCreateForType(string $type, array|string $name): static
    {
        $translations = is_array($name) ? $name : static::translations($name);
        $slug = Str::slug($translations['id'] ?? $translations['en'] ?? $translations['zh'] ?? '');

        return static::query()->firstOrCreate(
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
