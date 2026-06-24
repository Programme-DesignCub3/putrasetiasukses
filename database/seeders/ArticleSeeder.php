<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Article::defaults() as $article) {
            $record = Article::query()->updateOrCreate(
                ['slug' => $article['slug']],
                $article,
            );

            $category = ArticleCategory::findOrCreate($article['category']);

            $record->categories()->syncWithoutDetaching([$category->id]);
        }
    }
}
