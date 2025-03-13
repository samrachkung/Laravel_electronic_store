@extends('backend.layout.master')
@section('title', '🚀 Manage Orders')

@section('o_menu-open','menu-open')
@section('o_active','active')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold">📦 Order Management Dashboard</h2>

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

    <div class="table-responsive mt-4 shadow-lg rounded-4 overflow-hidden">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>🔢 INVOICE ID</th>
                    <th>👤 User</th>
                    <th>💰 Total</th>
                    <th>💳 Payment</th>
                    <th>📊 Status</th>
                    <th>⚙️ Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="text-center">
                        <td>#{{$invoice_code}}{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? '👥 Guest' }}</td>
                        <td><span class="badge bg-success">${{ number_format($order->grand_total, 2) }}</span></td>
                        <td>
                            <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('order.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>🆕 New</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>⚙️ Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>📦 Delivered</option>
                                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>❌ Canceled</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('order.destroy', $order->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">🗑 Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(event) {
        event.preventDefault();
        Swal.fire({
            title: '❗ Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }
</script>
@endsection
