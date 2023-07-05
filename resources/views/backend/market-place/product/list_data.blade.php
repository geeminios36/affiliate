@include('backend.market-place.market-place-style')
@include('backend.market-place.connect_style')
<style>
    .product-wrapper .product-list-wrapper #products-filter-empty-wrapper {
        height: 800px !important;
    }
</style>
<div id="app">
    <div id="market-place-wrapper">
        <div id="market-place-content" style="margin-top: 4px;">
            <div class="product-wrapper">
                {{--                <div class="product_warning_container">--}}
                {{--                    <button class="btn btn-close" type="button" style="font-size: 30px;">×</button>--}}
                {{--                    <div class="product_warning_content">--}}
                {{--                        <div class="product_warning_image">--}}
                {{--                            <svg width="53" height="45" viewBox="0 0 53 45" fill="none"--}}
                {{--                                 xmlns="http://www.w3.org/2000/svg">--}}
                {{--                                <path--}}
                {{--                                    d="M22.1744 2.53862L0.748304 37.2134C0.306548 37.955 0.0728059 38.7959 0.0703323 39.6522C0.0678588 40.5086 0.29674 41.3507 0.734205 42.0947C1.17167 42.8387 1.80247 43.4587 2.56385 43.893C3.32522 44.3273 4.19064 44.5608 5.07399 44.5702H47.9261C48.8094 44.5608 49.6749 44.3273 50.4362 43.893C51.1976 43.4587 51.8284 42.8387 52.2659 42.0947C52.7033 41.3507 52.9322 40.5086 52.9297 39.6522C52.9273 38.7959 52.6935 37.955 52.2518 37.2134L30.8257 2.53862C30.3748 1.81792 29.7398 1.22206 28.9821 0.808521C28.2244 0.394984 27.3696 0.177734 26.5 0.177734C25.6305 0.177734 24.7757 0.394984 24.018 0.808521C23.2603 1.22206 22.6253 1.81792 22.1744 2.53862Z"--}}
                {{--                                    fill="#FE9214"></path>--}}
                {{--                                <path d="M26.4995 9.07617L26.4995 29.5348" stroke="white" stroke-width="4"--}}
                {{--                                      stroke-linecap="round" stroke-linejoin="round"></path>--}}
                {{--                                <ellipse cx="26.8091" cy="38.1787" rx="3.30372" ry="3.17089" fill="white"></ellipse>--}}
                {{--                            </svg>--}}
                {{--                        </div>--}}
                {{--                        <div class="product_warning_text">--}}
                {{--                            <div>Kể từ thời điểm bạn liên kết sản phẩm giữa Sendo và , thì tất cả các thông tin về--}}
                {{--                                giá và tồn kho của sản phẩm trên Sendo sẽ được đồng bộ theo . Do vậy theo<span--}}
                {{--                                    class="text_black_bold"> chính sách của Sendo.vn</span><span>, khi cập nhật giá của nhiều sản phẩm cùng lúc, thì các sản phẩm đó có thể sẽ được kiểm duyệt lại trên sàn Sendo.</span>&nbsp;<a--}}
                {{--                                    href=" https://ban.sendo.vn/chinh-sach-nguoi-ban/36-5-quy-dinh-kiem-duyet/93-1-dang-san-pham"--}}
                {{--                                    target="_blank">Tìm hiểu thêm về chính sách kiểm duyệt của Sendo</a></div>--}}
                {{--                            <div class="text_bottom">Để không bị kiểm duyệt lại, vui lòng tắt cấu hình đồng bộ giá tự--}}
                {{--                                động trước khi liên kết sản phẩm. Sau khi liên kết xong, bạn mở lại cấu hình đồng bộ giá--}}
                {{--                                tự động.--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="product-dashboard-header">
                    <div id="filter-product-by-store">
                        <div id="fpbs-btn">
                            <div id="fpbs-list-store-avatar">
                                @foreach($connectedMarket as $connectedMarketInfo)
                                    <div class="fpbs-store-avatar" style="z-index: 3;"><img
                                            class="fpbs-store-avatar-img"
                                            src="{{static_asset($connectedMarketInfo->logo)}}"
                                            alt="store-avatar"></div>
                                @endforeach
                            </div>
                            <div id="fpbs-text">Tất cả gian hàng ({{count($connectedMarket)}})</div>
                            <div id="fpbs-icon">
                                <svg width="11" height="6" viewBox="0 0 11 6" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.979 0H0.979004L5.979 6L10.979 0Z" fill="#4F4F4F"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    @include('backend.market-place.product.modal.filter-product-by-store')
                    <div class="d-flex list-header">
                        <div class="header-title">Danh sách sản phẩm</div>
                        <div class="">
                            <button class="btn btn-primary-customized connect-instance " id="btn_tour_02" type="button"
                                    onclick="_modalChoiceMarket()">
                                Liên kết nhanh
                            </button>
                        </div>
                        <div class="">
                            <button class="btn btn-primary update-info " id="btn_tour_01" type="button"
                                    onclick="_syncingProducts()">Cập nhật dữ liệu
                                sản phẩm
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="product-dashboard-body" style="overflow-x: hidden"
                    id="product_dashboard_body">
                    <div id="product-table-header" style="position: relative;">
                        <div id="filter-product-wrapper">
                            <div id="filter-product-by-tab-wrapper">
                                <ul id="filter-product-by-tab">
                                    <li class="filter-product-tab active" type-check="0">Tất cả sản phẩm</li>
                                    <li class="filter-product-tab " type-check="1">Liên kết thành công</li>
                                    <li class="filter-product-tab " type-check="2">Chưa liên kết</li>
                                </ul>
                            </div>
                            <div id="filter-product-option-wrapper">
                                <div id="filter-product-search"
                                     style="    border: 1px solid #E0E0E0 !important; margin-left: 20px !important;">
                                    <div id="filter-product-search-icon">
                                        <svg width="16" height="16" viewBox="0 0 12 12" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.4446 10.3082C7.89928 10.3082 9.88919 8.2244 9.88919 5.65387C9.88919 3.08334 7.89928 0.999512 5.4446 0.999512C2.98991 0.999512 1 3.08334 1 5.65387C1 8.2244 2.98991 10.3082 5.4446 10.3082Z"
                                                stroke="#828282" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M11.0005 11.4713L8.58374 8.94043" stroke="#828282"
                                                  stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                    <input id="filter-product-search-input" placeholder="Tìm kiếm sản phẩm" value=""
                                           onkeyup="searchProducts()">
                                </div>
                            </div>

                        </div>
                        <div id="filter-product-modal-wrapper" style="display: none">
                            @include('backend.market-place.product.modal.filter-product-status')
                        </div>
                    </div>
                    <div class="dashboard-body-content">
                        <div class="content-container">
                            <div class="product-list-wrapper" style="padding: 0 20px !important;">
                                <div id="products-filter-empty-wrapper">
                                    @include('backend.market-place.product.no_data')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="notification-wrapper"></div>
</div>

@include('backend.market-place.cdn.library')

@include('backend.market-place.product_affiliate.modal.choice_market')
@include('backend.market-place.product_affiliate.modal.choice_market_un_syne')
@include('backend.market-place.product.product_in_market_js')
