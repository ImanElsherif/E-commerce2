@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-center">All Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Address</th>
                    <th>Payment</th>
                    <th>Items</th>
                    <th>Total Quantity</th>
                    <th>Total Price</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    @php
                        $totalPrice = 0; // Initialize total price for the order
                    @endphp
                    <tr>
                        <td class="align-middle">{{ $order->id }}</td>
                        <td class="align-middle">{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="align-middle">{{ $order->address }}</td>
                        <td class="align-middle">{{ $order->payment }}</td>
                        <td class="align-middle">
                            <ul class="list-unstyled mb-0">
                                @foreach($order->orderItems as $item)
                                    @php
                                        $itemTotal = $item->product->price * $item->quantity;
                                        $totalPrice += $itemTotal; // Add the item total to the order's total price
                                    @endphp
                                    <li>
                                        <strong>{{ $item->product->name ?? 'Product Deleted' }}</strong>
                                        (x{{ $item->quantity }}) - 
                                       ${{ number_format($item->product->price, 2) }}                                   </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="align-middle">{{ $order->orderItems->sum('quantity') }}</td>
                        <td class="align-middle">${{ number_format($totalPrice, 2) }}</td>
                        <td class="align-middle">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
