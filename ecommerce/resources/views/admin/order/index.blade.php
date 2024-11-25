@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">All Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Address</th>
                <th>Payment</th>
                <th>Items</th>
                <th>Total Quantity</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'Guest' }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->payment }}</td>
                    <td>
                        <ul>
                            @foreach($order->orderItems as $item)
                                <li>
                                    {{ $item->product->name ?? 'Product Deleted' }} (x{{ $item->quantity }})
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $order->orderItems->sum('quantity') }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
