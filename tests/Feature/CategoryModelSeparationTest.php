<?php

use App\Enums\CategoryType;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('product and article category models are scoped to their own type', function (): void {
    $productCategory = ProductCategory::findOrCreate(Category::translations('Steel Plate'));
    $articleCategory = ArticleCategory::findOrCreate(Category::translations('News'));

    expect($productCategory)
        ->toBeInstanceOf(ProductCategory::class)
        ->type->toBe(CategoryType::Product)
        ->and($articleCategory)
        ->toBeInstanceOf(ArticleCategory::class)
        ->type->toBe(CategoryType::Article)
        ->and(ProductCategory::query()->pluck('id')->all())
        ->toBe([$productCategory->id])
        ->and(ArticleCategory::query()->pluck('id')->all())
        ->toBe([$articleCategory->id]);
});

test('product categories are sorted separately from article categories', function (): void {
    $firstProductCategory = ProductCategory::findOrCreate(Category::translations('Plate'));
    $secondProductCategory = ProductCategory::findOrCreate(Category::translations('Pipe'));
    $articleCategory = ArticleCategory::findOrCreate(Category::translations('Industry'));

    $secondProductCategory->moveToStart();

    expect(ProductCategory::query()->ordered()->pluck('id')->all())
        ->toBe([$secondProductCategory->id, $firstProductCategory->id])
        ->and($articleCategory->fresh()->order_column)
        ->toBe(1);
});

test('product and article relations use the separated category models', function (): void {
    $product = Product::factory()->create([
        'slug' => 'black-plate-test',
        'name' => Category::translations('Black Plate Test'),
        'category' => Category::translations('Plate'),
    ]);

    $article = Article::factory()->create([
        'slug' => 'steel-news-test',
        'title' => Category::translations('Steel News Test'),
        'category' => Category::translations('News'),
    ]);

    expect($product->fresh()->load('categories')->categories->first())
        ->toBeInstanceOf(ProductCategory::class)
        ->and($article->fresh()->load('categories')->categories->first())
        ->toBeInstanceOf(ArticleCategory::class);
});

test('project category model is scoped to project type', function (): void {
    $projectCategory = ProjectCategory::findOrCreate(Category::translations('Building Construction'));

    expect($projectCategory)
        ->toBeInstanceOf(ProjectCategory::class)
        ->type->toBe(CategoryType::Project)
        ->and(ProjectCategory::query()->pluck('id')->all())
        ->toBe([$projectCategory->id]);
});

test('project categories are sorted separately from other categories', function (): void {
    $productCategory = ProductCategory::findOrCreate(Category::translations('Pipe'));
    $firstProjectCategory = ProjectCategory::findOrCreate(Category::translations('Infrastructure'));
    $secondProjectCategory = ProjectCategory::findOrCreate(Category::translations('Warehouse'));

    $secondProjectCategory->moveToStart();

    expect(ProjectCategory::query()->ordered()->pluck('id')->all())
        ->toBe([$secondProjectCategory->id, $firstProjectCategory->id])
        ->and($productCategory->fresh()->order_column)
        ->toBe(1);
});

test('project relations use the project category model', function (): void {
    $project = Project::factory()->create();
    $category = ProjectCategory::findOrCreate(Category::translations('Renovation'));

    $project->categories()->sync([$category->id]);

    expect($project->fresh()->load('categories')->categories->first())
        ->toBeInstanceOf(ProjectCategory::class);
});
