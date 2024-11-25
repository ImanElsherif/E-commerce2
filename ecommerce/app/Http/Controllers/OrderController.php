<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::all();
        return view('admin.order.index', compact('orders'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
{
    $userid = Auth::id();
    $cart = Cart::where('user_id', $userid)->with('items.product')->first();

    // Ensure the cart exists
    if (!$cart) {
        return redirect()->back()->withErrors(['cart_id' => 'Cart not found for the current user.']);
    }

    $request->validate([
        'address' => 'required|string|max:255',
        'payment' => 'required|string|max:255',
    ]);

    // Create the order
    $order = Order::create([
        'user_id' => $userid,
        'address' => $request->address,
        'payment' => $request->payment,
    ]);

    // Save cart items as order items
    foreach ($cart->items as $cartItem) {
        $order->orderItems()->create([
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
        ]);
    }

    // Reduce product stock
    foreach ($cart->items as $cartItem) {
        $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
    }

    // Delete the cart and its items
    $cart->items()->delete();
    $cart->delete();

    return redirect()->route('user.dashboard')->with('success', 'Order created successfully!');
}

    
}
