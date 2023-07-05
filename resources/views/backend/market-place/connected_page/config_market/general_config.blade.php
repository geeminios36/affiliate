@include('backend.market-place.market-place-style')
@include('backend.market-place.connect_style')

<div id="app">
    <div id="market-place-wrapper">
        <div id="market-place-content" style="margin-top: 4px;">
            <div class="container_settings">
                <div class="store-wrapper">
                    <div class="store-dashboard-header">
                        <div id="filter-by-store">
                            <div id="filter-by-connection">
                                <div id="fobs-btn" class="selected" role="presentation">
                                    <div id="fobs-list-store-avatar">
                                        @foreach($ecommerceMarketPlacesGroupType as $type => $ecommerceMarketPlacesGroupTypeData)
                                            <?php
                                            $ecommerceMarketPlaceFirst = $ecommerceMarketPlacesGroupTypeData[0];
                                            ?>
                                            <div class="fobs-store-avatar" style="z-index: 3;"><img
                                                    class="fobs-store-avatar-img"
                                                    src="{{static_asset($ecommerceMarketPlaceFirst->logo)}}"
                                                    alt="store-avatar"></div>
                                        @endforeach
                                    </div>
                                    <div id="fobs-text">Tất cả gian hàng</div>
                                </div>
                            </div>
                            @foreach($ecommerceMarketPlacesGroupType as $type => $ecommerceMarketPlacesGroupTypeData)
                                <?php
                                $ecommerceMarketPlaceFirst = $ecommerceMarketPlacesGroupTypeData[0];
                                $type_market = config('market_place.type_market')[$type];
                                ?>
                                <button id="filter-by-{{strtolower($type_market)}}-store"
                                        class="filter-by-channel-type " type="button">
                                    <div id="Icons-store-avatar">
                                        <div class="icons-store-avatar"><img class="icons-store-avatar-img"
                                                                             style="margin-top: 5px"
                                                                             src="{{static_asset($ecommerceMarketPlaceFirst->logo)}}"
                                                                             alt="icon-avatar"></div>
                                    </div>
                                    <span
                                        class="{{strtolower($type_market)}}-store">{{config('market_place.type_market')[$type]}}</span>
                                    ({{count($ecommerceMarketPlacesGroupTypeData)}})
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="store-dashboard-body" id="store_dashboard_body"
                         style="    padding-bottom: 10px;min-height: 0 !important;">
                        <div class="dashboard-body-content">
                            <div class="content-container">
                                <div class="store-list-wrapper">
                                    <div class="d-flex header-list store-header">
                                        <div class="margin-right20 header-store-name">Gian hàng</div>
                                        <div class="margin-right20 header-store-created">Ngày kết nối</div>
                                        <div class="margin-right20 header-sapo-go-chat">Kịch hoạt</div>
                                        <div class="margin-right20 header-store-options">Thao tác</div>
                                    </div>
                                    <div class="store-list-container">
                                        @foreach($ecommerceMarketPlaces as $key => $ecommerceMarketPlace)
                                            <?php
                                            $shorted_name = @$ecommerceMarketPlace->ecommerce_market_place_config->shorted_name;
                                            ?>
                                            <div role="presentation" class="d-flex store-item">
                                                <div role="presentation" class="margin-right20 item-list item-store">
                                                    <div class="market"><img class="fobs-store-avatar"
                                                                             src="{{static_asset($ecommerceMarketPlace->logo)}}"
                                                                             alt="store-avatar">
                                                        <div class="market-name">
                                                            <div class="text-ellipsis short-name"><span data-tip="true"
                                                                                                        data-for="short_name_id_{{$key}}"
                                                                                                        currentitem="false">{{$shorted_name}}</span>
                                                                <div
                                                                    class="__react_component_tooltip place-top type-dark"
                                                                    id="short_name_id_{{$key}}"
                                                                    data-id="tooltip">{{$shorted_name}}</div>
                                                            </div>
                                                            <div class="text-ellipsis cursor-text"
                                                                 role="presentation"><span
                                                                    data-tip="true" data-for="name_id_{{$key}}"
                                                                    currentitem="false">{{$shorted_name}}</span>
                                                                <div
                                                                    class="__react_component_tooltip place-top type-dark"
                                                                    id="name_id_{{$key}}"
                                                                    data-id="tooltip">{{$shorted_name}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div role="presentation"
                                                     class="margin-right20 item-list item-created"><span
                                                        class="cursor-text"
                                                        role="presentation">{{format_date_time($ecommerceMarketPlace->created_at)}}</span>
                                                </div>
                                                <div role="presentation"
                                                     class="margin-right20 item-list item-sapo-go-chat">
                                                    <div class="btn_content">
                                                        <div class="btn_button_accept" role="presentation"
                                                             style="margin-left: -50px">
                                                            <button type="button"
                                                                    class="btn btn-toggle {{$ecommerceMarketPlace->status == 1 ? 'active' : ''}}"
                                                                    style="position: relative; top: 0px; left: 60px;">
                                                                <div class="handle"></div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div role="presentation" class="margin-right20 item-list item-options">
                                                    <div class="item-action">
                                                        <div class="div-action">
                                                            <div class="btn-action" role="presentation"><span
                                                                    class="text">Tùy chọn</span><span><svg
                                                                        width="14" height="14" viewBox="0 0 14 14"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg"><path
                                                                            d="M3.5 5.25L7 8.75L10.5 5.25"
                                                                            stroke="#0084FF"
                                                                            stroke-width="2" stroke-linecap="round"
                                                                            stroke-linejoin="round"></path></svg></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
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
