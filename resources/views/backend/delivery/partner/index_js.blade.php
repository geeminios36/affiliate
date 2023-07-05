<script>
    const ghn = '{{config('constants.ghn')}}',
        ghtk = 'ghtk',
        vt_post = 'vt_post',
        vn_post = 'vn_post',
    bestexpress = 'bestexpress'

    function showPopupCreate(code) {
        $('#' + code + '_modal_connect').modal('show');
    }

    function showPopupMapInventory(code, id, token = null) {
        $('#' + code + '_modal_connect').modal('show');
        $('#input_token_' + code).css('display', 'none');
        getStoreDataDelivery(code, id, token)
    }

    function reloadDataAfterConnect() {
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('delivery.reload') }}',
            type: 'POST',
            data: {},
            success: function (data) {
                $('#delivery_partners').html(data)
            },
            error: function () {
                AIZ.plugins.notify('danger', 'Có lỗi xảy ra');
            }
        })
    }


    function _updateShipper(delivery_tenancy_id) {
        let url = "{{ route('delivery.update_delivery') }}/" + delivery_tenancy_id;

        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: {},
            success: function (data) {
                $('#modal_content_html').html(data);
                $('#info_modal_connect').modal('show');
            },
            error: function () {
                AIZ.plugins.notify('danger', 'Có lỗi xảy ra');
            }
        })
    }

    function _logOutDelivery(id) {
        let url = "{{ route('delivery.logout_delivery') }}/" + id;

        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: {},
            success: function (data) {
                AIZ.plugins.notify('success', data.msg);
                location.reload()
            },
            error: function () {
                AIZ.plugins.notify('danger', 'Có lỗi xảy ra');
            }
        })
    }

    function saveConnectGHN(connect_partner_id = null,) {
        if (!$('#warehouse_ghn option:selected').val()) {
            AIZ.plugins.notify('danger', 'Vui lòng chọn liên kết');
            return false;
        }
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('delivery.save_connect_ghn') }}',
            type: 'POST',
            data: {
                'ghn_id': $('#warehouse_ghn option:selected').val(),
                'delivery_id': $('#ghn').val(),
                'connect_partner_id': connect_partner_id,
                'token_key': $('#token_key_ghn').val(),
                'address': $('#warehouse_ghn option:selected').text(),
            },
            success: function (data) {
                if (data.status) {
                    $('#ghn_modal_connect').modal('hide');
                    AIZ.plugins.notify('success', data.msg);
                    reloadDataAfterConnect()
                } else {
                    AIZ.plugins.notify('danger', data.msg);
                }
            },
        })
    }

    function getStoreDataDelivery(code, id = null, token = null) {
        let tokenKey = id ? token : $('#token_key_' + code).val()
        if (!tokenKey && !id && code !== vt_post && code !== bestexpress) {
            AIZ.plugins.notify('danger', 'Vui lòng nhập token key');
            return false;
        }
        let url = '',
            headers = '',
            data = {},
            fullname = '',
            statusResponse = 0;
        if (code == ghn) {
            url = "{{config('api_delivery_partner.ghn.shop')}}";
            headers = {
                'Content-Type': 'application/json',
                token: tokenKey,
            };
            statusResponse = 200
            fullname = 'Giao hàng nhanh'
        } else if (code == ghtk) {
            url = "{{route('delivery.login_ghtk')}}";
            headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            data = {
                token: tokenKey,
            };
            statusResponse = true;
            fullname = 'Giao hàng tiết kiệm'
        } else if (code == vt_post) {
            url = "{{route('delivery.login_viettel_post')}}";
            headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            data = {
                username: $('#email_vt_post').val(),
                password: $('#password_vt_post').val(),
            };
            statusResponse = true;
        } else if (code == bestexpress) {
            url = "{{route('delivery.login_best_express')}}";
            headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            data = {
                account: $('#email_bestexpress').val(),
                password: $('#password_bestexpress').val(),
            };
            statusResponse = true;
        }

        $.ajax({
            headers: headers,
            type: "POST",
            url: url,
            data: data,
            success: function (result) {
                if (code == ghtk && isJson(result)) {
                    result = JSON.parse(result);
                } else {
                    AIZ.plugins.notify('danger', result.msg);
                }

                if (result.code == statusResponse || result.success == statusResponse) {
                    let view = '<div class="ui-banner ui-banner--status-warning">' +
                        '  <div class="ui-banner__ribbon"></div> ' +
                        '<div class="ui-banner__content"> ' +
                        '<h2 class="ui-banner__title">Lưu ý</h2> ' +
                        '<div class="ui-type-container"> ' +
                        '<div class="ui-type-container"> ' +
                        '<p>Nếu bạn có nhiều cửa hàng (Địa điểm lấy hàng), bạn cần tạo thêm các cửa hàng tương ứng trên tài khoản ' + fullname + ' để liên kết với  Sell Express. ' +
                        '<span>Xem hướng dẫn tạo cửa hàng trên ' + fullname + ' <a href="/" target="_blank" class="link_refer">tại đây.</a></span> ' +
                        '</p> </div> ' +
                        '</div> ' +
                        '</div> ' +
                        '</div><p style="margin: 20px 0;font-weight:500;">Vui lòng liên kết chi nhánh  Sell Express với kho trên hệ thống ' + fullname + '</p>'
                    let option = '', attr = '';
                    if (code == ghn) {
                        if (result.data.shops.length) {
                            $(result.data.shops).each(function (key, value) {
                                option += `<option ${(id && id == value._id) ? 'selected' : ''} value=" ${value._id}">${value.name} - ${value.address}</option>`
                            })
                        }
                        attr = 'saveConnectGHN(' + id + ')'
                    } else if (code == ghtk) {
                        if (result.data.length) {
                            $(result.data).each(function (key, value) {
                                option += `<option ${(id && id == value.pick_address_id) ? 'selected' : ''} value=" ${value.pick_address_id}">${value.pick_tel} - ${value.address}</option>`
                            })
                        }
                        attr = 'saveConnectGHTK(' + id + ')'
                    }

                    let table = '<div style="background-color:#F9FAFB; padding:0 10px"> ' +
                        ' <select class="form-control select2" id="warehouse_' + code + '"> ' +
                        '<option value="0">Chọn kho liên kết</option> ' + option +
                        '</select>' +
                        '</div>';

                    $('#input_token_' + code).css('display', 'none');
                    $('#save_token_' + code).html(view).append(table);
                    $('#' + code + '_modal_connect_dismiss').on('click', function () {
                        document.addEventListener('contextmenu', event => event.preventDefault());
                        location.reload()
                    })
                    $('#' + code + '_modal_connect_submit').text('Lưu').attr('onclick', attr)


                } else {
                    // AIZ.plugins.notify('danger', 'Có lỗi xảy ra');
                }

            }
        });
    }

    function saveConnectGHTK(connect_partner_id = null,) {
        if (!$('#warehouse_ghtk option:selected').val()) {
            AIZ.plugins.notify('danger', 'Vui lòng chọn liên kết');
            return false;
        }
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('delivery.save_connect_ghtk') }}',
            type: 'POST',
            data: {
                'ghtk_id': $('#warehouse_ghtk option:selected').val(),
                'delivery_id': $('#ghtk').val(),
                'connect_partner_id': connect_partner_id,
                'token_key': $('#token_key_ghtk').val(),
                'address': $('#warehouse_ghtk option:selected').text(),
            },
            success: function (data) {
                if (data.status) {
                    $('#ghtk_modal_connect').modal('hide');
                    AIZ.plugins.notify('success', data.msg);
                    reloadDataAfterConnect()
                } else {
                    AIZ.plugins.notify('danger', data.msg);
                }
            },
        })
    }

    function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

</script>
