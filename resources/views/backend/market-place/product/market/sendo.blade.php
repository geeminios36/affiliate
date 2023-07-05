<div class="product-item-wrapper">
    <div class="product-item-line">
        <div class="product-item-wrapper-image">
            <img src="{{$productInfo->image}}" alt="image">
        </div>
        <div class="d-flex align-items-center flex-wrap product-item-wrapper-info">
            <input type="checkbox" class="checkbox checkbox-add" style="display: none"
                   id="input-item-checkbox-var_{{$productInfo->item_id}}"
                   value="parent_{{$productInfo->item_id}}"
                   name="check" readonly="" disabled="">
            <div class="text-ellipsis name">
                <span class="text-ellipsis" data-tip="true"
                      data-for="product-name-tooltip-5672065"
                      currentitem="false">
                        {{$productInfo->name}}
                </span>
                <div class="__react_component_tooltip place-top type-dark"
                     id="product-name-tooltip-5672065" data-id="tooltip"
                     style="left: 169px; top: 281px;">{{$productInfo->name}}</div>
            </div>
            <div class="text-ellipsis variation">({{$productInfo->variants_length}} phiên bản)
            </div>
        </div>
        <div class="d-flex align-items-center text-ellipsis channel-info-wrapper">
            <div class="position-relative d-flex align-items-center text-ellipsis channel-info"
                 role="presentation">
                <img src="{{static_asset('/assets/img/market_place/sendo.png')}}" width="30px">
                &nbsp;&nbsp;
                <span
                    class="text-ellipsis">{{$name[config('market_place.type_market')[2]]['market']}}</span>
            </div>
        </div>
        <div class="d-flex align-items-center text-ellipsis mapped-info-wrapper">
            <div>
                                        <span class="count-mapping">
                                            {{$name[config('market_place.type_market')[2]]['synced']->where('parent_product_market_place_id',$productInfo->id )->count()}}
                                        </span>/<span class="count-variant-product">{{$productInfo->variants_length}}</span>
            </div>
        </div>
        <div class="empty-wrapper"></div>
    </div>
    <div
        class="variant-list-wrapper-{{$productInfo->item_id}}-{{$name[config('market_place.type_market')[2]]['id']}} variant-list-orig">
    </div>
    <div class="show-more">
        <div
            class="more-element-item more-element-item-{{$productInfo->item_id}}-{{$name[config('market_place.type_market')[2]]['id']}}">
            <div class="expand-button">
                <button type="button" class="btn btn-light"
                        onclick="seeMoreChildProduct('{{$productInfo->item_id}}', {{$name[config('market_place.type_market')[2]]['id']}})">
                    <span>Xem thêm</span>
                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.25 6.25L5 10L8.75 6.25" stroke="#0084FF" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M1.25 1L5 4.75L8.75 1" stroke="#0084FF" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
