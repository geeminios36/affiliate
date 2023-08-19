<!DOCTYPE html>
@php
    $cur_lang = \App\Language::where('code', Session::get('locale', Config::get('app.locale')))->first();
@endphp

<html @if(!empty($cur_lang) && $cur_lang->rtl == 1) dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      @else lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    @endif>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">

    <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )"/>
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">

    @yield('meta')

    @if(!isset($detailedProduct) && !isset($customer_product) && !isset($shop) && !isset($page) && !isset($blog))
        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="{{ get_setting('meta_title') }}">
        <meta itemprop="description" content="{{ get_setting('meta_description') }}">
        <meta itemprop="image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="product">
        <meta name="twitter:site" content="@publisher_handle">
        <meta name="twitter:title" content="{{ get_setting('meta_title') }}">
        <meta name="twitter:description" content="{{ get_setting('meta_description') }}">
        <meta name="twitter:creator" content="@author_handle">
        <meta name="twitter:image" content="{{ uploaded_asset(get_setting('meta_image')) }}">

        <!-- Open Graph data -->
        <meta property="og:title" content="{{ get_setting('meta_title') }}"/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="{{ route('home') }}"/>
        <meta property="og:image" content="{{ uploaded_asset(get_setting('meta_image')) }}"/>
        <meta property="og:description" content="{{ get_setting('meta_description') }}"/>
        <meta property="og:site_name" content="{{ env('APP_NAME') }}"/>
        <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
    @endif

    <!-- Favicon -->
    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap"
        rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
    @php
        $cur_lang = \App\Language::where('code', Session::get('locale', Config::get('app.locale')))->first();
    @endphp

        <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{  static_asset('assets/frontend/css/vendor/bootstrap.min.css') }}">

    <!-- Icons Css -->
    <link rel="stylesheet" href="{{  static_asset('assets/frontend/css/vendor/linearicons.min.css') }}">
    <link rel="stylesheet" href="{{  static_asset('assets/frontend/css/vendor/fontawesome-all.min.css') }}">

    <!-- Animation Css -->
    <link rel="stylesheet" href="{{  static_asset('assets/frontend/css/plugins/animation.min.css') }}">

    <!-- Slick Slier Css -->
    <link rel="stylesheet" href="{{  static_asset('assets/frontend/css/plugins/slick.min.css') }}">

    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{  static_asset('assets/frontend/css/plugins/magnific-popup.css') }}">

    <!-- Easyzoom CSS -->
    <link rel="stylesheet" href="{{  static_asset('assets/frontend/css/plugins/easyzoom.css') }}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{  static_asset('assets/frontend/css/style.css') }}">


    @php
        echo get_setting('header_script');
    @endphp
</head>
<body>

@yield('slide')

@yield('header')

@yield('breadcrumb')

<div id="main-wrapper">
    @yield('content')

    <!--====================  footer area ====================-->
    @include('frontend.footer')
    <!--====================  End of footer area  ====================-->
</div>

@yield('modal')

@include('frontend.partials.modal')
@include('frontend.partials.mobile')
@include('frontend.partials.offcanvas')
@include('frontend.partials.search')

<!--====================  scroll top ====================-->
<a href="#" class="scroll-top" id="scroll-top">
    <i class="arrow-top icon-arrow-up"></i>
    <i class="arrow-bottom icon-arrow-up"></i>
</a>
<!--====================  End of scroll top  ====================-->

<!-- JS
============================================ -->
<!-- Modernizer JS -->
<script src="{{  static_asset('assets/frontend/js/vendor/modernizr-2.8.3.min.js') }}"></script>

<!-- jQuery JS -->
<script src="{{  static_asset('assets/frontend/js/vendor/jquery-3.5.1.min.js') }}"></script>
<script src="{{  static_asset('assets/frontend/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>

<!-- Bootstrap JS -->
<script src="{{  static_asset('assets/frontend/js/vendor/bootstrap.min.js') }}"></script>

<!-- Fullpage JS -->
<script src="{{  static_asset('assets/frontend/js/plugins/fullpage.min.js') }}"></script>

<!-- Slick Slider JS -->
<script src="{{  static_asset('assets/frontend/js/plugins/slick.min.js') }}"></script>

<!-- Countdown JS -->
<script src="{{  static_asset('assets/frontend/js/plugins/countdown.min.js') }}"></script>

<!-- Magnific Popup JS -->
<script src="{{  static_asset('assets/frontend/js/plugins/magnific-popup.js') }}"></script>

<!-- Easyzoom JS -->
<script src="{{  static_asset('assets/frontend/js/plugins/easyzoom.js') }}"></script>

<!-- ImagesLoaded JS -->
<script src="{{  static_asset('assets/frontend/js/plugins/images-loaded.min.js') }}"></script>

<!-- Isotope JS -->
<script src="{{  static_asset('assets/frontend/js/plugins/isotope.min.js') }}"></script>

<!-- YTplayer JS -->
<script src="{{  static_asset('assets/frontend/js/plugins/YTplayer.js') }}"></script>

<!-- Instagramfeed JS -->
<!-- <script src="{{  static_asset('assets/frontend/js/plugins/jquery.instagramfeed.min.js') }}"></script> -->

<!-- Ajax Mail JS -->
<script src="{{  static_asset('assets/frontend/js/plugins/ajax.mail.js') }}"></script>

<!-- wow JS -->
<script src="{{  static_asset('assets/frontend/js/plugins/wow.min.js') }}"></script>


<!-- Plugins JS (Please remove the comment from below plugins.min.js for better website load performance and remove plugin js files from avobe) -->

{{--<script src="{{  static_asset('assets/frontend/js/plugins/plugins.min.js') }}"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const urlAddToCart = '{{ route('cart.addToCart') }}/',
        _token = '{{ csrf_token() }}';
</script>

<!-- Main JS -->
<script src="{{  static_asset('assets/frontend/js/main.js') }}"></script>

@yield('script')
</body>
</html>
