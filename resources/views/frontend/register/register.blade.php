@extends('frontend.layout.master')
@section('title','Register')
@section('content')
   <div class="container" id="login">
    <div class="row">
        <div class="col-md-5 py-3 py-md-0" id="side1">
            <h3 class="text-center text-white">Register</h3>
        </div>
        <div class="col-md-7 py-3 py-md-0" id="side2">
            <form action="{{ route('registerUser') }}" method="POST" id="registerForm">
                @csrf
                <h3 class="text-center">Create Account</h3>
                <div class="input2 text-center">
                <input type="name" name="name" placeholder="Name">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                </div>
                <button type="submit" id="btn-register">
                    SIGN UP
                 </button>
            </form>
        </div>
    </div>
   </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let form = this;
        let formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '{{ url("/") }}';
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }).catch(error => console.error('Error:', error));
    });
</script>
@endsection
