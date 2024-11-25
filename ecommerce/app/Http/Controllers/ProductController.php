<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function filter(Request $request){
           // Fetch all categories to show in the dropdown
    $categories = Category::all();

    // Check if a category is selected and filter the products accordingly
    if ($request->has('category_id') && $request->category_id != '') {
        $products = Product::where('category_id', $request->category_id)->get();
    } else {
        // If no category is selected, return all products
        $products = Product::all();
    }

    // Pass the filtered products and categories to the view
    return view('user.dashboard', compact('categories', 'products'));
    }
    public function create()
    {
        return view('admin.products.create');
    }

    // Store a newly created product in the database
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }
     // Display the form for editing an existing product
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }
        // Update the specified product
        public function update(Request $request, string $id)
        {
            $product = Product::find($id);
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:1',
                'stock_quantity' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $imagePath = $product->image_path;
            if ($request->hasFile('image')) {
                if ($product->image_path) {
                    Storage::delete('public/' . $product->image_path);
                }
                $imagePath = $request->file('image')->store('product_images', 'public');
            }

            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
                'image_path' => $imagePath,
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
        }
        // Delete the specified product
        public function destroy(string $id)
        {
            // Find the product by ID
            $product = Product::find($id);

            // Check if the product has an associated image and delete it from storage
            if ($product->image_path) {
                Storage::delete('public/' . $product->image_path);
            }

            // Delete the product
            $product->delete();

            // Redirect back to the products index with a success message
            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
        }

    public function show(string $id)
    {
        $product = Prodct::find($id);
        return view('product.show', compact('product'));
    }
}
