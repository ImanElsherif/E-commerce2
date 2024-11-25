@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Receipt Summary (Left) -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm rounded">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Your Receipt</h3>
                    @if($cart && $cart->items->count() > 0)
                        <div class="receipt">
                            <div class="receipt-header text-center mb-4">
                                <h4>Thank You for Shopping with Us!</h4>
                                <p>Your Purchase Receipt</p>
                            </div>

                            <table class="table table-borderless mb-4">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @foreach ($cart->items as $cartItem)
                                        @php
                                            $itemTotal = $cartItem->product->price * $cartItem->quantity;
                                            $subtotal += $itemTotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $cartItem->product->name }}</td>
                                            <td>{{ $cartItem->quantity }}</td>
                                            <td>${{ number_format($cartItem->product->price, 2) }}</td>
                                            <td>${{ number_format($itemTotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @php
                                $shippingFee = 10; // Placeholder for shipping fee
                                $tax = $subtotal * 0.05; // 5% tax
                                $total = $subtotal + $shippingFee + $tax;
                            @endphp

                            <div class="receipt-footer mt-4">
                                <p><strong>Subtotal:</strong> ${{ number_format($subtotal, 2) }}</p>
                                <p><strong>Shipping Fee:</strong> ${{ number_format($shippingFee, 2) }}</p>
                                <p><strong>Tax (5%):</strong> ${{ number_format($tax, 2) }}</p>
                                <hr>
                                <p><strong>Total:</strong> ${{ number_format($total, 2) }}</p>
                                <p class="text-center text-muted">Please confirm your details before placing the order.</p>
                            </div>
                        </div>
                    @else
                        <p>Your cart is empty! Please add items to your cart before proceeding.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Details Form (Right) -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm rounded mb-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Order Details</h3>
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="address" class="form-label">Delivery Address</label>
                            <textarea name="address" id="address" class="form-control" rows="4" placeholder="Enter your delivery address..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="payment" class="form-label">Payment Method</label>
                            <select name="payment" id="payment" class="form-select" required>
                                <option value="" disabled selected>Select a payment method</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                            </select>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-lg w-100 fas fa-wallet" style="background-color: #43707b; color: white; border: none;"> Confirm  Payment</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Buttons for Going Back to Cart or Shopping -->
            <div class="text-center mt-4">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('cart.index') }}" style="background-color: #43707b; color: white; border: none;" class="btn btn-outline-secondary btn-lg w-48">
                        <i class="fas fa-arrow-left"></i> Go Back to Cart
                    </a>
                    <a href="{{ url('/') }}" style="background-color: #43707b; color: white; border: none;" class="btn btn-outline-primary btn-lg w-48">
                        <i class="fas fa-shopping-bag"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
