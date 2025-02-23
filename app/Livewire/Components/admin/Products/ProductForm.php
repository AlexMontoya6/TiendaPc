<?php

namespace App\Livewire\Components\admin\Products;

use App\Models\Category;
use App\Models\ProductType;
use App\Models\Subcategory;
use Livewire\Component;

class ProductForm extends Component
{
    public $productTypes;

    public $categories = [];

    public $subcategories = [];

    public $selectedProductType = null;

    public $selectedCategory = null;

    public $selectedSubcategory = null;

    public function mount()
    {
        $this->productTypes = ProductType::all();
    }

    public function updatedSelectedProductType()
    {
        if ($this->selectedProductType) {
            $this->categories = Category::where('product_type_id', $this->selectedProductType)->get();
        } else {
            $this->categories = [];
        }

        $this->subcategories = [];
        $this->selectedCategory = null;
        $this->selectedSubcategory = null;
    }

    public function updatedSelectedCategory()
    {
        if ($this->selectedCategory) {
            $this->subcategories = Subcategory::where('category_id', $this->selectedCategory)->get();
        } else {
            $this->subcategories = [];
        }

        $this->selectedSubcategory = null;
    }

    public function render()
    {
        return view('livewire.product-form');
    }
}
