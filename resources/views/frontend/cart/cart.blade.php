@extends('frontend.layout.master')
@section('title', 'Shopping Cart')
@section('content')

<section class="container py-5">
    <h2 class="mb-4 text-center">🛒 Your Shopping Cart</h2>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="mb-3"><i class="bi bi-cart3"></i> Cart Items (<span id="cart-count">{{ $cartItems->count() }}</span>)</h5>

                    <div id="cart-items">
                        @foreach ($cartItems as $item)
                        <div class="cart-item row align-items-center py-3 border-bottom" data-id="{{ $item->id }}">
                            <div class="col-md-2 text-center">
                                <img src="{{ asset('/uploads/image/'.$item->product->image) }}" class="img-fluid rounded shadow-sm" style="max-width: 80px;" />
                            </div>
                            <div class="col-md-4">
                                <h6 class="fw-bold">{{ $item->product->name }}</h6>
                                <p class="mb-1 text-muted">${{ number_format($item->product->price, 2) }} each</p>
                            </div>
                            <div class="col-md-3 text-center d-flex justify-content-center">
                                <button class="btn btn-sm btn-outline-secondary quantity-decrease" data-id="{{ $item->id }}"><i class="bi bi-bag-dash"></i></button>
                                <input type="number" class="form-control quantity-update text-center mx-2 border-0 bg-light" value="{{ $item->quantity }}" min="1" data-id="{{ $item->id }}" style="width: 60px;">
                                <button class="btn btn-sm btn-outline-secondary quantity-increase" data-id="{{ $item->id }}"><i class="bi bi-bag-plus"></i></button>
                            </div>
                            <div class="col-md-2 text-center">
                                <p class="fw-bold total-price text-primary" id="total-{{ $item->id }}">
                                    ${{ number_format($item->product->price * $item->quantity, 2) }}
                                </p>
                            </div>
                            <div class="col-md-1 text-center">
                                <button class="btn btn-sm btn-outline-danger remove-cart" data-id="{{ $item->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-lg border-0 rounded-4 sticky-top">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-cart-check-fill"></i> Order Summary</h5>
                    <p class="text-muted">Subtotal: <span class="float-end" id="grand-total">
                            ${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
                        </span></p>
                    <hr>
                    <a href="{{url('/checkout')}}" class="btn btn-outline-primary    w-100"><i class="bi bi-bag-check-fill"></i> Proceed to Checkout</a>
                    <div class="text-center mt-4">
                        <a href="{{ url('/shop') }}" class="btn btn-outline-primary">
                            ← Back to Shop
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Handle quantity increase
        $(document).on("click", ".quantity-increase", function() {
            var input = $(this).siblings(".quantity-update");
            var cartId = input.data("id");
            var newQuantity = parseInt(input.val()) + 1;
            input.val(newQuantity);
            updateCartQuantity(cartId, newQuantity);
        });

        // Handle quantity decrease
        $(document).on("click", ".quantity-decrease", function() {
            var input = $(this).siblings(".quantity-update");
            var cartId = input.data("id");
            var newQuantity = parseInt(input.val()) - 1;

            if (newQuantity < 1) newQuantity = 1;
            input.val(newQuantity);
            updateCartQuantity(cartId, newQuantity);
        });

        // Handle manual input change
        $(document).on("change", ".quantity-update", function() {
            var cartId = $(this).data("id");
            var newQuantity = parseInt($(this).val());

            if (newQuantity < 1 || isNaN(newQuantity)) {
                newQuantity = 1;
                $(this).val(1);
            }

            updateCartQuantity(cartId, newQuantity);
        });

        function updateCartQuantity(cartId, quantity) {
            $.ajax({
                url: "{{ route('frontend.cart.update') }}"

                , method: "POST"
                , data: {
                    id: cartId
                    , quantity: quantity
                    , _token: "{{ csrf_token() }}"
                }
                , success: function(response) {
                    if (response.success) {

                        $("#total-" + cartId).text("$" + parseFloat(response.newTotal).toFixed(2));


                        $("#grand-total").html(`<strong>$${parseFloat(response.grandTotal).toFixed(2)}</strong>`);
                    } else {
                        Swal.fire("Error!", response.message || "Could not update cart.", "error");
                    }
                }
                , error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire("Error!", "Something went wrong. Please try again.", "error");
                }
            });
        }

        function updateCartTotal() {
            let total = 0;
            $(".cart-item").each(function() {
                let price = parseFloat($(this).find(".total-price").text().replace("$", ""));
                if (!isNaN(price)) {
                    total += price;
                }
            });

            $("#grand-total").html(`<strong>$${total.toFixed(2)}</strong>`);
        }

        // Remove cart item
        $(document).on("click", ".remove-cart", function() {
            var cartId = $(this).data("id");
            var button = $(this);
            button.prop("disabled", true);

            Swal.fire({
                title: "Are you sure?"
                , text: "You won't be able to undo this action!"
                , icon: "warning"
                , showCancelButton: true
                , confirmButtonText: "Yes, remove it!"
                , cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ route('frontend.cart.remove') }}", {

                        id: cartId
                        , _token: "{{ csrf_token() }}"
                    }, function(response) {
                        if (response.success) {
                            $(".cart-item[data-id='" + cartId + "']").fadeOut(500, function() {
                                $(this).remove();
                                updateCartTotal();
                                window.location.reload();
                            });
                            Swal.fire("Removed!", "Product removed from cart.", "success");
                        } else {
                            button.prop("disabled", false);
                        }
                    });
                } else {
                    button.prop("disabled", false);
                }
            });
        });
    });

</script>


@endsection
