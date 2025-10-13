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
                            </div>
                            <div class="col-md-6">
                                <p><strong>Payment Status:</strong>
                                    <span class="badge bg-success">{{ ucfirst($order->payment_status) }}</span>
                                </p>
                                <p><strong>Order Status:</strong>
                                    <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('frontend.shop') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                        <a href="{{ route('frontend.myorder') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list-alt me-2"></i>View Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
