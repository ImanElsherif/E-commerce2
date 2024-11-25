<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminController extends Controller
{
    public function dashboard()
    {
        $categories = Category::with('products')->get();
        return view('admin.dashboard', compact('categories'));
    }
}

