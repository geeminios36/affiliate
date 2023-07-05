@include('backend.market-place.market-place-style')
@include('backend.market-place.connect_style')
<?php
$url_components = parse_url($_SERVER['HTTP_REFERER']);
if (isset($url_components['query']))
    parse_str($url_components['query'], $params);

?>
<div id="app">
    <div id="market-place-wrapper">
        <div id="market-place-content" style="margin-top: 4px;">
            <div class="container_settings">
                <div class="setting_header"><h5>Thiết lập một số thông tin để hoàn tất quá trình kết nối gian
                        hàng {{config('market_place.type_market')[$ecommerceMarketPlace->market_type]}}</h5>
                </div>
                <div class="container_settings_body">
                    <div class="setting_row">
                        <div class="setting_row__left">
                            <div class="title_bold">Đặt tên rút gọn cho gian hàng*</div>
                            <div class="title_normal">Tên viết tắt của gian hàng trên  giúp nhận biết và phân biệt
                                các gian hàng với nhau
                            </div>
                        </div>
                        <div class="setting_row__right">
                            <div class="setting_content">
                                <div class="content_sub">
                                    <div class="title">Tên rút gọn</div>
                                    <div class="content content_inp"><input class="inp inp-default " id="shortenedName"
                                                                            placeholder="Nhập tên gian hàng"
                                                                            maxlength="33"
                                                                            value="{{isset($params['name']) ? $params['name'] : $shortenedName}}">
                                        <div class="char_count">
                                            ({{strlen(isset($params['name']) ? $params['name'] : $shortenedName)}}/33)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="setting_row setting_method_sync" style="display: none">
                        <div class="setting_row__left">
                            <div class="title_bold">Thiết lập cấu hình đồng bộ với </div>
                            <div class="title_normal">Lựa chọn cấu hình đồng bộ mặc định của hệ thống hoặc tùy chỉnh
                                riêng theo từng gian hàng.
                            </div>
                        </div>
                        <div class="setting_row__right">
                            <div class="content_sub">
                                <div class="setting_content">
                                    <div class="title">Chọn cấu hình đồng bộ với </div>
                                    <div class="content">
                                        <div class="form_check_radio_button"><input type="radio" name="settingTypes"
                                                                                    id="inp_default" value="default"
                                                                                    checked=""><label for="inp_default">Cấu
                                                hình mặc định</label>
                                            <p> sẽ kết nối với gian hàng theo cấu hình mặc định&nbsp;<span
                                                    onclick="first_config_default_modal()">(Xem chi tiết)</span>
                                            </p></div>
                                        <div class="form_check_radio_button"><input type="radio" name="settingTypes"
                                                                                    id="inp_custom"
                                                                                    value="custom"><label
                                                for="inp_custom">Cấu hình tùy chỉnh</label>
                                            <p> sẽ kết nối với gian hàng theo cấu hình do bạn tự thiết lập</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container_setting_footer">
                    <div class="btn_right">
                        <button class="btn btn-primary" id="save_first_config_market" type="button">Lưu lại</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="notification-wrapper"></div>
</div>
@include('backend.market-place.connected_page.config_market.first_config_default_modal')
@include('backend.market-place.cdn.library')

<script>

    function first_config_default_modal() {
        $('#first_config_default_modal').css('display', 'block').modal('show');
    }

    $('#save_first_config_market').on('click', function () {
        if ($('#inp_default').is(':checked')) {
            saveConfig()
        }

        if ($('#inp_custom').is(':checked')) {
            window.location.href = "{{route('market_place.custom_config', $ecommerceMarketPlace->id)}}?shortenedName=" + $('#shortenedName').val()
        }
    })

    function saveConfig() {
        let url = "{{ route('market_place.save_config', $ecommerceMarketPlace->id) }}";
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                shortenedName: $('#shortenedName').val(),
                custom: false,
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
