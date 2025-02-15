<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $products = Product::with(['images' => function ($query) {
            $query->where('order', 1)->orderBy('order');
        }])->get();

        return view('home', compact('products'));
    }
}
