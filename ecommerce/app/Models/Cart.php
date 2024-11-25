<?php

// app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // Each cart has many cart items
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // A cart belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Add product to the cart, update quantity if already exists
    public function addProduct(Product $product, $quantity)
    {
        $cartItem = $this->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $this->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }
    }

    // Check if the cart contains enough stock for each item before checkout
    public function isStockAvailable()
    {
        foreach ($this->items as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                return false;
            }
        }
        return true;
    }

    // Update stock after completing the order
    public function completeOrder()
    {
        foreach ($this->items as $item) {
            $item->product->decrement('stock_quantity', $item->quantity);
        }
        $this->delete(); // Delete the cart after order completion
    }
}
