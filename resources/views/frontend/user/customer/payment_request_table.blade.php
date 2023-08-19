<table class="table table-bordered">
    <thead class="thead-light">
        <tr>
            <th>STT</th>
            <th>Amount</th>
            <th>Message</th>
            <th>Status</th>
            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payment_histories as $key => $payment_history)
            <tr>
                <td>{{ $key + 1 }}
                </td>
                <td>{{ single_price($payment_history->amount) }}
                </td>
                <td>{{ $payment_history->message }}
                </td>
                <td>{{ $payment_history->status == 0 ? 'Pending' : 'Paid' }}
                </td>
                <td>{{ $payment_history->created_at }}
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
