@extends('backend.layouts.app')

@section('content')
    <style>
        .right {
            float: right !important;
        }

        .se-partner-logo img {
            margin-left: 10px;
            width: 70px;
            height: 35px;
        }

        .page-info {
            background-color: #fff;
            box-shadow: 0 0 0 1px rgb(63 63 68 / 5%), 0 1px 3px 0 rgb(63 63 68 / 15%);
            border-radius: 3px;
            padding: 20px;
            position: relative;
            margin-bottom: 20px;
        }

        .page-info .page-info-title {
            font-weight: 500;
            font-size: 16px;
            padding-bottom: 13px;
        }

        .page-info .page-info-body {
            display: flex;
            width: 100%;
            flex-wrap: wrap;
        }

        .page-info .page-info-body .page-info-body--sub {
            width: calc(100% + 40px);
            margin-left: -20px;
            margin-right: -20px;
            border-top: 1px solid #c4cdd5;
            padding: 18px 20px;
            float: left;
        }

        .page-info .page-info-body .page-info-body--sub {
            width: calc(100% + 40px);
            margin-left: -20px;
            margin-right: -20px;
            border-top: 1px solid #c4cdd5;
            padding: 18px 20px;
            float: left;
        }

        .page-info .page-info-body .page-info-body--sub .content {
            font-size: 13px;
            line-height: 1.5;
            display: flex;
            flex-wrap: wrap;
        }

        .page-info .page-info-body .page-info-body--sub .content {
            font-size: 13px;
            line-height: 1.5;
            display: flex;
            flex-wrap: wrap;
        }

    </style>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Delivery Partner')}}</h5>
            <div class="aiz-titlebar text-left mt-3 mb-4">
                <div class="row align-items-center">
                    <div class="col text-right">
                        <a href="{{route('all_orders.index')}}" target="_blank" class="btn btn-circle btn-info">
                            <span>Xem danh sách giao hàng</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="detail-shipper-container  mt-0">
                <div class="page-info page-info-order-detail w100">
                    <div class="page-info-title">
                        Thông tin kết nối <small style="background: #88C6ED80"> (Đang kích hoạt)</small>
                    </div>
                    <div class="page-info-body">
                        <div class="page-info-body--sub flex pb-0 row">
                            <div class="col-4 p-0">
                                <div class="line-info flex">
                                    <label style="width: 125px;    float: left;">Tên đối tác<span
                                            class="right" style="float:right !important;">:</span></label>
                                    <div class="content" title="{{$deliveryTenancy->delivery_partners->fullname}}"
                                         style="    width: calc(100% - 125px);   float: left;   padding-left: 5px;">{{$deliveryTenancy->delivery_partners->fullname}}</div>
                                </div>

                            </div>
                            <div class="col-4 p-0">
                                <div class="line-info flex">
                                    <label style="width: 125px;    float: left;">Mã đối tác<span class="right"
                                                                                                 style="float:right !important;">:</span></label>
                                    <div class="content"
                                         title="{{strtoupper($deliveryTenancy->delivery_partners->code)}}"
                                         style="    width: calc(100% - 125px);   float: left;   padding-left: 5px;">
                                        {{strtoupper($deliveryTenancy->delivery_partners->code)}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0">
                                <div class="line-info flex">
                                    <label style="width: 125px;    float: left;">Loại<span class="right"
                                                                                           style="float:right !important;">:</span></label>
                                    <div style="    width: calc(100% - 125px);   float: left;   padding-left: 5px;"
                                         class="content" title="external_service">Công ty
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="border-top:1px solid #C4CCDE;">
                        </div>
                        <div class="page-info-body--sub flex pb-0 row" style="border-top:0;">
                            <div class="col-4 p-0">
                                <div class="line-info flex">
                                    <label style="width:135px; ">Đang xử lý<span class="right">:
                                            <a class='#' target="_blank"
                                               href="">{{$isProcessing}}</a>
                                    </span>
                                    </label>
                                </div>
{{--                                <div class="line-info flex">--}}
{{--                                    <label style="width:135px; float: left;">Chưa đối soát--}}
{{--                                        <span class="right">: --}}
{{--                                            <a target="_blank" href="">0</a></span></label>--}}
{{--                                </div>--}}

                            </div>
                            <div class="col-4 p-0">
                                <div class="line-info flex">
                                    <label style="width:135px; ;">Tổng đơn hàng<span class="right">: <a target="_blank"
                                                                                                        href="">{{count($orders)}}</a></span></label>

                                </div>

{{--                                <div class="line-info flex">--}}
{{--                                    <label style="width:135px; float: left;">Đang đối soát<span--}}
{{--                                            class="right">:   <a target="_blank"--}}
{{--                                                                 href="">0</a></span></label>--}}
{{--                                </div>--}}
                            </div>
{{--                            <div class="col-4 p-0">--}}
{{--                                <div class="line-info flex">--}}
{{--                                    <label style="width:135px; ;">Công nợ<span class="right">: <a--}}
{{--                                                href="#">{{number_format($orders->sum('cod_amount'))}}</a></span></label>--}}

{{--                                </div>--}}
{{--                                <div class="line-info flex">--}}
{{--                                    <label style="width:135px; float: left  ;">Đã đối soát - Chưa thanh toán<span--}}
{{--                                            class="right">:   <a target="_blank"--}}
{{--                                                                 href="">0</a></span></label>--}}

{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-info w100 " id="scroll-debt">
                    <div class="page-info-title">
                        <span class="left">Thông tin</span>
                        <div class="flex right">
                            <div class="debt-shipper">
{{--                                <span>Công nợ hiện tại: </span><b>0</b>--}}
                            </div>
                        </div>
                    </div>
                    <div class="page-info-body">
                        <div class="page-info-body--sub block pb-0 ">
                            <div class="w100" id="table-debt">
{{--                                <a href="" style="float: right">--}}
{{--                                    <b> <i class="la la-print"></i></b> <span> Xuất file công nợ</span>--}}
{{--                                </a>--}}
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Mã phiếu</th>
                                        <th>Người tạo</th>
                                        <th>Ngày ghi nhận</th>
                                        <th>Ngày tạo</th>
                                        <th>Ghi chú</th>
                                        {{--                                        <th class="align-right">Giá trị thay đổi</th>--}}
{{--                                        <th class="align-right">Công nợ</th>--}}
                                        <th class="align-right">Trạng thái</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($orders) > 0)
                                        @foreach($orders as $orderInfo)
                                            <tr>
                                                <td class="text-center">{{$orderInfo['order_code']}}</td>
                                                <td class="text-center">{{@$orderInfo->seller->name}}</td>
                                                <td class="text-center">{{date('H:i:s d/m/Y', strtotime($orderInfo['created_at']))}}</td>
                                                <td class="text-center">{{date('H:i:s d/m/Y', strtotime($orderInfo['order_date']))}}</td>
                                                <td class="text-center">{{$orderInfo['note']}}</td>
                                                {{--                                                <td class="text-center"></td>--}}
{{--                                                <td class="text-center">{{number_format($orderInfo['cod_amount'])}}</td>--}}
                                                <td class="text-center">{{$orderInfo['status']}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100%" class="text-center">
                                                Không tìm thấy phiếu công nợ phù hợp với điều kiện tìm kiếm
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div id="total-records" style="display:none" bind="0">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal_content_html"></div>
@endsection

@section('modal')
@endsection

@section('script')
@endsection
