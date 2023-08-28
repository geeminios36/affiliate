@extends('frontend.layouts.app')

@section('meta_title')
    {{ $blog->meta_title }}
@stop

@section('meta_description')
    {{ $blog->meta_description }}
@stop

@section('meta_keywords')
    {{ $blog->meta_keywords }}
@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $blog->meta_title }}">
    <meta itemprop="description" content="{{ $blog->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($blog->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $blog->meta_title }}">
    <meta name="twitter:description" content="{{ $blog->meta_description }}">
    <meta name="twitter:creator"
        content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($blog->meta_img) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $blog->meta_title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('product', $blog->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($blog->meta_img) }}" />
    <meta property="og:description" content="{{ $blog->meta_description }}" />
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
@endsection

@section('content')
    <div class="site-wrapper-reveal border-bottom">

        <!-- Blog Page Area Start -->
        <div class="blog-page-wrapper section-space--pt_120 section-space--pb_120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Single Blog Item Start -->
                        <div class="single-blog-item">
                            <div class="blog-thumbnail-box">
                                <a href="#" class="thumbnail">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        class="img-fluid"
                                        data-src="{{ uploaded_asset($blog->banner) }}"
                                        alt="{{ $blog->title }}">
                                </a>
                            </div>
                            <div class="blog-contents">
                                <h3 class="blog-title-lg"><a
                                        href="#">{{ $blog->title }}</a></h3>

                                <div class="row">
                                    <div class="col-lg-12 m-auto">
                                        <div class="meta-tag-box">
                                            <div class="meta date">
                                                <span>{{ format_date($blog->created_at) }}</span>
                                            </div>
                                            <div class="meta author"><span><a
                                                        href="#">{{ $blog->user->name }}</a></span>
                                            </div>
                                            <div class="meta cat"><span>in <a
                                                        href="#">{{ $blog->category ? $blog->category->category_name : 'N/A' }}</a></span>
                                            </div>
                                        </div>

                                        {{-- <p class="mt-20 d_text">
                                            {{ $blog->short_description }}</p> --}}

                                        {{-- <blockquote>
                                            <p> Dalena dolor sit amet, consectetur
                                                adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore etyt
                                                dolore magna aliqua. Ut enim ad
                                                minim veniam, quis nostrud
                                                exercitation ullamco laboris nisi
                                                utino aliquip ex ea commodo
                                                consequat.</p>
                                        </blockquote> --}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="images mb-30">
                                            <img src="assets/images/blog/01-lg-570x327.webp"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="images mb-30">
                                            <img src="assets/images/blog/02-lg-570x327.webp"
                                                class="img-fluid" alt="">
                                        </div>
                                    </div>
                                </div>

                                <p class="mt-20 m-auto d_text" html>
                                    @php
                                        echo $blog->description;
                                    @endphp
                                </p>

                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div
                                            class="blog-post-social-networks mt-20">
                                            <h6 class="title">Share this story on :
                                            </h6>
                                            <ul class="list">
                                                <li class="item">
                                                    <a href="https://twitter.com"
                                                        target="_blank"
                                                        aria-label="Twitter">
                                                        <i
                                                            class="social social_facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="item">
                                                    <a href="https://facebook.com"
                                                        target="_blank"
                                                        aria-label="Facebook">
                                                        <i
                                                            class="social social_twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="item">
                                                    <a href="https://instagram.com"
                                                        target="_blank"
                                                        aria-label="Instagram">
                                                        <i
                                                            class="social social_tumblr"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div
                                            class="tag-blog d-flex justify-content-lg-end justify-content-start mt-20">
                                            <h6 class="mr-2">Tags:</h6>

                                            <div class="tagcloud">
                                                @if ($blog->tags != null)
                                                    @foreach ($blog->tags as $key => $tag)
                                                        <a href="#"
                                                            class="selected">{{ $tag }}</a>
                                                    @endforeach
                                                @else
                                                <a href="#"
                                                    class="selected">N/A</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="post-author-box clearfix section-space--mt_60">
                                        <div class="post-author-avatar">
                                            <img src="assets/images/blog/author.webp"
                                                alt="" class="photo">
                                        </div>
                                        <div class="post-author-info">
                                            <h6 class="author-name">{{ $blog->user?->name }}</h6>
                                            <p class="mt-1">Caleigh Jerde is a
                                                writer
                                                and producer for TIME Healthland.
                                                She is
                                                a graduate from the Northwestern
                                                University Medill School of
                                                Journalism.
                                            </p>
                                            <ul class="author-socials">
                                                <li><a href="http://facebook.com/meditex"
                                                        target="_blank">Facebook</a>
                                                </li>
                                                <li><a href="http://twitter.com/meditex"
                                                        target="_blank">Twitter</a>
                                                </li>
                                                <li><a href="#"
                                                        target="_blank">Pinterest</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div
                                        class="blog-relatel-post section-space--mt_60">
                                        <div class="navigation post-navigation">
                                            <a href="#" class="nav-links">
                                                <i
                                                    class="icon-chevron-left"></i><span
                                                    class="blog-nav nav-previous"><span
                                                        class="d-text">Top 10
                                                        unique
                                                        deco products 2022</span>
                                                    <br><span
                                                        class="title-nav">Previous</span></span>
                                            </a>
                                            <a href="#"
                                                class="nav-links post-next">
                                                <span
                                                    class="blog-nav nav-next"><span
                                                        class="d-text">Top 10
                                                        unique
                                                        deco products 2022</span>
                                                    <br><span
                                                        class="title-nav">Next</span></span>
                                                <i class="icon-chevron-right"></i>
                                            </a>
                                        </div>

                                    </div>


                                    <div
                                        class="comments-area comments-reply-area section-space--mt_60">
                                        <div class="row">
                                            @if (get_setting('facebook_comment') == 1)
                                                <div
                                                    class="col-lg-12 d-flex justify-content-center">
                                                    <div class="fb-comments mx-auto"
                                                        data-href="{{ route('blog', $blog->slug) }}"
                                                        data-width=""
                                                        data-numposts="5"></div>
                                                </div>
                                            @else
                                                <div class="col-lg-12 m-auto">
                                                    <h4 class="mb-30">Leave a
                                                        Reply</h4>
                                                    <form action="#"
                                                        class="comment-form-area">
                                                        <div
                                                            class="comment-input-12">
                                                            <textarea class="comment-notes" required="required"></textarea>
                                                        </div>

                                                        <div
                                                            class="comment-input-12">
                                                            <input type="text"
                                                                required="required"
                                                                name="Name"
                                                                placeholder="Name">
                                                        </div>
                                                        <div
                                                            class="comment-input-12">
                                                            <input type="text"
                                                                placeholder="Email"
                                                                required="required"
                                                                name="email">
                                                        </div>
                                                        <div
                                                            class="comment-input-12">
                                                            <input type="text"
                                                                placeholder="Website"
                                                                name="Website">
                                                        </div>

                                                        <div
                                                            class="comment-form-submit">
                                                            <input type="submit"
                                                                value="Post Comment"
                                                                class="comment-submit btn--md">
                                                        </div>


                                                    </form>
                                                </div> @endif
                                        </div>
                                    </div>

                                </div>
                            </div><!-- Single Blog Item End -->
                        </div>

                    </div>


                </div>
            </div>
            <!-- Blog Page Area End -->

        </div>

    </div>
@endsection


@section('script')
    @if (get_setting('facebook_comment') == 1)
<div id="fb-root">
    </div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0&appId={{ env('FACEBOOK_APP_ID') }}&autoLogAppEvents=1"
        nonce="ji6tXwgZ"></script>
    @endif
@endsection
