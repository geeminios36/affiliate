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
                                        <a>Sort by <i
                                                class="fa fa-angle-down angle-down"></i></a>
                                        <ul class="sorting_options">
                                            <li>
                                                <a class="sort-link" data-sort_by=""
                                                    data-sort_key="">Default
                                                    sorting</a>
                                            </li>
                                            <li><a class="sort-link">Sort by
                                                    popularity</a></li>
                                            <li><a class="sort-link">Sort by
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
                                <div id="filter-items" class="py-2 my-2">

                                </div>
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
                    <div class="d-flex mb-2">
                        <a id="clear-btn"
                            class=" ml-auto btn btn-primary text-white rounded-2">Clear</a>
                    </div>
                    <div class="row">
                        <!-- Product Filter -->
                        <div class=" mb-20 col__20">
                            <div class="product-filter">
                                <h5>Color</h5>
                                <ul class="widget-nav-list">
                                    <li>
                                        <div class="filter-item" data-column='color'
                                            data-value='black'><span
                                                class="swatch-color black"></span>

                                            Black</div>
                                    </li>
                                    <li>
                                        <div class="filter-item" data-column='color'
                                            data-value='green'><span
                                                class="swatch-color green"></span>
                                            Green</div>
                                    </li>
                                    <li>
                                        <div><span class="swatch-color grey"></span>
                                            Grey</div>
                                    </li>
                                    <li>
                                        <div><span class="swatch-color red"></span>
                                            Red</div>
                                    </li>
                                    <li>
                                        <div class="filter-item" data-column='color'
                                            data-value='white'><span
                                                class="swatch-color white"></span>
                                            White</div>
                                    </li>
                                    <li>
                                        <div class="filter-item" data-column=''
                                            data-value=''><span
                                                class="swatch-color yellow"></span>
                                            Yellow</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Product Filter -->
                        <div class=" mb-20 col__20">
                            <div class="product-filter">
                                <h5>Size</h5>
                                <ul class="widget-nav-list">
                                    <li>
                                        <div class="filter-item" data-column=''
                                            data-value=''>Large
                                        </div>
                                    </li>
                                    <li>
                                        <div class="filter-item" data-column=''
                                            data-value=''>Medium
                                        </div>
                                    </li>
                                    <li>
                                        <div class="filter-item" data-column=''
                                            data-value=''>Small
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Product Filter -->
                        <div class=" mb-20 col__20">
                            <div class="product-filter">
                                <h5>Price</h5>
                                <ul class="widget-nav-list">
                                    <li>
                                        <div class="filter-item"
                                            data-column='unit_price'
                                            data-value='0-20000'>0 - 20.000</div>
                                    </li>
                                    <li>
                                        <div class="filter-item"
                                            data-column='unit_price'
                                            data-value='20000-100000'>20.000 -
                                            100.000
                                        </div>
                                    </li>
                                    <li>
                                        <div class="filter-item"
                                            data-column='unit_price'
                                            data-value='100000-200000'>
                                            100.000-200.000</div>
                                    </li>
                                    <li>
                                        <div class="filter-item"
                                            data-column='unit_price'
                                            data-value='500000-600000'>500.000 -
                                            600.000</div>
                                    </li>
                                    <li>
                                        <div class="filter-item"
                                            data-column='unit_price'
                                            data-value='600000'> > 600.000</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Product Filter -->

                        <div class=" mb-20 col__20">
                            <div class="product-filter">
                                <h5>Tags</h5>
                                <div class="tagcloud"><a
                                        class="selected">All</a><a
                                        class="">Accesssories</a><a
                                        class="">Box</a><a
                                        class="">chair</a><a
                                        class="">Deco</a><a
                                        class="">Furniture</a><a
                                        class="">Glass</a><a
                                        class="">Pottery</a><a
                                        class="">Table</a>
                                </div>
                            </div>
                        </div>
                        <div class=" mb-20 col-12">
                            <div class="product-filter">
                                <h5>Categories</h5>
                                <ul class="widget-nav-list row">
                                    @foreach ($categories as $category)
                                        <li class="col-6 col-md-4 col-lg-3">
                                            <div class="filter-item"
                                                data-column='categories'
                                                data-value='{{ $category->id }}'
                                                data-output='{{ $category->name }}'>
                                                {{ $category->name }}
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>

                    </div>
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
            const search_queries = window.location.search || ''
            let url = "{{ route('show-product-shop') }}";

            $.ajax({
                'url': url + search_queries,
                'type': 'GET',
                success: function(
                    response) { // What to do if we succeed
                    renderData(response);
                },

            });
        }

        $('.sorting_options a').on('click', (function(e) {


            const sort_by = $(this).data('sort_by');
            const key = $(this).data('sort_key');
            const search = window.location.search


            if (!search) {
                window.location.href += `?sort_by=${sort_by}&key=${key}`
                return
            }
            let href = window.location.href
            if (search.startsWith('?sort_by')) {
                const indexOfFirst = search
                    .indexOf('&')

                const indexOfSecond = search
                    .indexOf('&', indexOfFirst + 1)
                let old_query = ''
                if (indexOfSecond !== -1) {
                    old_query = search.slice(0,
                        indexOfSecond)

                } else {
                    old_query = search.slice(0,
                        search.length)
                }
                const query = `?sort_by=${sort_by}&key=${key}`
                href = href
                    .replace(old_query, query)

            } else {
                const indexStart = search.indexOf(
                    '&sort_by')
                const old_query = search.slice(indexStart,
                    search.length)
                const query = `&sort_by=${sort_by}&key=${key}`
                href = href
                    .replace(old_query,
                        query)
            }
            window.location.href = href


        }))

        function renderData(data) {
            return $('#layouts-container').html(data);

        }

        let data = {
            unit_price: [],
            color: [],
            size: [],
            categories: [],
            tags: []
        }

        let output = {
            unit_price: [],
            color: [],
            size: [],
            categories: [],
            tags: []
        }

        function renderSelectedFilterOptions() {
            const values = Object.values(output).flat();
            let html;
            html = values.map(value => {
                return `<span class=" p-1 rounded-2 bg-light text-primary mx-1" data-column='' data-value=''>${value}</span>`
            })
            $('#filter-items').html(html);

        }
        let count = 10;
        let time
        $('#clear-btn').on('click', function() {
            if (window.location.search) {
                window.location.href = window.location.origin + window
                    .location
                    .pathname
            }
            output = {
                unit_price: [],
                color: [],
                size: [],
                categories: [],
                tags: []
            }
            clearInterval(time)
            console.log('count', count)
            renderSelectedFilterOptions();

        })

        $('.filter-item').on('click', function() {
            count = 10;
            clearInterval(time)
            time = setInterval(function() {
                console.log('count', count)

                if (count === 0) {
                    clearInterval(time);
                    filterProduct()
                }
                count--;
            }, 1000);
            const url = window.location.href;
            const column = $(this).data('column');
            const value = $(this).data('value');
            const output = $(this).data('output');
            if (column === 'categories') {
                combineCategories(value, output)
            }
            if (column === 'unit_price') {
                combineUnitPrice(value)
            }


            renderSelectedFilterOptions();
        })



        function combineCategories(value = '', input = '') {
            if (data.categories.includes(value)) {
                data.categories = data.categories?.filter(item =>
                    item !==
                    value)
                output.categories = output.categories?.filter(
                    item => item !==
                    input)
            } else {
                data?.categories?.push(value)
                output?.categories?.push(input)
            }
        }

        function combineUnitPrice(input = '') {
            if (output.unit_price.includes(input)) {
                data.unit_price = data.unit_price?.filter(item => item !==
                    input)
                output.unit_price = data.unit_price?.filter(item => item !==
                    input)
            } else {
                data?.unit_price?.push(input)
                output.unit_price.push(input)
            }
        }

        function filterProduct() {

            const keys = Object.keys(data).filter(key => data[
                key].length > 0);
            let filter_query = ''
            for (let index = 0; index < keys.length; index++) {
                const key = keys[index];
                const values = data[key];
                if (filter_query === '') {
                    filter_query += `${key}=${values}`
                    continue
                }
                filter_query += `&${key}=${values}`
            }
            const search = window.location.search
            if (!search.includes('sort_by')) {
                window.location.href += `?${filter_query}`
                return
            }

            let href = ''
            if (search.startsWith('?sort_by')) {

                const query = `&${filter_query}`
                const indexOfFirst = search
                    .indexOf('&')

                const indexOfSecond = search
                    .indexOf('&', indexOfFirst + 1)

                if (indexOfSecond === -1) {
                    href = search + query
                } else {
                    href = search.slice(0, indexOfSecond) + query
                }


            } else {
                const query = `?${filter_query}`

                const start = search.indexOf(
                    '&sort_by')

                href = query + search.slice(start, search.length)


            }
            window.location.href = href
        }
    </script>
@endsection
