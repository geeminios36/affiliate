<script>
    $(function () {
        $('#generalSearch').keypress(function (e) {
            var key = e.which;
            if (key == 13) {
                __$filterProduct()
            }
        });

        @if(!empty($keyword))
        __$filterProduct()
        @endif
        @if(!empty($productStockId) && !empty($page))
        __$loadPosition()
        showDetailProduct({{$productStockId}})
        @endif

        __checkboxUnSyncMarket();
        __checkboxSyncMarket()
    });

    $('.instant-mapping-sapo-product').on('hidden.bs.modal', function () {
        $('.market-checkbox').prop('checked', false);
    })

    let _modalChoiceMarket = function () {
        $('.register-channel-modal').css('display', 'block').modal('show');
    }

    let _modalUnSyneMarket = function () {
        $('.un-register-channel-modal').css('display', 'block').modal('show');
    }

    let setCheckBox = function ($productStockId = null, $marketPlaceId = null) {
        let headerMenu = '<div role="presentation" class="checkbox sapo-product-header-checkbox uncheck"><input id="product-header-checkbox" type="checkbox" name="check" readonly=""><label onclick="setCheckBox()"></label> </div> ' +
            '<div class="margin-right20 header-sapo-product-image">&nbsp;</div> <div class="margin-right20 header-sapo-product-name">Tên sản phẩm </div> ' +
            '<div class="margin-right20 header-sapo-tenant-name">Số sản phẩm liên kết</div> ' +
            '<div class="margin-right20 header-sapo-connection-status">Có thể bán</div> ' +
            '<div class="header-product-action margin-left header-sapo-manipulation-status">Thao tác </div>';

        let headerCheckbox = '<div class="d-flex dropdown dd-bulk-action sapo-product-bulk-action-dd"><div class="d-flex checkbox-wrapper"> ' +
            '<div role="presentation" style="margin:  0 !important;" class="checkbox sapo-product-header-checkbox checked">                    ' +
            '<input type="checkbox" name="check" readonly="" checked="" id="product-header-checkbox"><label onclick="setCheckBox()"></label></div> ' +
            '<div class="count-checked">Đã chọn (' + 0 + ' sản phẩm)</div> </div> ' +
            '<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Lựa chọn thao tác</button>                    ' +
            '<div style="left: 49%" class="dropdown-menu bulk-dd-menu" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" onclick="_modalChoiceMarket()">Liên kết nhanh</a>' +
            '<a class="dropdown-item" onclick="_modalUnSyneMarket()">Hủy liên kết</a></div> </div>'

        let checkbox = [];
        if ($productStockId) {
            let _checkSingleBox = $('#input-item-checkbox-' + $productStockId);
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
                    $('.count-checked').text('Đã chọn (' + checkbox.length + ' sản phẩm)')
                }
            }
        }
    }

    let _countCheckbox = function () {
        let checkbox = [];
        $('.checkbox-add:checked').each(function () {
            checkbox.push(this.value)
        });

        return checkbox;
    }


    let __checkboxSyncMarket = function () {
        let _marketSyncProductCheckBox = $('.market-checkbox-sync-product'),
            _buttonLinkMultiProduct = $('#linkMultiProducts');

          _marketSyncProductCheckBox.each(function(){
            $(this).next().on('click', function(){
                _marketSyncProductCheckBox.prop('checked', false);
                $(this).prev().prop('checked', true);
                _buttonLinkMultiProduct.removeAttr('disabled');
            })
        })

        _buttonLinkMultiProduct.on('click', function (e) {
            e.stopImmediatePropagation();
            let $marketPlaceId = $('.market-checkbox-sync-product:checked').val(),
                _checkboxToSync = [];

            $('.checkbox-add:checked').each(function(){
                _checkboxToSync.push(this.value)
            })

            _checkboxToSync = [...new Set(_checkboxToSync)];

            $('.register-channel-modal').modal('hide');

             __$linkMultiProducts(_checkboxToSync, Number($marketPlaceId));
         });
    }

    let __checkboxUnSyncMarket = function () {
        let _unRegisterMarketCheckbox = $('.market-checkbox-un-sync'),
            _buttonUnLinkMultiProduct = $('#unlinkMultiProducts');

        _unRegisterMarketCheckbox.each(function(){
            $(this).next().on('click', function(){
                _unRegisterMarketCheckbox.prop('checked', false);
                $(this).prev().prop('checked', true);
                _buttonUnLinkMultiProduct.removeAttr('disabled');
            })
        })

        _buttonUnLinkMultiProduct.on('click', function (e) {
            e.stopImmediatePropagation();
            let $marketPlaceId = $('.market-checkbox-un-sync:checked').val(),
                _checkboxToUnSync = [];

            $('.checkbox-add:checked').each(function(){
                _checkboxToUnSync.push(this.value)
            })

            _checkboxToUnSync = [...new Set(_checkboxToUnSync)];

            $('.un-register-channel-modal').modal('hide');

             __$disconnectProduct(_checkboxToUnSync, $marketPlaceId);
         });
    }

    let showDetailProduct = function ($productStockId) {
        $('.item-icon-' + $productStockId).addClass('rotate')
        let productDetail = document.getElementById("product-detail-" + $productStockId);
        if (productDetail.style.display === "none") {
            $('.item-icon-' + $productStockId).addClass('rotate')
            productDetail.style.display = "block";
        } else {
            $('.item-icon-' + $productStockId).removeClass('rotate')
            productDetail.style.display = "none ";
        }
    }

    let filterText = function () {
        let formFilter = '<div class="position-absolute sapo-filter-popup" role="presentation"> ' +
            '<div class="filter-popup-header">Hiển thị sản phẩm theo</div><div class="d-flex filter-line"><div class="dropdown"> ' +
            '<div class="dropdown-toggle cat-select-filter-type" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Trạng thái liên kết' +
            '<span class="position-absolute suffix-dropdown"><svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">' +
            '<path d="M4 0L7.4641 3.75H0.535898L4 0Z" fill="#373C40"></path>' +
            '<path d="M4 9L7.4641 5.25H0.535898L4 9Z" fill="#373C40"></path></svg></span></div> ' +
            '<div class="dropdown-menu cat-filter-dd" aria-labelledby="dropdownMenuButton">' +
            '<a class="dropdown-item cat-item" status-filter="1">Chưa liên kết</a><a class="dropdown-item cat-item" status-filter="2">Đã liên kết</a>' +
            '<a class="dropdown-item cat-item" status-filter="">Tất cả</a></div></div></div><div class="filter-action"> ' +
            '<button class="btn btn-primary " onclick="__$filterProduct()" type="button">Lọc</button></div></div>';

        if ($('.filter-by-options div').hasClass('sapo-filter-popup')) {
            $('.sapo-filter-popup').remove()
        } else {
            $('.filter-text').after(formFilter)
            $('.cat-filter-dd a').on('click', function (e) {
                e.stopImmediatePropagation();
                $('#status-filter').val($(this).attr('status-filter'))
                $('.cat-select-filter-type').text($(this).text())
            })
        }

    }

    let __$linkMultiProducts = function (_checkbox = [], $marketPlaceId) {
        block_submit()
        let url = `{{ route('market_place.product_affiliate.link_multi_products') }}`;
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{csrf_token()}}',
                product_stock_id: _checkbox,
                market_place_id: $marketPlaceId,
                all: _checkbox.length ? false : true,
            },
            success: function (result) {
                un_block_submit();
                if (result.status) {
                    message("Thành công!!", 'Sản phẩm đang được đồng bộ', "success");

                    setTimeout(function () {
                        window.location.href = '{{route('market_place.product_affiliate.list_data_product')}}?product_stock_id=' + '&keyword=' + $('#generalSearch').val() + '&page=' + {{$productStocks->currentPage()}}
                    }, 3000)

                } else {

                }
            },
            error: function () {
                un_block_submit();
            }
        });
    }

    let _syncingProducts = async function () {
        let url = "{{ route('market_place.product_affiliate.syncing') }}",
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

    let __$linkProduct = async function ($productStockid = '', $marketPlaceId = '') {
        block_submit()
        $marketPlaceId = $marketPlaceId == '' ? '' : '/' + $marketPlaceId;
        $productStockid = $productStockid == '' ? '' : '/' + $productStockid;

        let error,
            payload = {_token: '{{csrf_token()}}'},
            url = `{{ route('market_place.product_affiliate.link_product') }}${$productStockid}${$marketPlaceId}`

        try {
            await axios.post(url, payload)
                .then(function (response) {
                    un_block_submit()
                    if (response.data.status) {
                        message("Thành công!!", response.data.msg, "success")

                        setTimeout(function () {
                            $productStockid = $productStockid.replace('/', '');
                            window.location.href = '{{route('market_place.product_affiliate.list_data_product')}}?product_stock_id='
                                + $productStockid + '&keyword=' + $('#generalSearch').val() + '&page=' + {{$productStocks->currentPage()}}
                        }, 3000);
                    } else {
                        message("Có lỗi xảy ra", response.data.msg, "error")
                    }
                })
                .catch(err => {
                    un_block_submit()
                    if (err.response.status === 404) {
                        throw new Error(`${err.config.url} not found`);
                    }

                    throw err;
                })
        } catch (err) {
            un_block_submit()
            error = err;
            error.message;
        }
    }

    let __$disconnectProduct = async function ($productLinkedId = '', $marketPlaceId = '') {
        $marketPlaceId = $marketPlaceId == '' ? '' : '/' + $marketPlaceId;
        $productLinkedId = Array.isArray($productLinkedId) ? JSON.stringify([...new Set($productLinkedId)]) : $productLinkedId;
        let error,
            payload = {_token: '{{csrf_token()}}'},
            url = `{{ route('market_place.product_affiliate.disconnect_product') }}/${$productLinkedId}${$marketPlaceId}`
        try {
            await axios.post(url, payload)
                .then(function (response) {
                    if (response.data.status) {
                        message("Thành công!!", 'Hủy liên kết sản phẩm thành công', "success");
                        setTimeout(function () {
                            __$filterProduct()
                            {{--window.location.href = '{{route('market_place.product_affiliate.list_data_product')}}?product_stock_id=' + $productLinkedId + '&keyword=' + $('#generalSearch').val() + '&page=' + {{$productStocks->currentPage()}}--}}
                        }, 3000)
                    } else {
                        message("Có lỗi xảy ra", response.data.msg, "error")
                    }
                })
                .catch(err => {
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

    let __$filterProduct = async function () {
        let url = "{{ route('market_place.product_affiliate.data_product_filter') }}";
        let payload = {
            _token: '{{csrf_token()}}',
            keyword: $('#generalSearch').val(),
            status: $('#status-filter').val()
        }

        await axios.post(url, payload)
            .then(function (response) {
                if (response.data.status) {
                    $('.sapo-product-list-container').html(response.data.view)
                    @if(!empty($productStockId))
                    __$loadPosition()
                    showDetailProduct({{$productStockId}})
                    @endif
                    $('.sapo-filter-popup').remove();
                }
            })
            .catch(err => {
                if (err.response.status === 404)
                    throw new Error(`${err.config.url} not found`);
                throw err;
            })
    }

</script>
