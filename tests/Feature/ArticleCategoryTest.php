<?php

use App\Enums\CategoryType;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('articles can belong to multiple editable article categories', function () {
    $article = Article::factory()->create();
    $industry = Category::factory()->create([
        'type' => CategoryType::Article,
        'name' => Category::translations('Industri'),
    ]);
    $guide = Category::factory()->create([
        'type' => CategoryType::Article,
        'name' => Category::translations('Panduan'),
    ]);

    $article->categories()->sync([$industry->id, $guide->id]);

    $categoryIds = $article->fresh()->load('categories')->categories->pluck('id');

    expect($categoryIds)
        ->toHaveCount(2)
        ->toContain($industry->id, $guide->id);

    $guide->update(['name' => Category::translations('Tips & Panduan')]);

    expect($article->fresh()->load('categories')->category_names)
        ->toContain('Industri')
        ->toContain('Tips & Panduan');

    $guide->delete();

    $remainingCategories = $article->fresh()->load('categories')->categories;

    expect($remainingCategories)
        ->toHaveCount(1)
        ->and($remainingCategories->first()->id)->toBe($industry->id);
});
