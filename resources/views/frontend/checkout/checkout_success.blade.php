@extends('frontend.layout.master')
@section('title', 'Order Successful')
@section('content')

<section class="container py-5 text-center">
    <div class="card shadow-lg border-0 rounded-4 p-4 mx-auto" style="max-width: 500px;">
        <div class="mb-4">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
        </div>
        <h2 class="fw-bold text-success">🎉 Thank You for Your Order!</h2>
        <p class="text-muted">Your order has been placed successfully.</p>
        <p class="fw-semibold">You'll receive a confirmation email shortly.</p>
        <a href="{{ url('/myorder') }}" class="btn btn-primary btn-lg mt-3 px-4 fw-semibold">
            <i class="bi bi-arrow-right-circle"></i> My Orders
        </a>
    </div>
</section>

@endsection
