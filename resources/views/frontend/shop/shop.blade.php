@extends('frontend.layout.master')
@section('title','Shop')
@section('content')

<div class="container py-5">
    <div id="cart-items" style="display: none;"></div>

    <!-- Product Detail Modal -->
    <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="productDetailContent">
                    <!-- Product details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Product Collection</h4>
        <div class="d-flex gap-2 align-items-center">
            <span class="text-muted">Sort by:</span>
            <select class="form-select" name="sort" onchange="this.form.submit()">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Update</option>
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Update</option>
            </select>
        </div>
    </div>

    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5 class="fw-bold">Filters</h5>
                <form method="GET" action="{{url('/shop')}}">
                    <div class="filter-group mb-3">
                        <h6 class="mb-2">Categories</h6>
                        @foreach ($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}" {{ request('category') && in_array($category->id, request('category')) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    </div>
                    <div class="filter-group mb-3">
                        <h6 class="mb-2">Price Range</h6>
                        <input type="range" class="form-range" min="0" max="1000" value="{{ request('max_price', 1000) }}" id="priceRange">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">$0</span>
                            <span class="text-muted">$<span id="maxPrice">{{ request('max_price', 1000) }}</span></span>
                        </div>
                        <input type="hidden" name="min_price" value="0">
                        <input type="hidden" name="max_price" id="maxPriceInput" value="{{ request('max_price', 1000) }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
            <div class="row g-4">
                @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card product-card border-0 shadow-sm">
                        <div class="position-relative overflow-hidden">
                            <img src="{{ asset('/uploads/image/'.$product->image) }}" alt="{{ $product->product_name }}" class="product-image w-100 rounded-top">
                        </div>
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2">{{ $product->category_name }}</span>
                            <h6 class="fw-bold">{{ $product->product_name }}</h6>
                            <span class="text-primary fw-bold">${{ number_format($product->price, 2) }}</span>
                            <div class="d-flex align-items-center mt-2">
                                <button class="btn btn-outline-secondary btn-sm" onclick="decreaseQuantity(this)">-</button>
                                <input type="text" class="form-control text-center mx-2" value="1" style="width: 50px;">
                                <button class="btn btn-outline-secondary btn-sm" onclick="increaseQuantity(this)">+</button>
                            </div>
                            <div class="d-flex gap-2 mt-2">
                                <button class="btn btn-success flex-fill" onclick="addToCart('{{ $product->id }}', this)">Add to Cart</button>
                                <button class="btn btn-outline-primary" onclick="showProductDetails('{{ $product->id }}')" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let priceRange = document.getElementById('priceRange');
        let maxPriceSpan = document.getElementById('maxPrice');
        let maxPriceInput = document.getElementById('maxPriceInput');

        priceRange.addEventListener('input', function() {
            maxPriceSpan.innerText = this.value;
            maxPriceInput.value = this.value;
        });
    });

    function increaseQuantity(button) {
        let input = button.previousElementSibling;
        input.value = parseInt(input.value) + 1;
    }

    function decreaseQuantity(button) {
        let input = button.nextElementSibling;
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    function addToCart(productId, button) {
        let quantityInput = button.closest('.card-body').querySelector('input');
        let quantity = quantityInput.value;

        fetch("{{ url('/cart/add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: "Success!",
                        text: data.message,
                        icon: "success",
                        timer: 900,
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false
                    });
                    updateCartView();
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: data.message,
                        icon: "error",
                        timer: 1000,
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: "Error!",
                    text: "Something went wrong. Please try again.",
                    icon: "error",
                    timer: 1000,
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false
                });
            });
    }

    function showProductDetails(productId) {
        // Show loading state
        document.getElementById('productDetailContent').innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading product details...</p>
            </div>
        `;

        // Fetch product details
        fetch(`/api/products/${productId}`)
            .then(response => response.json())
            .then(product => {
                // Format the modal content
                const modalContent = `
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ asset('/uploads/image/') }}/${product.image}"
                                 alt="${product.product_name}"
                                 class="img-fluid rounded">
                        </div>
                        <div class="col-md-6">
                            <h4 class="fw-bold">${product.product_name}</h4>
                            <span class="badge bg-primary mb-2">${product.category_name}</span>
                            <span class="badge bg-secondary mb-2">${product.brand_name}</span>

                            <h5 class="text-primary my-3">$${parseFloat(product.price).toFixed(2)}</h5>

                            <p class="text-muted">${product.description || 'No description available.'}</p>

                            <div class="product-info mt-4">
                                <p><strong>Availability:</strong>
                                    <span class="${product.quantity > 0 ? 'text-success' : 'text-danger'}">
                                        ${product.quantity > 0 ? 'In Stock' : 'Out of Stock'}
                                    </span>
                                </p>
                                <p><strong>:</strong> ${product.id}</p>
                                ${product.is_featured ? '<p><span class="badge bg-warning">Featured Product</span></p>' : ''}
                            </div>
                        </div>
                    </div>
                `;

                document.getElementById('productDetailContent').innerHTML = modalContent;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('productDetailContent').innerHTML = `
                    <div class="alert alert-danger text-center">
                        <p>Failed to load product details. Please try again.</p>
                    </div>
                `;
            });

        // Show the modal
        const modal = new bootstrap.Modal(document.getElementById('productDetailModal'));
        modal.show();
    }

    function updateCartView() {
        fetch("{{ url('/cart/view') }}")
            .then(response => response.json())
            .then(data => {
                let cartContainer = document.getElementById("cart-items");
                cartContainer.innerHTML = "";
                data.items.forEach(item => {
                    cartContainer.innerHTML += `<div class='row'>
                        <div class='col-md-3'><img src='${item.image}' class='img-fluid'></div>
                        <div class='col-md-6'><p>${item.name}</p><p>${item.price}</p></div>
                        <div class='col-md-3'>Quantity: ${item.quantity}</div>
                    </div>`;
                });
            }).catch(error => console.error('Error:', error));
    }
</script>

@endsection
