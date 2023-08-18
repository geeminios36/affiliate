@extends('frontend.layouts.app')

@section('meta_title')
    {{ $detailedProduct->meta_title }}
@stop

@section('meta_description')
    {{ $detailedProduct->meta_description }}
@stop

@section('meta_keywords')
    {{ $detailedProduct->tags }}
@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}"/>
    <meta property="og:type" content="og:product"/>
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}"/>
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}"/>
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}"/>
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}"/>
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}"/>
    <meta property="product:price:currency"
          content="{{ \App\Currency::where('id', get_setting('system_default_currency'))->first()->code }}"/>
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

@section('header')
    @include('frontend.partials.header')
@endsection

@section('breadcrumb')
    @include('frontend.partials.breadcrumb')
@endsection

@section('content')
    <div class="site-wrapper-reveal">

        <div class="single-product-wrap section-space--pt_90 border-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                        @php
                            $photos = explode(',', $detailedProduct->photos);
                        @endphp
                            <!-- Product Details Left -->
                        <div class="product-details-left">
                            <div class="product-details-images-2 slider-lg-image-2">
                                @foreach ($photos as $key => $photo)
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{ uploaded_asset($photo) }}" class="poppu-img">
                                                <img src="{{ uploaded_asset($photo) }}" class="img-fluid" alt="">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="product-details-thumbs-2 slider-thumbs-2">
                                @foreach ($photos as $key => $photo)
                                    <div class="sm-image"><img src="{{ uploaded_asset($photo) }}" width="100"
                                                               height="100" alt="product image thumb"></div>
                                @endforeach
                            </div>
                        </div>
                        <!--// Product Details Left -->

                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                        <div class="product-details-content ">

                            <h5 class="font-weight--reguler mb-10">{{ $detailedProduct->name }}</h5>

                            <h3 class="price">
                                {{ home_discounted_base_price($detailedProduct) }}
                                @if(home_base_price($detailedProduct) != home_discounted_base_price($detailedProduct))
                                    - {{ home_base_price($detailedProduct) }}
                                @endif
                            </h3>

                            <div class="quickview-peragraph mt-10">
                                <p>At vero accusamus et iusto odio dignissimos blanditiis praesentiums dolores
                                    molest.</p>
                            </div>


                            <div class="product-size-wrapper mt-20">
                                <div class="tab-content d-flex">
                                    <label class="mr-2">Size</label>
                                    <div class="tab-pane fade show active" id="tab_list_l">
                                        L
                                    </div>
                                    <div class="tab-pane fade" id="tab_list_m">
                                        M
                                    </div>
                                    <div class="tab-pane fade" id="tab_list_s">
                                        S
                                    </div>
                                </div>

                                <ul class="nav product-size-menu" role="tablist">

                                    <li class="tab__item nav-item active">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab_list_l"
                                           role="tab">L</a>
                                    </li>
                                    <li class="tab__item nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab_list_m" role="tab">M</a>
                                    </li>
                                    <li class="tab__item nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab_list_s" role="tab">S</a>
                                    </li>

                                </ul>
                            </div>


                            <div class="product-color-wrapper mt-20">
                                <div class="tab-content d-flex">
                                    <label class="mr-2">Color </label>
                                    <div class="tab-pane fade show active" id="tab_list_black">
                                        Black
                                    </div>
                                    <div class="tab-pane fade" id="tab_list_white">
                                        White
                                    </div>
                                </div>

                                <ul class="nav product-color-menu" role="tablist">
                                    <li class="tab__item nav-item active">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab_list_black"
                                           role="tab"></a>
                                    </li>
                                    <li class="tab__item nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab_list_white" role="tab"></a>
                                    </li>
                                </ul>

                            </div>


                            <div class="quickview-action-wrap mt-30">
                                <div class="quickview-cart-box">
                                    <div class="quickview-quality">
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="0">
                                        </div>
                                    </div>

                                    <div class="quickview-button">
                                        <div class="quickview-cart button">
                                            <a href="#" onclick="addToCart({{ $detailedProduct->id }})"
                                               class="btn--lg btn--black font-weight--reguler text-white">Add to
                                                cart</a>
                                        </div>
                                        <div class="quickview-wishlist button">
                                            <a title="Add to wishlist" href="#"><i class="icon-heart"></i></a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="product_meta mt-30">
                                <div class="sku_wrapper item_meta">
                                    <span class="label"> SKU: </span>
                                    <span class="sku"> 502 </span>
                                </div>
                                <div class="posted_in item_meta">
                                    <span class="label">Categories: </span><a
                                        href="{{ route('products.category', $detailedProduct->category->slug) }}">{{ $detailedProduct->category->name}}</a>
                                </div>
                                <div class="tagged_as item_meta">
                                    <span class="label">Tag: </span><a href="#">Pottery</a>
                                </div>
                            </div>

                            <div class="product_socials section-space--mt_60">
                                <span class="label">Share this items :</span>
                                <ul class="helendo-social-share socials-inline">
                                    <li>
                                        <a class="share-twitter helendo-twitter" href="#" target="_blank"><i
                                                class="social_twitter"></i></a>
                                    </li>
                                    <li>
                                        <a class="share-facebook helendo-facebook" href="#" target="_blank"><i
                                                class="social_facebook"></i></a>
                                    </li>
                                    <li>
                                        <a class="share-google-plus helendo-google-plus" href="#" target="_blank"><i
                                                class="social_googleplus"></i></a>
                                    </li>
                                    <li>
                                        <a class="share-pinterest helendo-pinterest" href="#" target="_blank"><i
                                                class="social_pinterest"></i></a>
                                    </li>
                                    <li>
                                        <a class="share-linkedin helendo-linkedin" href="#" target="_blank"><i
                                                class="social_linkedin"></i></a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        <div class="product-details-tab section-space--pt_90">
                            <ul role="tablist" class=" nav">
                                <li class="active" role="presentation">
                                    <a data-bs-toggle="tab" role="tab" href="#description"
                                       class="active">Description</a>
                                </li>
                                {{--                                <li role="presentation">--}}
                                {{--                                    <a data-bs-toggle="tab" role="tab" href="#sheet">Additional information</a>--}}
                                {{--                                </li>--}}
                                <li role="presentation">
                                    <a data-bs-toggle="tab" role="tab" href="#reviews">Reviews</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="product_details_tab_content tab-content mt-30">
                            <!-- Start Single Content -->
                            <div class="product_tab_content tab-pane active" id="description" role="tabpanel">
                                <div class="product_description_wrap">
                                    <div class="product-details-wrap">
                                        <div class="row align-items-center">
                                            <div class="col-lg-7 order-md-1 order-2">
                                                <div class="details mt-30">
                                                    <h5 class="mb-10">Detail</h5>
                                                    {!! $detailedProduct->description !!}
                                                </div>
                                            </div>
                                            {{--                                            <div class="col-lg-5 order-md-2 order-1">--}}
                                            {{--                                                <div class="images">--}}
                                            {{--                                                    <img src="assets/images/product/single-product-01.webp" class="img-fluid" alt="">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>
                                    {{--                                    <div class="product-details-wrap">--}}
                                    {{--                                        <div class="row align-items-center">--}}
                                    {{--                                            <div class="col-lg-7 order-md-1 order-2">--}}
                                    {{--                                                <div class="details mt-30">--}}
                                    {{--                                                    <div class="pro_feature">--}}
                                    {{--                                                        <h5 class="title_3 mb-10">Features</h5>--}}
                                    {{--                                                        <ul class="feature_list">--}}
                                    {{--                                                            <li><a href="#"><i class="arrow_triangle-right"></i>Fully padded back panel, web hauded handle</a></li>--}}
                                    {{--                                                            <li><a href="#"><i class="arrow_triangle-right"></i>Internal padded sleeve fits 15″ laptop</a></li>--}}
                                    {{--                                                            <li><a href="#"><i class="arrow_triangle-right"></i>Internal tricot lined tablet sleeve</a></li>--}}
                                    {{--                                                            <li><a href="#"><i class="arrow_triangle-right"></i>One large main compartment and zippered</a></li>--}}
                                    {{--                                                            <li><a href="#"><i class="arrow_triangle-right"></i>Premium cotton canvas fabric</a></li>--}}
                                    {{--                                                        </ul>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <div class="col-lg-5 order-md-2 order-1">--}}
                                    {{--                                                <div class="images">--}}
                                    {{--                                                    <img src="assets/images/product/single-product-02.webp" class="img-fluid" alt="">--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                            <!-- End Single Content -->
                            <!-- Start Single Content -->
                            {{--                            <div class="product_tab_content tab-pane" id="sheet" role="tabpanel">--}}
                            {{--                                <div class="pro_feature">--}}
                            {{--                                    <table class="shop_attributes">--}}
                            {{--                                        <tbody>--}}
                            {{--                                        <tr>--}}
                            {{--                                            <th>Weight</th>--}}
                            {{--                                            <td>1.2 kg</td>--}}
                            {{--                                        </tr>--}}
                            {{--                                        <tr>--}}
                            {{--                                            <th>Dimensions</th>--}}
                            {{--                                            <td>12 × 2 × 1.5 cm</td>--}}
                            {{--                                        </tr>--}}
                            {{--                                        </tbody>--}}
                            {{--                                    </table>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            <!-- End Single Content -->
                            <!-- Start Single Content -->
                            <div class="product_tab_content tab-pane" id="reviews" role="tabpanel">

                                <!-- Start RAting Area -->
                                <div class="rating_wrap mb-30">
                                    <h4 class="rating-title-2">Be the first to review
                                        “{{ $detailedProduct->category->name}}”</h4>
                                    <p>Your rating</p>
                                    <div class="rating_list">
                                        <div class="product-rating d-flex">
                                            <i class="yellow icon_star"></i>
                                            <i class="yellow icon_star"></i>
                                            <i class="yellow icon_star"></i>
                                            <i class="yellow icon_star"></i>
                                            <i class="yellow icon_star"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- End RAting Area -->
                                <div class="comments-area comments-reply-area">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <form action="#" class="comment-form-area">
                                                <p class="comment-form-comment">
                                                    <label>Your review *</label>
                                                    <textarea class="comment-notes" required="required"></textarea>
                                                </p>
                                                <div class="comment-input">
                                                    <p class="comment-form-author">
                                                        <label>Name <span class="required">*</span></label>
                                                        <input type="text" required="required" name="Name">
                                                    </p>
                                                    <p class="comment-form-email">
                                                        <label>Email <span class="required">*</span></label>
                                                        <input type="text" required="required" name="email">
                                                    </p>
                                                </div>

                                                <div class="comment-form-submit">
                                                    <input type="submit" value="Submit" class="comment-submit">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Content -->
                        </div>
                    </div>
                </div>

                <div class="related-products section-space--ptb_90">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title text-center mb-30">
                                <h4>Related products</h4>
                            </div>
                        </div>
                    </div>

                    <div class="product-slider-active">
                        @php
                            $mergeProducts = @$detailedProduct->category->products;
                        @endphp
                        @if($mergeProducts && count($mergeProducts) > 0)
                            @foreach($mergeProducts as $product)
                                    <?php $qty = $product->productStocks->sum('qty'); ?>
                                <div class="col-lg-12">
                                    <!-- Single Product Item Start -->
                                    <div class="single-product-item text-center">
                                        <div class="products-images">
                                            <a href="{{ route('product', $product->slug) }}" class="product-thumbnail">
                                                <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                     class="img-fluid" alt="{{  $product->getTranslation('name')  }}"
                                                     width="300" height="300">
                                                @if($qty == 0)
                                                    <span class="ribbon out-of-stock ">Out Of Stock</span>
                                                @endif
                                            </a>
                                            <div class="product-actions">
                                                <a href="#" data-bs-toggle="modal"
                                                   data-bs-target="#product-modal-{{ $product->id }}"><i
                                                        class="p-icon icon-plus"></i><span
                                                        class="tool-tip">Quick View</span></a>
                                                <a href="#" onclick="addToCart({{ $product->id }})"><i
                                                        class="p-icon icon-bag2"></i> <span
                                                        class="tool-tip">Add to cart</span></a>
                                                <a href="{{ route('wishlists.index') }}"><i
                                                        class="p-icon icon-heart"></i> <span
                                                        class="tool-tip">Browse Wishlist</span></a>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h6 class="prodect-title"><a
                                                    href="{{ route('product', $product->slug) }}">{{  $product->getTranslation('name')  }}</a>
                                            </h6>
                                            <div class="prodect-price">
                                                <span
                                                    class="new-price">{{ home_discounted_base_price($product) }}</span>
                                                @if(home_base_price($product) != home_discounted_base_price($product))
                                                    - <span class="old-price"> {{ home_base_price($product) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div><!-- Single Product Item End -->
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('frontend.modal_product_detail')
@endsection

@section('script')
@endsection
