@extends('frontend.layout.master')
@section('title','Contact')
@section('content')


<section class="container py-5">
    <h2 class="text-center mb-4">📞 Contact Us</h2>
    <div class="row">
        <div class="col-lg-6">
            <h4>Get in Touch</h4>
            <p>If you have any questions, feel free to reach out to us!</p>
            <ul class="list-unstyled">
                <li><strong>📍 Address:</strong> PCP Vilage, Sankat Tekthla, Phnom Penh 12000</li>
                <li><strong>📞 Phone:</strong> +8558897666322</li>
                <li><strong>✉️ Email:</strong> support@electronicshop.com</li>
            </ul>
        </div>
        <div class="col-lg-6">
            <h4>Contact Form</h4>
            <form action="#" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea class="form-control" id="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Send Message</button>
            </form>
        </div>
    </div>
</section>

<!-- Optional: Google Maps Embed -->
<div class="container py-4 text-center">
    <h5>Find Us on the Map</h5>
    <iframe src="https://maps.google.com/maps?q=PCP Village, Sankat Tekthla, Phnom Penh 12000&t=&z=13&ie=UTF8&iwloc=&output=embed"
    width="100%" height="300" style="border:0;" allowfullscreen></iframe>
</div>

@endsection
