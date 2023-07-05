<?php
$posCartCollect = collect();
if (!empty(Session::get('posCart')))
    foreach (Session::get('posCart') as $posCart) {
        $posCartCollect->push($posCart['quantity'] * $posCart['price']);
    }
?>
<hr>
<style>
    .info-title {
        color: #088a4b;
        font-size: 16px;
        font-weight: 600;
        height: 24px;
    }

    .required {
        color: red
    }
</style>`
<div class="form-group">
    <div class="row">
        <img src="{{static_asset($logo)}}" style="width: 20%; margin: auto">
    </div>
</div>
<form id="form-submit-order-when-use-delivery-partner">
    <div class="form-group">
        <div class="row">
            <div class="info-title"> | Bên gửi</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label">Thông tin nơi đến lấy hàng</label>
            <div class="col-sm-4">
            <textarea disabled="" class="form-control"
                      style="width: 100%">{{$shop->pick_name.' - '.$shop->pick_tel}} &#13;&#10;{{$shop->address}}</textarea>
            </div>
            {{--            <label class="col-sm-2 control-label" for="pick_shift">Dự kiến lấy hàng</label>--}}
            {{--            <div class="col-sm-4">--}}
            {{--                <select name="pick_shift" id="pick_shift"--}}
            {{--                        class="form-control aiz-selectpicker"--}}
            {{--                        data-live-search="true" data-placeholder="Dự kiến lấy hàng">--}}
            {{--                    <option value="" selected disabled>Dự kiến lấy hàng</option>--}}
            {{--                    @foreach(config('constants.pick_shift_ghtk') as $key => $pick_shift_ghtk)--}}
            {{--                        <option value="{{$key}}">{{$pick_shift_ghtk}}</option>--}}
            {{--                    @endforeach--}}
            {{--                </select>--}}
            {{--            </div>--}}
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="info-title"> | Bên Nhận</div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label" for="to_phone">Số điện thoại <span class="required">*</span></label>
            <div class="col-sm-4">
                <input type="text" placeholder="Số điện thoại" id="to_phone" name="to_phone" class="form-control"
                       required>
            </div>
            <label class="col-sm-2 control-label" for="to_address">Địa chỉ <span class="required">*</span></label>
            <div class="col-sm-4">
                <input type="text" placeholder="Địa chỉ" id="to_address" name="to_address" class="form-control"
                       required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label" for="to_name">Họ tên <span class="required">*</span></label>
            <div class="col-sm-4">
                <input type="text" placeholder="Họ và tên" id="to_name" name="to_name" class="form-control"
                       required>
            </div>
            <label class="col-sm-2 control-label" for="to_province">Thành phố <span
                    class="required">*</span></label>
            <div class="col-sm-4">
                <select name="to_province" id="to_province"
                        class="form-control aiz-selectpicker"
                        data-live-search="true" required data-placeholder="Thành phố">
                    <option selected value="" disabled>Chọn Thành phố</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label" for="name"></label>
            <div class="col-sm-4">
                <input type="text" placeholder="Họ và tên" id="" name="" class="form-control"
                       style="visibility: hidden">
            </div>
            <label class="col-sm-2 control-label" for="to_district_id">Quận - Huyện <span
                    class="required">*</span></label>
            <div class="col-sm-4">
                <select name="to_district_id" id="to_district_id"
                        class="form-control aiz-selectpicker"
                        data-live-search="true" required data-placeholder="Quận - Huyện">
                    <option selected value="" disabled>Chọn Quận - Huyện</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label" for="name"></label>
            <div class="col-sm-4">
                <input type="text" placeholder="Họ và tên" id="" name="" class="form-control"
                       style="visibility: hidden">
            </div>
            <label class="col-sm-2 control-label" for="to_ward_code">Phường - Xã <span class="required">*</span></label>
            <div class="col-sm-4">
                <select name="to_ward_code" id="to_ward_code"
                        class="form-control aiz-selectpicker"
                        data-live-search="true" required data-placeholder="Phường - Xã">
                    <option selected value="" disabled>Phường - Xã</option>
                </select>
            </div>
        </div>
    </div>

    @if(!empty(Session::get('posCart')))
        <div class="form-group">
            <div class="row">
                <div class="info-title">| Hàng hoá - {{Session::get('posCart')->count()}} Sản phẩm</div>
            </div>
        </div>

        @foreach(Session::get('posCart') as $key => $posCart)
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label" for="item_name_{{$posCart['id']}}">Sản
                        phẩm {{$key+=1}}</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Sản phẩm" id="item_name_{{$posCart['id']}}"
                               name="item_name_{{$posCart['id']}}" class="form-control"
                               value="{{$posCart['variant']}}" disabled>
                    </div>
                    <label class="col-sm-1 control-label" for="quantity_{{$posCart['id']}}">Số lượng</label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Số lượng" id="quantity{{$posCart['id']}}"
                               name="quantity{{$posCart['id']}}" class="form-control"
                               value="{{$posCart['quantity']}}" disabled>
                    </div>
                    <label class="col-sm-1 control-label " for="weight">Khối lượng (kg) <span
                            class="required">*</span></label>
                    <div class="col-sm-2">
                        <input type="text" placeholder="Ví dụ: 0.5 - tối đa 20.0" name="weight[]"
                               class="form-control weight"
                               value="">
                    </div>
                </div>
            </div>
        @endforeach

        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label" style="visibility: hidden" for="cod_amount">Tổng tiền thu hộ COD</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Tổng tiền thu hộ COD" id="cod_amount" name="cod_amount"
                           class="form-control" style="visibility: hidden"
                           value="0">
                </div>
                <label class="col-sm-2 control-label" for="insurance_value">Tổng giá trị hàng hoá</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Tổng giá trị hàng hoá" id="insurance_value" name="insurance_value"
                           disabled
                           class="form-control"
                           value="{{number_format($posCartCollect->sum())}}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">

                </div>
                <label class="col-sm-2 control-label">Tag</label>
                <div class="col-sm-4" id="tag_ghtk_border">
                    <select name="tag_ghtk[]" id="tag_ghtk" multiple=""
                            class="form-control"
                            data-live-search="true" data-placeholder="Tag">
                        <option value="is_standard">Tiêu chuẩn</option>
                        <option value="is_breakable">Dễ vỡ</option>
                        @if($posCartCollect->sum() >= 1000000)
                            <option value="is_valuable">Giá trị cao (>= 1.000.000 vnd)</option>
                        @endif
                        <option value="is_part_deliver">Giao hàng một phần</option>
                        <option value="is_food">Sản phẩm khô / nông sản</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="info-title">| Lưu ý - Ghi chú</div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label" for="required_note">Tuỳ chọn thanh toán <span
                        class="required">*</span></label>
                <div class="col-sm-4">
                    <select name="payment_type_id" id="payment_type_id"
                            class="form-control aiz-selectpicker"
                            data-live-search="true" required data-placeholder="Tuỳ chọn thanh toán">
                        <option value="" disabled selected>Tuỳ chọn thanh toán</option>
                        <option value="1">Bên gửi trả phí</option>
                        <option value="2">Bên nhận trả phí</option>
                    </select>
                </div>
                <label class="col-sm-2 control-label" for="note">Ghi chú</label>
                <div class="col-sm-4">
                    <textarea name="note" id="note" class="form-control"></textarea>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label" for="service_type_id">Phương thức giao hàng <span
                        class="required">*</span></label>
                <div class="col-sm-4">
                    <select name="service_type_id" id="service_type_id"
                            class="form-control aiz-selectpicker"
                            data-live-search="true" required data-placeholder="Phương thức giao hàng">
                        <option value="" disabled selected>Phương thức giao hàng</option>
                        <option value="fly">Đường bay</option>
                        <option value="road">Đường bộ</option>
                    </select>
                </div>
            </div>
        </div>
    @endif
</form>
<script>
    $(document).ready(function () {
        let tag_ghtk = $('#tag_ghtk');

        tag_ghtk.select2().val('is_standard').trigger('change');
        @if($posCartCollect->sum() >= 1000000)
        tag_ghtk.val(['is_standard', 'is_valuable']).trigger('change')
        @endif

        getProvincesDelivery()
    });

    function getProvincesDelivery() {
        let url = '{{route('pos.get_locations')}}';
        let object = {parent_id: 0}
        __baseFunction.select2Ajax(url, 'to_province', 'Chọn Thành Phố', object)

        $("#to_province").on('change', function () {
            if ($(this).val()) {
                getDistrictsDelivery($(this).val())
                getWardsDelivery(-1)
            }
        })
    }

    function getDistrictsDelivery(parentId) {
        let url = '{{route('pos.get_locations')}}';
        let object = {parent_id: parentId}
        __baseFunction.select2Ajax(url, 'to_district_id', 'Chọn Quân - Huyện', object)

        $("#to_district_id").on('change', function () {
            if ($(this).val()) {
                getWardsDelivery($(this).val())
            }
        });
    }

    function getWardsDelivery(parentId) {
        let url = '{{route('pos.get_locations')}}';
        let object = {parent_id: parentId}
        __baseFunction.select2Ajax(url, 'to_ward_code', 'Chọn Phường - Xã', object)
    }

    function formatRepo(repo) {
        if (repo.loading) {
            return "Loading...";
        }
        var markup = "<div>" + repo.fullname + "</div>";
        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.fullname
    }


</script>
