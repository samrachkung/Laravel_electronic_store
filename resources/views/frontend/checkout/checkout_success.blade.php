@extends('frontend.layout.master')
@section('title', 'Order Success')
@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="text-success mb-3">Payment Successful!</h2>
                    <p class="text-muted mb-4">Thank you for your order. Your payment has been processed successfully.</p>

                    @if(isset($order))
                    <div class="order-details bg-light p-4 rounded mb-4">
                        <h5 class="mb-3">Order Details</h5>
                        <div class="row text-start">
                            <div class="col-md-6">
                                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                                <p><strong>Order Total:</strong> ${{ number_format($order->grand_total, 2) }}</p>
                                @if($order->khqr_amount_khr)
                                <p><strong>Amount Paid:</strong> ៛{{ number_format($order->khqr_amount_khr) }} KHR</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <p><strong>Payment Method:</strong>
                                    <span class="badge bg-info text-capitalize">{{ $order->payment_method }}</span>
                                </p>
                                <p><strong>Payment Status:</strong>
                                    <span class="badge bg-success">{{ ucfirst($order->payment_status) }}</span>
                                </p>
                                <p><strong>Order Status:</strong>
                                    <span class="badge bg-primary">{{ ucfirst($order->status) }}</span>
                                </p>
                            </div>
                        </div>

                        @if($order->address)
                        <div class="mt-3 pt-3 border-top">
                            <h6 class="mb-2">Shipping Address:</h6>
                            <p class="mb-0">
                                {{ $order->address->first_name }} {{ $order->address->last_name }}<br>
                                {{ $order->address->street_address }}<br>
                                {{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->zip_code }}<br>
                                Phone: {{ $order->address->phone }}
                            </p>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        A confirmation email has been sent to <strong>{{ $order->user->email ?? 'your email' }}</strong>
                    </div>

                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('frontend.shop') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                        <a href="{{ route('frontend.myorder') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list-alt me-2"></i>View Orders
                        </a>
                        @if($order)
                        <a href="{{ route('frontend.order.printInvoice', $order->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-print me-2"></i>Print Invoice
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
