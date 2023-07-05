<hr>
<style>
    .info-title {
        color: #f26522;
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
                      style="width: 100%">{{$shop->name.' - '.$shop->phone}} &#13;&#10;{{$shop->address}}</textarea>
            </div>
            <label class="col-sm-2 control-label" for="pick_shift">Ca lấy hàng</label>
            <div class="col-sm-4">
                <select name="pick_shift" id="pick_shift"
                        class="form-control aiz-selectpicker"
                        data-live-search="true" data-placeholder="Ca lấy hàng">
                    <option value="" selected disabled>Chọn ca lấy hàng</option>
                    @foreach($shop->pick_shift as $pick_shift)
                        <option value="{{$pick_shift->id}}">{{$pick_shift->title}}</option>
                    @endforeach
                </select>
            </div>
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
            <label class="col-sm-2 control-label" for="to_district_id">Quận - Huyện <span
                    class="required">*</span></label>
            <div class="col-sm-4">
                <select name="to_district_id" id="to_district_id"
                        class="form-control aiz-selectpicker"
                        data-live-search="true" required data-placeholder="Quận - Huyện">
                    <option selected value="" disabled>Chọn Quận - Huyện</option>
                    @foreach($location['district']->data as $district)
                        <option value="{{$district->DistrictID}}">{{$district->DistrictName}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="col-sm-2 control-label" for="name"></label>
            <div class="col-sm-4">

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
                    <label class="col-sm-2 control-label" for="quantity_{{$posCart['id']}}">Số lượng</label>
                    <div class="col-sm-4">
                        <input type="text" placeholder="Số lượng" id="quantity{{$posCart['id']}}"
                               name="quantity{{$posCart['id']}}" class="form-control"
                               value="{{$posCart['quantity']}}" disabled>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label " for="weight">Tổng khối lượng (gram)</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Tổng khối lượng (gram)" id="weight" name="weight"
                           class="form-control"
                           value="500">
                </div>
                <label class="col-sm-2 control-label">Kích thước (cm)</label>
                <div class="col-sm-1">
                    <input type="text" placeholder="Dài" id="length" name="length" class="form-control"
                           value="10">
                </div>
                <div class="col-sm-1">
                    <input type="text" placeholder="Rộng" id="width" name="width" class="form-control"
                           value="10">
                </div>
                <div class="col-sm-1">
                    <input type="text" placeholder="Cao" id="height" name="height" class="form-control"
                           value="10">
                </div>

            </div>
        </div>
        <?php
        $posCartCollect = collect();
        foreach (Session::get('posCart') as $posCart) {
            $posCartCollect->push($posCart['quantity'] * $posCart['price']);
        }
        ?>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-2 control-label" style="visibility: hidden" for="cod_amount">Tổng tiền thu hộ COD</label>
                <div class="col-sm-4">
                    <input type="text" style="visibility: hidden" placeholder="Tổng tiền thu hộ COD" id="cod_amount" name="cod_amount"
                           class="form-control"
                           value="0">
                </div>
                <label class="col-sm-2 control-label" for="insurance_value">Tổng giá trị hàng hoá</label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Tổng giá trị hàng hoá" id="insurance_value" name="insurance_value"
                           class="form-control"
                           value="{{number_format($posCartCollect->sum())}}">
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
                <label class="col-sm-2 control-label" for="required_note">Lưu ý giao hàng <span
                        class="required">*</span></label>
                <div class="col-sm-4">
                    <select name="required_note" id="required_note"
                            class="form-control aiz-selectpicker"
                            data-live-search="true" required data-placeholder="Lưu ý giao hàng">
                        <option value="" disabled selected>Chọn lưu ý giao hàng</option>
                        <option value="CHOTHUHANG">Cho thử hàng</option>
                        <option value="CHOXEMHANGKHONGTHU">Cho xem hàng không thử</option>
                        <option value="KHONGCHOXEMHANG">Không cho xem hàng</option>
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
                <label class="col-sm-2 control-label" for="content">Nội dung đơn hàng</label>
                <div class="col-sm-4">
                    <textarea name="content" id="content" class="form-control"></textarea>
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
                        <option value="1">Đường bay</option>
                        <option value="2">Đường bộ</option>
                    </select>
                </div>
            </div>
        </div>
    @endif
</form>
