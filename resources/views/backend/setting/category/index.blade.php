@extends('backend.layout.master')
@section('title', '📂 Manage Categories')
@section('p_menu-open','menu-open')
@section('p_active','active')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold">📋 Category Management </h2>
    <a href="{{ url('admin/category/create') }}" class="btn btn-primary mt-2 mb-2"><i class="fas fa-plus-circle"></i> Add Category</a>

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
            <h4>📂 Category List</h4>
        </div>

        <div class="table-responsive p-3">
            <table class="table table-hover align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th>🔢 No.</th>
                        <th>🏷️ Category Name</th>
                        <th>🔗 Slug</th>
                        <th>📊 Status</th>
                        <th>⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $key => $item)
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
                            <button type="button" class="btn btn-info btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#categoryModal" data-category="{{ json_encode($item) }}">
                                <i class="fas fa-eye"></i> 👁️ View
                            </button>

                            <a href="{{ url('admin/category/'.$item->id.'/edit') }}" class="btn btn-warning btn-sm"><i class="far fa-edit"></i> ✏️ Edit</a>
                            <form action="{{ url('admin/category/'.$item->id) }}" method="POST" class="d-inline delete-form">
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

<!-- Category Info Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="categoryModalLabel">📂 Category Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Category Name</th>
                                <td id="categoryName"></td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td id="categorySlug"></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="categoryStatus"></td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td>
                                    <img id="categoryImage" src="" alt="Category Image" class="img-fluid rounded" style="max-height: 100px; display: none;">
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
        // Initialize modal
        const categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'), {
            backdrop: true
            , keyboard: true
        });

        // Close modal function
        function closeModal() {
            categoryModal.hide();
        }

        // Add event listener to close button
        document.querySelector('.btn-close').addEventListener('click', closeModal);
        document.querySelector('.btn-secondary').addEventListener('click', closeModal);

        // Properly handle modal hide event
        document.getElementById('categoryModal').addEventListener('hidden.bs.modal', function() {
            // Reset modal content when hidden
            document.getElementById('categoryName').textContent = '';
            document.getElementById('categorySlug').textContent = '';
            document.getElementById('categoryStatus').textContent = '';
            document.getElementById('categoryImage').style.display = 'none';
            document.getElementById('categoryImage').src = '';
        });

        // View button functionality
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                const categoryData = JSON.parse(this.getAttribute('data-category'));

                // Set basic info
                document.getElementById('categoryName').textContent = categoryData.name;
                document.getElementById('categorySlug').textContent = categoryData.slug;
                document.getElementById('categoryStatus').textContent = categoryData.is_active ? '✅ Active' : '❌ Inactive';

                // Set image
                const categoryImage = document.getElementById('categoryImage');
                if (categoryData.image) {
                    categoryImage.src = "{{ asset('storage/') }}/" + categoryData.image;
                    categoryImage.style.display = 'block';
                } else {
                    categoryImage.style.display = 'none';
                }

                // Show modal
                categoryModal.show();
            });
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
