<div role="dialog" aria-modal="true" class="fade modal  instant-mapping-sapo-product register-channel-modal">
    <div id="register-channel-modal" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"><span>Liên kết nhanh
                    sản phẩm  với sản phẩm trên sàn TMĐT</span></div>
                <button data-dismiss="modal" id="dismiss-choice-market" type="button" class="close"><span
                        aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="content-wrapper" style="margin: 10px">
                    <div class="select-connection-wrapper">
                        <div>Lựa chọn gian hàng muốn cập nhật dữ liệu</div>
                        <div class="list-connection-to-map" style="margin: 10px 0 !important;">
                            @foreach($connectedMarket as $connectedMarketInfo)
                                <div class="d-flex channel-item-radio" style="margin-bottom: 10px">
                                    <div class="cntr">
                                        <label for="{{$connectedMarketInfo->id}}" class="btn-radio" onclick="setCheckBox(null, {{$connectedMarketInfo->id}})">
                                            <input type="radio" id="market-checkbox-{{$connectedMarketInfo->id}}" class="market-checkbox-sync-product market-checkbox" value="{{$connectedMarketInfo->id}}">
                                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                <circle cx="10" cy="10" r="9"></circle>
                                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                                            </svg>
                                        </label>
                                    </div>
                                    <div style="margin-left: 10px">
                                        <div
                                            class="position-relative d-flex align-items-center text-ellipsis channel-info"
                                            role="presentation">
                                            <img src="{{static_asset($connectedMarketInfo->logo)}}" width="30px"> &nbsp; &nbsp;
                                            <span
                                                class="text-ellipsis">{{$connectedMarketInfo->ecommerce_market_place_config->shorted_name}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Thoát</button>
                <button class=" btn btn-primary" data-dismiss="modal" type="button" disabled id="linkMultiProducts">
                    Xác nhận
                </button>
            </div>
        </div>
    </div>
</div>
