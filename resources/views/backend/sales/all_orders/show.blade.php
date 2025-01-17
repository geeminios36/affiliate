@extends('backend.layouts.app')

@section('content')
    <?php
    $shipping_address = json_decode($order->shipping_address);
    ?>
    <div class="card">
        <div class="card-header">
            <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
        </div>
        <div class="card-body">
            <div class="row gutters-5">
                <div class="col text-center text-md-left">
                </div>
                @php
                    $delivery_status = $order->delivery_status;
                    $payment_status = $order->payment_status;
                @endphp

                <!--Assign Delivery Boy-->
                @if (
                    \App\Addon::where('unique_identifier', 'delivery_boy')->first() != null &&
                        \App\Addon::where('unique_identifier', 'delivery_boy')->first()->activated)
                    <div class="col-md-3 ml-auto">
                        <label
                            for=assign_deliver_boy"">{{ translate('Assign Deliver Boy') }}</label>
                        @if ($delivery_status == 'pending' || $delivery_status == 'picked_up')
                            <select class="form-control aiz-selectpicker"
                                data-live-search="true"
                                data-minimum-results-for-search="Infinity"
                                id="assign_deliver_boy">
                                <option value="">
                                    {{ translate('Select Delivery Boy') }}</option>
                                @foreach ($delivery_boys as $delivery_boy)
                                    <option value="{{ $delivery_boy->id }}"
                                        @if ($order->assign_delivery_boy == $delivery_boy->id) selected @endif>
                                        {{ $delivery_boy->name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" class="form-control"
                                value="{{ optional($order->delivery_boy)->name }}">
                        @endif
                    </div>
                @endif

                <div class="col-md-3 ml-auto">
                    <label
                        for=update_payment_status"">{{ translate('Payment Status') }}</label>
                    <select class="form-control aiz-selectpicker"
                        data-minimum-results-for-search="Infinity"
                        id="update_payment_status">
                        <option value="paid"
                            @if ($payment_status == 'paid') selected @endif>
                            {{ translate('Paid') }}</option>
                        <option value="unpaid"
                            @if ($payment_status == 'unpaid') selected @endif>
                            {{ translate('Unpaid') }}</option>
                    </select>
                </div>
                <div class="col-md-3 ml-auto">
                    <label
                        for=update_delivery_status"">{{ translate('Delivery Status') }}</label>
                    {{--                @if ($delivery_status != 'delivered' && $delivery_status != 'cancelled') --}}
                    <select class="form-control aiz-selectpicker"
                        data-minimum-results-for-search="Infinity"
                        id="update_delivery_status">
                        <option
                            {{ empty($shipping_address) ? '' : (isset($shipping_address->is_hand_over) ? 'disabled' : '') }}
                            value="pending"
                            @if ($delivery_status == 'pending') selected @endif>
                            {{ translate('Pending') }}</option>
                        <option
                            {{ empty($shipping_address) ? '' : (isset($shipping_address->is_hand_over) ? 'disabled' : '') }}
                            value="confirmed"
                            @if ($delivery_status == 'confirmed') selected @endif>
                            {{ translate('Confirmed') }}
                            {{ empty($deliveryPartner) ? '' : '- Tạo đơn ' . $deliveryPartner->fullname }}
                        </option>
                        <option {{ empty($deliveryPartner) ? '' : 'disabled' }}
                            value="picked_up"
                            @if ($delivery_status == 'picked_up') selected @endif>
                            {{ translate('Picked Up') }}
                            {{ empty($deliveryPartner) ? '' : '(Bên đối tác cập nhật)' }}
                        </option>
                        <option {{ empty($deliveryPartner) ? '' : 'disabled' }}
                            value="on_the_way"
                            @if ($delivery_status == 'on_the_way') selected @endif>
                            {{ translate('On The Way') }}
                            {{ empty($deliveryPartner) ? '' : '(Bên đối tác cập nhật)' }}
                        </option>
                        <!--<option value="on_delivery" @if ($delivery_status == 'on_delivery') selected @endif>{{ translate('On delivery') }}</option>-->
                        <option {{ empty($deliveryPartner) ? '' : 'disabled' }}
                            value="delivered"
                            @if ($delivery_status == 'delivered') selected @endif>
                            {{ translate('Delivered') }}
                            {{ empty($deliveryPartner) ? '' : '(Bên đối tác cập nhật)' }}
                        </option>
                        <option {{ empty($deliveryPartner) ? '' : 'disabled' }}
                            {{ isset($shipping_address->is_hand_over) ? 'disabled' : '' }}
                            value="cancelled"
                            @if ($delivery_status == 'cancelled') selected @endif>
                            {{ translate('Cancel') }}
                        </option>
                    </select>
                    {{--                @else --}}
                    {{--                    <input type="text" class="form-control" value="{{ $delivery_status }}"> --}}
                    {{--                @endif --}}
                </div>
            </div>
            <div class="row gutters-5 my-3">
                <div class="col text-center text-md-left">
                    <address>
                        @if (empty($deliveryPartner))
                            <strong
                                class="text-main">{{ $shipping_address->name }}</strong><br>
                            {{ $shipping_address->email }}<br>
                            {{ $shipping_address->phone }}<br>
                            {{ $shipping_address->address }}
                            , {{ $shipping_address->city }}
                            , {{ $shipping_address->postal_code }}<br>
                            {{ $shipping_address->country }}
                        @else
                            <strong
                                class="text-main">{{ $shipping_address->to_name }}</strong><br>
                            {{ $shipping_address->to_phone }}<br>
                            {{ $shipping_address->to_address }},
                            {{ empty($shipping_address->province) ? '' : $shipping_address->province . ',' }}
                            {{ @$shipping_address->district }},
                            {{ @$shipping_address->ward }}
                        @endif
                    </address>
                    @if (
                        $order->manual_payment &&
                            is_array(json_decode($order->manual_payment_data, true)))
                        <br>
                        <strong
                            class="text-main">{{ translate('Payment Information') }}</strong><br>
                        {{ translate('Name') }}:
                        {{ json_decode($order->manual_payment_data)->name }},
                        {{ translate('Amount') }}:
                        {{ single_price(json_decode($order->manual_payment_data)->amount) }},
                        {{ translate('TRX ID') }}:
                        {{ json_decode($order->manual_payment_data)->trx_id }}
                        <br>
                        <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}"
                            target="_blank"><img
                                src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}"
                                alt="" height="100"></a>
                    @endif
                </div>
                <div class="col-md-4 ml-auto">
                    <table>
                        <tbody>
                            <tr>
                                <td class="text-main text-bold">
                                    {{ translate('Order #') }}</td>
                                <td class="text-right text-info text-bold">
                                    {{ $order->code }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">
                                    {{ translate('Order Status') }}</td>
                                @php
                                    $status = $order->orderDetails->first()->delivery_status ?? '';
                                @endphp
                                <td class="text-right">
                                    @if ($status == 'delivered')
                                        <span
                                            class="badge badge-inline badge-success">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                    @else
                                        <span
                                            class="badge badge-inline badge-info">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">
                                    {{ translate('Order Date') }} </td>
                                <td class="text-right">
                                    {{ date('d-m-Y h:i A', $order->date) }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">
                                    {{ translate('Total amount') }}
                                </td>
                                <td class="text-right">
                                    {{ single_price($order->grand_total) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">
                                    {{ translate('Payment method') }}</td>
                                <td class="text-right">
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="new-section-sm bord-no">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table class="table table-bordered aiz-table invoice-summary">
                        <thead>
                            <tr class="bg-trans-dark">
                                <th data-breakpoints="lg" class="min-col">#</th>
                                <th width="10%">{{ translate('Photo') }}</th>
                                <th class="text-uppercase">
                                    {{ translate('Description') }}</th>
                                <th data-breakpoints="lg" class="text-uppercase">
                                    {{ translate('Delivery Type') }}</th>
                                <th data-breakpoints="lg"
                                    class="min-col text-center text-uppercase">
                                    {{ translate('Qty') }}</th>
                                <th data-breakpoints="lg"
                                    class="min-col text-center text-uppercase">
                                    {{ translate('Price') }}</th>
                                <th data-breakpoints="lg"
                                    class="min-col text-right text-uppercase">
                                    {{ translate('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $key => $orderDetail)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if ($orderDetail->product != null)
                                            <a href="{{ route('product', $orderDetail->product->slug) }}"
                                                target="_blank"><img height="50"
                                                    src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}"></a>
                                        @else
                                            <strong>{{ translate('N/A') }}</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($orderDetail->product != null)
                                            <strong><a
                                                    href="{{ route('product', $orderDetail->product->slug) }}"
                                                    target="_blank"
                                                    class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                                            <small>{{ $orderDetail->variation }}</small>
                                        @else
                                            <strong>{{ translate('Product Unavailable') }}</strong>
                                        @endif
                                    </td>
                                    <td style="width: 25%">
                                        @if (!empty($deliveryPartner))
                                            <img src="{{ static_asset($deliveryPartner->logo) }}"
                                                width="15%">
                                            {{ $deliveryPartner->fullname }}
                                            <small>{{ isset($shipping_address->is_hand_over) ? '(' . @$status_delivery . ')' : '' }}</small>
                                        @endif
                                        @if (
                                            $orderDetail->shipping_type != null &&
                                                $orderDetail->shipping_type == 'home_delivery')
                                            {{ translate('Home Delivery') }}
                                        @elseif ($orderDetail->shipping_type == 'pickup_point')
                                            @if ($orderDetail->pickup_point != null)
                                                {{ $orderDetail->pickup_point->getTranslation('name') }}
                                                ({{ translate('Pickup Point') }})
                                            @else
                                                {{ translate('Pickup Point') }}
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $orderDetail->quantity }}</td>
                                    <td class="text-center">
                                        {{ single_price($orderDetail->price / $orderDetail->quantity) }}
                                    </td>
                                    <td class="text-center">
                                        {{ single_price($orderDetail->price) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix float-right">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <strong
                                    class="text-muted">{{ translate('Sub Total') }}
                                    :</strong>
                            </td>
                            <td>
                                {{ single_price($order->orderDetails->sum('price')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted">{{ translate('Tax') }}
                                    :</strong>
                            </td>
                            <td>
                                {{ single_price($order->orderDetails->sum('tax')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong
                                    class="text-muted">{{ translate('Shipping') }}
                                    :</strong>
                            </td>
                            <td>
                                {{ !empty($shippingFee) ? single_price($shippingFee) : single_price($order->orderDetails->sum('shipping_cost')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong
                                    class="text-muted">{{ translate('Coupon') }}
                                    :</strong>
                            </td>
                            <td>
                                {{ single_price($order->coupon_discount) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted">{{ translate('TOTAL') }}
                                    :</strong>
                            </td>
                            <td class="text-muted h5">
                                {{ !empty($shippingFee) ? single_price($order->grand_total + $shippingFee) : single_price($order->grand_total) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right no-print">
                    <a href="{{ route('invoice.download', $order->id) }}"
                        type="button" class="btn btn-icon btn-light"><i
                            class="las la-print"></i></a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#assign_deliver_boy').on('change', function() {
            var order_id = {{ $order->id }};
            var delivery_boy = $('#assign_deliver_boy').val();
            $.post('{{ route('orders.delivery-boy-assign') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                delivery_boy: delivery_boy
            }, function(data) {
                AIZ.plugins.notify('success',
                    '{{ translate('Delivery boy has been assigned') }}'
                );
            });
        });

        $('#update_delivery_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('orders.update_delivery_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                console.log(data)
                data = JSON.parse(data)
                if (data.code) {
                    if (data.code == 200 || data.success) {
                        let message = data.code ? data
                            .message_display : data.message;
                        AIZ.plugins.notify('success', message);
                        setTimeout(function() {
                            location.reload()
                        }, 2500)
                    } else {
                        AIZ.plugins.notify('danger', data.message);
                    }
                } else {
                    AIZ.plugins.notify('success',
                        '{{ translate('Delivery status has been updated') }}'
                    );
                }
            });
        });

        $('#update_payment_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('orders.update_payment_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                AIZ.plugins.notify('success',
                    '{{ translate('Payment status has been updated') }}'
                );
            });
        });
    </script>
@endsection
