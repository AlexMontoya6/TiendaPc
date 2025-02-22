<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Traits\HandlesCart;
use Livewire\Component;

class Home extends Component
{
    use HandlesCart;

    public function render()
    {
        $ofertaProducts = Tag::ofertaProducts();
        $trendingProducts = Tag::trendingProducts();
        $portatilProducts = Category::portatilProducts();


        return view('livewire.pages.home', compact('ofertaProducts', 'trendingProducts', 'portatilProducts'))
            ->layout('layouts.guest');
    }
}
