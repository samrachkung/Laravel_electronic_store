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
                        <input type="hidden" name="selected_items" id="selected-items" value="{{ implode(',', $selectedIds) }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control p-2 shadow-sm" name="first_name"
                                    value="{{ old('first_name', Auth::user()->first_name ?? '') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control p-2 shadow-sm" name="last_name"
                                    value="{{ old('last_name', Auth::user()->last_name ?? '') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control p-2 shadow-sm" name="email"
                                value="{{ old('email', Auth::user()->email ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control p-2 shadow-sm" name="phone"
                                value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Shipping Address <span class="text-danger">*</span></label>
                            <textarea class="form-control p-2 shadow-sm" name="address" rows="3" required>{{ old('address', Auth::user()->address ?? '') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control p-2 shadow-sm" name="city"
                                    value="{{ old('city', Auth::user()->city ?? '') }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" class="form-control p-2 shadow-sm" name="state"
                                    value="{{ old('state', Auth::user()->state ?? '') }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control p-2 shadow-sm" name="zip_code"
                                    value="{{ old('zip_code', Auth::user()->zip_code ?? '') }}" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-success"><i class="bi bi-bag-check"></i> Order Summary</h5>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        @if (!empty($selectedIds))
                            Checking out {{ count($cartItems) }} selected item(s)
                        @else
                            Checking out all {{ count($cartItems) }} cart items
                        @endif
                    </div>
                    <ul class="list-group mb-3">
                        @foreach ($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <img src="{{ asset('/uploads/image/' . $item->product->image) }}"
                                            class="img-fluid rounded shadow-sm" style="max-width: 60px;" />
                                    </div>
                                    <div>
                                        <h6 class="my-0 fw-semibold">{{ $item->product->name }}</h6>
                                        <small class="text-muted">Qty: {{ $item->quantity }} ×
                                            ${{ number_format($item->product->price, 2) }}</small>
                                    </div>
                                </div>
                                <span class="fw-bold text-dark">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <strong>Total:</strong>
                            <strong class="text-danger fs-5">${{ number_format($cartTotal, 2) }}</strong>
                        </li>
                    </ul>

                    <!-- Payment Method Selection -->
                    <h5 class="fw-bold mb-3 text-info"><i class="bi bi-credit-card"></i> Select Payment Method</h5>

                    <div class="payment-methods mb-4">
                        <div class="form-check mb-3 p-3 border rounded">
                            <input class="form-check-input" type="radio" name="payment_method" id="stripe" value="stripe" checked>
                            <label class="form-check-label w-100" for="stripe">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-credit-card text-primary fs-3 me-3"></i>
                                    <div>
                                        <strong>Credit/Debit Card (Stripe)</strong>
                                        <small class="d-block text-muted">Pay securely with your card</small>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="form-check mb-3 p-3 border rounded">
                            <input class="form-check-input" type="radio" name="payment_method" id="khqr" value="khqr">
                            <label class="form-check-label w-100" for="khqr">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-qr-code text-success fs-3 me-3"></i>
                                    <div>
                                        <strong>KHQR (Bakong)</strong>
                                        <small class="d-block text-muted">Scan QR with Bakong or any banking app</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary w-100 py-2 fw-bold shadow-sm hover-scale" id="checkout-button">
                        <i class="bi bi-cart-check"></i> Proceed to Payment
                    </button>

                    <div class="text-center mt-4">
                        <a href="{{ route('frontend.cart') }}" class="btn btn-outline-secondary fw-semibold">
                            ← Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById("checkout-button").addEventListener("click", function() {
        const button = this;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Processing...';
        button.disabled = true;

        const urlParams = new URLSearchParams(window.location.search);
        const selectedFromUrl = urlParams.getAll('selected[]');
        const selectedItems = selectedFromUrl.length > 0 ? selectedFromUrl : [];

        const requiredFields = ['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'state', 'zip_code'];
        let isValid = true;

        requiredFields.forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            Swal.fire("Error!", "Please fill in all required fields.", "error");
            button.innerHTML = originalText;
            button.disabled = false;
            return;
        }

        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        fetch("{{ route('frontend.checkout.placeOrder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    first_name: document.querySelector("[name='first_name']").value,
                    last_name: document.querySelector("[name='last_name']").value,
                    email: document.querySelector("[name='email']").value,
                    phone: document.querySelector("[name='phone']").value,
                    address: document.querySelector("[name='address']").value,
                    city: document.querySelector("[name='city']").value,
                    state: document.querySelector("[name='state']").value,
                    zip_code: document.querySelector("[name='zip_code']").value,
                    selected_items: selectedItems,
                    payment_method: paymentMethod
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.url) {
                    // Stripe payment
                    window.location.href = data.url;
                } else if (data.redirect_url) {
                    // KHQR payment
                    window.location.href = data.redirect_url;
                } else {
                    throw new Error(data.error || "Payment failed to initialize.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire("Error!", error.message || "Something went wrong. Please try again.", "error");
                button.innerHTML = originalText;
                button.disabled = false;
            });
    });
</script>

<style>
    .spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .payment-methods .form-check-input:checked + label {
        background-color: #f8f9fa;
        border-color: #0d6efd !important;
    }

    .payment-methods .form-check {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-methods .form-check:hover {
        background-color: #f8f9fa;
    }
</style>

@endsection
