<!doctype html>
<html lang="{{App::getLocale()}}">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link href="{{ asset('css/style.css')}}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/bootstrap-datepicker.css')}}" type="text/css" rel="stylesheet" />
<link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>



<!-- Favicon -->

<link href="{{ asset('daygrid/main.min.css')}}" type="text/css" rel="stylesheet" />

@livewireStyles
@stack('head')
<!-- Favicon and Touch Icons -->
@stack('plugin-styles')
<link href="{{ asset('favicon.ico')}}" rel="shortcut icon" type="image/png">
<link href="{{ asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon">
<link href="{{ asset('img/apple-touch-icon-72x72.png')}}" rel="apple-touch-icon" sizes="72x72">
<link href="{{ asset('img/apple-touch-icon-114x114.png')}}" rel="apple-touch-icon" sizes="114x114">
<link href="{{ asset('img/apple-touch-icon-144x144.png')}}" rel="apple-touch-icon" sizes="144x144">

<title>Day Expeditions Cusco</title>
</head>
<body>
<header class="header-static navbar-sticky">
@include('header')

</header>
<!-- =======================
	header End-->

<!-- =======================
	Main Banner -->
@yield('contenido')



<!-- =======================
	footer  -->
@include('footer')
<!-- =======================
	footer  -->
@include('whatsapp')

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/functions.js')}}" type="text/javascript"></script>
<script src="{{asset('js/owl.carousel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/slick.js')}}" type="text/javascript"></script>
<script src="{{asset('js/swiper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/main.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.fancybox.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-element-bundle.min.js"></script>

@livewireScripts
@stack('scripts')

@stack('plugin-scripts')
@stack('custom-scripts')
</body>
</html>

