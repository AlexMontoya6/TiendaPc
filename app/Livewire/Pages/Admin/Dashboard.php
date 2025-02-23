<?php

namespace App\Livewire\Pages\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.pages.admin.dashboard', [
            'totalProducts' => Product::count(),
            'totalUsers' => User::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'latestProducts' => Product::latest()->take(5)->get(),
        ])->layout('layouts.app');
    }
}
