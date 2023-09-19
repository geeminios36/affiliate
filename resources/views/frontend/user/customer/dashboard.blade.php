@extends('frontend.layouts.app')

@section('content')
    <style>
        .inline-YTPlayer {
            display: none;
        }

        .card {
            overflow: hidden;
            position: relative;
            min-height: 150px;
        }

        .card svg {
            position: absolute;
            bottom: 0;
            left: 0;

            opacity: 0.4;
        }

        .bg-gradient-info {
            background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
        }

        .bg-gradient-danger {
            background: linear-gradient(87deg, #f5365c 0, #f56036 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(87deg, #fb6340 0, #fbb140 100%) !important;
        }
    </style>
    <div class="site-wrapper-reveal border-bottom">

        <div class="my-account-page-warpper section-space--ptb_120">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <!-- My Account Page Start -->
                        <div class="myaccount-page-wrapper">
                            <div class="row">

                                <!-- My Account Tab Menu Start -->
                                <div class="col-lg-3 col-md-4">
                                    <div class="myaccount-tab-menu nav"
                                        role="tablist">
                                        <a href="#dashboad" class="active"
                                            data-bs-toggle="tab"><i
                                                class="fa fa-dashboard"></i>
                                            Dashboard</a>
                                        <a href="#orders" data-bs-toggle="tab"><i
                                                class="fa fa-cart-arrow-down"></i>
                                            Orders</a>
                                        <a href="#payment-history"
                                            data-bs-toggle="tab"><i
                                                class="fa fa-cart-arrow-down"></i>
                                            Payment history</a>
                                        <a href="#sold-orders"
                                            data-bs-toggle="tab"><i
                                                class="fa fa-cart-arrow-down"></i>
                                            Sold Orders</a>
                                        <a href="#account-info"
                                            data-bs-toggle="tab"><i
                                                class="fa fa-user"></i> Account
                                            Details</a>

                                        <a href="{{ route('dashboard.logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                            Logout
                                        </a>
                                        <form id="frm-logout"
                                            action="{{ route('dashboard.logout') }}"
                                            method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>

                                    </div>
                                </div>
                                <!-- My Account Tab Menu End -->

                                <!-- My Account Tab Content Start -->
                                <div class="col-lg-9 col-md-8">
                                    <div class="tab-content" id="myaccountContent">

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade show active"
                                            id="dashboad" role="tabpanel">
                                            <div class="myaccount-content">
                                                <div class="mb-5">
                                                    <p class="h3 px-2 mb-3">
                                                        Bảng thống kê</p>
                                                    <div class="container">
                                                        <div class="row mb-5">
                                                            <div class="col-sm">
                                                                <div
                                                                    class="card border-0 bg-gradient-info text-white">
                                                                    <div
                                                                        class="card-body">

                                                                        <h5
                                                                            class="card-title">
                                                                            0 Sản
                                                                            phẩm
                                                                        </h5>
                                                                        <p
                                                                            class="card-text text-white-50">
                                                                            Trong
                                                                            giỏ
                                                                            hàng của
                                                                            bạn
                                                                        </p>
                                                                    </div>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 1440 320">
                                                                        <path
                                                                            fill="#ecf1fd"
                                                                            fill-opacity="1"
                                                                            d="M0,128L48,112C96,96,192,64,288,90.7C384,117,480,203,576,208C672,213,768,139,864,112C960,85,1056,107,1152,106.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm">
                                                                <div
                                                                    class="card border-0 bg-gradient-danger text-white">
                                                                    <div
                                                                        class="card-body">
                                                                        <h5
                                                                            class="card-title">
                                                                            0 Sản
                                                                            phẩm
                                                                        </h5>
                                                                        <p
                                                                            class="card-text text-white-50">
                                                                            Trong
                                                                            danh
                                                                            sách yêu
                                                                            thích
                                                                        </p>
                                                                    </div>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 1440 320">
                                                                        <path
                                                                            fill="#ecf1fd"
                                                                            fill-opacity="1"
                                                                            d="M0,128L48,112C96,96,192,64,288,90.7C384,117,480,203,576,208C672,213,768,139,864,112C960,85,1056,107,1152,106.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm">
                                                                <div
                                                                    class="card border-0 bg-gradient-warning text-white">
                                                                    <div
                                                                        class="card-body">
                                                                        <h5
                                                                            class="card-title">
                                                                            0 sản
                                                                            phẩm
                                                                        </h5>
                                                                        <p
                                                                            class="card-text text-white-50">
                                                                            Bạn đã
                                                                            đặt
                                                                            hàng
                                                                        </p>
                                                                    </div>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 1440 320">
                                                                        <path
                                                                            fill="#ecf1fd"
                                                                            fill-opacity="1"
                                                                            d="M0,128L48,112C96,96,192,64,288,90.7C384,117,480,203,576,208C672,213,768,139,864,112C960,85,1056,107,1152,106.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-5 ">
                                                            <div class="col">
                                                                <div
                                                                    class="card rounded-1 border-0 shadow-sm">
                                                                    <div
                                                                        class="card-body p-0">
                                                                        <h6
                                                                            class="card-title border-bottom px-4 py-2">
                                                                            Địa chỉ
                                                                            giao
                                                                            hàng mặc
                                                                            định
                                                                        </h6>
                                                                        <div>
                                                                            <div class="text-center p-5 "
                                                                                style="height: 300px">
                                                                                <p
                                                                                    class="text-red h5 font-weight-bold ">
                                                                                    Chưa
                                                                                    có
                                                                                    thông
                                                                                    tin
                                                                                </p>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div
                                                                    class="card rounded-1  border-0 shadow-sm">
                                                                    <div
                                                                        class="card-body p-0">
                                                                        <h6
                                                                            class="card-title border-bottom px-4 py-2">
                                                                            Gói đang
                                                                            sử
                                                                            dụng
                                                                        </h6>
                                                                        <div>
                                                                            <div class="text-center p-5 "
                                                                                style="height: 300px">
                                                                                <p
                                                                                    class="text-red h5 font-weight-bold mb-5 ">
                                                                                    Không
                                                                                    tìm
                                                                                    thấy
                                                                                    gói
                                                                                </p>
                                                                                <a href="#"
                                                                                    class="btn text-white  btn-info rounded-2">
                                                                                    Nâng
                                                                                    cấp
                                                                                    gói
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="mb-5">
                                                    <p class="h3 px-2 mb-3">Doanh
                                                        thu
                                                    </p>
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div
                                                                    class="card border-0 bg-gradient-info text-white">
                                                                    <div
                                                                        class="card-body  ">
                                                                        <h5
                                                                            class="text-white card-title font-weight-bold">
                                                                            0 Sản
                                                                            phẩm
                                                                        </h5>
                                                                        <p
                                                                            class="card-text text-white-50">
                                                                            Tổng số
                                                                            sản phẩm
                                                                            đã bán
                                                                        </p>
                                                                    </div>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 1440 320">
                                                                        <path
                                                                            fill="#ecf1fd"
                                                                            fill-opacity="1"
                                                                            d="M0,128L48,112C96,96,192,64,288,90.7C384,117,480,203,576,208C672,213,768,139,864,112C960,85,1056,107,1152,106.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div
                                                                    class="card border-0 bg-gradient-danger text-white">
                                                                    <div
                                                                        class="card-body ">
                                                                        <h5
                                                                            class="text-white  card-title  font-weight-bold">
                                                                            0 Khách
                                                                            hàng
                                                                        </h5>
                                                                        <p
                                                                            class="card-text text-white-50">
                                                                            Tổng
                                                                            khách
                                                                            hàng đã
                                                                            mua
                                                                        </p>
                                                                    </div>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 1440 320">
                                                                        <path
                                                                            fill="#ecf1fd"
                                                                            fill-opacity="1"
                                                                            d="M0,128L48,112C96,96,192,64,288,90.7C384,117,480,203,576,208C672,213,768,139,864,112C960,85,1056,107,1152,106.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div
                                                                    class="card border-0 bg-gradient-warning text-white">
                                                                    <div
                                                                        class="card-body  ">
                                                                        <h5
                                                                            class="text-white 
                                                                            card-title  font-weight-bold">
                                                                            0 đ
                                                                        </h5>
                                                                        <p
                                                                            class="card-text text-white-50">
                                                                            Tổng
                                                                            doanh
                                                                            thu
                                                                        </p>
                                                                    </div>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 1440 320">
                                                                        <path
                                                                            fill="#ecf1fd"
                                                                            fill-opacity="1"
                                                                            d="M0,128L48,112C96,96,192,64,288,90.7C384,117,480,203,576,208C672,213,768,139,864,112C960,85,1056,107,1152,106.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="h3 px-2 mb-3">Ví của
                                                        tôi
                                                    </p>
                                                    <div class="container">
                                                        <div class="row">

                                                            <div class="col">
                                                                @php
                                                                    $wallet = \App\Wallet::where('user_id', Auth::user()->id)->first();
                                                                @endphp
                                                                <div
                                                                    class="card border-0 bg-gradient-success text-white">
                                                                    <div
                                                                        class="card-body d-flex flex-column justify-content-around align-items-center">
                                                                        <h4
                                                                            class="text-white font-weight-bold">
                                                                            {{ $wallet?->amount ? single_price($wallet?->amount) : 0 + 'đ' }}
                                                                        </h4>
                                                                        <p
                                                                            class="card-text text-white-50">
                                                                            Số dư
                                                                            Wallet
                                                                        </p>
                                                                    </div>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 1440 320">
                                                                        <path
                                                                            fill="#ecf1fd"
                                                                            fill-opacity="1"
                                                                            d="M0,128L48,112C96,96,192,64,288,90.7C384,117,480,203,576,208C672,213,768,139,864,112C960,85,1056,107,1152,106.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade" id="orders"
                                            role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3 class="title">Orders</h3>
                                                <div
                                                    class="myaccount-table table-responsive text-center">
                                                    <table
                                                        class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Order</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Aug 22, 2018
                                                                </td>
                                                                <td>Pending</td>
                                                                <td>$3000</td>
                                                                <td><a href="cart.html"
                                                                        class="btn btn btn-dark btn-hover-primary btn-sm rounded-2">View</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>July 22, 2018
                                                                </td>
                                                                <td>Approved</td>
                                                                <td>$200</td>
                                                                <td><a href="cart.html"
                                                                        class="btn btn btn-dark btn-hover-primary btn-sm rounded-2">View</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>June 12, 2019
                                                                </td>
                                                                <td>On Hold</td>
                                                                <td>$990</td>
                                                                <td><a href="cart.html"
                                                                        class="btn btn btn-dark btn-hover-primary btn-sm rounded-2">View</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade"
                                            id="payment-history" role="tabpanel">
                                            <div class="myaccount-content">
                                                <div
                                                    class="d-flex justify-content-between">
                                                    <h3 class="title">Payment
                                                        histories</h3>
                                                    <button
                                                        onClick="show_payment_request_modal()"
                                                        class="btn btn-primary btn-sm 
                                                  rounded-2"
                                                        type="button">Payment
                                                        request</button>
                                                </div>
                                                <div id="payment_request_table"
                                                    class="myaccount-table  table-responsive text-center">

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->

                                        <div class="tab-pane fade"
                                            id="sold-orders" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3 class="title">Sold Orders</h3>
                                                <div
                                                    class="myaccount-table table-responsive text-center">
                                                    <table
                                                        class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>STT</th>
                                                                <th>Order Number
                                                                </th>
                                                                <th>Customer</th>
                                                                <th>Amount</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $orders = \App\Order::where('seller_id', Auth::user()->id)->get();
                                                            @endphp
                                                            @foreach ($orders as $key => $order)
                                                                <tr>
                                                                    <td>{{ $key + 1 }}
                                                                    </td>
                                                                    <td>{{ $order->code }}
                                                                    </td>
                                                                    @if ($order->user_id)
                                                                        <td>{{ $order->user->name }}
                                                                        </td>
                                                                    @else
                                                                        <td>
                                                                            <p
                                                                                class="font-weight-bold
                                                                                m-0
                                                                                ">
                                                                                *Guest

                                                                            </p>
                                                                            @php
                                                                                $info = json_decode($order->shipping_address);
                                                                            @endphp
                                                                            <p
                                                                                class="my-1">
                                                                                {{ $info->name }}
                                                                            </p>
                                                                            <p>{{ $info->address }}
                                                                            </p>
                                                                        </td>
                                                                    @endif
                                                                    <td>{{ single_price($order->grand_total) }}
                                                                    </td>
                                                                    <td>{{ $order->delivery_status }}
                                                                    </td>
                                                                    <td><button
                                                                            onClick="show_sold_order_details({{ $order->id }})"
                                                                            class="btn btn-dark btn-hover-primary text-white btn-sm 
                                                                            open_sold_order rounded-2">View</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Single Tab Content Start -->
                                        {{-- <div class="tab-pane fade" id="download"
                                            role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3 class="title">Downloads</h3>
                                                <div
                                                    class="myaccount-table table-responsive text-center">
                                                    <table
                                                        class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Date</th>
                                                                <th>Expire</th>
                                                                <th>Download</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Haven - Free
                                                                    Real Estate PSD
                                                                    Template</td>
                                                                <td>Aug 22, 2018
                                                                </td>
                                                                <td>Yes</td>
                                                                <td><a href="#"
                                                                        class="btn btn btn-dark btn-hover-primary rounded-2"><i
                                                                            class="fa fa-cloud-download me-1"></i>
                                                                        Download
                                                                        File</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>HasTech -
                                                                    Profolio
                                                                    Business
                                                                    Template</td>
                                                                <td>Sep 12, 2018
                                                                </td>
                                                                <td>Never</td>
                                                                <td><a href="#"
                                                                        class="btn btn btn-dark btn-hover-primary rounded-2"><i
                                                                            class="fa fa-cloud-download me-1"></i>
                                                                        Download
                                                                        File</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        {{-- <div class="tab-pane fade"
                                            id="payment-method" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3 class="title">Payment Method
                                                </h3>
                                                <p class="saved-message">You Can't
                                                    Saved Your Payment Method yet.
                                                </p>
                                            </div>
                                        </div> --}}
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        {{-- <div class="tab-pane fade" id="address-edit"
                                            role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3 class="title">Billing Address
                                                </h3>
                                                <address>
                                                    <p><strong>Alex Aya</strong></p>
                                                    <p>1234 Market ##, Suite 900
                                                        <br>
                                                        Lorem Ipsum, ## 12345
                                                    </p>
                                                    <p>Mobile: (123) 123-456789</p>
                                                </address>
                                                <a href="#"
                                                    class="btn btn btn-dark btn-hover-primary rounded-2"><i
                                                        class="fa fa-edit me-2"></i>Edit
                                                    Address</a>
                                            </div>
                                        </div> --}}
                                        <!-- Single Tab Content End -->

                                        <!-- Single Tab Content Start -->
                                        <div class="tab-pane fade"
                                            id="account-info" role="tabpanel">
                                            <div class="myaccount-content">
                                                <h3 class="title">Account Details
                                                </h3>
                                                <div class="account-details-form">
                                                    <form action="#">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div
                                                                    class="single-input-item mb-3">
                                                                    <label
                                                                        for="first-name"
                                                                        class="required mb-1">First
                                                                        Name</label>
                                                                    <input
                                                                        type="text"
                                                                        id="first-name"
                                                                        placeholder="First Name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div
                                                                    class="single-input-item mb-3">
                                                                    <label
                                                                        for="last-name"
                                                                        class="required mb-1">Last
                                                                        Name</label>
                                                                    <input
                                                                        type="text"
                                                                        id="last-name"
                                                                        placeholder="Last Name" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="single-input-item mb-3">
                                                            <label
                                                                for="display-name"
                                                                class="required mb-1">Display
                                                                Name</label>
                                                            <input type="text"
                                                                id="display-name"
                                                                placeholder="Display Name" />
                                                        </div>
                                                        <div
                                                            class="single-input-item mb-3">
                                                            <label for="email"
                                                                class="required mb-1">Email
                                                                Addres</label>
                                                            <input type="email"
                                                                id="email"
                                                                placeholder="Email Address" />
                                                        </div>
                                                        <div
                                                            class="single-input-item mb-3">
                                                            <label for="phone"
                                                                class="required mb-1">Phone
                                                                Number</label>
                                                            <input type="tel"
                                                                id="phone"
                                                                placeholder="Phone Number" />
                                                        </div>
                                                        <fieldset>
                                                            <legend>Password Change
                                                            </legend>
                                                            <div
                                                                class="single-input-item mb-3">
                                                                <label
                                                                    for="current-pwd"
                                                                    class="required mb-1">Current
                                                                    Password</label>
                                                                <input
                                                                    type="password"
                                                                    id="current-pwd"
                                                                    placeholder="Current Password" />
                                                            </div>
                                                            <div class="row">
                                                                <div
                                                                    class="col-lg-6">
                                                                    <div
                                                                        class="single-input-item mb-3">
                                                                        <label
                                                                            for="new-pwd"
                                                                            class="required mb-1">New
                                                                            Password</label>
                                                                        <input
                                                                            type="password"
                                                                            id="new-pwd"
                                                                            placeholder="New Password" />
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-lg-6">
                                                                    <div
                                                                        class="single-input-item mb-3">
                                                                        <label
                                                                            for="confirm-pwd"
                                                                            class="required mb-1">Confirm
                                                                            Password</label>
                                                                        <input
                                                                            type="password"
                                                                            id="confirm-pwd"
                                                                            placeholder="Confirm Password" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset>
                                                            <legend>Bank Information
                                                            </legend>
                                                            <div
                                                                class="single-input-item mb-3">
                                                                <label
                                                                    for="momo-account"
                                                                    class="required mb-1">Momo
                                                                    Account
                                                                    Number</label>
                                                                <input
                                                                    type="text"
                                                                    id="momo-account"
                                                                    placeholder="Enter your MOMO account number" />
                                                            </div>
                                                        </fieldset>
                                                        <div
                                                            class="single-input-item single-item-button">
                                                            <button
                                                                class="btn btn btn-dark btn-hover-primary rounded-2">
                                                                Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> <!-- Single Tab Content End -->

                                    </div>
                                </div>
                                <!-- My Account Tab Content End -->

                            </div>
                        </div>
                        <!-- My Account Page End -->
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div id="append_modal">

    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            }
        });
        $(document).ready(function() {
            showPaymentRequestTable();
        });

        function showPaymentRequestTable() {
            let url = "{{ route('show-payment-request-table') }}";
            $.get(url, function(data) {
                $('#payment_request_table').html(data);
            })
        }

        function show_sold_order_details(id) {
            let sold_order_detail_url = "{{ route('sold_order_detail', ':id') }}";
            sold_order_detail_url = sold_order_detail_url.replace(':id', id);
            $.get(sold_order_detail_url, function(data) {
                console.log(data)
                $('#append_modal').html(data);
                $('#sold-order-detail-modal').modal('show');
            })

        }

        function show_payment_request_modal() {
            let sold_order_detail_url =
                "{{ route('show-payment-request-modal') }}";
            $.get(sold_order_detail_url, function(data) {
                $('#append_modal').html(data);
                $('#payment-request-modal').modal('show');
            })
        }

        function createNewPaymentRequeset(e) {

            const url = "{{ route('create-payment-request') }}";
            const data = {
                message: $("#message").val(),
                amount: $("#amount").val(),
            }
            $.ajax({
                url: url,
                method: 'POST',
                data,
                success: function(response) {
                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            toastr.error(
                                value)
                        });
                    }
                    if (response.success) {
                        $('#payment-request-modal').modal('hide');
                        toastr.success(
                            response.message)
                        showPaymentRequestTable()
                    }
                },
                error: function(response) {
                    toastr.error(
                        response.error);
                }

            });
        }
    </script>
@endsection
