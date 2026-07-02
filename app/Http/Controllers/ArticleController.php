<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Support\SeoMetadataBuilder;
use Illuminate\Contracts\View\View;

class ArticleController extends Controller
{
    public function index(SeoMetadataBuilder $metadata): View
    {
        $metadata->build(
            title: __('seo.articles.title').' - '.__('site.company_name'),
            description: __('seo.articles.description'),
            image: 'https://placehold.co/1400x320/4b5563/ffffff?text=Artikel',
        );

        $latestArticles = Article::query()
            ->with(['categories', 'media'])
            ->where('is_published', true)
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('articles.index', [
            'latestArticles' => $latestArticles,
            'latestArticleIds' => $latestArticles->pluck('id')->all(),
        ]);
    }

    public function show(Article $article, SeoMetadataBuilder $metadata): View
    {
        abort_unless($article->is_published, 404);

        $article->load('media');
        $article->loadMissing('categories');

        $metadata->build(
            title: $article->title.' - '.__('site.company_name'),
            description: $article->excerpt,
            image: $article->image_url,
            type: 'article',
            publishedAt: $article->published_at,
            modifiedAt: $article->updated_at,
            author: $article->author,
            section: $article->category_names,
            tags: $article->categories->pluck('name')->all(),
        );

        return view('articles.show', [
            'article' => $article,
        ]);
    }
}
