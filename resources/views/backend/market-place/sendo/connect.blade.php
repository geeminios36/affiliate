@include('backend.market-place.market-place-style')
@include('backend.market-place.connect_style')
<div id="app">
    <div id="market-place-wrapper">
        <div id="market-place-content" style="overflow: hidden; height: 100%;">
            <div id="sendo-login-wrapper">
                <div class="login-wrapper">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="sendo-login-content">
                                <div id="sendo-login-logo">
                                    <div id="sendo-login-logo-sapo">
                                        <img src="{{ static_asset('assets/img/logo.png') }}" width="90%"
                                             style="margin-top: 5%">
                                    </div>
                                    <div id="sendo-login-logo-refresh">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="-5 0 459 459.648"
                                             width="50px" class="">
                                            <g>
                                                <path
                                                    d="m416.324219 293.824219c0 26.507812-21.492188 48-48 48h-313.375l63.199219-63.199219-22.625-22.625-90.511719 90.511719c-6.246094 6.25-6.246094 16.375 0 22.625l90.511719 90.511719 22.625-22.625-63.199219-63.199219h313.375c44.160156-.054688 79.945312-35.839844 80-80v-64h-32zm0 0"
                                                    data-original="#000000" class="active-path" data-old_color="#000000"
                                                    fill="#4F4F4F"></path>
                                                <path
                                                    d="m32.324219 165.824219c0-26.511719 21.488281-48 48-48h313.375l-63.199219 63.199219 22.625 22.625 90.511719-90.511719c6.246093-6.25 6.246093-16.375 0-22.625l-90.511719-90.511719-22.625 22.625 63.199219 63.199219h-313.375c-44.160157.050781-79.949219 35.839843-80 80v64h32zm0 0"
                                                    data-original="#000000" class="active-path" data-old_color="#000000"
                                                    fill="#4F4F4F"></path>
                                            </g>
                                        </svg>
                                    </div>
                                    <div id="sendo-login-logo-sendo">
                                        <svg width="200" height="100" viewBox="0 0 142 40" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M111.388 1.75383L106.435 27.7303C105.803 31.1814 105.41 34.6721 105.259 38.1774H98.3175L98.7293 33.5421H98.6234C97.7478 34.9789 96.5175 36.1663 95.0506 36.9904C93.5837 37.8146 91.9295 38.2476 90.2469 38.2479C85.894 38.2479 82.2822 34.8009 82.2822 28.5656C82.2822 19.6597 88.7293 11.4832 98.4116 11.4832C99.6121 11.4759 100.805 11.6708 101.941 12.0597L103.918 1.74207L111.388 1.75383ZM100.8 18.095C99.9247 17.4962 98.8835 17.1875 97.8234 17.2127C93.3175 17.2127 90.1175 22.4479 90.1175 27.3656C90.1175 30.4597 91.4822 32.1891 93.6469 32.1891C95.8116 32.1891 98.4587 29.8362 99.4587 25.0127L100.8 18.095Z"
                                                fill="#ED2624"></path>
                                            <path
                                                d="M8.40022 29.4945C10.9324 30.9721 13.8096 31.7554 16.7414 31.7651C19.6826 31.7651 22.3649 30.4004 22.3649 27.6239C22.3649 25.6239 20.8355 24.318 17.5884 22.6357C13.812 20.5886 10.2355 17.8592 10.2355 13.2239C10.2355 6.08272 16.4708 1.74154 24.2002 1.74154C27.0883 1.60841 29.9617 2.22443 32.5414 3.52978L30.1884 9.82389C28.1307 8.76162 25.8453 8.2165 23.5296 8.23566C20.0002 8.23566 18.1767 10.0239 18.1767 11.9651C18.1767 13.9062 20.3296 15.271 23.3296 16.9533C27.6237 19.2121 30.3884 22.0945 30.3884 26.2945C30.3884 34.1651 23.8826 38.2121 16.012 38.2121C11.0826 38.2121 7.56492 36.9415 5.88257 35.6827L8.40022 29.4945Z"
                                                fill="#ED2624"></path>
                                            <path
                                                d="M52.4942 36.2226C49.506 37.5886 46.2499 38.268 42.9648 38.2108C35.6354 38.2108 31.8589 34.0696 31.8589 27.4226C31.8589 19.6108 37.5177 11.4932 46.7883 11.4932C51.9765 11.4932 55.6942 14.3755 55.6942 19.1402C55.6942 25.6932 49.353 28.0461 39.0942 27.7873C39.1113 28.7159 39.3796 29.6225 39.8707 30.4108C40.4815 31.1022 41.245 31.6418 42.1006 31.9869C42.9562 32.332 43.8805 32.4731 44.8001 32.399C47.285 32.415 49.7404 31.8596 51.9765 30.7755L52.4942 36.2226ZM45.8824 16.999C44.4245 17.054 43.0299 17.6091 41.933 18.571C40.8361 19.533 40.1037 20.8431 39.8589 22.2814C45.7412 22.2814 48.6589 21.5049 48.6589 19.199C48.6589 17.8814 47.6118 16.999 45.8824 16.999"
                                                fill="#ED2624"></path>
                                            <path
                                                d="M54.5884 38.1764L57.9413 20.3999C58.5648 17.1529 59.1178 13.7294 59.3884 11.4823H66.0943L65.4825 16.3176H65.5884C66.5739 14.8305 67.9131 13.6113 69.486 12.7694C71.0589 11.9275 72.8161 11.4893 74.6001 11.4941C78.8237 11.4941 81.1766 14.1176 81.1766 18.4588C81.1356 19.9178 80.9941 21.3722 80.7531 22.8117L77.8472 38.1058H70.2825L73.0237 23.5294C73.1878 22.5772 73.2743 21.6132 73.2825 20.647C73.2825 18.8705 72.659 17.6117 70.7766 17.6117C68.306 17.6117 65.4354 20.6941 64.3884 26.3529L62.1531 38.2352L54.5884 38.1764Z"
                                                fill="#ED2624"></path>
                                            <path
                                                d="M135.295 22.0235C135.295 31.4352 128.906 38.2588 120.001 38.2588C113.506 38.2588 109.165 34.0235 109.165 27.6705C109.165 18.7647 115.342 11.4823 124.459 11.4823C131.318 11.4823 135.306 16.1882 135.306 22.0705L135.295 22.0235ZM116.965 27.5294C116.965 30.5058 118.436 32.5058 121.048 32.5058C125.189 32.5058 127.495 26.4823 127.495 22.0823C127.495 19.7294 126.495 17.2117 123.459 17.2117C119.106 17.2117 116.918 23.5411 116.965 27.5294Z"
                                                fill="#ED2624"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div id="sendo-login-title">KẾT NỐI GIAN HÀNG SENDO MỚI</div>
                                <div class="sendo-login-step">
                                    <div class="sendo-login-step-number">1</div>
                                    <div class="sendo-login-text">Đăng nhập gian hàng Sendo mà bạn muốn kết nối với

                                    </div>
                                </div>
                                <div class="sendo-login-step-icon">
                                    <svg width="8" height="36" viewBox="0 0 8 36" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M3.48364 0.5C3.48364 0.223858 3.25978 0 2.98364 0C2.7075 0 2.48364 0.223858 2.48364 0.5V2.34286C2.48364 2.619 2.7075 2.84286 2.98364 2.84286C3.25978 2.84286 3.48364 2.619 3.48364 2.34286V0.5ZM3.48364 5.10714C3.48364 4.831 3.25978 4.60714 2.98364 4.60714C2.7075 4.60714 2.48364 4.831 2.48364 5.10714L2.48364 8.79286C2.48364 9.069 2.7075 9.29286 2.98364 9.29286C3.25978 9.29286 3.48364 9.069 3.48364 8.79286L3.48364 5.10714ZM3.48364 11.5571C3.48364 11.281 3.25978 11.0571 2.98364 11.0571C2.7075 11.0571 2.48364 11.281 2.48364 11.5571L2.48364 15.2429C2.48364 15.519 2.7075 15.7429 2.98364 15.7429C3.25978 15.7429 3.48364 15.519 3.48364 15.2429L3.48364 11.5571ZM3.48364 18.0071C3.48364 17.731 3.25978 17.5071 2.98364 17.5071C2.7075 17.5071 2.48364 17.731 2.48364 18.0071L2.48364 21.6929C2.48364 21.969 2.7075 22.1929 2.98364 22.1929C3.25978 22.1929 3.48364 21.969 3.48364 21.6929L3.48364 18.0071ZM3.48364 24.4571C3.48364 24.181 3.25978 23.9571 2.98364 23.9571C2.7075 23.9571 2.48364 24.181 2.48364 24.4571L2.48364 28.1429C2.48364 28.419 2.7075 28.6429 2.98364 28.6429C3.25978 28.6429 3.48364 28.419 3.48364 28.1429L3.48364 24.4571ZM3.48364 30.9071C3.48364 30.631 3.25978 30.4071 2.98364 30.4071C2.7075 30.4071 2.48364 30.631 2.48364 30.9071V32.75C2.48364 32.8046 2.49238 32.8571 2.50854 32.9062H0L3 35.9062L6 32.9062H3.45874C3.4749 32.8571 3.48364 32.8046 3.48364 32.75V30.9071Z"
                                              fill="#0089FF"></path>
                                    </svg>
                                </div>
                                <div class="sendo-login-step">
                                    <div class="sendo-login-step-number">2</div>
                                    <div class="sendo-login-text">Copy mã shop và mã bảo mật <a
                                            href="https://ban.sendo.vn/cau-hinh/api">tại đây</a></div>
                                </div>
                                <div class="sendo-login-step-icon">
                                    <svg width="8" height="36" viewBox="0 0 8 36" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M3.48364 0.5C3.48364 0.223858 3.25978 0 2.98364 0C2.7075 0 2.48364 0.223858 2.48364 0.5V2.34286C2.48364 2.619 2.7075 2.84286 2.98364 2.84286C3.25978 2.84286 3.48364 2.619 3.48364 2.34286V0.5ZM3.48364 5.10714C3.48364 4.831 3.25978 4.60714 2.98364 4.60714C2.7075 4.60714 2.48364 4.831 2.48364 5.10714L2.48364 8.79286C2.48364 9.069 2.7075 9.29286 2.98364 9.29286C3.25978 9.29286 3.48364 9.069 3.48364 8.79286L3.48364 5.10714ZM3.48364 11.5571C3.48364 11.281 3.25978 11.0571 2.98364 11.0571C2.7075 11.0571 2.48364 11.281 2.48364 11.5571L2.48364 15.2429C2.48364 15.519 2.7075 15.7429 2.98364 15.7429C3.25978 15.7429 3.48364 15.519 3.48364 15.2429L3.48364 11.5571ZM3.48364 18.0071C3.48364 17.731 3.25978 17.5071 2.98364 17.5071C2.7075 17.5071 2.48364 17.731 2.48364 18.0071L2.48364 21.6929C2.48364 21.969 2.7075 22.1929 2.98364 22.1929C3.25978 22.1929 3.48364 21.969 3.48364 21.6929L3.48364 18.0071ZM3.48364 24.4571C3.48364 24.181 3.25978 23.9571 2.98364 23.9571C2.7075 23.9571 2.48364 24.181 2.48364 24.4571L2.48364 28.1429C2.48364 28.419 2.7075 28.6429 2.98364 28.6429C3.25978 28.6429 3.48364 28.419 3.48364 28.1429L3.48364 24.4571ZM3.48364 30.9071C3.48364 30.631 3.25978 30.4071 2.98364 30.4071C2.7075 30.4071 2.48364 30.631 2.48364 30.9071V32.75C2.48364 32.8046 2.49238 32.8571 2.50854 32.9062H0L3 35.9062L6 32.9062H3.45874C3.4749 32.8571 3.48364 32.8046 3.48364 32.75V30.9071Z"
                                              fill="#0089FF"></path>
                                    </svg>
                                </div>
                                <div class="sendo-login-step">
                                    <div class="sendo-login-step-number">3</div>
                                    <div class="sendo-login-text">Nhập mã shop và mã bảo mật vào ô bên dưới</div>
                                </div>
                                <div id="message-sendo-login-api-key"></div>
                                <input id="sendo-login-api-key" placeholder="Nhập mã shop tại đây" class="input-key"
                                       value="">
                                <div id="message-sendo-login-secret-key"></div>
                                <input id="sendo-login-secret-key"
                                       placeholder="Nhập mã bảo mật tại đây" class="input-key"
                                       value="">
                                <button type="button" class="btn btn-primary " id="btn-login-sendo">Tiến hành kết nối
                                </button>
                                <div id="sendo-login-guide"><span>Bạn cần có tài khoản bán hàng trên Sendo. Nếu chưa có vui lòng đăng ký </span><span
                                        id="sendo-login-guide-link"><a href="https://ban.sendo.vn">tại đây</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="notification-wrapper"></div>
</div>

@include('backend.market-place.sendo.modal.confirm_connect')
@include('backend.market-place.cdn.library')

<script>
    $('#btn-login-sendo').on('click', function () {
        let url = "{{ route('market_place.sendo.connecting') }}";
        return $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                shop_key: $('#sendo-login-api-key').val(),
                secret_key: $('#sendo-login-secret-key').val(),
            },
            success: function (result) {
                if (result.status) {
                    $('.warning_login_modal').css('display', 'block').modal('show');
                    $('#confirm_connect_modal').on('click', function () {
                        window.top.location.href = result.data.count ? '{{route('market_place.index')}}' : '{{route('market_place.config_market')}}/' + result.data.id;
                    });
                } else {
                    swal(result.msg);
                }
            },
            error: function (result) {
                let sendo_login_api_key = result.responseJSON.errors.shop_key;
                let sendo_login_secret_key = result.responseJSON.errors.secret_key,
                    styleMessage = 'style="color: red;padding: 0 15px;margin: 10px 45px 5px;font-size: 10px; height: 40px; width: 396px; outline: none;"';
                $('#message-sendo-login-api-key').empty()
                if (sendo_login_api_key && sendo_login_api_key.length) {
                    $('#message-sendo-login-api-key').append('<br><span ' + styleMessage + ' > ' + sendo_login_api_key[0] + '</span>');
                    return false;
                }

                $('#message-sendo-login-secret-key').empty()
                if (sendo_login_secret_key && sendo_login_secret_key.length) {
                    $('#message-sendo-login-secret-key').append('<br><span ' + styleMessage + ' > ' + sendo_login_secret_key[0] + '</span>');
                    return false;
                }
            }
        })
    })


</script>
