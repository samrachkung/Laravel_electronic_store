@extends('backend.layout.master')
@section('title', 'Order Details')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Order #{{ $order->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.income') }}">Income</a></li>
                    <li class="breadcrumb-item active">Order Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order Information</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Order ID</th>
                                <td>#{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Order Date</th>
                                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-{{ getStatusColor($order->status) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Expected Arrival</th>
                                <td>{{ $order->expected_arrival ? $order->expected_arrival->format('M d, Y') : 'Not specified' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Payment Information</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Payment Method</th>
                                <td>{{ $order->payment_method ?? 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Payment Status</th>
                                <td>{{ $order->payment_status ?? 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Currency</th>
                                <td>{{ $order->currency ?? 'USD' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order Items</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ format_currency($item->price) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ format_currency($item->price * $item->quantity) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Subtotal</th>
                                    <td>{{ format_currency($order->grand_total - $order->shipping_amount) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3">Shipping</th>
                                    <td>{{ format_currency($order->shipping_amount) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <td>{{ format_currency($order->grand_total) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update Status</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
