<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MisComptrasController extends Controller
{
    public function index()
    {
        $payments = auth()->user()->payments;
        
        return view('panel.mis-compras', compact('payments'));
    }
}
