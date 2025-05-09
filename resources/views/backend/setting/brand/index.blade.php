@extends('backend.layout.master')
@section('title', '🏷️ Manage Brands')
@section('p_menu-open','menu-open')
@section('b_active','active')

@section('content')

<div class="container py-4">
    <h2 class="fw-bold">🏢 Brand Management </h2>
    <a href="{{ url('admin/brand/create') }}" class="btn btn-primary mt-2 mb-2"><i class="fas fa-plus-circle"></i> Add Brand</a>

    @if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success'
                , title: '✅ Success!'
                , text: '{{ session('
                success ') }}'
                , confirmButtonText: 'OK'
            });
        });

    </script>
    @endif

    <div class="card shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4>🏷️ Brand List</h4>
        </div>

        <div class="table-responsive p-3">
            <table class="table table-hover align-middle">
                <thead class="table-info text-center">
                    <tr>
                        <th>🔢 No.</th>
                        <th>🏷️ Brand Name</th>
                        <th>🔗 Slug</th>
                        <th>📊 Status</th>
                        <th>⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $key => $item)
                    <tr class="text-center">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->slug }}</td>
                        <td>
                            @if($item->is_active)
                            <span class="badge bg-success">✅ Active</span>
                            @else
                            <span class="badge bg-danger">❌ Inactive</span>
                            @endif
                        </td>
                        <td>
                            <!-- View Button trigger modal -->
                            <button type="button" class="btn btn-info btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#brandModal" data-brand="{{ json_encode($item) }}">
                                <i class="fas fa-eye"></i> 👁️ View
                            </button>

                            <a href="{{ url('/admin/brand/'.$item->id.'/edit') }}" class="btn btn-warning btn-sm"><i class="far fa-edit"></i> ✏️ Edit</a>
                            <form action="{{ url('/admin/brand/'.$item->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-btn">
                                    <i class="fas fa-trash-alt"></i> 🗑️ Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Brand Info Modal -->
<div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="brandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="brandModalLabel">🏷️ Brand Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Brand Name</th>
                                <td id="brandName"></td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td id="brandSlug"></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="brandStatus"></td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td>
                                    <img id="brandImage" src="" alt="Brand Image" class="img-fluid rounded" style="max-height: 100px;">
                                </td>
                            </tr>
                        </table>
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
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const viewButtons = document.querySelectorAll('.view-btn');
        const brandModal = new bootstrap.Modal(document.getElementById('brandModal'));
        const closeButton = document.querySelector('.btn-close');
        const modalCloseButton = document.querySelector('.modal-footer .btn-secondary');

        // Delete button functionality
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

        // View button functionality
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const brandData = JSON.parse(this.getAttribute('data-brand'));

                // Set basic info
                document.getElementById('brandName').textContent = brandData.name;
                document.getElementById('brandSlug').textContent = brandData.slug;
                document.getElementById('brandStatus').textContent = brandData.is_active ? '✅ Active' : '❌ Inactive';

                // Set image
                const brandImage = document.getElementById('brandImage');
                if (brandData.image) {
                    brandImage.src = "{{ asset('storage/') }}/" + brandData.image;
                    brandImage.style.display = 'block';
                } else {
                    brandImage.style.display = 'none';
                }

                // Show modal
                brandModal.show();
            });
        });

        // Close modal functionality
        closeButton.addEventListener('click', function() {
            brandModal.hide();
        });

        modalCloseButton.addEventListener('click', function() {
            brandModal.hide();
        });

        // Close modal when clicking outside
        document.getElementById('brandModal').addEventListener('click', function(e) {
            if (e.target === this) {
                brandModal.hide();
            }
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
