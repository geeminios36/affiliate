<div class="sapo-product-detail-list">
    <div class="d-flex flex-wrap sapo-product-detail-item"
         role="presentation">
        <div class="sapo-detail-tenant">
            <div class="position-relative d-flex align-items-center text-ellipsis channel-info" role="presentation">
                <img src="{{static_asset($connectedMarketInfo->logo)}}" width="40px"> &nbsp; &nbsp;
                <span class="text-ellipsis">
                    <span data-tip="true"
                          data-for="_name_connection_0">{{$connectedMarketInfo->ecommerce_market_place_config->shorted_name}}</span>
                </span>
            </div>
        </div>
        <?php
        $linkedMarketProducts = $productStock->linked_market_products->where('ecommerce_market_place_id', $connectedMarketInfo->id);
        ?>
        @if(count($linkedMarketProducts) > 0)
            @foreach($linkedMarketProducts as $linkedMarketProductInfo)
                <?php
                $productInfo = json_decode($linkedMarketProductInfo->product_detail);
                ?>
                    <div class="sapo-product-tenant-info">
                        <div class="d-container">
                            <div class="align-items-center sapo-detail-product-info">
                                <div class="sapo-product-detail-thumb">
                                    <div class="margin-right20 item-image">
                                        <img alt="product-thumb"
                                             src="{{ $productInfo->result->avatar->picture_url}}">
                                    </div>
                                </div>
                                <div class="margin-right20 item-product" style="width: 65% !important;">
                                    <div class="text-ellipsis item-name"><span data-tip="true"
                                                                               data-for="_sapo_product_name_id_0"
                                                                               currentitem="false"><a
                                                href="#"
                                                target="_blank">{{$productInfo->result->name}}</a></span>
                                        <div class="__react_component_tooltip place-top type-dark product-name-tooltip"
                                             id="_sapo_product_name_id_0"
                                             data-id="tooltip">{{$productInfo->result->name}}</div>
                                    </div>
                                    <div class="text-ellipsis item-sku"><span data-tip="true" data-for="sku_id_0"
                                                                              currentitem="false"><span
                                                class="sku-value"
                                                role="presentation">{{$productInfo->result->sku}}</span></span>
                                        <div class="__react_component_tooltip place-top type-dark" id="sku_id_0"
                                             data-id="tooltip">{{$productInfo->result->sku}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sapo-detail-connections-status"><span
                                    data-tip="true"
                                    data-for="mapping-status-0"
                                    role="presentation"
                                    style="color: rgb(33, 43, 53);"><a href="#">
                                    Đã liên kết
                                </a></span>
                            </div>
                            <div class="sapo-detail-price">
                                {{number_format($productInfo->result->price)}}
                            </div>
                            <div class="sapo-detail-quantity">
                                {{$productInfo->result->stock_quantity}}
                            </div>
                            <div class="sapo-detail-manipulation">
                                <div class="d-flex align-items-center margin-right20 item-manipulation">
                                    <button type="button" class="manipulation-unlink" data-tip="true" title="Hủy liên kết"
                                            onclick="__$disconnectProduct({{$linkedMarketProductInfo->id}}, {{$connectedMarketInfo->id}})"
                                            data-for="item_instant_cancel0" currentitem="false">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.5885 10.9665L15.556 9C16.4235 8.12965 16.9107 6.95089 16.9107 5.722C16.9107 4.49312 16.4235 3.31435 15.556 2.44401C14.6859 1.576 13.507 1.08854 12.278 1.08854C11.049 1.08854 9.8701 1.576 9 2.44401L8.34449 3.09952L9.65551 4.41053L10.311 3.75502C10.8335 3.23487 11.5407 2.94285 12.278 2.94285C13.0152 2.94285 13.7225 3.23487 14.245 3.75502C14.7656 4.27727 15.0579 4.9846 15.0579 5.722C15.0579 6.45941 14.7656 7.16674 14.245 7.68899L12.2775 9.65551C12.0522 9.87931 11.7868 10.0586 11.495 10.184L10.311 9L11.622 7.68899L10.9665 7.03348C10.5372 6.60153 10.0265 6.25906 9.46386 6.0259C8.90126 5.79274 8.29799 5.67353 7.68899 5.67518C7.4711 5.67518 7.25878 5.70485 7.04832 5.73637L1.31101 0L0 1.31101L16.689 18L18 16.689L12.8672 11.5562C13.124 11.3856 13.366 11.189 13.5885 10.9665ZM7.68899 14.245C7.1665 14.7651 6.45926 15.0571 5.722 15.0571C4.98475 15.0571 4.27751 14.7651 3.75502 14.245C3.23442 13.7227 2.94209 13.0154 2.94209 12.278C2.94209 11.5406 3.23442 10.8333 3.75502 10.311L5.12352 8.94344L3.81251 7.63243L2.44401 9C1.57645 9.87034 1.0893 11.0491 1.0893 12.278C1.0893 13.5069 1.57645 14.6856 2.44401 15.556C2.8741 15.9867 3.38505 16.3282 3.94752 16.5608C4.50998 16.7934 5.11287 16.9126 5.72154 16.9115C6.33037 16.9128 6.93345 16.7937 7.49609 16.561C8.05873 16.3284 8.56983 15.9868 9 15.556L9.65551 14.9005L8.34449 13.5895L7.68899 14.245Z"
                                                fill="#EE405E"></path>
                                        </svg>
                                    </button>
                                    <div class="__react_component_tooltip place-top type-dark auto-map"
                                         id="item_instant_cancel0" data-id="tooltip" style="left: 1391px; top: 289px;">Hủy
                                        liên kết
                                    </div>
                                    <button onclick="__$linkProduct({{$productStock->id}}, {{$connectedMarketInfo->id}})"
                                            type="button" class="btn manipulation-resync" data-tip="true"
                                            title="Đồng bộ lại"
                                            data-for="_sub_resync0" currentitem="false">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18.0643 8.7155C17.8248 8.78221 17.5686 8.75109 17.3521 8.62898C17.1355 8.50686 16.9763 8.30375 16.9095 8.06429C16.4888 6.57084 15.5999 5.25184 14.3736 4.30136C13.12 3.33597 11.5822 2.81247 10 2.81247C8.41781 2.81247 6.88005 3.33597 5.62649 4.30136C5.1611 4.66149 4.74165 5.07735 4.37754 5.53964L3.63817 5.7571L3.52246 3.67386C5.06883 2.0841 7.14571 1.11837 9.35787 0.960454C11.57 0.80254 13.763 1.46347 15.5195 2.81745C17.0651 4.01559 18.1854 5.67819 18.7154 7.56061C18.7822 7.8001 18.7511 8.0563 18.629 8.27288C18.5069 8.48946 18.3038 8.64867 18.0643 8.7155ZM16.0493 14.2428L15.31 14.4603C14.9459 14.9226 14.5264 15.3385 14.0611 15.6986C12.8075 16.664 11.2697 17.1875 9.68752 17.1875C8.10531 17.1875 6.56755 16.664 5.31399 15.6986C4.08762 14.7481 3.1987 13.4291 2.77805 11.9357C2.74498 11.8171 2.68887 11.7061 2.61293 11.6092C2.537 11.5123 2.44272 11.4313 2.33548 11.3709C2.22824 11.3104 2.11013 11.2716 1.98792 11.2568C1.8657 11.242 1.74176 11.2514 1.62317 11.2844C1.50458 11.3175 1.39366 11.3736 1.29675 11.4496C1.19985 11.5255 1.11885 11.6198 1.05838 11.727C0.997905 11.8343 0.959149 11.9524 0.944321 12.0746C0.929493 12.1968 0.938883 12.3207 0.971954 12.4393C1.50203 14.3218 2.62231 15.9843 4.16797 17.1825C5.92314 18.5398 8.11693 19.2029 10.3301 19.0449C12.5433 18.8869 14.6206 17.919 16.1652 16.326L16.0493 14.2428ZM2.45199 8.71182L7.76449 7.14932C7.88355 7.11541 7.99471 7.05826 8.09156 6.98117C8.18841 6.90407 8.26903 6.80856 8.32878 6.70014C8.38852 6.59172 8.4262 6.47254 8.43964 6.34948C8.45308 6.22642 8.44202 6.10192 8.40709 5.98316C8.37216 5.8644 8.31406 5.75374 8.23614 5.65755C8.15822 5.56136 8.06201 5.48156 7.95309 5.42275C7.84416 5.36394 7.72467 5.32728 7.6015 5.31489C7.47833 5.3025 7.35393 5.31463 7.23547 5.35057L3.05789 6.57925L2.81102 2.13546C2.80531 2.01173 2.77515 1.89036 2.72226 1.77836C2.66938 1.66636 2.59483 1.56595 2.50292 1.48293C2.41101 1.39991 2.30355 1.33593 2.18677 1.29467C2.06998 1.25342 1.94618 1.23571 1.82252 1.24258C1.69885 1.24945 1.57777 1.28076 1.46628 1.33469C1.35478 1.38863 1.25507 1.46412 1.17292 1.55681C1.09077 1.6495 1.0278 1.75755 0.987643 1.87472C0.947491 1.99188 0.930953 2.11585 0.938985 2.23944L1.25149 7.86444C1.25933 8.00555 1.29897 8.14305 1.36745 8.26667C1.43593 8.3903 1.53147 8.49684 1.64693 8.57833C1.76238 8.65983 1.89477 8.71416 2.03419 8.73728C2.17361 8.7604 2.31645 8.7517 2.45203 8.71182H2.45199ZM17.8645 18.7485C18.1127 18.7347 18.3453 18.6228 18.5111 18.4375C18.6769 18.2522 18.7623 18.0087 18.7485 17.7604L18.436 12.1354C18.4282 11.9943 18.3885 11.8568 18.3201 11.7332C18.2516 11.6095 18.156 11.503 18.0406 11.4215C17.9251 11.34 17.7927 11.2857 17.6533 11.2626C17.5139 11.2395 17.371 11.2482 17.2354 11.288L11.9231 12.8505C11.6856 12.9216 11.486 13.0838 11.3678 13.3017C11.2496 13.5196 11.2225 13.7754 11.2924 14.0132C11.3624 14.2511 11.5237 14.4515 11.741 14.5707C11.9583 14.6899 12.2141 14.7182 12.4522 14.6493L16.6296 13.4207L16.8765 17.8644C16.8898 18.1035 16.994 18.3285 17.168 18.4932C17.3419 18.6579 17.5722 18.7497 17.8117 18.75C17.8292 18.75 17.8468 18.7495 17.8645 18.7485Z"
                                                fill="#0084FF"></path>
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

            @endforeach
        @else
            <div class="sapo-product-tenant-info">
                <div class="d-container">
                    <div class="align-items-center sapo-detail-product-info">
                        <div class="sapo-product-detail-thumb">
                            <div class="no-image-content"></div>
                        </div>
                        <div class="d-flex flex-column text-ellipsis name-info"><span
                                class="text-ellipsis detail-text"
                                style="color: rgb(0, 0, 0);">---</span></div>
                    </div>
                    <div class="sapo-detail-connections-status"><span
                            data-tip="true"
                            data-for="mapping-status-0"
                            role="presentation"
                            style="color: rgb(33, 43, 53);">Chưa liên kết</span>
                    </div>
                    <div class="sapo-detail-price">
                        ---
                    </div>
                    <div class="sapo-detail-quantity">
                        ---
                    </div>
                    <div class="sapo-detail-manipulation">
                        <button onclick="__$linkProduct({{$productStock->id}}, {{$connectedMarketInfo->id}})"
                                type="button" class="btn manipulation-link" data-tip="true" data-for="_sub_auto_map0"
                                currentitem="false"
                                title="Liên kết từ {{$connectedMarketInfo->ecommerce_market_place_config->shorted_name}} <->   "
                                id="auto_link_product">
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
                        {{--                        <div class="select-product-to-map" role="presentation" data-tip="true"--}}
                        {{--                             data-for="_mapping_handler">--}}
                        {{--                            <div>--}}
                        {{--                                <button type="button" class="manipulation-link" data-tip="true"--}}
                        {{--                                        data-for="_sub_manual_map" currentitem="false">--}}
                        {{--                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"--}}
                        {{--                                         xmlns="http://www.w3.org/2000/svg">--}}
                        {{--                                        <path--}}
                        {{--                                            d="M12.6964 8.35711H9.64282V5.30354C9.64282 5.21514 9.5705 5.14282 9.48211 5.14282H8.51782C8.42943 5.14282 8.35711 5.21514 8.35711 5.30354V8.35711H5.30354C5.21514 8.35711 5.14282 8.42943 5.14282 8.51782V9.48211C5.14282 9.5705 5.21514 9.64282 5.30354 9.64282H8.35711V12.6964C8.35711 12.7848 8.42943 12.8571 8.51782 12.8571H9.48211C9.5705 12.8571 9.64282 12.7848 9.64282 12.6964V9.64282H12.6964C12.7848 9.64282 12.8571 9.5705 12.8571 9.48211V8.51782C12.8571 8.42943 12.7848 8.35711 12.6964 8.35711Z"--}}
                        {{--                                            fill="#006AFF"></path>--}}
                        {{--                                        <path--}}
                        {{--                                            d="M9 0C4.02991 0 0 4.02991 0 9C0 13.9701 4.02991 18 9 18C13.9701 18 18 13.9701 18 9C18 4.02991 13.9701 0 9 0ZM9 16.4732C4.87366 16.4732 1.52679 13.1263 1.52679 9C1.52679 4.87366 4.87366 1.52679 9 1.52679C13.1263 1.52679 16.4732 4.87366 16.4732 9C16.4732 13.1263 13.1263 16.4732 9 16.4732Z"--}}
                        {{--                                            fill="#006AFF"></path>--}}
                        {{--                                    </svg>--}}
                        {{--                                </button>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
