@include('backend.market-place.market-place-style')
@include('backend.market-place.connect_style')
<div id="app">
    <div id="market-place-wrapper">
        <div id="market-place-content" style="margin-top: 4px;">
            <div class="overview-wrapper">
                <div class="overview-today-wrapper">
                    <div class="overview-today-header">
                        <div class="overview-today-header-content">Báo cáo nhanh Hôm nay &amp; Danh sách cần làm</div>
                        <a class="overview-today-header-link"
                           href="https://artisq.mysapogo.com/admin/apps/market-place/home/report" target="_blank">Xem
                            chi tiết</a></div>
                    <div class="overview-today-body">
                        <a class="overview-today-order"
                           href="/market-place/home/report"
                           target="_blank">
                            <div class="overview-today-order-col revenue">
                                <div class="overview-today-order-col-icon">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="16" cy="16" r="16" fill="#0C9EB8"></circle>
                                        <path
                                            d="M15.8448 14.4611C13.8379 13.9039 13.1925 13.3278 13.1925 12.4306C13.1925 11.4011 14.0855 10.6833 15.5796 10.6833C17.1532 10.6833 17.7367 11.4861 17.7898 12.6667H19.7436C19.6817 11.0422 18.7534 9.55 16.9057 9.06833V7H14.2534V9.04C12.5383 9.43667 11.1591 10.6267 11.1591 12.4494C11.1591 14.6311 12.8477 15.7172 15.3143 16.35C17.5246 16.9167 17.9666 17.7478 17.9666 18.6261C17.9666 19.2778 17.5334 20.3167 15.5796 20.3167C13.7583 20.3167 13.0422 19.4478 12.945 18.3333H11C11.1061 20.4017 12.556 21.5633 14.2534 21.9506V24H16.9057V21.9694C18.6297 21.62 20 20.5528 20 18.6167C20 15.9344 17.8517 15.0183 15.8448 14.4611Z"
                                            fill="white"></path>
                                    </svg>
                                </div>
                                <div class="overview-today-order-col-text">
                                    <div class="overview-today-order-value">0</div>
                                    <div class="overview-today-order-name">Tổng giá trị</div>
                                </div>
                            </div>
                            <div class="separator"></div>
                            <div class="overview-today-order-col quantity">
                                <div class="overview-today-order-col-icon">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="16" cy="16" r="16" fill="#1E94D7"></circle>
                                        <path
                                            d="M12.9103 11.75L11.3655 8L14.4552 9.5L16 8L17.5448 9.5L20.6345 8L19.0897 11.75H12.9103ZM19.0897 23H12.9103C8.27586 23 9.04828 20 9.04828 20C9.04828 20 9.82069 14.75 12.9103 13.25H19.0897C22.1793 14.75 22.9517 20 22.9517 20C22.9517 20 23.7241 23 19.0897 23ZM12.5241 15.875C12.5241 16.1734 12.6462 16.4595 12.8635 16.6705C13.0808 16.8815 13.3755 17 13.6828 17C13.99 17 14.2847 16.8815 14.502 16.6705C14.7193 16.4595 14.8414 16.1734 14.8414 15.875C14.8414 15.5766 14.7193 15.2905 14.502 15.0795C14.2847 14.8685 13.99 14.75 13.6828 14.75C13.3755 14.75 13.0808 14.8685 12.8635 15.0795C12.6462 15.2905 12.5241 15.5766 12.5241 15.875ZM19.4759 20.375C19.4759 20.0766 19.3538 19.7905 19.1365 19.5795C18.9192 19.3685 18.6245 19.25 18.3172 19.25C18.01 19.25 17.7153 19.3685 17.498 19.5795C17.2807 19.7905 17.1586 20.0766 17.1586 20.375C17.1586 20.6734 17.2807 20.9595 17.498 21.1705C17.7153 21.3815 18.01 21.5 18.3172 21.5C18.6245 21.5 18.9192 21.3815 19.1365 21.1705C19.3538 20.9595 19.4759 20.6734 19.4759 20.375ZM19.4759 15.7625L18.4331 14.75L12.5241 20.4875L13.5823 21.5L19.4759 15.7625Z"
                                            fill="white"></path>
                                    </svg>
                                </div>
                                <div class="overview-today-order-col-text">
                                    <div class="overview-today-order-value">0</div>
                                    <div class="overview-today-order-name">Đơn hàng</div>
                                </div>
                            </div>
                        </a><a class="overview-today-order-status"
                               href="https://artisq.mysapogo.com/admin/apps/market-place/home/report" target="_blank">
                            <div class="overview-today-order-status-col pendding">
                                <div class="overview-today-order-value">0</div>
                                <div class="overview-today-order-name">Chờ xác nhận</div>
                            </div>
                            <div class="separator"></div>
                            <div class="overview-today-order-status-col packed">
                                <div class="overview-today-order-value">0</div>
                                <div class="overview-today-order-name">Chờ lấy hàng</div>
                            </div>
                            <div class="separator"></div>
                            <div class="overview-today-order-status-col cancelled">
                                <div class="overview-today-order-value">0</div>
                                <div class="overview-today-order-name">Chờ hủy</div>
                            </div>
                            <div class="separator"></div>
                            <div class="overview-today-order-status-col pendding">
                                <div class="overview-today-order-value">0</div>
                                <div class="overview-today-order-name">Đang vận chuyển</div>
                            </div>
                        </a></div>
                </div>
                <div class="list-connection-wrapper">
                    <div class="list-connection-header">
                        <div class="list-connection-header-content">Kết nối sàn TMĐT</div>
                        <button type="button" class="btn btn-primary btn-connect-new-connection"
                                onclick="modalRegister()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-plus union_icon">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            <span>Kết nối gian hàng mới</span></button>
                    </div>
                    <div class="list-connection-body">
                        <div class="list-connection-row header">
                            <div class="list-connection-col-number">STT</div>
                            <div class="list-connection-col-name">Tên gian hàng</div>
                            <div class="list-connection-col-status">Trạng thái</div>
                            <div class="list-connection-col-time">Ngày kết nối</div>
                            <div class="list-connection-col-product">Sản phẩm liên kết</div>
                            <div class="list-connection-col-order">Đơn hàng liên kết</div>
                            <div class="list-connection-col-revenue">Tổng giá trị hôm nay</div>
                        </div>
                        @foreach($connectedMarket as $key => $connectedMarketInfo)
                            <div class="list-connection-row">
                                <div class="list-connection-col-number">{{$key+=1}}</div>
                                <div class="list-connection-col-name">
                                    <img class="connection-image"
                                         src="{{static_asset($connectedMarketInfo->logo)}}"
                                         alt="store-avatar">
                                    <div
                                        class="connection-name">{{@$connectedMarketInfo->ecommerce_market_place_config->shorted_name}}</div>
                                </div>
                                <div
                                    class="list-connection-col-status {{$connectedMarketInfo->status == 1 ? 'active' : ''}}">
                                    <div
                                        class="connection-status-dot {{$connectedMarketInfo->status == 1 ? 'active' : ''}}"></div>
                                    <div class="connection-status-text" data-tip="true"
                                         data-for="connection-col-status-0">
                                        @if($connectedMarketInfo->status == 1)
                                            Đang hoạt động
                                        @elseif($connectedMarketInfo->status == 0)
                                            Chưa kích hoạt
                                        @else
                                            <a href="{{route('market_place.sendo.connect')}}">
                                                <button class="btn-primary" type="button">
                                                    Đăng nhập lại
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div
                                    class="list-connection-col-time">{{format_date($connectedMarketInfo->created_at)}}</div>
                                <div class="list-connection-col-product"><a class="connection-info-wrapper"
                                                                            href="https://artisq.mysapogo.com/admin/apps/market-place/home/product?filter=eyJzaG93RmlsdGVyIjpmYWxzZSwic2VsZWN0ZWRGaWx0ZXIiOlsibWFwcGluZyJdLCJtYXBwaW5nX3N0YXR1cyI6eyJzdGF0dXMiOiIyIn0sInN5bmNfc3RhdHVzIjp7InN0YXR1cyI6IiJ9LCJmaWx0ZXJUZXh0IjoiIiwic2VsZWN0ZWRTdG9yZSI6WzI1ODk0XSwic2hvd0ZpbHRlckJ5U3RvcmUiOmZhbHNlfQ=="
                                                                            target="_blank">
                                        <div class="connection-info-mapping">
                                            {{$connectedMarketInfo->connectProductCount}}
                                        </div>
                                        <div class="connection-info-total">/{{count($productCurrent)}}</div>
                                    </a></div>
                                <div class="list-connection-col-order"><a class="connection-info-wrapper"
                                                                          href="https://artisq.mysapogo.com/admin/apps/market-place/home/order?filter=eyJzaG93RmlsdGVyIjpmYWxzZSwic2VsZWN0ZWRGaWx0ZXIiOlsibWFwcGluZyJdLCJtYXBwaW5nX3N0YXR1cyI6eyJzdGF0dXMiOiIyIn0sInN5bmNfc3RhdHVzIjp7InN0YXR1cyI6IiJ9LCJvcmRlcl9zdGF0dXMiOnsic3RhdHVzIjpbXX0sImZpbHRlclRleHQiOiIiLCJzZWxlY3RlZFN0b3JlIjpbMjU4OTRdLCJzaG93RmlsdGVyQnlTdG9yZSI6ZmFsc2UsImNoYW5uZWxUeXBlIjoxLCJwcmludF9zdGF0dXMiOnsic3RhdHVzIjoiIn19"
                                                                          target="_blank">
                                        <div class="connection-info-mapping">{{$connectedMarketInfo->connectOrderCount}}</div>
                                        <div class="connection-info-total">/{{$orderToday}}</div>
                                    </a></div>
                                <div class="list-connection-col-revenue"><span
                                        class="connection-info-revenue">0 đ</span><span
                                        class="connection-info-rate ">0%</span></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="notification-wrapper"></div>
</div>

@include('backend.market-place.modal.connect-market')
@include('backend.market-place.cdn.library')
<script>
    function modalRegister() {
        $('#market_place_modal_connect').css('display', 'block').modal('show');
    }

    $('#btn-login-tiki').on('click', function () {
        window.top.location.href = '{{$connectOther['tiki']}}/'
    })
    $('#btn-login-lazada').on('click', function () {
        window.top.location.href = '{!! $connectOther['lazada'] !!}'
    })
</script>
