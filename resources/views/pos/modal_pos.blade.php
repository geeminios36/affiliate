<!-- Address Modal -->
<div id="new-customer" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" id="new-customer-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bord-btm">
                <h4 class="modal-title h6">{{translate('Shipping Address')}}</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <div class=" row">
                            <label class="col-sm-3 control-label" for="name">Phương thức giao hàng</label>
                            <div class="col-sm-9">
                                <select name="choiceDeliveryTypeSelect" id="choiceDeliveryTypeSelect"
                                        class="form-control aiz-selectpicker"
                                        data-live-search="true" required data-placeholder="Phương thức giao hàng">
                                    <option selected value="0">{{translate('Without Shipping Charge')}}</option>
                                    <option value="1">{{translate('With Shipping Charge')}}</option>
                                    <option value="2">Đơn vị vận chuyển ngoài</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="choiceDeliveryPartners" style="display: none; ">
                        <div class=" row">
                            <label class="col-sm-3 control-label" for="name">Đơn vị giao hàng</label>
                            <div class="col-sm-9">
                                <select name="choiceDeliveryPartnerSelect" id="choiceDeliveryPartnerSelect"
                                        class="form-control aiz-selectpicker"
                                        data-live-search="true" required data-placeholder="Đơn vị giao hàng">
                                    <option value="" selected disabled>Chọn đơn vị giao hàng</option>
                                    @foreach($deliveryPartners as $deliveryPartner)
                                        <option
                                            value="{{$deliveryPartner->delivery_tenancy->id}}" delivery_partner="{{$deliveryPartner->id}}">{{$deliveryPartner->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="shipping_address">

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-styled btn-base-3" data-dismiss="modal"
                        id="close-button">{{translate('Close')}}</button>
                <button type="button" class="btn btn-primary btn-styled btn-base-1" id="confirm-order-old" style="display: block"
                        data-dismiss="modal">{{translate('Confirm')}}</button>
                <button type="button" class="btn btn-primary btn-styled btn-base-1" id="confirm-order-and-delivery" data-target="#order-confirm" style="display:none;">Tạo đơn hàng</button>
            </div>
        </div>
    </div>
</div>

<!-- new address modal -->
<div id="new-address-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
        <div class="modal-content">
            <div class="modal-header bord-btm">
                <h4 class="modal-title h6">{{translate('Shipping Address')}}</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" action="{{ route('addresses.store') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="customer_id" id="set_customer_id" value="">
                    <div class="form-group">
                        <div class=" row">
                            <label class="col-sm-2 control-label" for="address">{{translate('Address')}}</label>
                            <div class="col-sm-10">
                                    <textarea placeholder="{{translate('Address')}}" id="address" name="address"
                                              class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class=" row">
                            <label class="col-sm-2 control-label" for="email">{{translate('Country')}}</label>
                            <div class="col-sm-10">
                                <select name="country" id="country" class="form-control aiz-selectpicker" required
                                        data-placeholder="{{translate('Select country')}}">
                                    @foreach (\App\Country::where('status',1)->get() as $key => $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class=" row">
                            <label class="col-sm-2 control-label" for="city">{{translate('City')}}</label>
                            <div class="col-sm-10">
                                <input type="text" placeholder="{{translate('City')}}" id="city" name="city"
                                       class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class=" row">
                            <label class="col-sm-2 control-label"
                                   for="postal_code">{{translate('Postal code')}}</label>
                            <div class="col-sm-10">
                                <input type="number" min="0" placeholder="{{translate('Postal code')}}"
                                       id="postal_code" name="postal_code" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class=" row">
                            <label class="col-sm-2 control-label" for="phone">{{translate('Phone')}}</label>
                            <div class="col-sm-10">
                                <input type="number" min="0" placeholder="{{translate('Phone')}}" id="phone"
                                       name="phone" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-styled btn-base-3"
                            data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="submit"
                            class="btn btn-primary btn-styled btn-base-1">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="product-variation" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-lg">
        <div class="modal-content" id="variants">

        </div>
    </div>
</div>

<div id="order-confirm" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content" id="variants">
            <div class="modal-header bord-btm">
                <h4 class="modal-title h6">{{translate('Order Confirmation')}}</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p>{{translate('Are you sure to confirm this order?')}}</p>
                <p id="shipping_fee_delivery_partner"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-styled btn-base-1 btn-secondary"
                        data-dismiss="modal">{{translate('Close')}}</button>
                <button type="button" onclick="submitOrder('cash')"
                        class="btn btn-styled btn-base-1 btn-primary">{{translate('Comfirm Order')}}</button>
            </div>
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
