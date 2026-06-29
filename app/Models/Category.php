<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

abstract class Category extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use HasSlug;
    use HasTranslations;
    use InteractsWithMedia;
    use SortableTrait;

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
        return static::query();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn (Category $category): string => $category->getTranslation('name', 'id', false) ?: '')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
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
