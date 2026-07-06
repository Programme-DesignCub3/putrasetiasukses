<?php

namespace App\Models;

use Database\Factories\TestimonialFactory;
use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model implements HasMedia, HasRichContent, Sortable
{
    /** @use HasFactory<TestimonialFactory> */
    use HasFactory;

    use HasTranslations;
    use InteractsWithMedia;
    use InteractsWithRichContent;
    use SortableTrait;

    /**
     * @var list<string>
     */
    public array $translatable = [
        'name',
        'content',
    ];

    /**
     * @var array<string, mixed>
     */
    public array $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    protected function setUpRichContent(): void
    {
        //
    }

    public function registerMediaCollections(): void
    {
        //
    }

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'content',
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
}
