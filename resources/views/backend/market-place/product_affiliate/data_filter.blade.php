<div class="wrapper-header-list">
    <div class="d-flex align-items-center header-list sapo-product-header di4l-product-header-menu">
        <div role="presentation" class="checkbox sapo-product-header-checkbox uncheck"><input
                    id="product-header-checkbox"
                    type="checkbox" name="check" readonly=""><label onclick="setCheckBox()"></label>
        </div>
        <div class="margin-right20 header-sapo-product-image">&nbsp;</div>
        <div class="margin-right20 header-sapo-product-name">Tên sản phẩm </div>
        <div class="margin-right20 header-sapo-tenant-name">Số sản phẩm liên kết</div>
        <div class="margin-right20 header-sapo-connection-status">Có thể bán</div>
        <div class="header-product-action margin-left header-sapo-manipulation-status">
            Thao tác
        </div>
    </div>
    @foreach($productStocks as $productStock)
        <div class="d-flex flex-wrap align-items-center sapo-product-item" role="presentation">
            <div role="presentation" class="item-icon item-icon-{{$productStock->id}}"
                 onclick="showDetailProduct({{$productStock->id}})">
                <svg width="12" height="11" viewBox="0 0 12 11" fill="none"
                     xmlns="http://www.w3.org/2000/svg" class="" style="cursor: pointer;">
                    <path d="M0.979004 1L5.479 5.5L0.979004 10" stroke="#0088FF"></path>
                    <path d="M5.979 1L10.479 5.5L5.979 10" stroke="#0088FF"></path>
                </svg>
            </div>
            <div class="checkbox item-checkbox">
                <input type="checkbox" class="checkbox checkbox-add" value="{{$productStock->id}}"
                       id="input-item-checkbox-{{$productStock->id}}"
                       name="check" readonly="" disabled=""><label
                        class="checkbox item-checkbox2 " onclick="setCheckBox({{$productStock->id}})"
                        style="cursor: pointer;"></label></div>
            <div class="margin-right20 item-image">
                <img alt="product-thumb"
                     src="{{ uploaded_asset($productStock->product->thumbnail_img)}}">
            </div>
            <div class="margin-right20 item-product">
                <div class="text-ellipsis item-name"><span data-tip="true"
                                                           data-for="_sapo_product_name_id_0"
                                                           currentitem="false"><a
                                href="{{route('products.admin.edit', $productStock->product->id)}}"
                                target="_blank">{{$productStock->product->name}} - {{$productStock->variant}}</a></span>
                    <div class="__react_component_tooltip place-top type-dark product-name-tooltip"
                         id="_sapo_product_name_id_0"
                         data-id="tooltip">{{$productStock->product->name}}
                        - {{$productStock->variant}}
                    </div>
                </div>
                <div class="text-ellipsis item-sku"><span data-tip="true" data-for="sku_id_0"
                                                          currentitem="false"><span
                                class="sku-value"
                                role="presentation">{{$productStock->sku}}</span></span>
                    <div class="__react_component_tooltip place-top type-dark" id="sku_id_0"
                         data-id="tooltip">{{$productStock->sku}}
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center margin-right20 item-connections">
                                <span
                                        data-tip="true" data-for="_connections_id_0"
                                        currentitem="false">{{count($productStock->linked_market_products)}} liên kết</span>
                <div class="__react_component_tooltip place-top type-dark" id="_connections_id_0"
                     data-id="tooltip">{{count($productStock->linked_market_products)}} liên kết
                </div>
            </div>
            <div class="d-flex align-items-center margin-right20 item-available">
                                <span
                                        data-tip="true" data-for="available_id_0" currentitem="false"><span
                                            class="quantities-value"
                                            role="presentation">{{$productStock->qty}}</span></span>
                <div class="__react_component_tooltip place-top type-dark" id="available_id_0"
                     data-id="tooltip">{{$productStock->qty}}
                </div>
            </div>
            <div class="d-flex align-items-center margin-right20 item-manipulation">
                @if(count($productStock->linked_market_products))
                    <button type="button" class="manipulation-unlink" data-tip="true"
                            title="Hủy liên kết"
                            onclick="__$disconnectProduct({{$productStock->id}})"
                            data-for="item_instant_cancel0" currentitem="false">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M13.5885 10.9665L15.556 9C16.4235 8.12965 16.9107 6.95089 16.9107 5.722C16.9107 4.49312 16.4235 3.31435 15.556 2.44401C14.6859 1.576 13.507 1.08854 12.278 1.08854C11.049 1.08854 9.8701 1.576 9 2.44401L8.34449 3.09952L9.65551 4.41053L10.311 3.75502C10.8335 3.23487 11.5407 2.94285 12.278 2.94285C13.0152 2.94285 13.7225 3.23487 14.245 3.75502C14.7656 4.27727 15.0579 4.9846 15.0579 5.722C15.0579 6.45941 14.7656 7.16674 14.245 7.68899L12.2775 9.65551C12.0522 9.87931 11.7868 10.0586 11.495 10.184L10.311 9L11.622 7.68899L10.9665 7.03348C10.5372 6.60153 10.0265 6.25906 9.46386 6.0259C8.90126 5.79274 8.29799 5.67353 7.68899 5.67518C7.4711 5.67518 7.25878 5.70485 7.04832 5.73637L1.31101 0L0 1.31101L16.689 18L18 16.689L12.8672 11.5562C13.124 11.3856 13.366 11.189 13.5885 10.9665ZM7.68899 14.245C7.1665 14.7651 6.45926 15.0571 5.722 15.0571C4.98475 15.0571 4.27751 14.7651 3.75502 14.245C3.23442 13.7227 2.94209 13.0154 2.94209 12.278C2.94209 11.5406 3.23442 10.8333 3.75502 10.311L5.12352 8.94344L3.81251 7.63243L2.44401 9C1.57645 9.87034 1.0893 11.0491 1.0893 12.278C1.0893 13.5069 1.57645 14.6856 2.44401 15.556C2.8741 15.9867 3.38505 16.3282 3.94752 16.5608C4.50998 16.7934 5.11287 16.9126 5.72154 16.9115C6.33037 16.9128 6.93345 16.7937 7.49609 16.561C8.05873 16.3284 8.56983 15.9868 9 15.556L9.65551 14.9005L8.34449 13.5895L7.68899 14.245Z"
                                    fill="#EE405E"></path>
                        </svg>
                    </button>
                    <div class="__react_component_tooltip place-top type-dark auto-map"
                         id="item_instant_cancel0" data-id="tooltip"
                         style="left: 1391px; top: 289px;">Hủy
                        liên kết
                    </div>
                @else
                    <button type="button" class="manipulation-link" data-tip="true"
                            onclick="__$linkProduct({{$productStock->id}})"
                            data-for="item_instant_map0" currentitem="false">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M5.2706 8.25433C6.46561 7.05933 8.54975 7.05933 9.74475 8.25433L10.4904 9.00002L11.9818 7.50864L11.2361 6.76295C10.2415 5.76729 8.91679 5.21777 7.50768 5.21777C6.09856 5.21777 4.77383 5.76729 3.77922 6.76295L1.54109 9.00002C0.554176 9.99011 0 11.3311 0 12.729C0 14.127 0.554176 15.4679 1.54109 16.458C2.03035 16.948 2.6116 17.3364 3.25145 17.601C3.8913 17.8657 4.57714 18.0013 5.26955 18C5.96215 18.0015 6.6482 17.866 7.28825 17.6013C7.92829 17.3367 8.50971 16.9481 8.99906 16.458L9.74475 15.7123L8.25337 14.2209L7.50768 14.9666C6.91331 15.5583 6.10877 15.8905 5.27008 15.8905C4.43139 15.8905 3.62684 15.5583 3.03247 14.9666C2.44025 14.3725 2.1077 13.5679 2.1077 12.729C2.1077 11.8902 2.44025 11.0855 3.03247 10.4914L5.2706 8.25433Z"
                                    fill="#006AFF"></path>
                            <path
                                    d="M8.999 1.54196L8.25331 2.28765L9.74469 3.77904L10.4904 3.03334C11.0848 2.44163 11.8893 2.10943 12.728 2.10943C13.5667 2.10943 14.3712 2.44163 14.9656 3.03334C15.5578 3.62744 15.8904 4.43209 15.8904 5.27095C15.8904 6.10981 15.5578 6.91445 14.9656 7.50855L12.7275 9.74562C11.5325 10.9406 9.44832 10.9406 8.25331 9.74562L7.50762 8.99993L6.01624 10.4913L6.76193 11.237C7.75653 12.2327 9.08127 12.7822 10.4904 12.7822C11.8995 12.7822 13.2242 12.2327 14.2188 11.237L16.457 8.99993C17.4439 8.00984 17.9981 6.6689 17.9981 5.27095C17.9981 3.87299 17.4439 2.53205 16.457 1.54196C15.4672 0.554531 14.1261 0 12.728 0C11.3299 0 9.98882 0.554531 8.999 1.54196Z"
                                    fill="#006AFF"></path>
                        </svg>
                    </button>
                    <div class="__react_component_tooltip place-top type-dark"
                         id="item_instant_map0"
                         data-id="tooltip">Liên kết nhanh
                    </div>
                @endif
            </div>
            <div class=" flex-wrap sapo-product-detail " style="display:none !important;"
                 id="product-detail-{{$productStock->id}}">
                <div class="sapo-product-detail-wrapper">
                    <div class="d-flex align-items-center detail-header" role="presentation">
                        <div class="sapo-detail-tenant"><span class="detail-text">Gian hàng</span>
                        </div>
                        <div class="sapo-detail-product-info"><span class="detail-text">Sản phẩm liên kết</span>
                        </div>
                        <div class="sapo-detail-connections-status">Trạng thái liên kết</div>
                        <div class="sapo-detail-price">Giá bán</div>
                        <div class="sapo-detail-quantity">Tồn kho</div>
                        <div class="sapo-detail-manipulation">Thao tác</div>
                    </div>
                    @foreach($connectedMarket as $connectedMarketInfo)
                        @include('backend.market-place.product_affiliate.linked_product')
                    @endforeach
                    <div class="announce-meta-data">
                        Dữ liệu được đồng bộ tự động từ  lên các gian hàng có sản phẩm liên kết
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="d-flex products-footer sapo-product-footer">
    {!! $productStocks->links() !!}
</div>
