<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryCard extends Component
{
    public Category $category;

    public function getProductCount()
    {
        return $this->category->products()->count();
    }

    public function render()
    {
        return view('livewire.category-card');
    }
}
