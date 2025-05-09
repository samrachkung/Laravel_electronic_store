@extends('frontend.layout.master')
@section('title', 'Checkout')
@section('content')

<section class="container py-5">
    <h2 class="text-center mb-4 fw-bold">🛍️ Secure Checkout</h2>

    <div class="row">
        <!-- Billing Details -->
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-person-circle"></i> Billing Details</h5>
                    <form id="payment-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control p-2 shadow-sm" name="first_name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control p-2 shadow-sm" name="last_name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control p-2 shadow-sm" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control p-2 shadow-sm" name="phone" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Shipping Address <span class="text-danger">*</span></label>
                            <textarea class="form-control p-2 shadow-sm" name="address" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control p-2 shadow-sm" name="city" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control p-2 shadow-sm" name="state" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control p-2 shadow-sm" name="zip_code" required>
                        </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-success"><i class="bi bi-bag-check"></i> Order Summary</h5>
                    <ul class="list-group mb-3">
                        @foreach ($cartItems as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <div class="col-md-2 text-center">
                                <img src="{{ asset('/uploads/image/'.$item->product->image) }}" class="img-fluid rounded shadow-sm" style="max-width: 80px;" />
                            </div>
                            <div>
                                <h6 class="my-0 fw-semibold">{{ $item->product->name }}</h6>
                                <small class="text-muted">Qty: {{ $item->quantity }}</small>
                            </div>
                            <span class="fw-bold text-dark">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                        </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <strong>Total:</strong>
                            <strong class="text-danger fs-5" id="grand-total">${{ number_format($cartTotal, 2) }}</strong>
                        </li>
                    </ul>

                    <!-- Stripe Payment -->
                    <h5 class="fw-bold mb-3 text-info"><i class="bi bi-credit-card"></i> Secure Payment with Stripe</h5>
                    <button type="button" class="btn btn-primary w-100 py-2 fw-bold shadow-sm hover-scale" id="checkout-button">
                        <i class="bi bi-cart-check"></i> Pay with Stripe
                    </button>

                    <div class="text-center mt-4">
                        <a href="{{ url('/shop') }}" class="btn btn-outline-secondary fw-semibold">
                            ← Back to Shop
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
    document.getElementById("checkout-button").addEventListener("click", function() {
        fetch("{{ route('frontend.checkout.placeOrder') }}", {

                method: "POST"
                , headers: {
                    "Content-Type": "application/json"
                    , "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
                , body: JSON.stringify({
                    first_name: document.querySelector("[name='first_name']").value
                    , last_name: document.querySelector("[name='last_name']").value
                    , email: document.querySelector("[name='email']").value
                    , phone: document.querySelector("[name='phone']").value
                    , address: document.querySelector("[name='address']").value
                    , city: document.querySelector("[name='city']").value
                    , state: document.querySelector("[name='state']").value,
                    zip_code: document.querySelector("[name='zip_code']").value,
                    payment_method: "stripe"
                , })
            , })
            .then(response => response.json())
            .then(data => {
                if (data.url) {
                    window.location.href = data.url; // Redirect to Stripe Checkout
                } else {
                    alert("Payment failed. Try again!");
                }
            })
            .catch(error => console.error("Error:", error));
    });

</script>

@endsection
