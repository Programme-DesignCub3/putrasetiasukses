<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()
            ->where('is_published', true)
            ->latest('published_at')
            ->get();

        return view('articles.index', [
            'site' => SiteSetting::current(),
            'featuredArticles' => $articles->where('is_featured', true)->take(2),
            'articles' => $articles->where('is_featured', false),
        ]);
    }

    public function show(Article $article): View
    {
        abort_unless($article->is_published, 404);

        return view('articles.show', [
            'site' => SiteSetting::current(),
            'article' => $article,
        ]);
    }
}
