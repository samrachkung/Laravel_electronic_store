<!-- top navbar -->
<div class="top-navbar">
    <p>WELCOME TO OUR SHOP</p>
    <div class="icons">
        @if(Auth::check())
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn" style="border: none; background: none;">
                    <img src="{{asset('frontend/images/register.png')}}" alt="" width="18px"> Logout
                </button>
            </form>
        @else
            <a class="nav-link" href="{{ route('login') }}"><img src="{{asset('frontend/images/register.png')}}" alt="" width="18px"> Login</a>
        @endif
        <a class="nav-link" href="{{url('/register')}}"><img src="{{asset('frontend/images/register.png')}}" alt="" width="18px"> Register</a>
    </div>
</div>
<!-- top navbar -->
<nav class="navbar navbar-expand-lg" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{url('/')}}" id="logo"><span id="span1"></span>ELectronic Shop <span></span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span><img src="{{asset('frontend/images/menu.png')}}" alt="" width="30px"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{url('/')}}"><i class="bi bi-house"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/shop')}}"><i class="bi bi-bag-dash"></i> Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/about')}}"><i class="bi bi-file-earmark-person"></i> About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/contact')}}"><i class="bi bi-person-lines-fill"></i> Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href=""><i class="bi bi-person-circle"></i>
                        {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/cart')}}"><i class="bi bi-cart-check"></i> Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/myorder')}}"><i class="bi bi-basket"></i> My Order</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
