<!DOCTYPE html>


<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="Orbitor,business,company,agency,modern,bootstrap4,tech,software">
    <meta name="author" content="themefisher.com">

    <!-- theme meta -->
    <meta name="theme-name" content="orbitor" />

    <title>{{ $title ?? 'Home' }} - {{ env('APP_NAME') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/logo.png') }}" />

    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Icon Font Css -->
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/plugins/themify/css/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/plugins/fontawesome/css/all.css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/plugins/magnific-popup/dist/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/plugins/modal-video/modal-video.css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/plugins/animate-css/animate.css">
    <!-- Slick Slider  CSS -->
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/plugins/slick-carousel/slick/slick.css">
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/plugins/slick-carousel/slick/slick-theme.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend_theme') }}/css/style.css">

</head>

<body>



    @include('layouts.frontend.navbar')

    @yield('content')


    @include('layouts.frontend.footer')

    <!--
    Essential Scripts
    =====================================-->


    <!-- Main jQuery -->
    <script src="{{ asset('frontend_theme') }}/plugins/jquery/jquery.js"></script>
    <script src="{{ asset('frontend_theme') }}/js/contact.js"></script>
    <!-- Bootstrap 4.3.2 -->
    <script src="{{ asset('frontend_theme') }}/plugins/bootstrap/js/popper.js"></script>
    <script src="{{ asset('frontend_theme') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--  Magnific Popup-->
    <script src="{{ asset('frontend_theme') }}/plugins/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <!-- Slick Slider -->
    <script src="{{ asset('frontend_theme') }}/plugins/slick-carousel/slick/slick.min.js"></script>
    <!-- Counterup -->
    <script src="{{ asset('frontend_theme') }}/plugins/counterup/jquery.waypoints.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/plugins/counterup/jquery.counterup.min.js"></script>

    <script src="{{ asset('frontend_theme') }}/plugins/modal-video/modal-video.js"></script>
    <!-- Google Map -->
    <script src="{{ asset('frontend_theme') }}/plugins/google-map/map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA&callback=initMap">
    </script>

    <script src="{{ asset('frontend_theme') }}/js/script.js"></script>

</body>

</html>
