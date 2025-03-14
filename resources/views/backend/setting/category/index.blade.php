@extends('backend.layout.master')
@section('title', '📂 Manage Categories')
@section('p_menu-open','menu-open')
@section('p_active','active')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold">📋 Category Management Dashboard</h2>
    <a href="{{ url('/category/create') }}" class="btn btn-primary mt-2 mb-2"><i class="fas fa-plus-circle"></i> Add Category</a>

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
                                <a href="{{ url('category/'.$item->id.'/edit') }}" class="btn btn-warning btn-sm"><i class="far fa-edit"></i> ✏️ Edit</a>
                                <form action="{{ url('category/'.$item->id) }}" method="POST" class="d-inline delete-form">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');

                Swal.fire({
                    title: "❗ Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your category has been deleted.",
                            icon: "success"
                        });
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
