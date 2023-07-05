<div class="wrapper header-detail">
    <div class="row">
        <div class="col-sm active">Chi tiết sản phẩm</div>
        <div class="col-sm" style="text-align: center">Mã SKU</div>
        <div class="col-sm">Tên sản phẩm</div>
        <div class="col-sm" style="text-align: center">Giá bán</div>
        <div class="col-sm" style="text-align: center">Tồn kho</div>
        <div class="col-sm" style="text-align: center">Trạng thái sản phẩm</div>
    </div>
</div>
<div class="wrapper brand-detail">
    <div class="row">
        <div class="__react_component_tooltip place-top type-dark" id="product-item-logo11_0" data-id="tooltip"
             style="left: 52px; top: 447px;">Bấm để xem sản phẩm trên sàn
        </div>
        <div class="col-sm icon" data-tip="true" data-for="product-item-logo11_0" currentitem="false">
            <img src="{{ static_asset($connectedMarket->logo) }}" width="25%">
        </div>
        <div class="col-sm"><span data-tip="true" data-for="product_detail_11_0"
                                  currentitem="false">{{$variantProductDetail->variant_sku}}</span>
            <div class="__react_component_tooltip place-top type-dark" id="product_detail_11_0" data-id="tooltip">
                {{$variantProductDetail->variant_sku}}
            </div>
        </div>
        <div class="col-sm name"><span data-tip="true" data-for="name_detail_11_0"
                                       currentitem="false">{{$moreData['name']}}</span>
            <div class="__react_component_tooltip place-top type-dark" id="name_detail_11_0"
                 data-id="tooltip">{{$moreData['name']}}</div>
        </div>
        <div class="col-sm">{{number_format($variantProductDetail->variant_price)}}</div>
        <div class="col-sm">{{$variantProductDetail->variant_quantity}}</div>
        <div class="col-sm">
            <?php
            $status = config('market_place.'.strtolower(config('market_place.type_market')[$connectedMarket->market_type]).'.product_status');
            ?>
            {{isset($status[$moreData['status']]) ? $status[$moreData['status']] : 'Ngưng kích hoạt'}}
        </div>
    </div>
</div>
<div class="wrapper brand-detail">
    <div class="row">
        <div class="col-sm icon">
            <img src="{{ static_asset('assets/img/logo.png') }}" width="60%">
        </div>
        <div class="col-sm"><span data-tip="true" data-for="product_detail_sapo_sku_11_0"
                                  currentitem="false">{{$productStockInfo->sku}}</span>
            <div class="__react_component_tooltip place-top type-dark" id="product_detail_sapo_sku_11_0"
                 data-id="tooltip">{{$productStockInfo->sku}}
            </div>
        </div>
        <div class="col-sm name"><span data-tip="true" data-for="product_detail_sapo_11_0"
                                       currentitem="false">{{$productStockInfo->product->name}}</span>
            <div class="__react_component_tooltip place-top type-dark" id="product_detail_sapo_11_0"
                 data-id="tooltip">{{$productStockInfo->product->name}}</div>
        </div>
        <div class="col-sm">{{number_format($productStockInfo->price)}}</div>
        <div class="col-sm">{{$productStockInfo->qty}}</div>
        <div class="col-sm">Đang giao dịch</div>
    </div>
</div>
<div class="d-flex wrapper footer-detail">
    <div class="col-sm-8"><span style="width: 100%;">Sản phẩm này trên gian hàng {{$connectedMarket->ecommerce_market_place_config->shorted_name}} đang được liên kết với sản phẩm trên &nbsp;<span>dựa theo mã SKU:&nbsp;</span><span
                style="font-weight: 500;">{{$productStockInfo->sku}}</span>. Dữ liệu được đồng bộ tự động từ  lên {{config('market_place.type_market')[$connectedMarket->market_type]}}</span>
    </div>
    <div class="col-sm-4">
        <div>
            <button type="button" class="btn  btn-info">Chi tiết</button>
            <button type="button" class="btn btn-danger" style="margin-right: 10px;"
                    onclick="__$disconnectProduct('var_{{$variantProductDetail->variant_attribute_hash}}',{{$connectedMarket->id}})">
                Hủy liên kết
            </button>
            <button type="button" class="btn btn-primary" onclick="__linkEachProduct('{{$moreData['id']}}', '{{$variantProductDetail->variant_sku}}', {{$connectedMarket->id}})">Đồng bộ dữ liệu ngay</button>
        </div>
    </div>
</div>
