@php
    $products_18 = $products->paginate(18);
@endphp
@section('resultCount')
    <div class="shop-toolbar__item shop-toolbar__item--result">
        <p class="result-count"> Showing
            {{ $products_18->perPage() }} of
            {{ $products_18->total() }}
            results</p>
    </div>
@endsection
<div class="tab-pane fade show active" id="tab_columns_03">
    <div class="row">
        @foreach ($products_18 as $product)
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="single-product-item text-center">
                    <div class="products-images">
                        <a href="product-details.html" class="product-thumbnail">
                            <img src="{{ $product->photos ? $product->photos : static_asset('assets/img/placeholder-rect.jpg') }}"
                                @if ($product->thumbnail_img) data-src="{{ uploaded_asset($product->thumbnail_img) }}" @endif
                                alt="{{ $product->name }}" class="img-fluid"
                                width="300" height="300">

                            @if ($product->stock_visibility_state == 'quantity')
                                <span class="ribbon out-of-stock ">
                                    {{ $product->current_stock > 0 ? $product->current_stock : 'Out Of Stock' }}
                            @endif
                            </span>
                        </a>
                        <div class="product-actions">
                            <a href="#" data-bs-toggle="modal"
                                data-bs-target="#prodect-modal"><i
                                    class="p-icon icon-plus"></i><span
                                    class="tool-tip">Quick
                                    View</span></a>
                            <a href="product-details.html"><i
                                    class="p-icon icon-bag2"></i>
                                <span class="tool-tip">Add to
                                    cart</span></a>
                            <a href="wishlist.html"><i
                                    class="p-icon icon-heart"></i>
                                <span class="tool-tip">Browse
                                    Wishlist</span></a>
                        </div>
                    </div>
                    <div class="product-content">
                        <h6 class="prodect-title"><a
                                href="product-details.html">{{ $product->name }}</a>
                        </h6>
                        <div class="prodect-price">
                            <span
                                class="new-price">{{ home_discounted_price($product) }}</span>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
    @if ($products_18->hasPages())
        <div class="paginatoin-area">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="pagination-box">
                        <li>
                            <a href="{{ $products_18->previousPageUrl() }}"
                                class="Previous btn {{ $products_18->onFirstPage() ? 'disabled' : '' }}"><i
                                    class="icon-chevron-left"></i></a>
                        </li>

                        @for ($i = 1; $i <= $products_18->lastPage(); $i++)
                            <li
                                class="{{ $i == $products_18->currentPage() ? 'active' : '' }}">
                                <a
                                    href="{{ $products_18->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li>
                            <a href="{{ $products_18->nextPageUrl() }}"
                                class="Next btn {{ $products_18->currentPage() == $products_18->lastPage() ? 'disabled' : '' }}""><i
                                    class="icon-chevron-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>
