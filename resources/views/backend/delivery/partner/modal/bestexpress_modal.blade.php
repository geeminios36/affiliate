<div class="modal" id="bestexpress_modal_connect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                            <img
                                src="{{static_asset('assets/img/delivery/bestexpress.png')}}" width="30%"
                                class="icon-bestexpress">
                        </div>
                        <div id="input_token_bestexpress">
                            <p style="margin:12px 0;"> Sell Express kết nối 2 chiều với đối tác Best Express giúp cửa
                                hàng:</p>
                            <ul class="list__learn-more">
                                <li>Tự động đẩy thông tin đơn hàng, tiền thu hộ... sang đối tác.</li>
                                <li>Shipper sẽ qua cửa hàng gom đơn mà bạn không cần liên hệ.</li>
                                <li>Cập nhật nhanh chóng phí và chi tiết lịch trình đơn.</li>
                            </ul>
                            <hr style="border-top: 1px solid #dfe4e8; margin-left: -20px; width: 106.5%;">
                            <div>
                                <p style="margin-bottom:10px"><strong>Đăng nhập tài khoản Best Express</strong></p>
                                <div class="ui-stack ui-stack--wrap">
                                    <div class="row">
                                        <div class="col-6">
                                            Tên đăng nhập
                                            <input type="text" class="form-control" id="email_bestexpress"
                                                   autocomplete="off">
                                        </div>
                                        <div class="col-6">
                                            Mật khẩu
                                            <input type="password" class="form-control" id="password_bestexpress"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <p style="margin-top:5px;">Bạn chưa có tài khoản? <a
                                        href="https://www.best-inc.vn/signup" target="_blank" rel="nofollow"
                                        class="delivery-link">Đăng ký tại đây</a></p>
                            </div>
                            <hr style="border-top: 1px solid #dfe4e8; margin-left: -20px; width: 106.5%;">
                            <div style="margin-top:10px;">
                                <p><strong>Thông tin hỗ trợ</strong></p>
                                <p style="color:#08f">&gt;&gt; <a href="#"
                                                                  class="delivery-link" target="_blank" rel="nofollow">
                                        Hướng dẫn kết nối và sử dụng</a></p>
                                <p style="color:#08f">&gt;&gt; <a href="https://www.best-inc.vn/" class="delivery-link" target="_blank" rel="nofollow">
                                        Tìm hiểu thêm về Best Express
                                    </a></p>
                            </div>
                        </div>
                        <div id="save_token_bestexpress">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary fw-600" id="bestexpress_modal_connect_dismiss"
                        data-dismiss="modal">{{translate('Cancel')}}</button>
                <button type="submit" class="btn btn-primary fw-600" id="bestexpress_modal_connect_submit"
                        onclick="getStoreDataDelivery('{{config('constants.bestexpress')}}')">Tiếp theo
                </button>
            </div>
        </div>
    </div>
</div>
