<!--====================  header area ====================-->
<div
    class="header-area header-area--default bg-white position-relative z-index-1">

    <!-- Header Bottom Wrap Start -->
    <header class="header-area  header_height-120">
        <div class="container-fluid container-fluid--cp-100">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-4 d-none d-md-block">
                    <div class="header-left-side">
                        <div class="header-right-items  d-none d-md-block">
                            <a href="javascript:void(0)"
                                class="mobile-navigation-icon"
                                id="mobile-menu-trigger">
                                <i class="icon-menu"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-6">
                    <div class="logo text-md-center">
                        <a href="index.html"><img
                                src="assets/frontend/images/logo/logo.svg"
                                alt=""></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-6">
                    <div class="header-right-side text-end">
                        <div class="header-right-items d-block d-lg-none">
                            <a href="javascript:void(0)" class="search-icon"
                                id="search-overlay-trigger">
                                <i class="icon-magnifier"></i>
                            </a>
                        </div>
                        <div class="d-none d-lg-block">
                            <div class="header-left-search">
                                <form action="#" class="header-search-box">
                                    <input class="search-field" type="text"
                                        placeholder="Search Anything...">
                                    <button class="search-icon"><i
                                            class="icon-magnifier"></i></button>
                                </form>
                            </div>
                        </div>

                        <div class="header-right-items d-none d-md-block">
                            <a href="{{ route('wishlists.index') }}"
                                class="header-cart">
                                <i class="icon-heart"></i>
                                <span
                                    class="item-counter">{{ Auth::check() ? count(Auth::user()->wishlists) : 0 }}</span>
                            </a>
                        </div>

                        <div class="header-right-items">
                            <a href="#miniCart"
                                class=" header-cart minicart-btn toolbar-btn header-icon">
                                <i class="icon-bag2"></i>
                                <span
                                    class="item-counter">{{ count(get_cart()) }}</span>
                            </a>
                        </div>
                        <div class="header-right-items ">
                            <a href="{{ route('dashboard') }}"
                                id="move-dashboard"
                                class="{{ Auth::check() ? '' : 'd-none' }}">
                                <i class="icon-user"></i>
                            </a>
                            <a id="user_icon"
                                class="{{ !Auth::check() ? '' : 'd-none' }}">
                                <i class="icon-user"></i>
                            </a>
                        </div>
                        <div class="header-right-items  d-block d-md-none">
                            <a href="javascript:void(0)"
                                class="mobile-navigation-icon"
                                id="mobile-menu-trigger-2">
                                <i class="icon-menu"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Bottom Wrap End -->

</div>
<div id="append_modal">

</div>
<!--====================  End of header area  ====================-->
@section('script')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            }
        });

        $('#user_icon').on('click', function() {
            show_home_login_register_modal()
        })




        function show_home_login_register_modal() {
            let url =
                "{{ route('home.show_login_register_modal') }}";
            $.get(url, function(data) {
                $('#append_modal').html(data);
                $('#login_register_modal').modal('show');
            })
        }

        function home_register() {
            let url = "{{ route('home.registration') }}";
            let email = $('#registration_form #email').val();
            let password = $('#registration_form #password').val();
            let username = $('#registration_form #username').val();
            let data = {
                email,
                password,
                username
            }
            $.post(url, data, function(data) {
                if (data.errors) {
                    showErrorMessage(data.errors)
                }
                if (data.success) {
                    toastr.success(
                        data.message)
                    switchToLoginForm()

                }
            })
        }

        function switchToLoginForm() {
            $('#tab-item-login .nav-link').addClass('active');
            $('#tab_login').addClass('active');
            $('#tab-item-register .nav-link').removeClass('active');
            $('#tab_register').removeClass('active');
        }

        function home_login() {
            let url = "{{ route('home.login') }}";
            let email_or_phone = $('#email_or_phone').val();
            let password = $('#password').val();
            let remember = $('#remember').val();
            let data = {
                email_or_phone: email_or_phone,
                password: password,
                remember: remember
            }
            $.post(url, data, function(data) {
                if (data.errors) {
                    showErrorMessage(data.errors)
                }
                if (data.success) {
                    toastr.success(
                        data.message)
                    $('#login_register_modal').modal('hide');
                    $('#user_icon').addClass('d-none');
                    $('#move-dashboard').removeClass('d-none');
                }
            })
        }

        function showErrorMessage(errors = []) {
            $.each(errors, function(key, value) {
                toastr.error(
                    value)
            });
        }
    </script>
@endsection
