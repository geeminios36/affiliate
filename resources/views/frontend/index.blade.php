@extends('frontend.layouts.app')

@section('content')
    <div class="site-wrapper-reveal pt-5">

        <!-- About us Area Start -->
        @include('frontend.about-us')
        <!-- About us Area End -->

        <!-- Product Area Start -->
        @include('frontend.popular-products')
        <!-- Product Area End -->

        <!-- Our Newsletter Area Start -->
        @include('frontend.newsletter')
        <!-- Our Newsletter Area End -->

        <!-- Our Blog Area Start -->
        @include('frontend.blog')
        <!-- Our Blog Area End -->

        <!-- Our Brand Area Start -->
        @include('frontend.brand')
        <!-- Our Brand Area End -->
    </div>

@endsection

@section('script')

@endsection


