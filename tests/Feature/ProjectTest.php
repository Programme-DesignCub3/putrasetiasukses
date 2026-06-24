<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('project can be created with translatable fields', function () {
    $project = Project::factory()->create([
        'name' => Category::translations('Proyek Test'),
    ]);

    expect($project->name)->toBe('Proyek Test')
        ->and($project->getTranslation('name', 'en'))->not->toBeEmpty()
        ->and($project->getTranslation('name', 'zh'))->not->toBeEmpty();
});

test('project slug is auto-generated from indonesian name', function () {
    $project = Project::factory()->create([
        'name' => Category::translations('Proyek Gedung Bertingkat'),
        'slug' => '',
    ]);

    expect($project->slug)->toBe('proyek-gedung-bertingkat');
});

test('project can be assigned to multiple categories', function () {
    $project = Project::factory()->create();
    $project->categories()->detach();

    $categoryA = ProjectCategory::findOrCreate(Category::translations('Konstruksi'));
    $categoryB = ProjectCategory::findOrCreate(Category::translations('Infrastruktur'));
    $project->categories()->attach([$categoryA->id, $categoryB->id]);

    $freshProject = $project->fresh()->load('categories');

    expect($freshProject->categories)
        ->toHaveCount(2)
        ->and($freshProject->category_names)->toContain('Konstruksi', 'Infrastruktur');
});

test('project categories are sorted by order column', function () {
    $project = Project::factory()->create();
    $first = ProjectCategory::findOrCreate(Category::translations('First'));
    $second = ProjectCategory::findOrCreate(Category::translations('Second'));

    $project->categories()->sync([$second->id, $first->id]);

    $orderedNames = $project->fresh()->load('categories')->categories->pluck('name')->all();

    expect($orderedNames)->toBe(['First', 'Second']);
});

test('projects can be ordered with sortable trait', function () {
    Project::factory()->create(['name' => Category::translations('Proyek A')]);
    Project::factory()->create(['name' => Category::translations('Proyek B')]);

    $first = Project::ordered()->first();
    $second = Project::ordered()->get()->last();

    expect($first->order_column)->toBeLessThan($second->order_column);
});

test('project factory creates associated project category', function () {
    $project = Project::factory()->create();

    expect($project->fresh()->load('categories')->categories)
        ->toHaveCount(1)
        ->and($project->fresh()->load('categories')->categories->first())
        ->toBeInstanceOf(ProjectCategory::class);
});

test('project category_names fallback to category translatable column', function () {
    $project = Project::factory()->create([
        'category' => Category::translations('Legacy Category'),
    ]);

    expect($project->category_names)->toContain('Legacy Category');
});

test('project completion date is nullable', function () {
    $project = Project::factory()->create(['completion_date' => null]);

    expect($project->completion_date)->toBeNull();
});
