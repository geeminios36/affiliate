@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0 h6">{{ translate('Seller Payments') }}</h3>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th data-breakpoints="lg">#</th>
                        <th data-breakpoints="lg">{{ translate('TXN Code') }}</th>
                        <th>{{ translate('Sellers') }}</th>
                        {{-- <th>{{ translate('Seller Type') }}</th> --}}
                        {{-- <th>{{ translate('Wallet ID') }}</th> --}}
                        <th data-breakpoints="lg">{{ translate('Request Type') }}
                        <th data-breakpoints="lg">{{ translate('Requested Amount') }}
                        <th data-breakpoints="lg">
                            {{ translate('Your wallet balance') }}
                        <th data-breakpoints="lg">{{ translate('Payment Details') }}
                        <th data-breakpoints="lg">{{ translate('Payment Method') }}
                        <th data-breakpoints="lg">{{ translate('Status') }}
                        </th>
                        <th data-breakpoints="lg">{{ translate('Created At') }}
                        </th>
                        <th data-breakpoints="lg">{{ translate('Updated At') }}
                            {{-- <th data-breakpoints="lg">{{ translate('Created By') }}
                        <th data-breakpoints="lg">{{ translate('Updated By') }} --}}

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $key => $payment)
                        @if (
                            \App\Seller::find($payment->seller_id) != null &&
                                \App\Seller::find($payment->seller_id)->user != null)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $payment->txn_code }}</td>

                                <td>
                                    {{ \App\Seller::find($payment->seller_id)->user->name }}
                                </td>
                                {{-- <td>

                                    {{ \App\Seller::find($payment->seller_id)->user->user_type }}
                                </td> --}}
                                {{-- <td>
                                    {{ \App\Seller::find($payment->seller_id)->user->wallets->id }}
                                </td> --}}
                                <td>
                                    {{ get_request_type_payments($payment->request_type) }}
                                </td>
                                <td>
                                    {{ single_price($payment->amount) }}
                                </td>
                                <td>
                                    {{ single_price(\App\Seller::find($payment->seller_id)->user->balance) }}
                                </td>
                                <td>
                                    {{ $payment->payment_details }}
                                </td>
                                <td>
                                    {{ $payment->payment_method }}
                                </td>
                                <td>{{ get_status_payments($payment->status) }}
                                </td>
                                <td>{{ $payment->created_at }}</td>
                                <td>{{ $payment->updated_at }}</td>
                                {{-- <td>{{ $payment->created_by }}</td>
                                <td>{{ $payment->updated_by }}</td> --}}

                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection
