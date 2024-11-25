<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function welcome()
    {
        $categories = Category::with('products')->get();
        return view('welcome', compact('categories'));
    }
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

        // Show the form for creating a new category
        public function create()
        {
            return view('admin.categories.create');
        }

        // Store a newly created category in the database
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);

            Category::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
            return redirect()->route('admin.dashboard')->with('success', 'Category added successfully!');
        }

    public function show(string $id)
    {
        $category = Category::where('id', $id)->with('products')->first();
        return view('admin.categories.show', compact('category'));
    }

    // Show the form for editing the specified category
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

       // Update the specified category in the database
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $category->update(
            [
                'name' => $request->name,
                'description' => $request->description
            ]
        );
        return redirect()->route('admin.dashboard')->with('success', 'Category updated successfully!');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.dashboard')->with('error', 'Cannot delete category with products.');
        }

        $category->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Category deleted successfully!');
    }

}
