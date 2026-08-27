<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public string $search = '';

    public string $categorySlug = '';

    public bool $compact = false;

    protected int $perPage = 6;

    public function mount(): void
    {
        $this->search = request('search', '');
        $this->categorySlug = request('category', '');
    }

    public function updated($property): void
    {
        if (in_array($property, ['search', 'categorySlug'])) {
            $this->resetPage();
        }
    }

    #[Computed]
    public function categories()
    {
        return ProductCategory::query()
            ->ordered()
            ->get();
    }

    public function render()
    {
        $products = Product::query()
            ->with(['categories', 'media'])
            ->where('is_published', true);

        if (! $this->compact && $this->search) {
            $search = mb_strtolower($this->search);
            $products->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($this->categorySlug) {
            $products->whereHas('categories', fn ($q) => $q->where('product_categories.slug', $this->categorySlug));
        }

        $perPage = $this->compact ? 6 : $this->perPage;

        return view('livewire.product-list', [
            'products' => $products->ordered()->paginate($perPage),
        ]);
    }
}
