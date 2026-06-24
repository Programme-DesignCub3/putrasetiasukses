<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Product;
use App\Models\Project;
use Livewire\Component;

class SearchResults extends Component
{
    public string $query = '';

    public function render()
    {
        $products = collect();
        $articles = collect();
        $projects = collect();

        if (strlen($this->query) >= 2) {
            $search = mb_strtolower($this->query);

            $products = Product::query()
                ->with('media')
                ->where('is_published', true)
                ->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
                })
                ->ordered()
                ->take(5)
                ->get();

            $articles = Article::query()
                ->with('media')
                ->where('is_published', true)
                ->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(excerpt) LIKE ?', ["%{$search}%"]);
                })
                ->latest('published_at')
                ->take(5)
                ->get();

            $projects = Project::query()
                ->with('media')
                ->where('is_published', true)
                ->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(location) LIKE ?', ["%{$search}%"]);
                })
                ->ordered()
                ->take(5)
                ->get();
        }

        return view('livewire.search-results', [
            'products' => $products,
            'articles' => $articles,
            'projects' => $projects,
            'hasResults' => $products->isNotEmpty() || $articles->isNotEmpty() || $projects->isNotEmpty(),
            'totalCount' => $products->count() + $articles->count() + $projects->count(),
        ]);
    }
}
