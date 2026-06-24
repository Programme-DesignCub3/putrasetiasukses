<?php

use App\Filament\Resources\Articles\Pages\ListArticles;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\ContactMessages\Pages\ListContactMessages;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Models\User;
use Benriadh1\FilamentTranslationManager\Pages\TranslationManagerEnhancedPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('filament resource list pages render with the admin layout', function (string $page): void {
    $this->actingAs(User::factory()->create());

    Livewire::test($page)
        ->assertStatus(200);
})->with([
    ListArticles::class,
    ListCategories::class,
    ListContactMessages::class,
    ListProducts::class,
    TranslationManagerEnhancedPage::class,
]);

test('filament language switcher renders on the admin login page', function (): void {
    $this->get('/admin/login')
        ->assertSuccessful()
        ->assertSee('Indonesia')
        ->assertSee('English')
        ->assertSee('中文');
});
