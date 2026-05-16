<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;


class Products extends Component
{

    use WithFileUploads;

    public $name, $price, $image, $products;

    public function mount()
    {
        $this->products = Product::all();
    }

    public function saveProduct()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $this->image ? $this->image->store('products', 'public') : null;

        Product::create([
            'name' => $this->name,
            'price' => $this->price,
            'image' => $imagePath,
        ]);

        $this->resetInputFields();
        $this->products = Product::all(); // Refresh the product list
        session()->flash('message', 'Product added successfully!');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->price = '';
        $this->image = null;
    }

    public function render()
    {
        return view('livewire.products');
    }

    
}

