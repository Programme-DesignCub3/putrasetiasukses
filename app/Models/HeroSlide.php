<?php

namespace App\Models;

use App\Traits\WithLocaleImages;
use Database\Factories\HeroSlideFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HeroSlide extends Model implements HasMedia, Sortable
{
    /** @use HasFactory<HeroSlideFactory> */
    use HasFactory;

    use InteractsWithMedia;
    use SortableTrait;
    use WithLocaleImages;

    public const ImageCollection = 'hero_image';

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
        'image',
        'label',
        'title',
        'subtitle',
        'link',
        'is_active',
        'order_column',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order_column' => 'integer',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::ImageCollection)
            ->useDisk('public');
    }

    public function getImageAttribute(?string $value): string
    {
        return $this->getLocaleImageUrl(self::ImageCollection, $value);
    }
}
