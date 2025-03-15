@extends('frontend.layout.master')
@section('title', 'My Orders')
@section('content')
<section style="background-color: #f8f9fa;">
    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12">
                @if ($orders->count() > 0)
                @foreach ($orders as $order)
                <div class="card card-stepper mb-4 shadow-sm" style="border-radius: 16px; background: #ffffff;">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">📄 INVOICE <span class="text-primary font-weight-bold">#{{ $invoice_code }}{{ $order->id }}</span>
                            </h5>
                        </div>
                        <hr>
                        <!-- Cool Progress Bar -->
                        <div class="progress-container mb-4">
                            <div class="progress" style="background: #e9ecef; border-radius: 50px; height: 12px; position: relative;">
                                <div class="progress-bar" style="width: {{ $order->status == 'new' ? '25%' : ($order->status == 'processing' ? '50%' : ($order->status == 'shipped' ? '75%' : '100%')) }}; height: 100%; border-radius: 50px; background: linear-gradient(90deg, #4e54c8, #8f94fb); transition: width 0.6s ease;">
                                </div>
                                <div class="progress-icons" style="position: absolute; top: -20px; left: 0; right: 0; display: flex; justify-content: space-between;">
                                    <div class="step {{ in_array($order->status, ['new', 'processing', 'shipped', 'delivered']) ? 'active' : '' }}">
                                        🛒</div>
                                    <div class="step {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'active' : '' }}">
                                        📦</div>
                                    <div class="step {{ in_array($order->status, ['shipped', 'delivered']) ? 'active' : '' }}">
                                        🚚</div>
                                    <div class="step {{ $order->status == 'delivered' ? 'active' : '' }}">🏠
                                    </div>
                                </div>
                            </div>
                        </div>
                        <style>
                            .progress-icons .step {
                                width: 30px;
                                height: 30px;
                                line-height: 30px;
                                text-align: center;
                                border-radius: 50%;
                                background: #ddd;
                                transition: background 0.6s;
                            }
                            .progress-icons .step.active {
                                background: #4e54c8;
                                color: white;
                            }
                        </style>
                        <!-- Order Status Icons -->
                        <div class="d-flex justify-content-between mb-4">
                            <div class="d-lg-flex align-items-center">
                                <span class="fs-2">📋</span>
                                <div class="ms-2">
                                    <p class="fw-bold mb-1">Order</p>
                                    <p class="fw-bold mb-0">Processed</p>
                                </div>
                            </div>
                            <div class="d-lg-flex align-items-center">
                                <span class="fs-2">📦</span>
                                <div class="ms-2">
                                    <p class="fw-bold mb-1">Order</p>
                                    <p class="fw-bold mb-0">Shipped</p>
                                </div>
                            </div>
                            <div class="d-lg-flex align-items-center">
                                <span class="fs-2">🚚</span>
                                <div class="ms-2">
                                    <p class="fw-bold mb-1">Order</p>
                                    <p class="fw-bold mb-0">En Route</p>
                                </div>
                            </div>
                            <div class="d-lg-flex align-items-center">
                                <span class="fs-2 {{ $order->status == 'delivered' ? 'text-success' : '' }}">🏠</span>
                                <div class="ms-2">
                                    <p class="fw-bold mb-1">Order</p>
                                    <p class="fw-bold mb-0">Arrived</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Order Details -->
                        <h5 class="mb-3">📌 Order Details</h5>
                        <hr>
                        <p class="mb-0">📅 Your Order Date :
                            <strong>{{ \Carbon\Carbon::parse($order->expected_arrival)->format('Y-m-d') ?? 'TBD' }}</strong>
                        </p>
                        <br>
                        <p class="mb-0">📅 Expected Arrival:
                            <strong>{{ \Carbon\Carbon::parse($order->expected_arrival)->addDay(4)->format('Y-m-d') ?? 'TBD' }}</strong>
                        </p>
                        <br>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p><strong>Total Price:</strong> 💲{{ number_format($order->grand_total, 2) }}</p>
                        <p><strong>Shipping Method:</strong> {{ $order->shipping_method ?? 'Card' }}</p>
                        <hr>
                        <!-- Shipping Address -->
                        <h5 class="mt-4">📍 Shipping Address</h5>
                        <hr>
                        @if ($order->address)
                        <p>👤 {{ $order->address->first_name }} {{ $order->address->last_name }}</p>
                        <p>🏠 {{ $order->address->street_address }}, {{ $order->address->city }},
                            {{ $order->address->state }} - {{ $order->address->zip_code }}</p>
                        <p>📞 <strong>Phone:</strong> {{ $order->address->phone }}</p>
                        @else
                        <p>No address available.</p>
                        @endif
                        <hr>
                        <!-- Ordered Products -->
                        <h5 class="mt-4">🛍️ Products</h5>
                        <hr>
                        <ul class="list-group">
                            @foreach ($order->items as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item->product->name }} (x{{ $item->quantity }})
                                <span>💲{{ number_format($item->total_amount, 2) }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('order.printInvoice', $order->id) }}" class="btn btn-primary mt-5">📄 Print / Download Invoice</a>
                    </div>
                </div>
                @endforeach
                @else
                <p class="text-center">❌ No orders found.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
