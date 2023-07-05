@foreach($productInfo->variants as $variantInfo)
    <?php
    $ecommerceLinkProduct = $connectedMarket->ecommerce_link_products->where('product_market_place_id', 'var_' . $variantInfo->variant_attribute_hash)->first();
    ?>
    <div class="product-tooltip-wrapper">
        <div class="d-flex product-item ">
            <div role="presentation" class="item-icon item-icon-{{$variantInfo->variant_sku}}"
                 hash_id="{{$variantInfo->variant_attribute_hash}}" market="{{$marketId}}"
                 sku="{{$variantInfo->variant_sku}}">
                <svg width="12" height="11" viewBox="0 0 12 11" fill="none"
                     xmlns="http://www.w3.org/2000/svg" class="" style="cursor: pointer;">
                    <path d="M0.979004 1L5.479 5.5L0.979004 10" stroke="#0088FF"></path>
                    <path d="M5.979 1L10.479 5.5L5.979 10" stroke="#0088FF"></path>
                </svg>
            </div>
            <div class="checkbox item-checkbox"><input type="checkbox" class="checkbox checkbox-add"
                                                       id="input-item-checkbox-var_{{$variantInfo->variant_attribute_hash}}"
                                                       value="{{$productInfo->item_id}}_var_{{$variantInfo->variant_attribute_hash}}"
                                                       name="check" readonly="" disabled=""><label
                    class="checkbox item-checkbox2" style="cursor: pointer;"
                    onclick="setCheckBox('var_{{$variantInfo->variant_attribute_hash}}', {{$marketId}})"></label></div>
            <div class="margin-right20 item-image position-relative image-hover" data-tip="true"
                 data-for="product-item-image0_0" currentitem="false"><img alt="product-thumb"
                                                                           src="{{$productInfo->image}}"
                                                                           class="image-item">
                <div class="__react_component_tooltip place-top type-dark"
                     id="product-item-image0_0" data-id="tooltip">Bấm để xem sản phẩm trên sàn
                </div>
            </div>
            <div class="margin-right20 item-product ">
                <div class="item-name"><span data-tip="true" data-for="product_name_id_0_0"
                                             currentitem="false">{{$productInfo->name}}</span>
                    <div class="__react_component_tooltip place-top type-dark product-name-tooltip"
                         id="product_name_id_0_0" data-id="tooltip">{{$productInfo->name}}</div>
                </div>
                <div class="item-sku"><span data-tip="true" data-for="sku_id_0_0"
                                            currentitem="false">{{$variantInfo->variant_sku}}</span>
                    <div class="__react_component_tooltip place-top type-dark" id="sku_id_0_0"
                         data-id="tooltip">{{$variantInfo->variant_sku}}</div>
                </div>
            </div>
            <div class="margin-right20 item-tenant"></div>
            <div class="margin-right20 item-status">
                @if(!empty($ecommerceLinkProduct))
                    <span data-tip="true" data-for="mapping-status-11_0" style="color: rgb(0, 136, 255);">Liên kết thành công</span>
                @else
                    <span data-tip="true" data-for="mapping-status-0_0"
                          style="color: rgb(22, 22, 29);">Chưa liên kết</span>
                @endif
            </div>
            <div class=" item-product mapping margin-left ">
                @if(!empty($ecommerceLinkProduct))
                    <div style="color: #1e8afe">
                        {{@$ecommerceLinkProduct->product_stock->product->name}}
                        - {{@$ecommerceLinkProduct->product_stock->variant}}
                    </div>
                    <div>
                        {{@$ecommerceLinkProduct->product_stock->sku}}
                    </div>
                @else
                    <div class="item-sku">
                        ---
                    </div>
                @endif
            </div>
            <div class="item-action">
                @if(!empty($ecommerceLinkProduct))
                    <div class="" data-tip="true" data-for="tool-tip-cancel-mapping-15539286" currentitem="false"
                         onclick="__$disconnectProduct('var_{{$variantInfo->variant_attribute_hash}}', {{$marketId}})">
                        <svg class="cancel-mapping-icon" width="34" height="34" viewBox="0 0 34 34" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect class="mapping-icon-rect-1" x="0.5" y="0.5" width="33" height="33" rx="3.5"
                                  fill="white"></rect>
                            <path class="mapping-icon-path"
                                  d="M21.5885 18.9665L23.556 17C24.4235 16.1297 24.9107 14.9509 24.9107 13.722C24.9107 12.4931 24.4235 11.3144 23.556 10.444C22.6859 9.576 21.507 9.08854 20.278 9.08854C19.049 9.08854 17.8701 9.576 17 10.444L16.3445 11.0995L17.6555 12.4105L18.311 11.755C18.8335 11.2349 19.5407 10.9429 20.278 10.9429C21.0152 10.9429 21.7225 11.2349 22.245 11.755C22.7656 12.2773 23.0579 12.9846 23.0579 13.722C23.0579 14.4594 22.7656 15.1667 22.245 15.689L20.2775 17.6555C20.0522 17.8793 19.7868 18.0586 19.495 18.184L18.311 17L19.622 15.689L18.9665 15.0335C18.5372 14.6015 18.0265 14.2591 17.4639 14.0259C16.9013 13.7927 16.298 13.6735 15.689 13.6752C15.4711 13.6752 15.2588 13.7049 15.0483 13.7364L9.31101 8L8 9.31101L24.689 26L26 24.689L20.8672 19.5562C21.124 19.3856 21.366 19.189 21.5885 18.9665ZM15.689 22.245C15.1665 22.7651 14.4593 23.0571 13.722 23.0571C12.9847 23.0571 12.2775 22.7651 11.755 22.245C11.2344 21.7227 10.9421 21.0154 10.9421 20.278C10.9421 19.5406 11.2344 18.8333 11.755 18.311L13.1235 16.9434L11.8125 15.6324L10.444 17C9.57645 17.8703 9.0893 19.0491 9.0893 20.278C9.0893 21.5069 9.57645 22.6856 10.444 23.556C10.8741 23.9867 11.3851 24.3282 11.9475 24.5608C12.51 24.7934 13.1129 24.9126 13.7215 24.9115C14.3304 24.9128 14.9335 24.7937 15.4961 24.561C16.0587 24.3284 16.5698 23.9868 17 23.556L17.6555 22.9005L16.3445 21.5895L15.689 22.245Z"
                                  fill="#EE405E"></path>
                            <rect class="mapping-icon-rect-2" x="0.5" y="0.5" width="33" height="33" rx="3.5"
                                  stroke="#C4CDD5"></rect>
                        </svg>
                        <div class="__react_component_tooltip place-top type-dark" id="tool-tip-cancel-mapping-15539286"
                             data-id="tooltip" style="left: 1393px; top: 291px;">Hủy liên kết
                        </div>
                    </div>
                @else
                    <div class="btn-show-popup-select-product " data-tip="true" title="Liên kết sản phẩm tự động"
                         onclick="__linkEachProduct('{{$productInfo->item_id}}', '{{$variantInfo->variant_sku}}', {{$marketId}} )"
                         data-for="tool-tip-auto-mapping-20180853" currentitem="false">
                        <svg class="mapping-icon" width="32" height="32" viewBox="0 0 32 32" fill="none"
                             xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
                            <rect class="mapping-icon-rect-1" x="0.5" y="0.5" width="30.9981"
                                  height="31" rx="3.5" fill="white"></rect>
                            <path class="mapping-icon-path"
                                  d="M12.2706 15.2544C13.4656 14.0594 15.5497 14.0594 16.7448 15.2544L17.4904 16.0001L18.9818 14.5087L18.2361 13.763C17.2415 12.7673 15.9168 12.2178 14.5077 12.2178C13.0986 12.2178 11.7738 12.7673 10.7792 13.763L8.54109 16.0001C7.55418 16.9902 7 18.3311 7 19.7291C7 21.127 7.55418 22.468 8.54109 23.4581C9.03035 23.948 9.6116 24.3365 10.2515 24.6011C10.8913 24.8657 11.5771 25.0013 12.2695 25.0001C12.9621 25.0015 13.6482 24.866 14.2882 24.6014C14.9283 24.3367 15.5097 23.9482 15.9991 23.4581L16.7448 22.7124L15.2534 21.221L14.5077 21.9667C13.9133 22.5584 13.1088 22.8906 12.2701 22.8906C11.4314 22.8906 10.6268 22.5584 10.0325 21.9667C9.44025 21.3726 9.1077 20.5679 9.1077 19.7291C9.1077 18.8902 9.44025 18.0856 10.0325 17.4915L12.2706 15.2544Z"
                                  fill="#006AFF"></path>
                            <path class="mapping-icon-path"
                                  d="M15.999 8.54196L15.2533 9.28765L16.7447 10.779L17.4904 10.0333C18.0848 9.44163 18.8893 9.10943 19.728 9.10943C20.5667 9.10943 21.3712 9.44163 21.9656 10.0333C22.5578 10.6274 22.8904 11.4321 22.8904 12.2709C22.8904 13.1098 22.5578 13.9145 21.9656 14.5085L19.7275 16.7456C18.5325 17.9406 16.4483 17.9406 15.2533 16.7456L14.5076 15.9999L13.0162 17.4913L13.7619 18.237C14.7565 19.2327 16.0813 19.7822 17.4904 19.7822C18.8995 19.7822 20.2242 19.2327 21.2188 18.237L23.457 15.9999C24.4439 15.0098 24.9981 13.6689 24.9981 12.2709C24.9981 10.873 24.4439 9.53205 23.457 8.54196C22.4672 7.55453 21.1261 7 19.728 7C18.3299 7 16.9888 7.55453 15.999 8.54196Z"
                                  fill="#006AFF"></path>
                            <rect class="mapping-icon-rect-2" x="0.5" y="0.5" width="30.9981"
                                  height="31" rx="3.5" stroke="#C4CDD5"></rect>
                        </svg>
                        <div class="__react_component_tooltip place-top type-dark"
                             id="tool-tip-auto-mapping-20180853" data-id="tooltip">Liên kết sản phẩm tự
                            động
                        </div>
                    </div>
                @endif
            </div>
            <div class="product-detail item-icon-{{$variantInfo->variant_sku}}" style="display: none">
                <div class="d-flex wrapper footer-detail">
                    <div class="d-flex col-lg-8 col-md-8 col-sm-8" style="height: 73px;"><span>Sản phẩm này trên gian hàng chưa được thực hiện liên kết với sản phẩm trên . Vui lòng thực hiện liên kết ngay</span>
                    </div>
                    <div class="col-sm-4">
                        <div style="display: flex;">
                            <button type="button" class="btn btn-info">Chi tiết</button>
                            <button type="button" class="btn btn-primary"
                                    onclick="__linkEachProduct('{{$productInfo->item_id}}', '{{$variantInfo->variant_sku}}', {{$marketId}})">
                                Liên kết ngay
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr style="margin: 0 !important;">
    </div>
@endforeach
<script>
    $(function () {
        $('.item-icon').each(function () {
            $(this).on('click', function () {
                let classList = $(this).attr('class').split(' '),
                    hashId = $(this).attr('hash_id'),
                    marketId = $(this).attr('market'),
                    sku = $(this).attr('sku');
                showDetailProduct(classList[1], hashId, marketId, sku)
            })
        })
    });

    let showDetailProduct = function (className, hashId, marketId, sku) {
        let _productDetail = $('.' + className + ':last-child');
        if ($('.' + className).hasClass('rotate')) {
            $('.' + className).removeClass('rotate')
            _productDetail.removeClass('rotate').css('display', 'none')
        } else {
            $('.' + className).addClass('rotate');
            __getDetailVariantProduct(hashId, marketId, sku, _productDetail);
        }
    }

    async function __linkEachProduct(productSku, variantSku, marketId) {
        block_submit()
        let error,
            payload = {
                _token: '{{csrf_token()}}',
                product_sku: productSku,
                variant_sku: variantSku,
                market_id: marketId,
            },
            url = `{{ route('market_place.product.link_each_product') }}`

        try {
            await axios.post(url, payload)
                .then(function (response) {
                    un_block_submit()
                    if (response.data.status) {
                        message("Thành công!!", response.data.msg, "success")
                        ajaxGetDataProduct()
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

    function __getDetailVariantProduct(hashId, marketId, sku, _productDetail) {
        block_submit()
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('market_place.product.detail_product_synced') }}',
            type: 'POST',
            data: {
                _token: '{{csrf_token()}}',
                variant_id: hashId,
                market_id: marketId,
                variant_sku: sku,
                product_sku: '{{$productInfo->item_id}}',
            },
            success: function (data) {
                un_block_submit();
                if (data.status) {
                    _productDetail.html(data.view);
                }
                _productDetail.removeClass('rotate').css('display', 'block')
            },
            error: function () {
                un_block_submit();
                message('Có lỗi xảy ra', '', "error");
            }
        })
    }
</script>
