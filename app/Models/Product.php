<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia, Sortable
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use HasSlug;
    use HasTranslations;
    use InteractsWithMedia;
    use SortableTrait;

    public const MainImageCollection = 'main_image';

    public const GalleryCollection = 'gallery';

    /**
     * @var list<string>
     */
    public array $translatable = [
        'category',
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
        'category',
        'name',
        'slug',
        'description',
        'main_image_url',
        'gallery_images',
        'is_published',
        'order_column',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
            'is_published' => 'boolean',
            'order_column' => 'integer',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn (Product $product): string => $product->getTranslation('name', 'id', false) ?: '')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * @return BelongsToMany<ProductCategory, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'product_product_category', 'product_id', 'product_category_id')
            ->orderBy('order_column');
    }

    public function getCategoryNamesAttribute(): string
    {
        if ($this->relationLoaded('categories') && $this->categories->isNotEmpty()) {
            return $this->categories
                ->pluck('name')
                ->filter()
                ->implode(', ');
        }

        return (string) $this->category;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MainImageCollection)
            ->singleFile();

        $this->addMediaCollection(self::GalleryCollection);
    }

    public function getMainImageUrlAttribute(?string $value): string
    {
        return $this->getFirstMediaUrl(self::MainImageCollection) ?: (string) $value;
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
}
