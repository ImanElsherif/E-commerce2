<?php

// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // View the user's cart
    public function index()
    {
        $userid = Auth::id();
        $cart = Cart::where('user_id', $userid)->with('items')->first();
        return view('cart.index', compact('cart'));
    }

    // Add a product to the cart
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Check if the requested quantity is available
        if ($request->quantity > $product->stock_quantity) {
            return redirect()->back()->withErrors(['error' => 'Not enough stock available.']);
        }
        $userid = Auth::id();
        $cart = Cart::where('user_id', $userid)->with('items')->first();

        // If no cart exists for the user, create one
        if (!$cart) {
            $cart = Cart::create(['user_id' => Auth::id()]);
        }

        // Add the product to the cart
        $cart->addProduct($product, $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Update the quantity of a product in the cart
    public function update(Request $request, $itemId)
{
    $userid = Auth::id();
    $cart = Cart::where('user_id', $userid)->first();

    if (!$cart) {
        return redirect()->route('cart.index')->withErrors(['error' => 'Cart not found.']);
    }

    // Retrieve the cart item by its ID
    $cartItem = $cart->items()->where('id', $itemId)->first();

    if (!$cartItem) {
        return redirect()->route('cart.index')->withErrors(['error' => 'Cart item not found.']);
    }

    // Check if the requested quantity is available
    if ($request->quantity > $cartItem->product->stock_quantity) {
        return redirect()->back()->withErrors(['error' => 'Not enough stock available.']);
    }

    // Update the quantity
    $cartItem->update(['quantity' => $request->quantity]);

    return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
}


    // Complete the order (check stock and reduce quantity)
    public function checkout()
    {
        $userid = Auth::id();
        $cart = Cart::where('user_id', $userid)->first();

        if (!$cart) {
            return redirect()->route('cart.index')->withErrors(['error' => 'Your cart is empty!']);
        }

        // Check if stock is available for all items
        if (!$cart->isStockAvailable()) {
            return redirect()->route('cart.index')->withErrors(['error' => 'Not enough stock for some items.']);
        }


        return redirect()->route('orders.create')->with('success', 'Order created successfully!');
    }
    public function delete($itemId)
{
    $userid = Auth::id();
    $cart = Cart::where('user_id', $userid)->first();

    if (!$cart) {
        return redirect()->route('cart.index')->withErrors(['error' => 'Cart not found.']);
    }

    $cartItem = $cart->items()->where('id', $itemId)->first();

    if (!$cartItem) {
        return redirect()->route('cart.index')->withErrors(['error' => 'Cart item not found.']);
    }

    // Delete the cart item
    $cartItem->delete();

    return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
}

}

