@extends('frontend.layout.master')
@section('title', 'Home')
@section( 'content')

<section class="home">
    <div class="content">
        <h1> <span>Electronic Products</span>
            <br>
            Up To <span id="span2">50%</span> Off
        </h1>
        <p>{{ __('messages.discover_latest_gadgets') ?? 'Discover the latest electronic gadgets and accessories at unbeatable prices.' }}


            <br>{{ __('messages.sub_discover') ?? 'Shop now and enjoy exclusive deals and discounts.' }}

        </p>
        <div class="btn"><button>{{__('messages.shop_now')}}</button></div>


    </div>
    <div class="img">
        <img src="{{asset('frontend/images/background.jpg')}}" alt="">
    </div>
</section>
<!-- home content -->
<div class="container" id="newslater">
    <h3 class="text-center">Search Electronic Product That You Want.</h3>
    <div class="input text-center">
        <input type="text" placeholder="Enter Product Name..">
        <button id="subscribe">Search</button>
    </div>
</div>
<!-- product cards -->
<div class="container" id="product-cards">
    <h1 class="text-center"><i class="bi bi-box"></i> {{ __('messages.products') }}</h1>
    <div class="row" style="margin-top: 30px;">
        @foreach ($products as $product)
            <div class="col-md-3 py-3">
                <div class="card">
                    <img src="{{ asset('/uploads/image/'.$product->image) }}" alt="{{ $product->product_name }}">
                    <div class="card-body">
                        <h3 class="text-center">{{ $product->product_name }}</h3>
                        <p class="text-center">{{ $product->description ?? 'No description available.' }}</p>
                        <div class="rating-stars mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <span class="text-muted ms-2">(4.0)</span>
                        </div>
                        <h2>${{ number_format($product->price, 2) }}
                            {{-- <button class="btn btn-primary"><i class="bi bi-heart"></i></button> --}}
                            <a href="{{ url('/shop') }}" class="btn btn-primary"><i class="bi bi-cart-fill"></i>{{__('messages.shop_now')}}</a>

                        </h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<br>
<!-- product cards -->
<!-- other cards -->
<div class="container" id="other-cards">
    <div class="row">
        <div class="col-md-6 py-3 py-md-0">
            <div class="card">
                <img src="{{asset('frontend/images/c1.png')}}" alt="">
                <div class="card-img-overlay">
                    <h3>Best Laptop</h3>
                    <h5>Latest Collection</h5>
                    <p>Up To 50% Off</p>
                     <a href="{{ url('/shop') }}" class="btn btn-primary"><i class="bi bi-cart-fill"></i>{{__('messages.shop_now')}}</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 py-3 py-md-0">
            <div class="card">
                <img src="{{asset('frontend/images/c2.png')}}" alt="">
                <div class="card-img-overlay">
                    <h3>Best Headphone</h3>
                    <h5>Latest Collection</h5>
                    <p>Up To 50% Off</p>
                     <a href="{{ url('/shop') }}" class="btn btn-primary"><i class="bi bi-cart-fill"></i>{{__('messages.shop_now')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- other cards -->

<!-- banner -->
<section class="banner">
    <div class="content">
        <h1> <span>Electronic Gadget</span>
            <br>
            Up To <span id="span2">50%</span> Off
        </h1>
        <p>Discover the latest electronic gadgets and accessories at unbeatable prices.
            <br>Shop now and enjoy exclusive deals and discounts.
        </p>
        <div class="btn"><button>Shop Now</button></div>

    </div>
    <div class="img">
        <img src="{{asset('frontend/images/image1.png')}}" alt="">
    </div>
</section>
<!-- banner -->
<!-- Optional: Google Maps Embed -->

<!-- product cards -->
<div class="container" id="product-cards">
    {{-- <h1 class="text-center"><i class="bi bi-box"></i></h1> --}}
    <div class="row" style="margin-top: 30px;">
        @foreach ($products2 as $product)
            <div class="col-md-3 py-3">
                <div class="card">
                    <img src="{{ asset('/uploads/image/'.$product->image) }}"" alt="{{ $product->product_name }}">
                    <div class="card-body">
                        <h3 class="text-center">{{ $product->product_name }}</h3>
                        <p class="text-center">{{ $product->description ?? 'No description available.' }}</p>
                        <div class="rating-stars mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                            <span class="text-muted ms-2">(4.0)</span>
                        </div>
                        <h2>${{ number_format($product->price, 2) }}
                            {{-- <button class="btn btn-primary"><i class="bi bi-heart"></i></button> --}}
                            <a href="{{ url('shop/' . $product->slug) }}" class="btn btn-primary"><i class="bi bi-cart-fill"></i>{{__('messages.shop_now')}}</a>
                        </h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<br>
<!-- product cards -->
<div class="container py-4 text-center">
    <h5>Find Us on the Map</h5>
    <iframe src="https://maps.google.com/maps?q=PCP Village, Sankat Tekthla, Phnom Penh 12000&t=&z=13&ie=UTF8&iwloc=&output=embed"
    width="100%" height="300" style="border:0;" allowfullscreen></iframe>
</div>

<!-- offer -->
<div class="container" id="offer">
    <div class="row">
        <div class="col-md-3 py-3 py-md-0">
            <i class="bi bi-cart-fill"></i>
            <h3>Free Shipping</h3>
            <p>On order over $1000</p>
        </div>
        <div class="col-md-3 py-3 py-md-0">
            <i class="fa-solid fa-rotate-left"></i>
            <h3>Free Returns</h3>
            <p>Within 30 days</p>
        </div>
        <div class="col-md-3 py-3 py-md-0">
            <i class="fa-solid fa-truck"></i>
            <h3>Fast Delivery</h3>
            <p>World Wide</p>
        </div>
        <div class="col-md-3 py-3 py-md-0">
            <i class="fa-solid fa-thumbs-up"></i>
            <h3>Big choice</h3>
            <p>Of products</p>
        </div>
    </div>
</div>
<!-- offer -->

@endsection
