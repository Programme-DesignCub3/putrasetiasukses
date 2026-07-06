<?php

namespace App\Models;

use App\Traits\WithLocaleImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
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
    use WithLocaleImages;

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
            ->useDisk('public');

        $this->addMediaCollection(self::GalleryCollection)
            ->useDisk('public');
    }

    public function getImageUrlAttribute(?string $value): string
    {
        return $this->getLocaleImageUrl(self::ImageCollection, $value);
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getGalleryImagesAttribute(?string $value): array
    {
        if ($this->hasMedia(self::GalleryCollection)) {
            return $this->getLocaleGalleryImages(self::GalleryCollection);
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
