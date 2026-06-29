<?php

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('product and article category models use their own tables', function (): void {
    $productCategory = ProductCategory::findOrCreate(['id' => 'Steel Plate', 'en' => 'Steel Plate', 'zh' => '钢板']);
    $articleCategory = ArticleCategory::findOrCreate(['id' => 'News', 'en' => 'News', 'zh' => '新闻']);

    expect($productCategory)
        ->toBeInstanceOf(ProductCategory::class)
        ->and($articleCategory)
        ->toBeInstanceOf(ArticleCategory::class)
        ->and(ProductCategory::query()->pluck('id')->all())
        ->toBe([$productCategory->id])
        ->and(ArticleCategory::query()->pluck('id')->all())
        ->toBe([$articleCategory->id]);
});

test('product categories are sorted separately from article categories', function (): void {
    $firstProductCategory = ProductCategory::findOrCreate(['id' => 'Plate', 'en' => 'Plate', 'zh' => '板']);
    $secondProductCategory = ProductCategory::findOrCreate(['id' => 'Pipe', 'en' => 'Pipe', 'zh' => '管']);
    $articleCategory = ArticleCategory::findOrCreate(['id' => 'Industry', 'en' => 'Industry', 'zh' => '工业']);

    $secondProductCategory->moveToStart();

    expect(ProductCategory::query()->ordered()->pluck('id')->all())
        ->toBe([$secondProductCategory->id, $firstProductCategory->id])
        ->and($articleCategory->fresh()->order_column)
        ->toBe(1);
});

test('product and article relations use the separated category models', function (): void {
    $product = Product::factory()->create([
        'slug' => 'black-plate-test',
        'name' => ['id' => 'Black Plate Test', 'en' => 'Black Plate Test', 'zh' => '黑钢板测试'],
        'category' => ['id' => 'Plate', 'en' => 'Plate', 'zh' => '板'],
    ]);

    $article = Article::factory()->create([
        'slug' => 'steel-news-test',
        'title' => ['id' => 'Steel News Test', 'en' => 'Steel News Test', 'zh' => '钢铁新闻测试'],
        'category' => ['id' => 'News', 'en' => 'News', 'zh' => '新闻'],
    ]);

    expect($product->fresh()->load('categories')->categories->first())
        ->toBeInstanceOf(ProductCategory::class)
        ->and($article->fresh()->load('categories')->categories->first())
        ->toBeInstanceOf(ArticleCategory::class);
});

test('project category model is scoped to project type', function (): void {
    $projectCategory = ProjectCategory::findOrCreate(['id' => 'Building Construction', 'en' => 'Building Construction', 'zh' => '建筑施工']);

    expect($projectCategory)
        ->toBeInstanceOf(ProjectCategory::class)
        ->and(ProjectCategory::query()->pluck('id')->all())
        ->toBe([$projectCategory->id]);
});

test('project categories are sorted separately from other categories', function (): void {
    $productCategory = ProductCategory::findOrCreate(['id' => 'Pipe', 'en' => 'Pipe', 'zh' => '管']);
    $firstProjectCategory = ProjectCategory::findOrCreate(['id' => 'Infrastructure', 'en' => 'Infrastructure', 'zh' => '基础设施']);
    $secondProjectCategory = ProjectCategory::findOrCreate(['id' => 'Warehouse', 'en' => 'Warehouse', 'zh' => '仓库']);

    $secondProjectCategory->moveToStart();

    expect(ProjectCategory::query()->ordered()->pluck('id')->all())
        ->toBe([$secondProjectCategory->id, $firstProjectCategory->id])
        ->and($productCategory->fresh()->order_column)
        ->toBe(1);
});

test('project relations use the project category model', function (): void {
    $project = Project::factory()->create();
    $category = ProjectCategory::findOrCreate(['id' => 'Renovation', 'en' => 'Renovation', 'zh' => '翻新']);

    $project->categories()->sync([$category->id]);

    expect($project->fresh()->load('categories')->categories->first())
        ->toBeInstanceOf(ProjectCategory::class);
});
