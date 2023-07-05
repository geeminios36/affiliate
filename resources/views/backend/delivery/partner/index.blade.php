@extends('backend.layouts.app')

@section('content')
    <style>
        .page-body-item {
            width: 98.5%;
            float: left;
            padding-top: 15px;
            margin-left: 10px;
        }

        .note-connect-di4l-sell-express-partner {
            height: 34px;
            background-color: #e3f1df;
            margin-bottom: 15px;
            border-top: 3px solid #50b83c;
        }

        .page-body-item .page-body-item-left {
            width: 30%;
            float: left;
        }

        .page-body-item .page-body-item-right {
            width: 70%;
            float: right;
            margin-bottom: 20px;
        }

        .note-connect-di4l-sell-express-partner .content-note {
            margin-left: 10px;
            padding-top: 7px;
        }

        .page-body-item .page-body-item-right .di4l-sell-express-content {
            padding: 5px 20px;
            box-shadow: 0 0 0 1px rgb(63 63 68 / 5%), 0 1px 3px 0 rgb(63 63 68 / 15%);
            border-radius: 3px;
            padding: 15px;
            background-color: #fff;
            margin-bottom: 25px;
        }

        .se-partner-logo img {
            margin-left: 10px;
            width: 70px;
            height: 35px;
        }

        .content-delivery .line-content-delivery {
            display: block;
            width: 100%;
            float: left;
        }

        .content-delivery .line-content-delivery .name-delivery-diactive {
            float: left;
            width: 55%;
            margin-top: 8px;
            font-weight: 500;
        }

        .di4l-sell-btn-default {
            float: right;
            padding: 6px 16px;
            color: #fff !important;
            border: 1px solid #08f !important;
            background: linear-gradient(
                180deg, #08f, #4697fe);
            box-shadow: inset 0 1px 0 0 #1391ff;
        }

        .icon-ghtk {
            width: 20%;
        }

    </style>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Delivery Partner')}}</h5>
        </div>
        <div class="card-body">
            <div class="page-body-item" id="di4l-sell-express">
                <div class="note-connect-di4l-sell-express-partner">
                    <p class="content-note">Kết nối để tự động gửi yêu cầu giao hàng cho các đối tác vận chuyển và nhận
                        cập nhật trạng thái vận đơn ngay trên  Sell Express.</p>
                </div>
                {{--                <div class="page-body-item-left">--}}
                {{--                    <div class="item-tittle" style="padding-right:40px;">--}}
                {{--                        <div class="flex">--}}
                {{--                            <h4>Kết nối qua  Sell Express</h4>--}}
                {{--                        </div>--}}
                {{--                        <div style="margin-top:15px;">--}}
                {{--                            <p>--}}
                {{--                                - Shop không cần có tài khoản riêng với từng ĐTVC, kích hoạt  Sell Express để sử--}}
                {{--                                dụng toàn bộ các đối tác đã kết nối<br>--}}
                {{--                                - Hưởng bảng giá và chính sách ưu đãi từ  Sell Express<br>--}}
                {{--                                -  Sell Express sẽ trực tiếp hỗ trợ đơn hàng, thanh toán, đối soát cho shop<br>--}}
                {{--                            </p>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="page-body-item-right">--}}
                {{--                    <div class="di4l-sell-express-content">--}}
                {{--                        <div class="row">--}}
                {{--                            <div class="col-md-2" style="margin: auto;">--}}
                {{--                                <div class="logo-delivery" style="opacity:0.5">--}}
                {{--                                    <img src="{{ static_asset('assets/img/logo.png') }}" style="width:100%;">--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <div class="col-md-10">--}}
                {{--                                <div class="content-delivery">--}}
                {{--                                    <div class="line-content-delivery">--}}
                {{--                                        <div class="name-delivery-diactive">--}}
                {{--                                            <span style="opacity:0.5">--}}
                {{--                                                <span> Sell Express</span> (Chưa kích hoạt)--}}
                {{--                                            </span>--}}
                {{--                                        </div>--}}
                {{--                                        <a href="#" class="btn di4l-sell-btn-default"--}}
                {{--                                           onclick="showPopupCreate('external_service','di4l-sellexpress')">--}}
                {{--                                            Kích hoạt--}}
                {{--                                        </a>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="line-content-delivery" style="margin-top: 5px;">--}}
                {{--                                        <span>--}}
                {{--                                            Giải pháp giúp shop tối ưu vận hành và chi phí vận chuyển, quản lý vận đơn tập trung, minh bạch, sử dụng dễ dàng, lựa chọn đa dạng.<a--}}
                {{--                                                href=""--}}
                {{--                                                target="_blank"> Hướng dẫn kích hoạt</a>--}}
                {{--                                        </span>--}}
                {{--                                        <br>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="line-content-delivery" style="margin-top: 5px;">--}}
                {{--                                        <div class="se-partner-logo">--}}
                {{--                                            <span>Các đối tác vận chuyển:</span>--}}
                {{--                                        </div>--}}
                {{--                                        <br>--}}
                {{--                                        <div class="se-partner-logo">--}}
                {{--                                            <img src="{{ static_asset('assets/img/delivery/ghn.png') }}">--}}
                {{--                                            <img src="{{ static_asset('assets/img/delivery/ghtk.png') }}">--}}
                {{--                                            <img src="{{ static_asset('assets/img/delivery/viettel-post.jpg') }}">--}}
                {{--                                            <img src="{{ static_asset('assets/img/delivery/vnpt-post.jpg') }}">--}}
                {{--                                        </div>--}}
                {{--                                        <br>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
            <div class="page-body-item" id="delivery-external-service">
                <div class="page-body-item-left">
                    <div class="item-tittle" style="padding-right:40px;">
                        <div>
                            <h4>Kết nối bằng tài khoản riêng của Shop</h4>
                        </div>
                        <div style="margin-top:15px;">
                            <p>
                                - Shop cần sử dụng tài khoản đã đăng ký riêng với từng ĐTVC <br>
                                - Sử dụng chính sách riêng Shop đã thỏa thuận với ĐTVC <br>
                                - Shop tự quản lý đối soát, thanh toán, và vấn đề đơn hàng với ĐTVC<br>

                            </p>
                        </div>
                    </div>
                </div>
                <div class="page-body-item-right" id="delivery_partners">
                    @include('backend.delivery.partner.delivery_partners')
                </div>
            </div>
        </div>
    </div>
    <div id="modal_content_html"></div>
@endsection

@section('modal')
    @include('backend.delivery.partner.modal.ghn_modal')
    @include('backend.delivery.partner.modal.ghtk_modal')
    @include('backend.delivery.partner.modal.bestexpress_modal')
    @include('backend.delivery.partner.modal.dhl_modal')
    @include('backend.delivery.partner.modal.vt_post_modal')
    {{--    @include('backend.delivery.partner.modal.update_ghn_modal')--}}
@endsection

@section('script')
    @include('backend.delivery.partner.index_js')
@endsection
