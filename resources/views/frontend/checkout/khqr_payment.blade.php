@extends('frontend.layout.master')
@section('title', 'KHQR Payment')
@section('content')

<div class="khqr-payment-page">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="khqr-card">
                    <!-- Bakong Header -->
                    <div class="bakong-header">
                        <img src="https://play-lh.googleusercontent.com/ABNDYwddbqTFpqp809iNq3r9LjrE2qTZ8xFqWmc-iLfHe2vyPAPwZrN_4S1QCFaLDYE"
                             alt="Bakong Logo" class="bakong-logo">
                        <h1 class="bakong-title">បាគង</h1>
                        <p class="bakong-tagline">Scan. Pay. Done.</p>
                    </div>

                    <!-- QR Code Container -->
                    <div class="qr-frame">
                        <div class="qr-scanner-overlay">
                            <div class="scanner-corner top-left"></div>
                            <div class="scanner-corner top-right"></div>
                            <div class="scanner-corner bottom-left"></div>
                            <div class="scanner-corner bottom-right"></div>
                            <div id="qrcode" class="qr-inner"></div>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="payment-details">
                        <div class="detail-row">
                            <span class="detail-label">Order ID</span>
                            <span class="detail-value">#{{ $order->id }}</span>
                        </div>
                        <div class="detail-row amount-row">
                            <span class="detail-label">Amount</span>
                            <span class="detail-value amount">${{ number_format($order->grand_total, 2) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Expires in</span>
                            <span class="detail-value countdown" id="countdown"></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Status</span>
                            <span class="detail-value">
                                <span class="status-badge pending">
                                    <span class="status-dot"></span>
                                    Pending Payment
                                </span>
                            </span>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="instructions">
                        <h3 class="instruction-title">
                            <i class="bi bi-info-circle"></i>
                            How to Pay
                        </h3>
                        <ol class="instruction-list">
                            <li>Open your <strong>Bakong</strong> app or mobile banking app</li>
                            <li>Tap on <strong>Scan QR</strong></li>
                            <li>Scan the QR code above</li>
                            <li>Confirm the amount and complete payment</li>
                        </ol>
                    </div>

                    <!-- Payment Status Indicator -->
                    <div id="payment-status" class="payment-status">
                        <div class="status-spinner">
                            <div class="spinner"></div>
                        </div>
                        <p class="status-text">Waiting for payment confirmation...</p>
                        <small class="status-counter" id="check-counter">Checking...</small>
                    </div>

                    <!-- KHQR Badge -->
                    <div class="khqr-badge">
                        <span class="badge-text">Member of</span>
                        <svg class="khqr-logo" viewBox="0 0 100 30" xmlns="http://www.w3.org/2000/svg">
                            <text x="0" y="20" font-family="Arial, sans-serif" font-size="18" font-weight="bold" fill="#E31E24">KHQR</text>
                        </svg>
                    </div>

                    <!-- Back Button -->
                    <div class="action-buttons">
                        <a href="{{ route('frontend.cart') }}" class="btn-back">
                            <i class="bi bi-arrow-left"></i>
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include QR Code Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Generate QR Code from KHQR string
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: "{{ $order->khqr_code }}",
        width: 280,
        height: 280,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });

    // Countdown Timer
    @php
        $expiresAt = $order->khqr_expires_at instanceof \Carbon\Carbon
            ? $order->khqr_expires_at
            : \Carbon\Carbon::parse($order->khqr_expires_at);
    @endphp

    const expiresAt = new Date({{ $expiresAt->timestamp }} * 1000);
    const countdownElement = document.getElementById('countdown');

    function updateCountdown() {
        const now = new Date();
        const diff = expiresAt - now;

        if (diff <= 0) {
            countdownElement.textContent = 'Expired';
            clearInterval(countdownInterval);
            clearInterval(statusCheckInterval);

            Swal.fire({
                icon: 'warning',
                title: 'QR Code Expired',
                text: 'Your payment QR code has expired.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "{{ route('frontend.checkout.khqr.expired', ['order' => $order->id]) }}";
            });
            return;
        }

        const minutes = Math.floor(diff / 60000);
        const seconds = Math.floor((diff % 60000) / 1000);
        countdownElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }

    updateCountdown();
    const countdownInterval = setInterval(updateCountdown, 1000);

    // Check Payment Status
    const checkInterval = {{ config('khqr.check_interval_seconds', 3) }} * 1000;
    let statusCheckInterval;
    let checkCount = 0;

    function checkPaymentStatus() {
        checkCount++;
        document.getElementById('check-counter').textContent = `Checked ${checkCount} times...`;

        console.log('Checking payment status...', checkCount);

        fetch("{{ route('frontend.checkout.khqr.check', ['order' => $order->id]) }}")
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Payment status response:', data);

                if (data.status === 'paid') {
                    clearInterval(statusCheckInterval);
                    clearInterval(countdownInterval);

                    console.log('Payment confirmed! Redirecting...');

                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful!',
                        text: 'Your payment has been confirmed.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = data.redirect_url;
                    });
                } else if (data.status === 'expired') {
                    clearInterval(statusCheckInterval);
                    clearInterval(countdownInterval);
                    console.log('Payment expired!');
                    window.location.href = data.redirect_url;
                } else {
                    console.log('Payment still pending...');
                }
            })
            .catch(error => {
                console.error('Status check error:', error);
            });
    }

    // Start checking immediately, then every interval
    checkPaymentStatus();
    statusCheckInterval = setInterval(checkPaymentStatus, checkInterval);

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        clearInterval(statusCheckInterval);
        clearInterval(countdownInterval);
    });
</script>

<style>
    .khqr-payment-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
        padding: 20px 0;
    }

    .khqr-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    /* Bakong Header */
    .bakong-header {
        background: linear-gradient(135deg, #E31E24 0%, #C41E3A 100%);
        padding: 30px 20px 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .bakong-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .bakong-logo {
        width: 80px;
        height: 80px;
        margin: 0 auto 15px;
        display: block;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }

    .bakong-title {
        color: #ffffff;
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .bakong-tagline {
        color: rgba(255, 255, 255, 0.95);
        font-size: 18px;
        font-weight: 400;
        margin: 0;
        letter-spacing: 0.5px;
    }

    /* QR Frame */
    .qr-frame {
        padding: 30px;
        background: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .qr-scanner-overlay {
        position: relative;
        width: 320px;
        height: 320px;
        background: #f8f9fa;
        border-radius: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .scanner-corner {
        position: absolute;
        width: 30px;
        height: 30px;
        border: 3px solid #E31E24;
    }

    .scanner-corner.top-left {
        top: 10px;
        left: 10px;
        border-right: none;
        border-bottom: none;
        border-radius: 8px 0 0 0;
    }

    .scanner-corner.top-right {
        top: 10px;
        right: 10px;
        border-left: none;
        border-bottom: none;
        border-radius: 0 8px 0 0;
    }

    .scanner-corner.bottom-left {
        bottom: 10px;
        left: 10px;
        border-right: none;
        border-top: none;
        border-radius: 0 0 0 8px;
    }

    .scanner-corner.bottom-right {
        bottom: 10px;
        right: 10px;
        border-left: none;
        border-top: none;
        border-radius: 0 0 8px 0;
    }

    .qr-inner {
        display: flex;
        justify-content: center;
        align-items: center;
        background: white;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    #qrcode img,
    #qrcode canvas {
        margin: 0 auto;
        display: block;
        border-radius: 8px;
    }

    /* Payment Details */
    .payment-details {
        padding: 25px 30px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
    }

    .detail-value {
        color: #212529;
        font-size: 15px;
        font-weight: 600;
    }

    .amount-row .detail-value {
        color: #E31E24;
        font-size: 24px;
        font-weight: 700;
    }

    .countdown {
        font-family: 'Courier New', monospace;
        color: #E31E24;
        font-size: 18px;
        font-weight: 700;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .status-badge.pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #856404;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Instructions */
    .instructions {
        padding: 25px 30px;
        background: #ffffff;
    }

    .instruction-title {
        color: #212529;
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 15px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .instruction-title i {
        color: #E31E24;
    }

    .instruction-list {
        margin: 0;
        padding-left: 20px;
        color: #6c757d;
    }

    .instruction-list li {
        margin-bottom: 10px;
        font-size: 14px;
        line-height: 1.6;
    }

    .instruction-list strong {
        color: #E31E24;
        font-weight: 600;
    }

    /* Payment Status */
    .payment-status {
        padding: 20px 30px;
        text-align: center;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    .status-spinner {
        margin-bottom: 10px;
    }

    .spinner {
        width: 40px;
        height: 40px;
        margin: 0 auto;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #E31E24;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .status-text {
        color: #6c757d;
        font-size: 14px;
        margin: 0 0 5px 0;
    }

    .status-counter {
        color: #adb5bd;
        font-size: 12px;
    }

    /* KHQR Badge */
    .khqr-badge {
        padding: 15px 30px;
        text-align: center;
        background: #ffffff;
        border-top: 1px solid #e9ecef;
    }

    .badge-text {
        display: block;
        color: #6c757d;
        font-size: 11px;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .khqr-logo {
        width: 60px;
        height: auto;
    }

    /* Action Buttons */
    .action-buttons {
        padding: 20px 30px 30px;
        text-align: center;
        background: #ffffff;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 30px;
        background: #6c757d;
        color: #ffffff;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #5a6268;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Responsive */
    @media (max-width: 576px) {
        .khqr-payment-page {
            padding: 10px 0;
        }

        .bakong-logo {
            width: 60px;
            height: 60px;
        }

        .bakong-title {
            font-size: 24px;
        }

        .bakong-tagline {
            font-size: 16px;
        }

        .qr-frame {
            padding: 20px;
        }

        .qr-scanner-overlay {
            width: 280px;
            height: 280px;
        }

        .payment-details,
        .instructions,
        .action-buttons {
            padding: 20px;
        }

        .amount-row .detail-value {
            font-size: 20px;
        }
    }
</style>

@endsection
