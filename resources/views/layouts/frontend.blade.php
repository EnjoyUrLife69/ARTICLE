<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>News HTML-5 Template </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets-front/img/favicon.ico') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets-front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-front/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-front/css/ticker-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-front/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-front/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-front/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-front/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-front/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-front/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-front/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-front/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-front/css/style.css') }}">
    <style>
        html {
            scroll-behavior: smooth;
        }

        .custom-dropdown-menu li:hover {
            background-color: #f8f9fa;
        }

        .custom-dropdown-item i {
            margin-right: 8px;
        }

        .weekly2-news-active {
            display: flex;
            flex-wrap: wrap;
            justify-content: left;
            gap: 15px;
        }

        .weekly2-single {
            max-width: 270px;
            flex: 1;
        }

        .weekly2-img img {
            width: 105%;
            height: 170px;
            object-fit: cover;
            border-radius: 10px;
        }

        #title-cardd {
            background-color: #FFFFFF;
            box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.2), 2px 2px 5px 1px rgba(0, 0, 0, 0.19);
            padding: 1rem;
        }

        #view {
            border-radius: 5%;
            box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.2), 2px 2px 5px 1px rgba(0, 0, 0, 0.19);
            text-align: center;
            justify-content: center;
            width: 20vh;
            height: 6vh;
        }

        #button {
            border-radius: 50%;
            box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.2), 2px 2px 5px 1px rgba(0, 0, 0, 0.19);
            text-align: center;
            justify-content: center;
            width: 6vh;
            height: 6vh;
            cursor: pointer;
        }

        #button:hover {
            transform: translateY(-5px);
            /* Loncat ke atas */
            box-shadow: 1px 4px 6px rgba(0, 0, 0, 0.2);
            /* Tambah efek bayangan */
        }
    </style>
    @yield('styles')
    <!-- BoxIcons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

</head>


<body>

    <!-- Preloader Start -->
    {{-- <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets-front/img/logo/logo.png" alt="">
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Preloader Start -->

    {{-- Header --}}
    <header>
        @include('frontend.header')
    </header>

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer>
        @include('frontend.footer')
    </footer>

    <script>
        $(document).ready(function() {
            $('.weekly2-news-active').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: true,
                autoplay: false,
                startPosition: 0,
            });

            $('.weekly2-news-active').trigger('to.owl.carousel', [0, 0]);
        });
    </script>

    <!-- All JS Custom Plugins Link Here here -->
    <script>
        $(document).ready(function() {
            $('.weekly2-news-active').slick();
        });
    </script>

    <script src="{{ asset('./assets-front/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="{{ asset('./assets-front/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('./assets-front/js/popper.min.js') }}"></script>
    <script src="{{ asset('./assets-front/js/bootstrap.min.js') }}"></script>
    <!-- Jquery Mobile Menu -->
    <script src="{{ asset('./assets-front/js/jquery.slicknav.min.js') }}"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="{{ asset('./assets-front/js/owl.carousel.min.js') }}"></script>
    <script src="./assets-front/js/slick.min.js"></script>
    <!-- Date Picker -->
    <script src="{{ asset('./assets-front/js/gijgo.min.js') }}"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="{{ asset('./assets-front/js/wow.min.js') }}"></script>
    <script src="{{ asset('./assets-front/js/animated.headline.js') }}"></script>
    <script src="{{ asset('./assets-front/js/jquery.magnific-popup.js') }}"></script>

    <!-- Breaking New Pluging -->
    <script src="{{ asset('./assets-front/js/jquery.ticker.js') }}"></script>
    <script src="{{ asset('./assets-front/js/site.js') }}"></script>

    <!-- Scrollup, nice-select, sticky -->
    <script src="{{ asset('./assets-front/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('./assets-front/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('./assets-front/js/jquery.sticky.js') }}"></script>

    <!-- contact js -->
    <script src="{{ asset('./assets-front/js/contact.js') }}"></script>
    <script src="{{ asset('./assets-front/js/jquery.form.js') }}"></script>
    <script src="{{ asset('./assets-front/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('./assets-front/js/mail-script.js') }}"></script>
    <script src="{{ asset('./assets-front/js/jquery.ajaxchimp.min.js') }}"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="{{ asset('./assets-front/js/plugins.js') }}"></script>
    <script src="{{ asset('./assets-front/js/main.js') }}"></script>

    @yield('scripts')
</body>

</html>
