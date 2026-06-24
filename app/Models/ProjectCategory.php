<?php

namespace App\Models;

use App\Enums\CategoryType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectCategory extends Category
{
    protected $table = 'categories';

    protected static function booted(): void
    {
        static::addGlobalScope(
            'project-category',
            fn (Builder $builder) => $builder->where('type', CategoryType::Project),
        );

        static::creating(function (ProjectCategory $category): void {
            $category->type = CategoryType::Project;
        });
    }

    public static function findOrCreate(array|string $name): self
    {
        return self::findOrCreateForType(CategoryType::Project, $name);
    }

    /**
     * @return BelongsToMany<Project, $this>
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'category_project', 'category_id', 'project_id');
    }
}
