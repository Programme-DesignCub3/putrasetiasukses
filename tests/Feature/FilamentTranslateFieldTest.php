<?php

use App\Filament\Resources\Articles\Pages\CreateArticle;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use App\Support\FilamentTranslatableFields;
use Filament\Forms\Components\RichEditor\FileAttachmentProviders\SpatieMediaLibraryFileAttachmentProvider;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('article body rich editor allows public media attachments', function () {
    $field = FilamentTranslatableFields::richEditor('body', 'Body', 'id');
    $toolbarButtons = new ReflectionProperty($field, 'toolbarButtons');
    $provider = (new Article)->getRichContentAttribute('body')?->getFileAttachmentProvider();

    expect(collect($toolbarButtons->getValue($field))->flatten()->all())
        ->toContain('attachFiles')
        ->and($field->hasFileAttachments())->toBeTrue()
        ->and($provider)->toBeInstanceOf(SpatieMediaLibraryFileAttachmentProvider::class)
        ->and($provider?->getCollection())->toBe(Article::BodyAttachmentCollection);
});

test('indonesian article translations are required while other locales are optional', function () {
    $this->actingAs(User::factory()->create());

    $category = ArticleCategory::factory()->create([
        'is_active' => true,
        'name' => ['id' => 'Berita', 'en' => 'News', 'zh' => '新闻'],
    ]);

    Livewire::test(CreateArticle::class)
        ->fillForm([
            'categories' => [$category->id],
            'title' => [
                'id' => 'Judul Indonesia',
                'en' => null,
                'zh' => null,
            ],
            'author' => 'Admin',
            'excerpt' => [
                'id' => 'Ringkasan Indonesia',
                'en' => null,
                'zh' => null,
            ],
            'body' => [
                'id' => '<h2>Isi artikel Indonesia</h2><p>Konten detail.</p>',
                'en' => null,
                'zh' => null,
            ],
            'is_featured' => false,
            'is_published' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $article = Article::query()->firstOrFail();

    expect($article->getTranslation('title', 'id'))->toBe('Judul Indonesia')
        ->and($article->getTranslation('title', 'en', false))->toBe('')
        ->and($article->getTranslation('title', 'zh', false))->toBe('')
        ->and(RichContentRenderer::make($article->getTranslation('body', 'id'))->toText())->toContain('Isi artikel Indonesia')
        ->and($article->getTranslation('body', 'en', false))->toBe('')
        ->and($article->getTranslation('body', 'zh', false))->toBe('');
});

test('article forms reject missing indonesian translations', function (array $data, array $errors) {
    $this->actingAs(User::factory()->create());

    $category = ArticleCategory::factory()->create([
        'is_active' => true,
        'name' => ['id' => 'Berita', 'en' => 'News', 'zh' => '新闻'],
    ]);

    $validData = [
        'categories' => [$category->id],
        'title' => [
            'id' => 'Judul Indonesia',
            'en' => null,
            'zh' => null,
        ],
        'author' => 'Admin',
        'excerpt' => [
            'id' => 'Ringkasan Indonesia',
            'en' => null,
            'zh' => null,
        ],
        'body' => [
            'id' => '<p>Isi artikel Indonesia</p>',
            'en' => null,
            'zh' => null,
        ],
        'is_featured' => false,
        'is_published' => true,
    ];

    Livewire::test(CreateArticle::class)
        ->fillForm(array_replace_recursive($validData, $data))
        ->call('create')
        ->assertHasFormErrors($errors);
})->with([
    'title id is required' => [
        ['title' => ['id' => null]],
        ['title.id' => 'required'],
    ],
    'excerpt id is required' => [
        ['excerpt' => ['id' => null]],
        ['excerpt.id' => 'required'],
    ],
    'body id is required' => [
        ['body' => ['id' => null]],
        ['body.id'],
    ],
]);
