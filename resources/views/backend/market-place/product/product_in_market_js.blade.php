<script>
    $(function () {
        ajaxGetDataProduct()
        filterProductByStore();
        __checkboxSyncMarket();
        __checkboxUnSyncMarket();
        $('.product_warning_container button').on('click', function () {
            $('.product_warning_container').remove()
        })

        $('#filter-product-by-tab li').click(function () {
            ajaxGetDataProduct($(this).attr('type-check'))
            $('#filter-product-by-tab li').removeClass('active')
            $(this).addClass('active');
        });

        let filterProductModalWrapper = document.getElementById("filter-product-modal-wrapper");
        $("#filter-product-button").on('click', function () {
            if (filterProductModalWrapper.style.display === "none") {
                filterProductModalWrapper.style.display = "block";
            } else {
                filterProductModalWrapper.style.display = "none";
            }
        })

    });

    function filterProductByStore() {
        let filterProductByStoreModal = document.getElementById("filter-product-by-store-modal");
        $("#fpbs-btn").on('click', function () {
            if (filterProductByStoreModal.style.display === "none") {
                filterProductByStoreModal.style.display = "block";
            } else {
                filterProductByStoreModal.style.display = "none";
            }
        })
        $('#fpbsm-footer-btn').on('click', function () {
            filterProductByStoreModal.style.display = "none";
            ajaxGetDataProduct(0);
        });
    }

    function ajaxGetDataProduct(type = null, variant = null, marketId = null) {
        block_submit()
        let object = $('#market_connected_filter').serializeArray();
        object.push({name: '_token', value: '{{csrf_token()}}'});
        object.push({name: 'type', value: type});

        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('market_place.product.list_data_product') }}',
            type: 'POST',
            data: object,
            success: function (data) {
                un_block_submit()
                if (!data.status) {

                } else {
                    $('#products-filter-empty-wrapper').html(data.view)
                }
            },
            error: function () {
                AIZ.plugins.notify('danger', 'Có lỗi xảy ra');
            }
        })
    }

    function searchProducts() {
        var input, filter, ul, li, a, i, txtValue;
        input = $('#filter-product-search-input');
        filter = input.val().toUpperCase();
        li = $('.product-list-container .product-item-wrapper-info');
        let productItemWrapper = document.getElementsByClassName('product-item-wrapper');
        for (i = 0; i < li.length; i++) {
            txtValue = $(li[i]).find('span').text().toUpperCase();
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                productItemWrapper[i].style.display = "";
            } else {
                productItemWrapper[i].style.display = "none";
            }
        }
    }

    let _modalChoiceMarket = function () {
        $('.register-channel-modal').css('display', 'block').modal('show');
    }
    // let _syncingProducts = function () {
    //     $('.register-channel-modal').css('display', 'block').modal('show');
    // }

    let __checkboxSyncMarket = function () {
        let _marketSyncProductCheckBox = $('.market-checkbox-sync-product'),
            _buttonLinkMultiProduct = $('#linkMultiProducts');

        _marketSyncProductCheckBox.each(function () {
            $(this).next().on('click', function () {
                _marketSyncProductCheckBox.prop('checked', false);
                $(this).prev().prop('checked', true);
                _buttonLinkMultiProduct.removeAttr('disabled');
            })
        })

        _buttonLinkMultiProduct.on('click', function (e) {
            e.stopImmediatePropagation();
            let $marketPlaceId = $('.market-checkbox-sync-product:checked').val(),
                _checkboxToSync = [];

            $('.checkbox-add:checked').each(function () {
                _checkboxToSync.push(this.value)
            })

            _checkboxToSync = [...new Set(_checkboxToSync)];

            $('.register-channel-modal').modal('hide');

            __$linkMultiProducts(_checkboxToSync, Number($marketPlaceId));
        });
    }

    let __$linkMultiProducts = function (_checkbox = [], $marketPlaceId) {
        block_submit()
        let url = `{{ route('market_place.product.link_multi_product_by_market') }}`;
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{csrf_token()}}',
                varianthash: _checkbox,
                market_place_id: $marketPlaceId,
                all: _checkbox.length ? false : true,
            },
            success: function (result) {
                un_block_submit();
                if (result.status) {
                    message("Thành công!!", 'Sản phẩm đang được đồng bộ', "success");

                    setTimeout(function () {
                        ajaxGetDataProduct()
                    }, 3000)

                } else {

                }
            },
            error: function () {
                un_block_submit();
            }
        });
    }
    let _modalUnSyneMarket = function () {
        $('.un-register-channel-modal').css('display', 'block').modal('show');
    }


    function setCheckBox(_$variantSku = null, $marketPlaceId = null) {
        let headerMenu = '<div role="presentation" class="checkbox header-checkbox"> <input id="input-item-checkbox-all" type="checkbox" name="check"  readonly=""> <label onclick="setCheckBox()"></label> </div> ' +
            '<div class="margin-right20 header-product-image">&nbsp;</div> ' +
            '<div class="margin-right20 header-product-name">Tên sản phẩm</div> ' +
            '<div class="margin-right20 header-tenant-name">Gian hàng</div> ' +
            '<div class="margin-right20 header-connection-status">Trạng thái liên kết</div>' +
            '<div class="header-product-name mapping ">Sản phẩm liên kết</div> ' +
            '<div class="header-product-action margin-left">Thao tác</div>';

        let headerCheckbox = '<div class="d-flex header-list product-header" style="padding: 2px 0px 9px;">' +
            '<div class="d-flex dropdown dd-bulk-action product-bulk-action-dd">' +
            '<div class="d-flex checkbox-wrapper">' +
            '<div role="presentation" class="checkbox header-checkbox">' +
            '<input id="product-header-checkbox" type="checkbox" name="check" readonly="" checked="">' +
            '<label onclick="setCheckBox()" style="margin-top: 5px !important;"></label></div><div class="count-check" style="margin-top: 13px !important;">' +
            '<span class="details count-checked">Đã chọn (' + 0 + ' phiên bản)</span></div></div>' +
            '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Lựa chọn thao tác</button>' +
            '<div style="left: 50%" class="dropdown-menu bulk-dd-menu" aria-labelledby="dropdownMenuButton">' +
            '<a class="dropdown-item" onclick="_modalChoiceMarket()" >Liên kết sản phẩm</a>' +
            '<a class="dropdown-item" onclick="_modalUnSyneMarket()">Hủy liên kết</a></div></div></div>'

        let checkbox = [];
        if (_$variantSku) {
            let _checkSingleBox = $('#input-item-checkbox-' + _$variantSku);
            if (_checkSingleBox.is(':checked')) {
                _checkSingleBox.prop('checked', false);
                checkbox = _countCheckbox();
                checkbox.length ? $('.count-checked').text('Đã chọn (' + checkbox.length + ' sản phẩm)') : $('.di4l-product-header-menu').html(headerMenu);
            } else {
                _checkSingleBox.prop('checked', true);
                $('.di4l-product-header-menu').html(headerCheckbox);
                checkbox = _countCheckbox()
                $('.count-checked').text('Đã chọn (' + checkbox.length + ' sản phẩm)');
            }
        } else {
            if (!$marketPlaceId) {
                let _checkAllBox = $('#product-header-checkbox'),
                    _checkSingleBox = $('.checkbox-add');
                if (_checkAllBox.is(':checked')) {
                    $('.di4l-product-header-menu').html(headerMenu)
                    _checkAllBox.prop('checked', false)
                    _checkSingleBox.prop('checked', false)
                } else {
                    _checkSingleBox.prop('checked', true)
                    checkbox = _countCheckbox()
                    $('.di4l-product-header-menu').html(headerCheckbox);
                    let total = checkbox.length - $(".product-item-wrapper").length;
                    $('.count-checked').text('Đã chọn (' + total + ' sản phẩm)')
                }
            }
        }
    }

    function _countCheckbox() {
        let checkbox = [];
        $('.checkbox-add:checked').each(function () {
            checkbox.push(this.value)
        });

        return checkbox;
    }

    let __checkboxUnSyncMarket = function () {
        let _unRegisterMarketCheckbox = $('.market-checkbox-un-sync'),
            _buttonUnLinkMultiProduct = $('#unlinkMultiProducts');

        _unRegisterMarketCheckbox.each(function () {
            $(this).next().on('click', function () {
                _unRegisterMarketCheckbox.prop('checked', false);
                $(this).prev().prop('checked', true);
                _buttonUnLinkMultiProduct.removeAttr('disabled');
            })
        })

        _buttonUnLinkMultiProduct.on('click', function (e) {
            e.stopImmediatePropagation();
            let $marketPlaceId = $('.market-checkbox-un-sync:checked').val(),
                _checkboxToUnSync = [];

            $('.checkbox-add:checked').each(function () {
                _checkboxToUnSync.push(this.value)
            })

            _checkboxToUnSync = [...new Set(_checkboxToUnSync)];

            $('.un-register-channel-modal').modal('hide');

            __$disconnectProduct(_checkboxToUnSync, $marketPlaceId);
        });
    }

    async function __$disconnectProduct($variantId = '', $marketPlaceId = '') {
        block_submit()
        let error,
            payload = {
                _token: '{{csrf_token()}}',
                variant_id: $variantId,
                market_id: $marketPlaceId,
            },
            url = `{{ route('market_place.product.disconnect_product') }}`
        try {
            await axios.post(url, payload)
                .then(function (response) {
                    un_block_submit();
                    if (response.data.status) {
                        message("Thành công!!", 'Hủy liên kết sản phẩm thành công', "success");
                        ajaxGetDataProduct()
                    } else {
                        message("Có lỗi xảy ra", response.data.msg, "error")
                    }
                })
                .catch(err => {
                    un_block_submit();
                    if (err.response.status === 404) {
                        throw new Error(`${err.config.url} not found`);
                    }

                    throw err;
                })
        } catch (err) {
            error = err;
            error.message;
        }
    }
    let _syncingProducts = async function () {
        let url = "{{ route('market_place.product.sync_all_product') }}",
            payload = {
                _token: '{{csrf_token()}}',
            }
        await axios.post(url, payload)
            .then(function (response) {
                message("Thành công!!", response.msg, "success");
            })
            .catch(err => {
                if (err.response.status === 404)
                    throw new Error(`${err.config.url} not found`);
                throw err;
            })
    }

</script>
