<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('articles can belong to multiple editable article categories', function () {
    $article = Article::factory()->create();
    $industry = ArticleCategory::factory()->create([
        'name' => ['id' => 'Industri', 'en' => 'Industry', 'zh' => '工业'],
    ]);
    $guide = ArticleCategory::factory()->create([
        'name' => ['id' => 'Panduan', 'en' => 'Guide', 'zh' => '指南'],
    ]);

    $article->categories()->sync([$industry->id, $guide->id]);

    $categoryIds = $article->fresh()->load('categories')->categories->pluck('id');

    expect($categoryIds)
        ->toHaveCount(2)
        ->toContain($industry->id, $guide->id);

    $guide->update(['name' => ['id' => 'Tips & Panduan', 'en' => 'Tips & Guides', 'zh' => '提示与指南']]);

    expect($article->fresh()->load('categories')->category_names)
        ->toContain('Industri')
        ->toContain('Tips & Panduan');

    $guide->delete();

    $remainingCategories = $article->fresh()->load('categories')->categories;

    expect($remainingCategories)
        ->toHaveCount(1)
        ->and($remainingCategories->first()->id)->toBe($industry->id);
});
