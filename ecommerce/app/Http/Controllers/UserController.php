<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class UserController extends Controller
{
    public function dashboard()
    {
        $products = Product::all();
        return view('user.dashboard', compact('products'));
    }
}
