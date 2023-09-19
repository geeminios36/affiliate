@php
    $products_15 = $products->paginate(15);
@endphp
@section('resultCount')
    <div class="shop-toolbar__item shop-toolbar__item--result">
        <p class="result-count"> Showing
            {{ $products_15->perPage() }} of
            {{ $products_15->total() }}
            results</p>
    </div>
@endsection

<div class="tab-pane fade" id="tab_columns_02">
    <div class="row">
        @foreach ($products_15 as $product)
            <div class="col__20">
                <div class="single-product-item text-center">
                    <div class="products-images">
                        <a href="product-details.html" class="product-thumbnail">
                            <img src="{{ $product->photos ? $product->photos : static_asset('assets/img/placeholder-rect.jpg') }}"
                                @if ($product->thumbnail_img) data-src="{{ uploaded_asset($product->thumbnail_img) }}" @endif
                                alt="{{ $product->name }}" class="img-fluid"
                                width="300" height="300">

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
                        <div class="prodect-price ml-auto">
                            <span
                                class="new-price">{{ home_discounted_price($product) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    @if ($products_15->hasPages())
        <div class="paginatoin-area">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="pagination-box">
                        <li>
                            <a href="{{ $products_15->previousPageUrl() }}"
                                class="Previous btn {{ $products_15->onFirstPage() ? 'disabled' : '' }}"><i
                                    class="icon-chevron-left"></i></a>
                        </li>

                        @for ($i = 1; $i <= $products_15->lastPage(); $i++)
                            <li
                                class="{{ $i == $products_15->currentPage() ? 'active' : '' }}">
                                <a
                                    href="{{ $products_15->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li>
                            <a href="{{ $products_15->nextPageUrl() }}"
                                class="Next btn {{ $products_15->currentPage() == $products_15->lastPage() ? 'disabled' : '' }}""><i
                                    class="icon-chevron-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>
