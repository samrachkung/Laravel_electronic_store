@extends('backend.layout.master')
@section('title', '🛍️ Manage Products')
@section('pro_menu-open','menu-open')
@section('pro_active','active')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold">🛒 Product Management</h2>
    <a href="{{ url('admin/product/create') }}" class="btn btn-primary mt-2 mb-2"><i class="fas fa-plus-circle"></i> Add Product</a>

    @if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                title: '✅ Success!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    <div class="card shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📋 Product List</h4>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-success">
                        <tr>
                            <th class="text-center" style="min-width: 50px">🔢 No.</th>
                            <th style="min-width: 200px">📦 Product Name</th>
                            <th style="min-width: 150px">📂 Category</th>
                            <th style="min-width: 200px">📝 Description</th>
                            <th style="min-width: 100px">💲 Price</th>
                            <th class="text-center" style="min-width: 250px">⚙️ Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category->name ?? '🚫 No Category' }}</td>
                            <td>{{ Str::limit($item->description, 50) }}</td>
                            <td><span class="badge bg-info fs-6">${{ number_format($item->price, 2) }}</span></td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center flex-wrap">
                                    <button type="button" class="btn btn-info btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#productModal" data-product="{{ json_encode($item) }}" data-category="{{ $item->category->name ?? 'No Category' }}">
                                        <i class="fas fa-eye"></i> View
                                    </button>

                                    <a href="{{ url('admin/product/'.$item->id.'/edit') }}" class="btn btn-warning btn-sm">
                                        <i class="far fa-edit"></i> Edit
                                    </a>

                                    <form action="{{ url('admin/product/'.$item->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Product Info Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="productModalLabel">📦 Product Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>📝 Basic Information</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Product Name</th>
                                <td id="productName"></td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td id="productCategory"></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td id="productPrice"></td>
                            </tr>
                            <tr>
                                <th>Stock</th>
                                <td id="productStock"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>🖼️ Product Image</h5>
                        <div class="text-center">
                            <img id="productImage" src="" alt="Product Image" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h5>📄 Description</h5>
                        <div id="productDescription" class="p-3 bg-light rounded"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize modal
        const productModal = new bootstrap.Modal(document.getElementById('productModal'), {
            backdrop: true
            , keyboard: true
        });

        // View button functionality
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productData = JSON.parse(this.getAttribute('data-product'));
                const categoryName = this.getAttribute('data-category');

                // Set basic info
                document.getElementById('productName').textContent = productData.name;
                document.getElementById('productCategory').textContent = categoryName;
                document.getElementById('productPrice').textContent = '$' + parseFloat(productData.price).toFixed(2);
                document.getElementById('productStock').textContent = productData.quantity || 'N/A';
                document.getElementById('productDescription').textContent = productData.description;

                // Set image
                const productImage = document.getElementById('productImage');
                if (productData.image) {
                    productImage.src = "{{ asset('/uploads/image/') }}/" + productData.image;

                    productImage.style.display = 'block';
                } else {
                    productImage.src = "{{ asset('path/to/default-product-image.jpg') }}";
                    productImage.style.display = 'block';
                }

                // Show modal
                productModal.show();
            });
        });

        // Close modal functionality
        document.querySelector('.btn-close').addEventListener('click', function() {
            productModal.hide();
        });

        document.querySelector('.modal-footer .btn-secondary').addEventListener('click', function() {
            productModal.hide();
        });

        // Delete button functionality
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');

                Swal.fire({
                    title: "❗ Are you sure?"
                    , text: "You won't be able to revert this!"
                    , icon: "warning"
                    , showCancelButton: true
                    , confirmButtonColor: "#d33"
                    , cancelButtonColor: "#3085d6"
                    , confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Properly handle modal hide event
        document.getElementById('productModal').addEventListener('hidden.bs.modal', function() {
            // Reset modal content when hidden
            document.getElementById('productName').textContent = '';
            document.getElementById('productCategory').textContent = '';
            document.getElementById('productPrice').textContent = '';
            document.getElementById('productSku').textContent = '';
            document.getElementById('productStock').textContent = '';
            document.getElementById('productDescription').textContent = '';
            document.getElementById('productImage').src = '';
        });

        @if(session('flash_message'))
        toastr.success("{{ session('flash_message') }}");
        @endif

        @if(session('info'))
        toastr.info("{{ session('info') }}");
        @endif

        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif
    });
</script>

@endsection
