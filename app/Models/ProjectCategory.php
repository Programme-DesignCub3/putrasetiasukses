<?php

namespace App\Models;

use Database\Factories\ProjectCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class ProjectCategory extends Category
{
    /** @use HasFactory<ProjectCategoryFactory> */
    use HasFactory;

    protected $table = 'project_categories';

    public static function findOrCreate(array|string $name): self
    {
        $translations = is_array($name) ? $name : static::translations($name);
        $slug = Str::slug($translations['id'] ?? $translations['en'] ?? $translations['zh'] ?? '');

        return static::query()->firstOrCreate(
            ['slug' => $slug],
            ['name' => $translations, 'is_active' => true],
        );
    }

    /**
     * @return BelongsToMany<Project, $this>
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_project_category', 'project_category_id', 'project_id');
    }
}
