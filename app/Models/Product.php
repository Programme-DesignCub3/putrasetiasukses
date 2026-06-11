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
     * @return BelongsToMany<Category, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
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

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function defaults(): array
    {
        return [
            [
                'category' => [
                    'id' => 'Steel Plate',
                    'en' => 'Steel Plate',
                    'zh' => '钢板',
                ],
                'name' => [
                    'id' => 'Plat Hitam',
                    'en' => 'Black Plate',
                    'zh' => '黑钢板',
                ],
                'slug' => 'plat-hitam',
                'description' => [
                    'id' => "Plat baja hitam adalah lembaran baja struktural berdensitas tinggi yang diproduksi melalui proses canai panas (hot-rolled), sehingga menghasilkan ciri khas permukaan berwarna gelap kehitaman. Material ini dikenal memiliki kekuatan tarik yang tinggi, tangguh, dan mudah dibentuk maupun dilas untuk berbagai kebutuhan konstruksi dan fabrikasi.\n\nKami menyediakan plat baja hitam dalam berbagai pilihan ketebalan mulai dari 1,2 mm hingga puluhan milimeter, dengan ukuran standar seperti 4x8 feet, 5x10 feet, dan custom sesuai kebutuhan proyek.",
                    'en' => "Black steel plate is a high-density structural steel sheet produced through a hot-rolled process, creating its distinctive dark surface. This material is known for high tensile strength, toughness, and easy forming or welding for construction and fabrication needs.\n\nWe provide black steel plate in many thickness options, from 1.2 mm to dozens of millimeters, with standard sizes such as 4x8 feet, 5x10 feet, and custom sizes for project requirements.",
                    'zh' => "黑钢板是一种通过热轧工艺生产的高密度结构钢板，表面呈深色。该材料具有较高抗拉强度、韧性好，并且易于成型和焊接，适用于建筑和加工需求。\n\n我们提供多种厚度的黑钢板，从 1.2 毫米到数十毫米，标准尺寸包括 4x8 英尺、5x10 英尺，也可按项目需求定制。",
                ],
                'main_image_url' => 'https://placehold.co/860x620/2b2b2b/ffffff?text=Plat+Hitam',
                'gallery_images' => [
                    ['url' => 'https://placehold.co/320x180/525252/ffffff?text=Steel+Plate+1'],
                    ['url' => 'https://placehold.co/320x180/737373/ffffff?text=Steel+Plate+2'],
                    ['url' => 'https://placehold.co/320x180/404040/ffffff?text=Steel+Plate+3'],
                ],
                'is_published' => true,
            ],
        ];
    }
}
