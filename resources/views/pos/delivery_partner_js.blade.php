<script>
    const ghn = '{{config('constants.ghn')}}',
        ghtk = '{{config('constants.ghtk')}}';

    $(function () {
        $('.aiz-selectpicker').selectpicker();
        $('#add-info-delivery-btn').on('click', function () {
            $('#choiceDeliveryTypeSelect').val(0).change()
        });
        $('#choiceDeliveryTypeSelect').on('change', function () {
            if (this.value == 2) {
                $('#confirm-order-and-delivery').css('display', 'block')
                $('#confirm-order-old').css('display', 'none')
                _deliveryPartnerPos.getFormInputDeliveryPartner()
            } else {
                $('#shipping_address').css('visibility', 'visible');
                $('#choiceDeliveryPartners').css('display', 'none')
                $('#new-customer-dialog').css('margin', 'auto').css('max-width', '27%')
                getShippingAddress();
                $('#confirm-order-and-delivery').css('display', 'none')
                $('#confirm-order-old').css('display', 'block')
            }
        })
    })

    let _deliveryPartnerPos = {
        getFormInputDeliveryPartner: function () {
            $('#shipping_address').css('visibility', 'hidden');
            $('#choiceDeliveryPartners').css('display', 'block');
            let _posCart = null;
            @if(!empty(Session::get('posCart')))
                _posCart = {!! Session::get('posCart') !!};
            @endif

            let checkEmptyCart = $('#cart-details table tbody tr td:first-child p').text()
            if (_posCart == null && checkEmptyCart == 'Không có sản phẩm đã thêm') {
                return AIZ.plugins.notify('danger', 'Vui chọn sản phẩm trước khi chọn đơn vị');
            }

            $('#choiceDeliveryPartnerSelect').val('').off().on('change', function () {
                $('#new-customer-dialog').css('margin', 'auto').css('max-width', '75%')
                _deliveryPartnerPos.getFormRegisterDelivery($(this).val())
            })
        },
        getFormRegisterDelivery: function ($deliveryTenancyId) {
            let url = "{{ route('pos.get_form_register_delivery') }}/" + $deliveryTenancyId;
            block_submit('new-customer')
            return $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                // async: false,
                type: 'POST',
                data: {},
                success: function (data) {
                    un_block_submit()
                    $('#shipping_address').empty().html(data.view).css('visibility', 'visible');
                    _deliveryPartnerPos.eventGeneralData();
                    if (data.code == ghn) {
                        _deliveryPartnerPos.eventGhnData(data);
                    } else if (data.code == ghtk) {
                        _deliveryPartnerPos.eventGhnGhtk();
                    }

                    $('#confirm-order-and-delivery').off().on('click', function () {
                        if (!$('#choiceDeliveryPartnerSelect').val()) {
                            return false;
                        }

                        block_submit('new-customer');
                        let $validate = _deliveryPartnerPos.clientOrderDeliveryValidate(data.code);
                        if ($validate) {
                            let $validateFee = _deliveryPartnerPos.ajaxGetShipIngFee(data.delivery_tenancy)
                            $validateFee = JSON.parse($validateFee.responseText)
                            if ($validateFee.code == 200)
                                $('#pay-with-cash').click()
                        }

                        un_block_submit();
                    });

                },
                error: function () {
                    un_block_submit()
                    AIZ.plugins.notify('danger', 'Có lỗi xảy ra');
                }
            })
        },
        eventGeneralData: function () {
            $('#pick_shift').selectpicker();
            $('#to_name').val($('#pos-customer-select-delivery option:selected').text());
            $('#to_phone').val($('#pos-customer-select-delivery option:selected').attr('data-phone'));
            $('#to_address').val($('#pos-customer-select-delivery option:selected').attr('data-address'));
        },
        eventGhnData: function (data) {
            $('#to_province').selectpicker();
            $('#required_note').selectpicker();
            $('#to_district_id').selectpicker().on('change', function () {
                _deliveryPartnerPos.ajaxGetWardByDistrictID(this.value, data.delivery_tenancy);
            });
        },
        eventGhnGhtk: function () {
            // $('#to_province').select2();
            $('#required_note').selectpicker();
            $('#to_district_id').select2()
            $('#to_ward_code').select2()
        },
        ajaxGetWardByDistrictID: function (districtID, delivery_tenancy) {
            let url = "{{ route('pos.get_ward_by_district_id') }}/" + districtID;

            return $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                async: false,
                type: 'POST',
                data: {
                    token: delivery_tenancy.token_key,
                    code: delivery_tenancy.delivery_partners.code,
                },
                success: function (result) {
                    result = JSON.parse(result)
                    if (result.code == 200) {
                        let option = '';
                        $(result.data).each(function (key, value) {
                            option += '<option value="' + value.WardCode + '" >' + value.WardName + '</option>'
                        })
                        $('#to_ward_code').empty().append(option)
                    } else {
                        AIZ.plugins.notify('danger', 'Có lỗi xảy ra');
                    }
                },
                error: function () {
                    AIZ.plugins.notify('danger', 'Có lỗi xảy ra');
                }
            })
        },
        ajaxGetShipIngFee: function (delivery_tenancy) {
            let data = $('#form-submit-order-when-use-delivery-partner').serializeArray()
            data.push({name: 'delivery_tenancy_id', value: delivery_tenancy.id});
            data.push({name: 'shopId', value: delivery_tenancy.connect_partner_id});
            data.push({name: 'token', value: delivery_tenancy.token_key});
            data.push({name: 'code', value: delivery_tenancy.delivery_partners.code});
            data.push({name: 'price_products', value: un_number_format($('#insurance_value').val())});
            data.push({name: 'tag_ghtk', value: $('#tag_ghtk').val()});

            return $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('pos.get_shipping_fee') }}",
                async: false,
                type: 'POST',
                data: data,
                success: function (result) {
                    result = JSON.parse(result);
                    if (result.code == 200) {
                        $('#shipping_fee_delivery_partner').html('Phí vận chuyển: <strong>' + number_format(result.data.total_fee) + '</strong> vnd');
                    } else {
                        AIZ.plugins.notify('danger', result.message);
                    }
                },
                error: function () {
                    AIZ.plugins.notify('danger', 'Có lỗi xảy ra');
                }
            })
        },
        clientOrderDeliveryValidate: function (code) {
            if ($('#to_phone').val() == '') {
                AIZ.plugins.notify('danger', 'Vui lòng nhập số điện thoại');
                return false
            } else {
                let isNumeric = /^\d+$/
                if ($('#to_phone').val() && !isNumeric.test($('#to_phone').val())) {
                    AIZ.plugins.notify('danger', 'Vui lòng chỉ nhập số');
                    return false
                } else {
                    let to_phone_arr = $('#to_phone').val().split("");
                    if (Number(to_phone_arr[0]) !== 0) {
                        AIZ.plugins.notify('danger', 'Số điện thoại không đúng');
                        return false
                    }

                    let lengthPhone = to_phone_arr.length;
                    if (lengthPhone !== 10) {
                        AIZ.plugins.notify('danger', 'Số điện thoại phải có 10 số');
                        return false
                    }
                }
            }

            if ($('#to_name').val() == '') {
                AIZ.plugins.notify('danger', 'Vui lòng nhập họ tên');
                return false
            } else {
                if (hasNumber($('#to_name').val())) {
                    AIZ.plugins.notify('danger', 'Tên không được có số');
                    return false
                }
            }
            if ($('#to_address').val() == '') {
                AIZ.plugins.notify('danger', 'Vui lòng nhập địa chỉ');
                return false
            }

            if (code == ghtk) {
                if ($('#to_province').val() == null) {
                    AIZ.plugins.notify('danger', 'Vui lòng chọn thành phố');
                    return false
                }

                let arrWeight = $('.weight').map((i, e) => Number(e.value)).get(),
                    arrFilterLength = arrWeight.filter(function (el) {
                        return el != '';
                    }).length;

                if (arrFilterLength < arrWeight.length) {
                    AIZ.plugins.notify('danger', 'Vui lòng nhập đầy đủ khối lượng');
                    return false
                }

                let sumArrWeight = arrWeight.reduce((a, b) => a + b, 0)
                if (sumArrWeight > 20) {
                    AIZ.plugins.notify('danger', 'Tổng khối lượng không được lớn hơn 20kg');
                    return false
                }

            }

            if ($('#to_district_id').val() == null) {
                AIZ.plugins.notify('danger', 'Vui lòng chọn quận huyện');
                return false
            }

            if ($('#to_ward_code').val() == null) {
                AIZ.plugins.notify('danger', 'Vui lòng chọn phường xã');
                return false
            }

            if (code == ghn) {
                if ($('#required_note').val() == null) {
                    AIZ.plugins.notify('danger', 'Vui lòng chọn lưu ý giao hàng');
                    return false
                }
            }

            if ($('#payment_type_id').val() == null) {
                AIZ.plugins.notify('danger', 'Vui lòng chọn thanh toán');
                return false
            }

            if ($('#service_type_id').val() == null) {
                AIZ.plugins.notify('danger', 'Vui lòng chọn phương thức giao hàng');
                return false
            }

            return true;
        },
    }

    function hasNumber(myString) {
        return /\d/.test(myString);
    }

</script>
