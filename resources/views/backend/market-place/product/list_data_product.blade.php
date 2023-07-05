<style>
    .product-wrapper .product-list-wrapper #products-filter-empty-wrapper {
        display: block !important;
    }

    .product-list-container {
        position: absolute;
        top: 60px;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: auto;
        overflow-x: hidden;
    }
</style>
<div class="dashboard-body-content" style=" ">
    <div class="content-container">
        <div class="product-list-wrapper">
            <div class="d-flex header-list product-header di4l-product-header-menu">
                <div role="presentation" class="checkbox header-checkbox">
                    <input type="checkbox" name="check" readonly="" id="input-item-checkbox-all">
                    <label onclick="setCheckBox()"></label>
                </div>
                <div class="margin-right20 header-product-image">&nbsp;</div>
                <div class="margin-right20 header-product-name">Tên sản phẩm</div>
                <div class="margin-right20 header-tenant-name">Gian hàng</div>
                <div class="margin-right20 header-connection-status">Trạng thái liên kết</div>
                <div class="header-product-name mapping ">Sản phẩm liên kết</div>
                <div class="header-product-action margin-left">Thao tác</div>
            </div>
            <div class="product-list-container">
                @if(isset($products[config('market_place.type_market')[2]]))
                    @foreach($products[config('market_place.type_market')[2]]['product'] as $productInfo)
                        @include('backend.market-place.product.market.sendo')
                    @endforeach
                @endif
                @if(isset($products[config('market_place.type_market')[3]]))
                    @foreach($products[config('market_place.type_market')[3]]['product'] as $productInfo)
                        @include('backend.market-place.product.market.lazada')
                    @endforeach
                @endif
            </div>
{{--            <div class="d-flex products-footer">--}}
{{--                <div class="result-info">Hiển thị kết quả từ&nbsp;1 -&nbsp;17 trên tổng 17</div>--}}
{{--                <div class="margin-left-auto"></div>--}}
{{--                <div class="products-pagination">--}}
{{--                    <div class="page-number-control">--}}
{{--                        <nav aria-label="Page navigation example">--}}
{{--                            <ul class="pagination"></ul>--}}
{{--                        </nav>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</div>

<script>
    function seeMoreChildProduct(sku, marketId) {
        block_submit()
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{route("market_place.product.get_list_variant")}}',
            type: 'POST',
            data: {
                _token: '{{csrf_token()}}',
                sku: sku,
                marketId: marketId,
            },
            success: function (data) {
                un_block_submit()
                $('.variant-list-wrapper-' + sku + '-' + marketId).html(data);
                $('.more-element-item-' + sku + '-' + marketId + ' button').attr('onclick', 'collapseChildProduct("' + sku + '", ' + marketId + ')')
                    .html('<span>Thu gọn</span><svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.75 4.75L5 1L1.25 4.75" stroke="#0084FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.75 10L5 6.25L1.25 10" stroke="#0084FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>')

            },
            error: function () {
                un_block_submit()
                AIZ.plugins.notify('danger', 'Có lỗi xảy ra');
            }
        })
    }

    function collapseChildProduct(sku, marketId) {
        $('.variant-list-wrapper-' + sku + '-' + marketId).empty();
        $('.more-element-item-' + sku + '-' + marketId + ' button').attr('onclick', 'seeMoreChildProduct("' + sku + '", ' + marketId + ')')
            .html('<span>Xem thêm</span> <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M1.25 6.25L5 10L8.75 6.25" stroke="#0084FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M1.25 1L5 4.75L8.75 1" stroke="#0084FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </svg>')
    }
</script>

