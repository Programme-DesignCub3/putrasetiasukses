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

    public string $categoryId = '';

    protected int $perPage = 12;

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
        return ProductCategory::query()
            ->ordered()
            ->get();
    }

    public function render()
    {
        $products = Product::query()
            ->with(['categories', 'media'])
            ->where('is_published', true);

        if ($this->search) {
            $search = mb_strtolower($this->search);
            $products->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($this->categoryId) {
            $products->whereHas('categories', fn ($q) => $q->where('categories.id', $this->categoryId));
        }

        return view('livewire.product-list', [
            'products' => $products->ordered()->paginate($this->perPage),
        ]);
    }
}
