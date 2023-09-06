@extends('frontend.layouts.app')

@section('content')
    {{-- Breadcrumb --}}
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div
                            class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-start">
                            <h2 class="breadcrumb-title">Blog</h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-end">
                                <li class="breadcrumb-item"><a
                                        href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active">Blog</li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Container   --}}
    {{-- <section class="pt-4 mb-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <h1 class="fw-600 h4">{{ translate('Blog') }}</h1>
                </div>
                <div class="col-lg-6">
                    <ul
                        class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="{{ route('home') }}">
                                {{ translate('Home') }}
                            </a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset" href="{{ route('blog') }}">
                                "{{ translate('Blog') }}"
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section> --}}
    <div id="main-wrapper">
        <div class="site-wrapper-reveal border-bottom">

            <!-- Blog Page Area Start -->
            <div
                class="blog-page-wrapper section-space--pt_90 section-space--pb_120">
                <div class="container">
                    <div class="row">
                        @foreach ($blogs as $blog)
                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="single-blog-item mt-40">
                                    <div class="blog-thumbnail-box">
                                        <a href="{{ url('blog') . '/' . $blog->slug }}"
                                            class="thumbnail">
                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                data-src="{{ uploaded_asset($blog->banner) }}"
                                                alt="{{ $blog->title }}"
                                                class="img-fluid">
                                        </a>
                                        <a href="#" class="btn-blog"> Read
                                            more
                                        </a>
                                    </div>
                                    <div class="blog-contents">
                                        <h6 class="blog-title"> <a
                                                href="{{ url('blog') . '/' . $blog->slug }}"
                                                class="text-reset">
                                                {{ $blog->title }}
                                            </a></h6>
                                        <div class="meta-tag-box">
                                            <div class="meta date">
                                                <span>{{ format_date($blog->created_at) }}</span>
                                            </div>
                                            <div class="meta author"><span><a
                                                        href="#">{{ $blog->user->name }}</a></span>
                                            </div>
                                            <div class="meta cat"><span>in <a
                                                        href="#">{{ $blog->category ? $blog->category->category_name : 'category' }}</a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>

        </div>
    @endsection
