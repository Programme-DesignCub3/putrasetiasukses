<?php

namespace App\Models;

use Database\Factories\ArticleFactory;
use Filament\Forms\Components\RichEditor\FileAttachmentProviders\SpatieMediaLibraryFileAttachmentProvider;
use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Article extends Model implements HasMedia, HasRichContent
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory;

    use HasSlug;
    use HasTranslations;
    use InteractsWithMedia;
    use InteractsWithRichContent;

    public const BodyAttachmentCollection = 'article_body_attachments';

    public const ImageCollection = 'article_image';

    /**
     * @var list<string>
     */
    public array $translatable = [
        'category',
        'title',
        'excerpt',
        'body',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category',
        'title',
        'slug',
        'author',
        'image_url',
        'excerpt',
        'body',
        'published_at',
        'is_featured',
        'is_published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::ImageCollection)
            ->singleFile();

        $this->addMediaCollection(self::BodyAttachmentCollection);
    }

    protected function setUpRichContent(): void
    {
        $this->registerRichContent('body')
            ->fileAttachmentProvider(
                SpatieMediaLibraryFileAttachmentProvider::make()
                    ->collection(self::BodyAttachmentCollection),
            );
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn (Article $article): string => $article->getTranslation('title', 'id', false) ?: '')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * @return BelongsToMany<ArticleCategory, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ArticleCategory::class, 'article_article_category', 'article_id', 'article_category_id')
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

    public function getImageUrlAttribute(?string $value): string
    {
        return $this->getFirstMediaUrl(self::ImageCollection) ?: (string) $value;
    }
}
