<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h2>Create Order</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="payment" class="form-label">Payment Method</label>
                <select name="payment" id="payment" class="form-control" required>
                    <option value="" disabled selected>Select a payment method</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="cash_on_delivery">Cash on Delivery</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Order</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
