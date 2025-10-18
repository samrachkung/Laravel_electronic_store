@extends('frontend.layout.master')
@section('title', 'Forgot Password')
@section('content')

<style>
    /* Your existing styles remain the same */
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

    #btn-submit, #btn-verify, #btn-reset, #btn-resend {
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

    #btn-submit:hover, #btn-verify:hover, #btn-reset:hover, #btn-resend:hover {
        background: linear-gradient(135deg, #ff758c, #ff7eb3);
        transform: scale(1.05);
    }

    #btn-resend {
        background: linear-gradient(135deg, #667eea, #764ba2);
        margin-top: 10px;
    }

    #btn-resend:hover {
        background: linear-gradient(135deg, #764ba2, #667eea);
    }

    .otp-inputs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .otp-input {
        width: 50px !important;
        height: 50px;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        #side1 {
            display: none;
        }
    }
</style>

<div class="container mt-5" id="login">
    <div class="row">
        <div class="col-md-5 d-none d-md-flex" id="side1">
            <h2>Reset Password</h2>
            <p>Enter your email to reset your password.</p>
        </div>
        <div class="col-md-7" id="side2">
            <!-- Email Form -->
            <form id="emailForm" style="display: block;">
                @csrf
                <h3 class="text-center mb-4">Forgot Password</h3>
                <div>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <button type="submit" id="btn-submit">SEND OTP</button>
                <p class="text-center mt-3">
                    <a href="{{ route('frontend.login') }}" style="color: #ff758c; font-weight: bold;">Back to Login</a>
                </p>
            </form>

            <!-- OTP Verification Form -->
            <form id="otpForm" style="display: none;">
                @csrf
                <h3 class="text-center">Verify OTP</h3>
                <p class="text-center">Enter the 6-digit OTP sent to your email</p>

                <div class="otp-inputs">
                    <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 1)">
                    <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 2)">
                    <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 3)">
                    <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 4)">
                    <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 5)">
                    <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 6)">
                </div>
                <input type="hidden" name="otp" id="fullOtp">

                <button type="submit" id="btn-verify">
                    VERIFY OTP
                </button>
                <button type="button" id="btn-resend" onclick="resendPasswordOTP()">
                    RESEND OTP
                </button>
            </form>

            <!-- Password Reset Form -->
            <form id="passwordForm" style="display: none;">
                @csrf
                <h3 class="text-center">Set New Password</h3>
                <div>
                    <input type="password" name="password" placeholder="New Password" required>
                    <input type="password" name="password_confirmation" placeholder="Confirm New Password" required>
                </div>
                <button type="submit" id="btn-reset">
                    RESET PASSWORD
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function moveToNext(input, nextIndex) {
        const otpInputs = document.querySelectorAll('.otp-input');

        if (input.value.length === 1 && nextIndex < otpInputs.length) {
            otpInputs[nextIndex].focus();
        }

        updateFullOTP();
    }

    function updateFullOTP() {
        const otpInputs = document.querySelectorAll('.otp-input');
        let fullOtp = '';
        otpInputs.forEach(input => {
            fullOtp += input.value;
        });
        document.getElementById('fullOtp').value = fullOtp;
    }

    function resendPasswordOTP() {
        fetch('{{ route("frontend.password.resend-otp") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Email Form Submission
    document.getElementById('emailForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch('{{ route("frontend.password.send-otp") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('emailForm').style.display = 'none';
                document.getElementById('otpForm').style.display = 'block';
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // OTP Form Submission
    document.getElementById('otpForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch('{{ route("frontend.password.verify-otp") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('otpForm').style.display = 'none';
                document.getElementById('passwordForm').style.display = 'block';
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Password Form Submission
    document.getElementById('passwordForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch('{{ route("frontend.password.reset") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
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
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
