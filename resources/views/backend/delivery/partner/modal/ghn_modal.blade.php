<div class="modal" id="ghn_modal_connect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class=" modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document"
         style="    margin: auto;    width: 650px;">
        <div class="modal-content position-relative">
            <div class="modal-header">
                <h5 class="modal-title fw-600 heading-5">Kết nối đối tác</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body gry-bg">
                <div class="form-group">
                    <div class="add-channel-modal__learn-more">
                        <div class="image-connect">
                            <img style="width: 30%"
                                 src="{{static_asset('assets/img/delivery/ghn.png')}}"
                                 class="icon-ghn">
                        </div>
                        <div id="input_token_ghn">
                            <p style="margin:12px 0;"> Sell Express kết nối 2 chiều với đối tác Giao hàng nhanh giúp
                                cửa hàng:</p>
                            <ul class="list__learn-more">
                                <li>Tự động đẩy thông tin đơn hàng, tiền thu hộ... sang đối tác.</li>
                                <li>Shipper sẽ qua cửa hàng gom đơn mà bạn không cần liên hệ.</li>
                                <li>Cập nhật nhanh chóng phí và chi tiết lịch trình đơn.</li>
                            </ul>
                            <hr style="border-top: 1px solid #dfe4e8; margin-left: -20px; width: 106.5%;">
                            <div>
                                <p style="margin-bottom:10px"><strong>Điền mã Token tài khoản Giao hàng
                                        nhanh</strong></p>
                                <div class="ui-stack ui-stack--wrap">
                                    <div class="ui-stack-item ui-stack-item--fill">
                                        <div class="next-input-wrapper">
                                            <input type="text" class="form-control" id="token_key_ghn"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <p style="margin-top:5px;">Bạn chưa có tài khoản? <a
                                        href="https://khachhang.ghn.vn/" target="_blank" rel="nofollow"
                                        class="delivery-link">Đăng ký tại đây</a></p>
                                <p style="margin-top:5px;">Xem hướng dẫn lấy mã token <a
                                        href="#"
                                        target="_blank" rel="nofollow" class="delivery-link">Tại đây</a></p>
                            </div>
                            <hr style="border-top: 1px solid #dfe4e8; margin-left: -20px; width: 106.5%;">
                            <div style="margin-top:10px;">
                                <p><strong>Thông tin hỗ trợ</strong></p>
                                <p style="color:#08f">&gt;&gt; <a href="#"
                                                                  class="delivery-link" target="_blank" rel="nofollow">
                                        Hướng dẫn kết nối và sử dụng</a></p>
                                <p style="color:#08f">&gt;&gt; <a href="https://ghn.vn/" class="delivery-link"
                                                                  target="_blank" rel="nofollow">
                                        Tìm hiểu thêm về Giao hàng nhanh
                                    </a></p>
                            </div>
                        </div>
                        <div id="save_token_ghn">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary fw-600" id="ghn_modal_connect_dismiss"
                        data-dismiss="modal">{{translate('Cancel')}}</button>
                <button type="submit" class="btn btn-primary fw-600" id="ghn_modal_connect_submit"
                        onclick="getStoreDataDelivery('{{config('constants.ghn')}}')">Tiếp theo
                </button>
            </div>
        </div>
    </div>
</div>
