<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product=Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
        ]);

        if ($request->hasFile('images')) {
            $images = $request->file('images'); // Get the uploaded images

            foreach ($images as $image) {
                $imageName = date('YmdHis') . '-' . $image->getClientOriginalName();

                $image->move(public_path('uploads/product'), $imageName);

                Image::create([
                    'product_id' => $product->id,
                    'file_path' => 'uploads/product/' . $imageName,
                ]);
            }
        }

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
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
            ]);
            if ($request->hasFile('images')) {
                $images = $request->file('images'); // Get the uploaded images

                foreach ($images as $image) {
                    $imageName = date('YmdHis') . '-' . $image->getClientOriginalName();

                    $image->move(public_path('uploads/product'), $imageName);

                    Image::create([
                        'product_id' => $product->id,
                        'file_path' => 'uploads/product/' . $imageName,
                    ]);
                }
            }

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
        $product = Product::with ('images')->where('id', $id)->first();
        return view('admin.products.show', compact('product'));
    }

    public function userShow(string $id)
    {
        $product = Product::with ('images')->where('id', $id)->first();
        return view('user.show', compact('product'));
    }
}
