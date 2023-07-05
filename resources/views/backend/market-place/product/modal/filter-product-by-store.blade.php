<div id="filter-product-by-store-modal" style="display: none">
    <div id="fpbsm-wrapper">
        <div id="fpbsm-header">Chọn gian hàng bạn muốn xem</div>
        <div id="fpbsm-body">
            <form id="market_connected_filter">
                @foreach($connectedMarket as $connectedMarketInfo)
                    <div class="fpbsm-store">
                        <div class="fpbsm-store-option-checkbox"><input name="market[]"  value="{{$connectedMarketInfo->id}}" type="checkbox"
                                                                        class="styledCheckbox"><span
                                class="styledCheckbox_span"><svg class="styledCheckbox_icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" id="checkmark-thick" width="100%"
                                        height="100%"><svg viewBox="0 0 24 24"
                                                           enable-background="new 0 0 24 24"><path
                                                d="M23.6 5L22 3.4c-.5-.4-1.2-.4-1.7 0L8.5 15l-4.8-4.7c-.5-.4-1.2-.4-1.7 0L.3 11.9c-.5.4-.5 1.2 0 1.6l7.3 7.1c.5.4 1.2.4 1.7 0l14.3-14c.5-.4.5-1.1 0-1.6z"></path></svg></svg></svg></span>
                        </div>
                        <div role="presentation" class="fpbsm-store-avatar"><img
                                class="fpbsm-store-avatar-img"
                                src="{{static_asset($connectedMarketInfo->logo)}}"
                                alt="store-avatar"></div>
                        <div role="presentation" class="fpbsm-store-name">
                            <div
                                class="fpbsm-store-name-main">{{@$connectedMarketInfo->ecommerce_market_place_config->shorted_name}}</div>
                            <div
                                class="fpbsm-store-name-sub">{{config('market_place.type_market')[$connectedMarketInfo->market_type]}}
                                - {{@$connectedMarketInfo->ecommerce_market_place_config->shorted_name}}</div>
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
        <div id="fpbsm-footer">
            <div id="fpbsm-footer-text">Đã chọn 0 gian hàng</div>
            <button id="fpbsm-footer-btn" class="btn btn-primary" type="button">Xem</button>
        </div>
    </div>
</div>
