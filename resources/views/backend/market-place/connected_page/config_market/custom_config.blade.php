@include('backend.market-place.market-place-style')
@include('backend.market-place.connect_style')
<div id="app">
    <div id="market-place-wrapper">
        <div id="market-place-content" style="margin-top: 4px;">
            <div class="container_settings">
                <div class="container_settings">
                    <div class="setting_header ">
                        <div class="setting_header_flex"><p class="header_txt">Thiết lập cấu hình đồng bộ giữa  và
                                gian hàng {{config('market_place.type_market')[$ecommerceMarketPlace->market_type]}} ({{$ecommerceMarketPlace->ecommerce_market_place_config->shorted_name}})</p></div>
                    </div>
                    <div class="container_settings_body">
                        <div class="setting_row">
                            <div class="setting_row__left">
                                <div class="title_bold">Cấu hình API</div>
                                <div class="title_normal"><p>Nhập mã shop và mã bảo mật để liên kết gian hàng Sendo của
                                        bạn.</p><a>Lấy thông Mã Shop và Mã bảo mật tại đây</a></div>
                            </div>
                            <div class="setting_row__right">
                                <div class="setting_content">
                                    <div class="content_sub">
                                        <div class="title">Mã Shop</div>
                                        <div class="content content_inp"><input class="inp inp-default " disabled
                                                                                placeholder="Nhập mã Shop"
                                                                                value="{{$shopKey}}">
                                        </div>
                                    </div>
                                    <div class="content_sub">
                                        <div class="title">Mã bảo mật</div>
                                        <div class="content content_inp"><input class="inp inp-default " disabled
                                                                                placeholder="Nhập mã bảo mật"
                                                                                value="{{$secretKey}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="setting_row setting_method_sync">
                            <div class="setting_row__left">
                                <div class="title_bold">Đồng bộ đơn hàng từ Sàn</div>
                                <div class="title_normal">Thiết lập đồng bộ đơn hàng giữa Sàn và </div>
                            </div>
                            <div class="setting_row__right">
                                <div class="setting_content">
                                    <div class="setting_button_toggle">
                                        <div class="setting_button_sub">
                                            <div class="btn_title">Sử dụng mã đơn hàng từ Sàn</div>
                                            <div class="btn_content">
                                                <button type="button" class="btn btn-toggle active" id="use_code_order">
                                                    <div class="handle"></div>
                                                </button>
                                                <span style="margin-left: 50px; line-height: 2.5;">Không áp dụng</span>
                                                <div style="font-size: 13px; color: rgb(130, 130, 130);">Sử dụng mã đơn
                                                    hàng từ
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="setting_row setting_method_sync">
                            <div class="setting_row__left">
                                <div class="title_bold">Cấu hình đồng bộ sản phẩm</div>
                                <div class="title_normal">Lựa chọn cấu hình đồng bộ dữ liệu sản phẩm từ  lên Sendo
                                </div>
                            </div>
                            <div class="setting_row__right">
                                <div class="setting_content">
                                    <div class="setting_button_toggle">
                                        <div class="setting_button_sub">
                                            <div class="btn_title">Tự động đồng bộ tồn kho sản phẩm</div>
                                            <div class="btn_content">
                                                <button type="button" class="btn btn-toggle active" style=""
                                                        id="sync_inventory">
                                                    <div class="handle"></div>
                                                </button>
                                                <span style="margin-left: 50px; line-height: 2.5;">Áp dụng</span></div>
                                        </div>
                                        <div class="setting_button_sub">
                                            <div class="btn_title">Tự động đồng bộ giá sản phẩm</div>
                                            <div class="btn_content">
                                                <button type="button" class="btn btn-toggle active" style=""
                                                        id="sync_price">
                                                    <div class="handle"></div>
                                                </button>
                                                <span style="margin-left: 50px; line-height: 2.5;">Áp dụng</span></div>
                                        </div>
                                    </div>
                                    <div class="content_sub">
                                        <div class="title">Chọn chính sách giá đồng bộ với gian hàng</div>
                                        <div class="content">
                                            <div class="ui_select_options ">
                                                <select class="ui_select" id="policy_price">
                                                    <option value="" hidden=""></option>
                                                    <option value="0" selected>Giá bán lẻ</option>
                                                    <option value="1">Giá nhập</option>
                                                    <option value="2">Giá bán buôn</option>
                                                </select>
                                                <svg class="select_icon_absolute" xmlns="http://www.w3.org/2000/svg"
                                                     id="select-chevron" width="100%" height="100%">
                                                    <svg viewBox="0 0 20 20">
                                                        <path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path>
                                                    </svg>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content_sub_auto_active">
                                        <div class="title">Tự động bật trạng thái sản phẩm “Đang bán” khi tồn kho đồng
                                            bộ &gt; 0
                                        </div>
                                        <div class="content">
                                            <button type="button" class="btn btn-toggle active" style=""
                                                    id="status_sold">
                                                <div class="handle"></div>
                                            </button>
                                            <span>Không áp dụng</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="setting_row setting_method_sync">
                            <div class="setting_row__left">
                                <div class="title_bold">Cấu hình chi nhánh </div>
                                <div class="title_normal">Lựa chọn các chi nhánh trên  sẽ đồng bộ thông tin với gian
                                    hàng
                                </div>
                            </div>
                            <div class="setting_row__right">
                                <div class="setting_content setting_content_flex">
                                    <div class="content_sub content_sub_first">
                                        <div class="title">Chi nhánh đồng bộ tồn kho với gian hàng</div>
                                        {{--                                        <div class="title">Chọn chính sách giá đồng bộ với gian hàng</div>--}}
                                        <div class="content">
                                            <div class="ui_select_options ">
                                                <select class="ui_select" id="sync_inventory_branch_to_store">
                                                    <option value="" hidden=""></option>
                                                    <option value="0" selected>Tất cả chi nhánh</option>
                                                    <option value="1">Chi nhánh mặc định</option>
                                                </select>
                                                <svg class="select_icon_absolute" xmlns="http://www.w3.org/2000/svg"
                                                     id="select-chevron" width="100%" height="100%">
                                                    <svg viewBox="0 0 20 20">
                                                        <path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path>
                                                    </svg>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content_sub">
                                        <div class="title">Chi nhánh nhận đơn hàng từ gian hàng</div>
                                        <div class="content">
                                            <div class="ui_select_options " style=""><select class="ui_select"
                                                                                             id="branch_receives_order">
                                                    <option value="" hidden=""></option>
                                                    <option value="1" selected>Chi nhánh mặc định</option>
                                                </select>
                                                <svg class="select_icon_absolute" xmlns="http://www.w3.org/2000/svg"
                                                     id="select-chevron" width="100%" height="100%">
                                                    <svg viewBox="0 0 20 20">
                                                        <path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path>
                                                    </svg>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="setting_row setting_method_sync">
                            <div class="setting_row__left">
                                <div class="title_bold">Nhân viên phụ trách</div>
                                <div class="title_normal">Lựa chọn nhân viên phụ trách các đơn hàng từ gian hàng này
                                    trên
                                </div>
                            </div>
                            <div class="setting_row__right">
                                <div class="setting_content">
                                    <div class="content_sub">
                                        <div class="title">Nhân viên phụ trách đơn hàng</div>
                                        <div class="content">
                                            <div class="ui_select_options " style=""><select class="ui_select" id="order_officer">
                                                    <option value="" hidden=""></option>
                                                    @foreach($employees as $employee)
                                                        <option
                                                            value="{{$employee->id}}" {{$employee->id == $staffId ? 'selected' : ''}}>{{$employee->name}}</option>
                                                    @endforeach
                                                </select>
                                                <svg class="select_icon_absolute" xmlns="http://www.w3.org/2000/svg"
                                                     id="select-chevron" width="100%" height="100%">
                                                    <svg viewBox="0 0 20 20">
                                                        <path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path>
                                                    </svg>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container_setting_footer">
                        <div class="btn_right">
                            <button class="btn btn-primary " onclick="saveConfig()" type="button">Lưu lại</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="notification-wrapper"></div>
</div>
@include('backend.market-place.cdn.library')

<script>
    let active = 'active';
    $('#use_code_order').on('click', function () {
        $(this).hasClass(active) ? $(this).removeClass(active) : $(this).addClass(active)
    });
    $('#sync_inventory').on('click', function () {
        $(this).hasClass(active) ? $(this).removeClass(active) : $(this).addClass(active)
    });
    $('#sync_price').on('click', function () {
        $(this).hasClass(active) ? $(this).removeClass(active) : $(this).addClass(active)
    });
    $('#status_sold').on('click', function () {
        $(this).hasClass(active) ? $(this).removeClass(active) : $(this).addClass(active)
    });

    function saveConfig() {
        let url = "{{ route('market_place.save_config', $ecommerceMarketPlaceId) }}";
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                custom: true,
                use_code_order: $('#use_code_order').hasClass(active) ? 1 : 0,
                sync_inventory: $('#sync_inventory').hasClass(active) ? 1 : 0,
                sync_price: $('#sync_price').hasClass(active) ? 1 : 0,
                status_sold: $('#status_sold').hasClass(active) ? 1 : 0,
                policy_price: $('#policy_price option:selected').val(),
                sync_inventory_branch_to_store: $('#sync_inventory_branch_to_store option:selected').val(),
                branch_receives_order: $('#branch_receives_order option:selected').val(),
                order_officer: $('#order_officer option:selected').val(),
            },
            success: function (result) {
                if (result.status) {
                    window.top.location.href = "{{route('market_place.index')}}"
                } else {
                    swal(result.msg);
                }
            },
            error: function (result) {
            }
        })
    }
</script>
