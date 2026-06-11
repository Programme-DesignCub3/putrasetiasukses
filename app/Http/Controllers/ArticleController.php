<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Support\SiteConfig;
use Illuminate\Contracts\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()
            ->with('media')
            ->where('is_published', true)
            ->latest('published_at')
            ->get();

        return view('articles.index', [
            'site' => SiteConfig::current(),
            'featuredArticles' => $articles->where('is_featured', true)->take(2),
            'articles' => $articles->where('is_featured', false),
        ]);
    }

    public function show(Article $article): View
    {
        abort_unless($article->is_published, 404);

        $article->load('media');

        return view('articles.show', [
            'site' => SiteConfig::current(),
            'article' => $article,
        ]);
    }
}
