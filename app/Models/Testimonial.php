<?php

namespace App\Models;

use Database\Factories\TestimonialFactory;
use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model implements HasRichContent, Sortable
{
    /** @use HasFactory<TestimonialFactory> */
    use HasFactory;

    use HasTranslations;
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
        $this->registerRichContent('content');
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
