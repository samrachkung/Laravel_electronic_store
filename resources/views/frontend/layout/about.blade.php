@extends('frontend.layout.master')
@section('title', 'About Us')
@section('content')

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">About Our Electronic Store</h2>
        <p class="text-muted">Your one-stop destination for the latest gadgets and electronics.</p>
    </div>

    <div class="row align-items-center">
        <div class="col-lg-6 mb-4">
            <img src="{{asset('frontend/images/background.jpg')}}" alt="About Us" class="img-fluid rounded shadow-lg">
        </div>
        <div class="col-lg-6">
            <h3 class="fw-bold">Who We Are</h3>
            <p class="text-muted">Founded in 2020, we are a leading retailer specializing in high-quality electronics. Our mission is to provide top-notch products at unbeatable prices, ensuring customer satisfaction with every purchase.</p>
            <ul class="list-unstyled">
                <li><i class="fas fa-check-circle text-primary"></i> Premium Quality Electronics</li>
                <li><i class="fas fa-check-circle text-primary"></i> Competitive Prices</li>
                <li><i class="fas fa-check-circle text-primary"></i> Excellent Customer Service</li>
                <li><i class="fas fa-check-circle text-primary"></i> Fast & Secure Shipping</li>
            </ul>
        </div>
    </div>
</section>

<section class="bg-light py-5">
    <div class="container text-center">
        <h3 class="fw-bold text-primary">Why Choose Us?</h3>
        <p class="text-muted">We are dedicated to providing the best shopping experience.</p>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-lg p-4">
                    <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                    <h5>Fast Delivery</h5>
                    <p class="text-muted">Get your products delivered in record time.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-lg p-4">
                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    <h5>24/7 Support</h5>
                    <p class="text-muted">Our team is here to assist you anytime.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-lg p-4">
                    <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                    <h5>Secure Payments</h5>
                    <p class="text-muted">Your transactions are 100% safe with us.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5 text-center">
    <h3 class="fw-bold text-primary">Join Our Community</h3>
    <p class="text-muted">Follow us on social media and stay updated with the latest deals and offers.</p>
    <div class="mt-3">
        <a href="#" class="btn btn-primary me-2"><i class="fab fa-facebook"></i> Facebook</a>
        <a href="#" class="btn btn-danger me-2"><i class="fab fa-instagram"></i> Instagram</a>
        <a href="#" class="btn btn-info"><i class="fab fa-twitter"></i> Twitter</a>
    </div>
</section>

@endsection
