<style>
    .content-delivery .line-content-delivery .action {
        float: right;
        margin-top: 5px;
        margin-left: 10px;
    }

    .content-delivery .line-content-delivery .action > a {
        padding-right: 7px;
        color: #212b35;
    }

    .content-delivery .line-content-delivery .show-detail {
        margin-left: 15px;
        float: right;
    }

    .dropdown-menu {
        max-height: 250px;
        overflow-y: auto;
        border: 1px solid #c4cdd5;
        box-shadow: 0 6px 12px rgb(0 0 0 / 18%);
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        display: none;
        float: left;
        min-width: 10rem;
        padding: .5rem 0;
        margin: .125rem 0 0;
        font-size: 1rem;
        color: #212529;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, .15);
        border-radius: .25rem;
    }

    .dropdown-menu li {
        margin: 0;
        padding: 0;
        list-style-type: none;
        border-bottom: 1px solid #d8dee6;
        position: relative;
        line-height: 18px;
        cursor: pointer;
    }

    .dropdown-menu li:last-child {
        border-bottom: none !important;
    }

    a:not([href]):not([tabindex]), a:not([href]):not([tabindex]):focus, a:not([href]):not([tabindex]):hover {
        color: inherit;
        text-decoration: none;
    }

    .dropdown-menu li a:hover {
        background: #4697fe;
        color: #fff !important;
    }

    .dropdown-menu > li > a {
        display: block;
        padding: 6px 20px;
        clear: both;
        font-weight: 400;
        line-height: 1.42857143;
        color: #333;
        white-space: nowrap;
    }

</style>
@foreach($deliveryPartners as $deliveryPartner)
    <div class="item-content" style="padding: 10px 0">
        <div class="row">
            <div class="col-md-2" style="margin: auto;">
                <div
                    class="logo-delivery" {!! empty($deliveryPartner->delivery_tenancy) ? 'style="opacity: 0.5"' : ($deliveryPartner->delivery_tenancy->status == 0 ? 'style="opacity: 0.5"' : '') !!}>
                    <img src="{{ static_asset($deliveryPartner->logo) }}" style="width:100%;">
                </div>
            </div>
            <div class="col-md-10" {!! !empty($deliveryPartner->delivery_tenancy) ? 'style="margin-top: 15px"' : '' !!}>
                <div class="content-delivery">
                    @if(empty($deliveryPartner->delivery_tenancy))
                        <div class="line-content-delivery">
                            <div class="name-delivery-diactive">
                                <span
                                    style="opacity:0.5"><span>{{ $deliveryPartner->fullname }}</span> (Chưa kết nối)</span>
                            </div>
                            <input type="hidden" id="{{$deliveryPartner->code}}" value="{{$deliveryPartner->id}}">
                            <a href="#" class="btn di4l-sell-btn-default"
                               onclick="showPopupCreate('{{$deliveryPartner->code}}')">Kết nối</a>
                        </div>
                    @else
                        @if($deliveryPartner->delivery_tenancy['status'] == 0)
                            <div class="line-content-delivery">
                                <div class="name-delivery-diactive">
                                <span
                                    style="opacity:0.5"><span>{{ $deliveryPartner->fullname }}</span> (Chưa kết nối)</span>
                                </div>
                                <input type="hidden" id="{{$deliveryPartner->code}}" value="{{$deliveryPartner->id}}">
                                <a href="#" class="btn di4l-sell-btn-default"
                                   onclick="showPopupCreate('{{$deliveryPartner->code}}')">Kết nối lại</a>
                            </div>
                        @else
                            <div class="line-content-delivery">
                                <div class="name-delivery-active" style="float: left">
                                    <a class="delivery-provider-name"
                                       href="{{route('delivery.partner.shippers', $deliveryPartner->delivery_tenancy->id)}}"><span>{{ $deliveryPartner->fullname }} (Đã kết nối)</span></a>
                                </div>
                                <div class="action">
                                    <a href="javascript:" data-toggle="dropdown" aria-expanded="false">Thao tác khác <i
                                            class="la la-caret-down" aria-hidden="true"></i></a>
                                    <ul class="dropdown-menu newscroll"
                                        style="font-size: 13px; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(763px, 24px, 0px);"
                                        x-placement="bottom-start">
                                        <li>
                                            <a onclick="showPopupMapInventory({{$deliveryPartner->code}},{{$deliveryPartner->delivery_tenancy->connect_partner_id}}, '{{$deliveryPartner->delivery_tenancy->token_key}}')">Liên
                                                kết kho</a></li>
                                        <li><a onclick="_updateShipper({{$deliveryPartner->delivery_tenancy->id}})">Cập
                                                nhật thông tin</a></li>
                                        <li><a onclick="_logOutDelivery({{$deliveryPartner->delivery_tenancy->id}})">Ngừng
                                                kết nối</a></li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endif

                    <div class="line-content-delivery" style="margin-top: 5px;">
                        <span>
                            {{ $deliveryPartner->info }}
                        </span>
                        @if(empty($deliveryPartner->delivery_tenancy))
                            <br>
                            <a class="delivery-guide"
                               href="#"
                               target="_blank" rel="nofollow">Hướng dẫn kết nối</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
@endforeach
