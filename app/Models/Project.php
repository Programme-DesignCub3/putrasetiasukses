<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Filament\Forms\Components\RichEditor\FileAttachmentProviders\SpatieMediaLibraryFileAttachmentProvider;
use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
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

class Project extends Model implements HasMedia, HasRichContent, Sortable
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    use HasSlug;
    use HasTranslations;
    use InteractsWithMedia;
    use InteractsWithRichContent;
    use SortableTrait;

    public const MainImageCollection = 'main_image';

    public const GalleryCollection = 'gallery';

    public const BodyAttachmentCollection = 'project_body_attachments';

    /**
     * @var list<string>
     */
    public array $translatable = [
        'category',
        'name',
        'description',
        'location',
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
        'client',
        'location',
        'main_image_url',
        'gallery_images',
        'completion_date',
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
            'completion_date' => 'date',
            'order_column' => 'integer',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn (Project $project): string => $project->getTranslation('name', 'id', false) ?: '')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * @return BelongsToMany<ProjectCategory, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProjectCategory::class, 'project_project_category', 'project_id', 'project_category_id')
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

    protected function setUpRichContent(): void
    {
        $this->registerRichContent('description')
            ->fileAttachmentProvider(
                SpatieMediaLibraryFileAttachmentProvider::make()
                    ->collection(self::BodyAttachmentCollection),
            );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MainImageCollection)
            ->useDisk('public');

        $this->addMediaCollection(self::GalleryCollection)
            ->useDisk('public');

        $this->addMediaCollection(self::BodyAttachmentCollection)
            ->useDisk('public');
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
                ->values()
                ->all();
        }

        return json_decode((string) $value, true) ?: [];
    }
}
