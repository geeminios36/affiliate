@extends('frontend.layouts.app')

@include('frontend.partials.header')


@section('breadcrumb')
    <div class="breadcrumb-area">
        <div class="container-fluid container-fluid--cp-100">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div
                            class="col-lg-6 col-md-6 col-sm-6 text-center text-sm-start">
                            <h2 class="breadcrumb-title">Shop</h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-6">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-sm-end">
                                <li class="breadcrumb-item"><a
                                        href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Shop</li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="site-wrapper-reveal border-bottom" id="products-container">
        <div class="product-wrapper section-space--ptb_120">
            <div class="container-fluid container-fluid--cp-100">

                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="shop-toolbar__items shop-toolbar__item--left">
                            @yield('resultCount')

                            {{--
                                <p class="result-count"> Showing
                                    {{ $products->perPage() }} of
                                    {{ $products->total() }}
                                    results</p>
                            </div> --}}

                            <div class="shop-toolbar__item shop-short-by">
                                <ul>
                                    <li>
                                        <a href="#">Sort by <i
                                                class="fa fa-angle-down angle-down"></i></a>
                                        <ul class="sorting_options">
                                            <li class="active">
                                                <a class="sort-link" data-sort_by=""
                                                    data-sort_key="">Default
                                                    sorting</a>
                                            </li>
                                            <li><a href="#">Sort by
                                                    popularity</a></li>
                                            <li><a href="#">Sort by
                                                    average rating</a></li>
                                            <li><a class="sort-link"
                                                    data-sort_by="created_at"
                                                    data-sort_key="desc">Sort
                                                    by
                                                    latest</a></li>
                                            <li><a class="sort-link"
                                                    data-sort_by="unit_price"
                                                    data-sort_key="asc">Sort
                                                    by
                                                    price:
                                                    low to high</a>
                                            </li>
                                            <li><a class="sort-link"
                                                    data-sort_by="unit_price"
                                                    data-sort_key="desc">Sort
                                                    by
                                                    price:
                                                    high to low</a></li>
                                        </ul>
                                    </li>

                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="shop-toolbar__items shop-toolbar__item--right">
                            <div class="shop-toolbar__items-wrapper">
                                <div class="shop-toolbar__item">
                                    <ul class="nav toolber-tab-menu justify-content-start"
                                        role="tablist">
                                        <li class="tab__item nav-item active">
                                            <a class="nav-link" data-bs-toggle="tab"
                                                href="#tab_columns_01"
                                                role="tab">
                                                <img src="assets/images/svg/column-04.svg"
                                                    class="img-fluid"
                                                    alt="Columns 01">
                                            </a>
                                        </li>
                                        <li class="tab__item nav-item">
                                            <a class="nav-link "
                                                data-bs-toggle="tab"
                                                href="#tab_columns_02"
                                                role="tab"><img
                                                    src="assets/images/svg/column-05.svg"
                                                    class="img-fluid"
                                                    alt="Columns 02">
                                            </a>
                                        </li>
                                        <li class="tab__item nav-item">
                                            <a class="nav-link active"
                                                data-bs-toggle="tab"
                                                href="#tab_columns_03"
                                                role="tab"><img
                                                    src="assets/images/svg/column-06.svg"
                                                    class="img-fluid"
                                                    alt="Columns 03">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div
                                    class="shop-toolbar__item shop-toolbar__item--filter ">
                                    <a class="shop-filter-active"
                                        href="#">Filter<i
                                            class="icon-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-filter-wrapper">
                    <form method="POST" class="row">
                        <!-- Product Filter -->
                        <div class=" mb-20 col__20">
                            <div class="product-filter">
                                <h5>Color</h5>
                                <ul class="widget-nav-list">
                                    <li><label for="color-black"><span
                                                class="swatch-color black"></span>
                                            <input type="checkbox"
                                                name="color.black" hidden
                                                id="color-black">
                                            Black</label></li>
                                    <li><a href="#"><span
                                                class="swatch-color green"></span>
                                            Green</a></li>
                                    <li><a href="#"><span
                                                class="swatch-color grey"></span>
                                            Grey</a></li>
                                    <li><a href="#"><span
                                                class="swatch-color red"></span>
                                            Red</a></li>
                                    <li><a href="#"><span
                                                class="swatch-color white"></span>
                                            White</a></li>
                                    <li><a href="#"><span
                                                class="swatch-color yellow"></span>
                                            Yellow</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Product Filter -->
                        <div class=" mb-20 col__20">
                            <div class="product-filter">
                                <h5>Size</h5>
                                <ul class="widget-nav-list">
                                    <li><a href="#">Large</a></li>
                                    <li><a href="#">Medium</a></li>
                                    <li><a href="#">Small</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Product Filter -->
                        <div class=" mb-20 col__20">
                            <div class="product-filter">
                                <h5>Price</h5>
                                <ul class="widget-nav-list">
                                    <li><a href="#">$0.00 - $20.00</a>
                                    </li>
                                    <li><a href="#">$20.00 - $40.00</a>
                                    </li>
                                    <li><a href="#">£40.00 - £50.00</a>
                                    </li>
                                    <li><a href="#">£50.00 - £60.00</a>
                                    </li>
                                    <li><a href="#">£60.00 +</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Product Filter -->
                        <div class=" mb-20 col__20">
                            <div class="product-filter">
                                <h5>Categories</h5>
                                <ul class="widget-nav-list">
                                    <li><a href="#">All</a></li>
                                    <li><a href="#">Accessories</a></li>
                                    <li><a href="#">Chair</a></li>
                                    <li><a href="#">Decoration</a></li>
                                    <li><a href="#">Furniture</a></li>
                                    <li><a href="#">Table</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class=" mb-20 col__20">
                            <div class="product-filter">
                                <h5>Tags</h5>
                                <div class="tagcloud"><a href="#"
                                        class="selected">All</a><a href="#"
                                        class="">Accesssories</a><a
                                        href="#" class="">Box</a><a
                                        href="#" class="">chair</a><a
                                        href="#" class="">Deco</a><a
                                        href="#"
                                        class="">Furniture</a><a
                                        href="#" class="">Glass</a><a
                                        href="#"
                                        class="">Pottery</a><a
                                        href="#" class="">Table</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-content" id="layouts-container">

                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            showProducts();
        });

        function showProducts() {
            let url = "{{ route('show-product-shop') }}";
            $.get(url, function(data) {
                renderData(data);
                window.history.pushState("", "",
                    `/shop`
                );

            })
        }
        $('.sorting_options a').on('click', (function(e) {

            if (!$(this).data('sort_by') || !$(this).data('sort_key')) {
                showProducts();
                return;
            }
            filter($(this).data('sort_by'), $(
                this).data(
                'sort_key'))

        }))

        function renderData(data) {
            return $('#layouts-container').html(data);

        }

        function filter(column = '', value = '') {
            let url =
                `{{ route('filter-product-shop') }}`;
            const data = {
                column,
                value
            }
            $.ajax({
                url: url,
                method: 'POST',
                data,
                success: function(response) {
                    if (response.success) {
                        renderData(response.view);

                        window.history.pushState("", "",
                            `?sort_by=${column}&sort_key=${value}`
                        );
                    }
                },
            });
        }
    </script>
@endsection
