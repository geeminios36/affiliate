

<!--====================  header area ====================-->
<div class="header-area header-area--default">

    <!-- Header Bottom Wrap Start -->
    <header class="header-area  header_height-90 header-sticky">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-4 d-none d-md-block">
                    <div class="header-left-search">
                        <form action="#" class="header-search-box">
                            <input class="search-field" type="text" placeholder="Search Anything...">
                            <button class="search-icon"><i class="icon-magnifier"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-6">
                    <div class="logo text-md-center">
                        <a href="index.html"><img src="assets/images/logo/logo.svg" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-6">
                    <div class="header-right-side text-end">
                        <div class="header-right-items  d-none d-md-block">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="icon-user"></i>
                            </a>
                        </div>
                        <div class="header-right-items d-none d-md-block">
                            <a href="{{ route('wishlists.index') }}" class="header-cart">
                                <i class="icon-heart"></i>
                                <span class="item-counter">{{ Auth::check() ? count(Auth::user()->wishlists) : 0 }}</span>
                            </a>
                        </div>

                        <div class="header-right-items">
                            <a href="#miniCart" class=" header-cart minicart-btn toolbar-btn header-icon">
                                <i class="icon-bag2"></i>
                                <span class="item-counter">{{ count(get_cart()) }}</span>
                            </a>
                        </div>
                        <div class="header-right-items d-block d-md-none">
                            <a href="javascript:void(0)" class="search-icon" id="search-overlay-trigger">
                                <i class="icon-magnifier"></i>
                            </a>
                        </div>
                        <div class="header-right-items">
                            <a href="javascript:void(0)" class="mobile-navigation-icon" id="mobile-menu-trigger">
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
<!--====================  End of header area  ====================-->

