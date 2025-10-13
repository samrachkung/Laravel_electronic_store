@extends('frontend.layout.master')
@section('title', 'Shopping Cart')
@section('content')
    <section class="container py-5">
        <h2 class="mb-4 text-center">🛒 Your Shopping Cart</h2>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5><i class="bi bi-cart3"></i> Cart Items (<span id="cart-count">{{ $cartItems->count() }}</span>)</h5>
                            @if($cartItems->count() > 0)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select-all">
                                <label class="form-check-label" for="select-all">
                                    Select All
                                </label>
                            </div>
                            @endif
                        </div>

                        <div id="cart-items">
                            @if($cartItems->count() > 0)
                                @foreach ($cartItems as $item)
                                    <div class="cart-item row align-items-center py-3 border-bottom"
                                        data-id="{{ $item->id }}">
                                        <div class="col-md-1 text-center">
                                            <input class="form-check-input item-checkbox" type="checkbox"
                                                   value="{{ $item->id }}" data-price="{{ $item->product->price }}"
                                                   data-quantity="{{ $item->quantity }}">
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <img src="{{ asset('/uploads/image/' . $item->product->image) }}"
                                                class="img-fluid rounded shadow-sm" style="max-width: 80px;" />
                                        </div>
                                        <div class="col-md-3">
                                            <h6 class="fw-bold">{{ $item->product->name }}</h6>
                                            <p class="mb-1 text-muted">${{ number_format($item->product->price, 2) }} each</p>
                                        </div>
                                        <div class="col-md-3 text-center d-flex justify-content-center">
                                            <button class="btn btn-sm btn-outline-secondary quantity-decrease"
                                                data-id="{{ $item->id }}"><i class="bi bi-bag-dash"></i></button>
                                            <input type="number"
                                                class="form-control quantity-update text-center mx-2 border-0 bg-light"
                                                value="{{ $item->quantity }}" min="1" data-id="{{ $item->id }}"
                                                style="width: 60px;">
                                            <button class="btn btn-sm btn-outline-secondary quantity-increase"
                                                data-id="{{ $item->id }}"><i class="bi bi-bag-plus"></i></button>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <p class="fw-bold total-price text-primary" id="total-{{ $item->id }}">
                                                ${{ number_format($item->product->price * $item->quantity, 2) }}
                                            </p>
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <button class="btn btn-sm btn-outline-danger remove-cart"
                                                data-id="{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-cart-x display-1 text-muted"></i>
                                    <h4 class="text-muted mt-3">Your cart is empty</h4>
                                    <a href="{{ route('frontend.shop') }}" class="btn btn-primary mt-3">Start Shopping</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-lg border-0 rounded-4 sticky-top">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-cart-check-fill"></i> Order Summary</h5>

                        @if($cartItems->count() > 0)
                            <p class="text-muted">Subtotal (All Items): <span class="float-end" id="grand-total">
                                ${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
                            </span></p>

                            <p class="text-muted">Selected Items: <span class="float-end" id="selected-total">$0.00</span></p>
                            <p class="text-muted">Selected Items Count: <span class="float-end" id="selected-count">0</span></p>
                            <hr>

                            <button id="checkout-selected" class="btn btn-primary w-100 mb-2" disabled>
                                <i class="bi bi-bag-check-fill"></i> Checkout Selected Items
                            </button>

                            <a href="{{ route('frontend.checkout.index') }}" class="btn btn-outline-primary w-100 mb-2">
                                <i class="bi bi-bag-check-fill"></i> Checkout All Items
                            </a>
                        @else
                            <div class="text-center py-3">
                                <p class="text-muted">No items in cart</p>
                            </div>
                        @endif

                        <div class="text-center mt-3">
                            <a href="{{ route('frontend.shop') }}" class="btn btn-outline-secondary">
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
            let selectedItems = new Set();
            let selectedTotal = 0;
            let selectedCount = 0;

            // Select All functionality
            $('#select-all').change(function() {
                const isChecked = $(this).is(':checked');
                $('.item-checkbox').prop('checked', isChecked);

                if (isChecked) {
                    $('.item-checkbox').each(function() {
                        const itemId = $(this).val();
                        selectedItems.add(itemId);
                    });
                } else {
                    selectedItems.clear();
                }

                updateSelectedSummary();
                updateCheckoutButton();
            });

            // Individual checkbox functionality
            $(document).on('change', '.item-checkbox', function() {
                const itemId = $(this).val();
                const isChecked = $(this).is(':checked');

                if (isChecked) {
                    selectedItems.add(itemId);
                } else {
                    selectedItems.delete(itemId);
                    $('#select-all').prop('checked', false);
                }

                updateSelectedSummary();
                updateCheckoutButton();
            });

            // Update selected items summary
            function updateSelectedSummary() {
                selectedTotal = 0;
                selectedCount = 0;

                $('.item-checkbox:checked').each(function() {
                    const price = parseFloat($(this).data('price'));
                    const quantity = parseInt($(this).data('quantity'));
                    selectedTotal += price * quantity;
                    selectedCount++;
                });

                $('#selected-total').text('$' + selectedTotal.toFixed(2));
                $('#selected-count').text(selectedCount);
            }

            // Update checkout button state
            function updateCheckoutButton() {
                const checkoutBtn = $('#checkout-selected');
                if (selectedItems.size > 0) {
                    checkoutBtn.prop('disabled', false);
                } else {
                    checkoutBtn.prop('disabled', true);
                }
            }

            // Checkout selected items
            $('#checkout-selected').click(function() {
                if (selectedItems.size === 0) {
                    Swal.fire('Error!', 'Please select at least one item to checkout.', 'error');
                    return;
                }

                // Convert Set to Array and create URL parameters
                const selectedArray = Array.from(selectedItems);
                const params = new URLSearchParams();
                selectedArray.forEach(id => params.append('selected[]', id));

                window.location.href = "{{ route('frontend.checkout.index') }}?" + params.toString();
            });

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
                    url: "{{ route('frontend.cart.update') }}",
                    method: "POST",
                    data: {
                        id: cartId,
                        quantity: quantity,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update individual item total
                            $("#total-" + cartId).text("$" + parseFloat(response.newTotal).toFixed(2));

                            // Update grand total
                            $("#grand-total").html(`<strong>$${parseFloat(response.grandTotal).toFixed(2)}</strong>`);

                            // Update quantity data attribute for selected items calculation
                            const checkbox = $(`.item-checkbox[value="${cartId}"]`);
                            if (checkbox.length) {
                                checkbox.data('quantity', quantity);

                                // If this item is selected, update selected total
                                if (checkbox.is(':checked')) {
                                    updateSelectedSummary();
                                }
                            }
                        } else {
                            Swal.fire("Error!", response.message || "Could not update cart.", "error");
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire("Error!", "Something went wrong. Please try again.", "error");
                    }
                });
            }

            // Remove cart item
            $(document).on("click", ".remove-cart", function() {
                var cartId = $(this).data("id");
                var button = $(this);
                button.prop("disabled", true);

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to undo this action!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, remove it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('frontend.cart.remove') }}", {
                            id: cartId,
                            _token: "{{ csrf_token() }}"
                        }, function(response) {
                            if (response.success) {
                                // Remove from selected items if present
                                selectedItems.delete(cartId.toString());

                                // Remove the item from DOM
                                $(".cart-item[data-id='" + cartId + "']").fadeOut(500, function() {
                                    $(this).remove();

                                    // Update grand total
                                    $("#grand-total").html(
                                        `<strong>$${parseFloat(response.grandTotal).toFixed(2)}</strong>`
                                    );

                                    // Update cart count
                                    var currentCount = parseInt($("#cart-count").text());
                                    $("#cart-count").text(currentCount - 1);

                                    // Update selected summary
                                    updateSelectedSummary();
                                    updateCheckoutButton();

                                    // If no items left, reload page
                                    if (currentCount - 1 === 0) {
                                        location.reload();
                                    }
                                });
                                Swal.fire("Removed!", "Product removed from cart.", "success");
                            } else {
                                button.prop("disabled", false);
                                Swal.fire("Error!", response.message || "Could not remove item.", "error");
                            }
                        }).fail(function() {
                            button.prop("disabled", false);
                            Swal.fire("Error!", "Something went wrong. Please try again.", "error");
                        });
                    } else {
                        button.prop("disabled", false);
                    }
                });
            });
        });
    </script>
@endsection
