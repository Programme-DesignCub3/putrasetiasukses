<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    public function configure(): static
    {
        return $this->afterCreating(function (Article $article): void {
            $category = Category::findOrCreateForType(Category::TypeArticle, $article->getTranslations('category'));

            $article->categories()->syncWithoutDetaching([$category->id]);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return Article::defaults()[0];
    }
}
