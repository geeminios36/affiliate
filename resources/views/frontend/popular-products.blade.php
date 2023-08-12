<div class="product-wrapper section-space--ptb_120">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <div class="section-title text-lg-start text-center mb-20">
                    <h3 class="section-title">Popular Products</h3>
                </div>
            </div>
            <div class="col-lg-8">
                <ul class="nav product-tab-menu justify-content-lg-end justify-content-center" role="tablist">
                    <li class="tab__item nav-item active">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab_list_00" role="tab">
                            All Products
                        </a>
                    </li>
                    @foreach($categories as $key => $category)
                        @if(count($category->products))
                            <li class="tab__item nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab_list_{{ $category->id }}"
                                   role="tab">{{ $category->name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="tab-content mt-30">
            <div class="tab-pane fade show active" id="tab_list_00">
                <!-- product-slider-active -->
                <div class="row">
                    @foreach($allProducts as $product)
                        @php
                            $qty = $product->productStocks->sum('qty');
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <!-- Single Product Item Start -->
                            <div class="single-product-item text-center">
                                <div class="products-images">
                                    <a href="{{ route('product', $product->slug) }}" class="product-thumbnail">
                                        <img src="{{ uploaded_asset($product->thumbnail_img) }}" class="img-fluid"
                                             alt="{{  $product->getTranslation('name')  }}" width="300" height="300">
                                        @if($qty == 0)
                                            <span class="ribbon out-of-stock ">Out Of Stock</span>
                                        @endif
                                        {{--                                        <span class="ribbon onsale">--}}
                                        {{--                                            -14%--}}
                                        {{--                                            </span>--}}
                                    </a>
                                    <div class="product-actions">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#prodect-modal"><i
                                                class="p-icon icon-plus"></i><span
                                                class="tool-tip">Quick View</span></a>
                                        <a href="{{ route('product', $product->slug) }}"><i
                                                class="p-icon icon-bag2"></i> <span
                                                class="tool-tip">Add to cart</span></a>
                                        <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span
                                                class="tool-tip">Browse Wishlist</span></a>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h6 class="prodect-title"><a
                                            href="{{ route('product', $product->slug) }}">{{  $product->getTranslation('name')  }}</a>
                                    </h6>
                                    <div class="prodect-price">
                                        <span class="new-price">{{ home_discounted_base_price($product) }}</span>
                                        @if(home_base_price($product) != home_discounted_base_price($product))
                                            - <span class="old-price"> {{ home_base_price($product) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- Single Product Item End -->
                        </div>
                    @endforeach

                </div>
            </div>
            @foreach($categories as $key => $category)
                @if(count($category->products))
                    <div class="tab-pane {{$key !== 0 ? 'fade' : '' }}" id="tab_list_{{ $category->id }}">
                        <div class="row ">
                            @foreach($category->products as $product)
                                @php
                                    $qty = $product->productStocks->sum('qty');
                                @endphp
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <!-- Single Product Item Start -->
                                    <div class="single-product-item text-center">
                                        <div class="products-images">
                                            <a href="{{ route('product', $product->slug) }}" class="product-thumbnail">
                                                <img
                                                    src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                    class="img-fluid"
                                                    alt="Product Images" width="300" height="300">
                                                @if($qty == 0)
                                                    <span class="ribbon out-of-stock ">Out Of Stock</span>
                                                @endif
                                            </a>
                                            <div class="product-actions">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#prodect-modal"><i
                                                        class="p-icon icon-plus"></i><span
                                                        class="tool-tip">Quick View</span></a>
                                                <a href="{{ route('product', $product->slug) }}"><i
                                                        class="p-icon icon-bag2"></i> <span
                                                        class="tool-tip">Add to cart</span></a>
                                                <a href="wishlist.html"><i class="p-icon icon-heart"></i> <span
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
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
