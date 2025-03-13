<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronic Shop</title>
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- bootstrap links -->
    <!-- fonts links -->
    <link href='https://fonts.googleapis.com/css?family=JetBrains Mono' rel='stylesheet'>
    <!-- fonts links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <!-- navbar -->
    @include('frontend.layout.navbar')
    <!-- navbar -->

    <!-- home content -->
    @yield('content')
    <!-- footer -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>Electronic Shop</h3>
                        <p>
                            PCP Vilage, Sankat Tekthla,<br>
                            Phnom Penh <br>
                            Cambodia<br>
                        </p>
                        <strong>Phone:</strong> +8558897666322 <br>
                        <strong>Email:</strong> ecnshop@gmail.com <br>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Usefull Links</h4>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Terms of service</a></li>
                            <li><a href="#">Privacy policey</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>

                        <ul>
                            <li><a href="#">PS 5</a></li>
                            <li><a href="#">Computer</a></li>
                            <li><a href="#">Gaming Laptop</a></li>
                            <li><a href="#">Mobile Phone</a></li>
                            <li><a href="#">Gaming Gadget</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">

                        <p>Our Social Networks</p>

                        <div class="socail-links mt-3">
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-skype"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <hr>
        <div class="container py-4">
            <div class="copyright">
                &copy; Copyright <strong><span>Electronic Shop</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by <a href="#">KungSamRach</a>
            </div>
        </div>
    </footer>
    <!-- footer -->

    <a href="#" class="arrow"><i><img src="{{asset('frontend/images/arrow.png')}}" alt=""></i></a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
