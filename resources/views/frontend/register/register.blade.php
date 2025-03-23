@extends('frontend.layout.master')
@section('title','Register')
@section('content')

<style>
    #login {
        width: 100%;
        max-width: 900px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
        color: white;
    }

    #side1 {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
        padding: 50px;

    }

    #side2 {
        padding: 50px;
    }

    input {
        width: 100%;
        padding: 14px;
        margin-bottom: 15px;
        border: 1px solid rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.2);
        color: rgb(0, 0, 0);
        outline: none;
    }

    input::placeholder {
        color: rgba(0, 0, 0, 0.7);
    }

    #btn-login {
        width: 100%;
        background: linear-gradient(135deg, #ff7eb3, #ff758c);
        color: white;
        border: none;
        padding: 14px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: bold;
    }

    #btn-login:hover {
        background: linear-gradient(135deg, #ff758c, #ff7eb3);
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        #side1 {
            display: none;
        }
    }

</style>

   <div class="container" id="login">
    <div class="row">

        <div class="col-md-5 d-none d-md-flex" id="side1">
            <h2>Welcome!</h2>
            <p>Create new Account to continue your journey with us.</p>
        </div>

        <div class="col-md-7 py-3 py-md-0" id="side2">
            <form action="{{ route('registerUser') }}" method="POST" id="registerForm">
                @csrf
                <h3 class="text-center">Create Account</h3>
                <div class="text-center">
                <input type="name" name="name" placeholder="Name">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                </div>
                <button type="submit" id="btn-login">
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
