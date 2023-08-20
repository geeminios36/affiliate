<div class="modal fade" id="sold-order-detail-modal" tabindex="-1" role="dialog"
    aria-labelledby="sold-order-detail-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
                <span id="order-code">
                    <?php
                    $shipping_address = json_decode($order->shipping_address);
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h2 fs-16 mb-0">
                                Order Details</h1>
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
                                            <select
                                                class="form-control aiz-selectpicker"
                                                data-live-search="true"
                                                data-minimum-results-for-search="Infinity"
                                                id="assign_deliver_boy">
                                                <option value="">
                                                    Select Delivery Boy
                                                </option>
                                                @foreach ($delivery_boys as $delivery_boy)
                                                    <option
                                                        value="{{ $delivery_boy->id }}"
                                                        @if ($order->assign_delivery_boy == $delivery_boy->id) selected @endif>
                                                        {{ $delivery_boy->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text"
                                                class="form-control"
                                                value="{{ optional($order->delivery_boy)->name }}">
                                        @endif
                                    </div>
                                @endif

                                <div class="col-md-3 ml-auto">
                                    <p>Payment
                                        Status</p>
                                    <p class="text-uppercase font-weight-bold">
                                        {{ $payment_status }}
                                    </p>
                                </div>
                                <div class="col-md-3 ml-auto ">
                                    <p>Delivery
                                        Status</p>
                                    <p class="text-uppercase font-weight-bold">
                                        {{ $delivery_status }}
                                    </p>
                                </div>
                            </div>
                            {{-- <div class="row gutters-5 my-3">
                                <div class="col text-center text-md-left">
                                    <address>
                                        @if (empty($deliveryPartner))
                                            <strong
                                                class="text-main">{{ $shipping_address->name }}</strong><br>
                                            {{ $shipping_address->email }}<br>
                                            {{ $shipping_address->phone }}<br>
                                            {{ $shipping_address->address }}
                                            , {{ $shipping_address->city }}
                                            ,
                                            {{ $shipping_address->postal_code }}<br>
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
                                    @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                                        <br>
                                        <strong class="text-main">Payment
                                            Information</strong><br>
                                        Name:
                                        {{ json_decode($order->manual_payment_data)->name }},
                                        Amount:
                                        {{ single_price(json_decode($order->manual_payment_data)->amount) }},
                                        TRX ID:
                                        {{ json_decode($order->manual_payment_data)->trx_id }}
                                        <br>
                                        <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}"
                                            target="_blank"><img
                                                src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}"
                                                alt=""
                                                height="100"></a>
                                    @endif
                                </div>
                                <div class="col-md-4 ml-auto">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="text-main text-bold">
                                                    Order #
                                                </td>
                                                <td
                                                    class="text-right text-info text-bold">
                                                    {{ $order->code }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-main text-bold">
                                                    Order Status
                                                </td>
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
                                                    Order Date
                                                </td>
                                                <td class="text-right">
                                                    {{ date('d-m-Y h:i A', $order->date) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-main text-bold">
                                                    Total amount
                                                </td>
                                                <td class="text-right">
                                                    {{ single_price($order->grand_total) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-main text-bold">
                                                    Payment method
                                                </td>
                                                <td class="text-right">
                                                    {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}
                            <hr class="new-section-sm bord-no">
                            <div class="row">
                                <div class="col-lg-12 table-responsive">
                                    <table
                                        class="table table-bordered aiz-table invoice-summary">
                                        <thead>
                                            <tr class="bg-trans-dark">
                                                <th data-breakpoints="lg"
                                                    class="min-col">#</th>
                                                <th width="10%"
                                                    class="text-uppercase">
                                                    Photo
                                                </th>
                                                <th class="text-uppercase">
                                                    Description
                                                </th>
                                                <th data-breakpoints="lg"
                                                    class="text-uppercase">
                                                    Delivery Type
                                                </th>
                                                <th data-breakpoints="lg"
                                                    class="min-col text-center text-uppercase">
                                                    Qty</th>
                                                <th data-breakpoints="lg"
                                                    class="min-col text-center text-uppercase">
                                                    Price
                                                </th>
                                                <th data-breakpoints="lg"
                                                    class="min-col text-right text-uppercase">
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderDetails as $key => $orderDetail)
                                                <tr>
                                                    <td>{{ $key + 1 }}
                                                    </td>
                                                    <td>
                                                        @if ($orderDetail->product != null)
                                                            <a href="{{ route('product', $orderDetail->product->slug) }}"
                                                                target="_blank"><img
                                                                    height="50"
                                                                    src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}"></a>
                                                        @else
                                                            <strong>N/A</strong>
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
                                                            <strong>Product
                                                                Unavailable</strong>
                                                        @endif
                                                    </td>
                                                    <td style="width: 25%">
                                                        @if (
                                                            $orderDetail->shipping_type != null &&
                                                                $orderDetail->shipping_type == 'home_delivery')
                                                            <p>
                                                                Home Delivery
                                                            </p>
                                                        @else
                                                            <p>
                                                                N/A
                                                            </p>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $orderDetail->quantity }}
                                                    </td>
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
                                                <strong class="text-muted">Sub
                                                    Total
                                                    :</strong>
                                            </td>
                                            <td>
                                                {{ single_price($order->orderDetails->sum('price')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="text-muted">Tax
                                                    :</strong>
                                            </td>
                                            <td>
                                                {{ single_price($order->orderDetails->sum('tax')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong
                                                    class="text-muted">Shipping
                                                    :</strong>
                                            </td>
                                            <td>
                                                {{ single_price($order->orderDetails->sum('shipping_cost')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong
                                                    class="text-muted">Coupon
                                                    :</strong>
                                            </td>
                                            <td>
                                                {{ single_price($order->coupon_discount) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="text-muted">TOTAL
                                                    :</strong>
                                            </td>
                                            <td class="text-muted h5">
                                                {{ single_price($order->grand_total) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>
