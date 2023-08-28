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
    <meta name="twitter:creator" content="@author_handle">
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
                                    <img src="assets/images/blog/8-1170x672.webp"
                                        class="img-fluid" alt="Blog Images">
                                </a>
                            </div>
                            <div class="blog-contents">
                                <h3 class="blog-title-lg"><a href="#">Interior
                                        design is the art, the interior designer is
                                        the artist.</a></h3>

                                <div class="row">
                                    <div class="col-lg-9 m-auto">
                                        <div class="meta-tag-box">
                                            <div class="meta date"><span>October 16,
                                                    2022</span></div>
                                            <div class="meta author"><span><a
                                                        href="#">Hastheme</a></span>
                                            </div>
                                            <div class="meta cat"><span>in <a
                                                        href="#">Chair</a></span>
                                            </div>
                                        </div>

                                        <p class="mt-20 d_text">Contrary to popular
                                            belief, Lorem Ipsum indignation and
                                            dislike men who are so beguiled and
                                            demoralized by the charms of pleasure of
                                            the moment, so blinded by desire, that
                                            they cannot foresee the pain and trouble
                                            that are bound to ensue; and equal blame
                                            belongs to those who fail in their duty
                                            through weakness of will, which is the
                                            same saying.One order all scale sense
                                            her gay style wrote.</p>

                                        <blockquote>
                                            <p> Dalena dolor sit amet, consectetur
                                                adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore etyt
                                                dolore magna aliqua. Ut enim ad
                                                minim veniam, quis nostrud
                                                exercitation ullamco laboris nisi
                                                utino aliquip ex ea commodo
                                                consequat.</p>
                                        </blockquote>
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

                                <p class="mt-20 m-auto d_text">In show dull give
                                    need so held. One order all scale sense her gay
                                    style wrote. Incommode our not one ourselves
                                    residen. Shall there whose those stand she end.
                                    So unaffected partiality indulgence dispatched
                                    to of ebrated remarkably. Unfeel are had
                                    allowance own perceived abilities. Promotion an
                                    ourselves up other my. High what each snug rich
                                    far yet easy. In companions inhabiting mr
                                    principles at insensible do. Heard their hoped
                                    enjoy vexed child for. Prosperous so occasi
                                    assistance it discovered especially no.
                                    Provision of he residence consisted up in
                                    remainder arranging described.</p>

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
                                            <div class="tagcloud"><a href="#"
                                                    class="selected">Chair</a><a
                                                    href="#">chair</a><a
                                                    href="#">Table</a></div>
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
                                        <h6 class="author-name">grixbase</h6>
                                        <p class="mt-1">Caleigh Jerde is a writer
                                            and producer for TIME Healthland. She is
                                            a graduate from the Northwestern
                                            University Medill School of Journalism.
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
                                            <i class="icon-chevron-left"></i><span
                                                class="blog-nav nav-previous"><span
                                                    class="d-text">Top 10 unique
                                                    deco products 2022</span>
                                                <br><span
                                                    class="title-nav">Previous</span></span>
                                        </a>
                                        <a href="#"
                                            class="nav-links post-next">
                                            <span class="blog-nav nav-next"><span
                                                    class="d-text">Top 10 unique
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
                                        <div class="col-lg-9 m-auto">
                                            <h4 class="mb-30">Leave a Reply</h4>
                                            <form action="#"
                                                class="comment-form-area">
                                                <div class="comment-input-12">
                                                    <textarea class="comment-notes" required="required"></textarea>
                                                </div>

                                                <div class="comment-input-12">
                                                    <input type="text"
                                                        required="required"
                                                        name="Name"
                                                        placeholder="Name">
                                                </div>
                                                <div class="comment-input-12">
                                                    <input type="text"
                                                        placeholder="Email"
                                                        required="required"
                                                        name="email">
                                                </div>
                                                <div class="comment-input-12">
                                                    <input type="text"
                                                        placeholder="Website"
                                                        name="Website">
                                                </div>

                                                <div class="comment-form-submit">
                                                    <input type="submit"
                                                        value="Post Comment"
                                                        class="comment-submit btn--md">
                                                </div>
                                            </form>
                                        </div>
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
    {{-- <section class="py-4">
        <div class="container">
            <div class="mb-4">
                <img
                    src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                    data-src="{{ uploaded_asset($blog->banner) }}"
                    alt="{{ $blog->title }}"
                    class="img-fluid lazyload w-100"
                >
            </div>
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="bg-white rounded shadow-sm p-4">
                        <div class="border-bottom">
                            <h1 class="h4">
                                {{ $blog->title }}
                            </h1>

                            @if ($blog->category != null)
                                <div class="mb-2 opacity-50">
                                    <i>{{ $blog->category->category_name }}</i>
                                </div>
                            @endif
                        </div>
                        <div class="mb-4 overflow-hidden">
                            {!! $blog->description !!}
                        </div>

                        @if (get_setting('facebook_comment') == 1)
                            <div>
                                <div class="fb-comments" data-href="{{ route('blog', $blog->slug) }}" data-width=""
                                     data-numposts="5"></div>
                            </div> @endif
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

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
