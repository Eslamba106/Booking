<table>
    <thead>
        <tr>
            <th rowspan="2">Transaction Date</th>
            <th rowspan="2">User</th>
            <th rowspan="2">Customer ID</th>
            <th rowspan="2">Customer Name</th>
            <th colspan="3" class="text-center">Link Payments</th>
            <th colspan="3" class="text-center">Cash Payments</th>
            <th colspan="3" class="text-center">Card Payments</th>
        </tr>
        <tr>
            <th>Euro</th>
            <th>USD</th>
            <th>TL</th>
            <th>Euro</th>
            <th>USD</th>
            <th>TL</th>
            <th>Euro</th>
            <th>USD</th>
            <th>TL</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($paymentsGrouped as $date => $payments)
            @php
                $link = ['EUR' => 0, 'USD' => 0, 'TL' => 0];
                $cash = ['EUR' => 0, 'USD' => 0, 'TL' => 0];
                $card = ['EUR' => 0, 'USD' => 0, 'TL' => 0];
            @endphp

            @foreach ($payments as $payment)
                @php
                    $type = strtolower($payment->payment_method);
                    $currency = strtoupper($payment->currency ?? '');

                    if (!in_array($currency, ['EUR', 'USD', 'TL'])) {
                        $currency = 'USD';
                    }

                    $amount = $payment->amount;

                    if ($type == 'link') {
                        $link[$currency] += $amount;
                    } elseif ($type == 'cash') {
                        $cash[$currency] += $amount;
                    } elseif ($type == 'card') {
                        $card[$currency] += $amount;
                    }
                @endphp
            @endforeach

            <tr>
                <td>{{ $date }}</td>
                <td>{{ $payments->first()->user->name ?? 'N/A' }}</td>
                <td>{{ $payments->first()->custFile->customer->id ?? '-' }}</td>
                <td>{{ $payments->first()->custFile->customer->name ?? '-' }}</td>

                <td>{{ number_format($link['EUR'], 2) }}</td>
                <td>{{ number_format($link['USD'], 2) }}</td>
                <td>{{ number_format($link['TL'], 2) }}</td>

                <td>{{ number_format($cash['EUR'], 2) }}</td>
                <td>{{ number_format($cash['USD'], 2) }}</td>
                <td>{{ number_format($cash['TL'], 2) }}</td>

                <td>{{ number_format($card['EUR'], 2) }}</td>
                <td>{{ number_format($card['USD'], 2) }}</td>
                <td>{{ number_format($card['TL'], 2) }}</td>
            </tr>
        @endforeach
    </tbody>

</table>
