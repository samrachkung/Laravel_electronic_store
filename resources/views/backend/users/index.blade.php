@extends('backend.layout.master')
@section('title', '👥 Manage Users')
@section('user_menu-open','menu-open')
@section('user_active','active')


@section('content')
<div class="container py-4">
    <h2 class="fw-bold">👥 User Management</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary mt-2 mb-2">
        <i class="fas fa-user-plus"></i> Add User
    </a>

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
            <h4>📋 Users List</h4>
        </div>

        <div class="table-responsive p-3">
            <table class="table table-hover align-middle">
                <thead class="table-info text-center">
                    <tr>
                        <th>🆔 ID</th>
                        <th>👤 Name</th>
                        <th>📧 Email</th>
                        <th>🎭 Roles</th>
                        <th>✅ Status</th>
                        <th>⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="text-center">
                        <td>{{ $user->id }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                            <span class="badge bg-dark">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($user->active)
                            <span class="badge bg-success">🟢 Active</span>
                            @else
                            <span class="badge bg-danger">🔴 Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                <i class="far fa-edit"></i> ✏️ Edit
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-btn">
                                    <i class="fas fa-trash-alt"></i> 🗑️ Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center text-muted">
                        <td colspan="6">🚫 No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- <div class="card-footer d-flex justify-content-center">
            {{ $users->links() }}
        </div> --}}
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');

                Swal.fire({
                    title: "❗ Are you sure?"
                    , text: "You won’t be able to revert this!"
                    , icon: "warning"
                    , showCancelButton: true
                    , confirmButtonColor: "#d33"
                    , cancelButtonColor: "#3085d6"
                    , confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: "Deleted!"
                            , text: "User has been deleted."
                            , icon: "success"
                        });
                    }
                });
            });
        });
    });

</script>
@endsection
