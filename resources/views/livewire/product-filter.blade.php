<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductFilter extends Component
{
    public $categories = [];
    public $selectedCategory = null;
    public $priceRange = [0, 1000]; // Example range
    public $products = [];

    public function mount()
    {
        $this->categories = \App\Models\Category::all();
        $this->products = Product::all();
    }

    public function filterProducts()
    {
        $this->products = Product::query()
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->when($this->priceRange, function ($query) {
                $query->whereBetween('price', $this->priceRange);
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.product-filter');
    }
}
