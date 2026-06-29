<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\ArticleCategory;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleList extends Component
{
    use WithPagination;

    public string $search = '';

    public string $categoryId = '';

    protected int $perPage = 6;

    public function mount(): void
    {
        $this->search = request('search', '');
    }

    public function updated($property): void
    {
        if (in_array($property, ['search', 'categoryId'])) {
            $this->resetPage();
        }
    }

    #[Computed]
    public function categories()
    {
        return ArticleCategory::query()
            ->ordered()
            ->get();
    }

    public function render()
    {
        $articles = Article::query()
            ->with(['categories', 'media'])
            ->where('is_published', true)
            ->where('is_featured', false);

        if ($this->search) {
            $search = mb_strtolower($this->search);
            $articles->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(excerpt) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($this->categoryId) {
            $articles->whereHas('categories', fn ($q) => $q->where('article_categories.id', $this->categoryId));
        }

        return view('livewire.article-list', [
            'articles' => $articles->latest('published_at')->paginate($this->perPage),
        ]);
    }
}
