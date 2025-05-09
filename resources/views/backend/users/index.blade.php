@extends('backend.layout.master')
@section('title', '👥 Manage Users')
@section('user_menu-open','menu-open')
@section('user_active','active')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold">👥 User Management</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-2 mb-2">
        <i class="fas fa-user-plus"></i> Add User
    </a>

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
                            <button type="button" class="btn btn-info btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#userModal" data-user="{{ json_encode($user) }}" data-roles="{{ $user->roles->pluck('name')->join(', ') }}" data-created="{{ optional($user->created_at)->format('M d, Y h:i A') ?? 'N/A' }}" data-updated="{{ optional($user->updated_at)->format('M d, Y h:i A') ?? 'N/A' }}">
                                <i class="fas fa-eye"></i> 👁️ View
                            </button>

                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                <i class="far fa-edit"></i> ✏️ Edit
                            </a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
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
    </div>
</div>

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="userModalLabel">👤 User Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>📝 Basic Information</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>User ID</th>
                                <td id="userId"></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td id="userName"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td id="userEmail"></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="userStatus"></td>
                            </tr>
                            <tr>
                                <th>Roles</th>
                                <td id="userRoles"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>🕒 Timestamps</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Created At</th>
                                <td id="userCreated"></td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td id="userUpdated"></td>
                            </tr>
                        </table>
                        <div class="text-center mt-3">
                            <img id="userAvatar" src="" alt="User Avatar" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const userModal = new bootstrap.Modal(document.getElementById('userModal'));

        // Function to close modal
        const closeModal = () => {
            userModal.hide();
        };

        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userData = JSON.parse(this.getAttribute('data-user'));
                const roles = this.getAttribute('data-roles');
                const created = this.getAttribute('data-created');
                const updated = this.getAttribute('data-updated');

                document.getElementById('userId').textContent = userData.id;
                document.getElementById('userName').textContent = userData.name;
                document.getElementById('userEmail').textContent = userData.email;
                document.getElementById('userStatus').textContent = userData.active ? '🟢 Active' : '🔴 Inactive';
                document.getElementById('userRoles').textContent = roles;
                document.getElementById('userCreated').textContent = created;
                document.getElementById('userUpdated').textContent = updated;

                const userAvatar = document.getElementById('userAvatar');
                if (userData.avatar) {
                    userAvatar.src = "{{ asset('storage/') }}/" + userData.avatar;
                } else {
                    userAvatar.src = "https://ui-avatars.com/api/?name=" + encodeURIComponent(userData.name) + "&background=random";
                }

                userModal.show();
            });
        });

        // Add event listener for close button
        document.querySelector('.btn-close').addEventListener('click', closeModal);
        document.querySelector('.modal-footer .btn-secondary').addEventListener('click', closeModal);

        document.querySelectorAll('.delete-btn').forEach(button => {
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

        document.getElementById('userModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('userId').textContent = '';
            document.getElementById('userName').textContent = '';
            document.getElementById('userEmail').textContent = '';
            document.getElementById('userStatus').textContent = '';
            document.getElementById('userRoles').textContent = '';
            document.getElementById('userCreated').textContent = '';
            document.getElementById('userUpdated').textContent = '';
            document.getElementById('userAvatar').src = '';
        });

        @if(session('success'))
        Swal.fire({
            icon: 'success'
            , title: '✅ Success!'
            , text: '{{ session('success') }}'
            , confirmButtonText: 'OK'
        });
        @endif

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

