@extends('layouts.dashboard')

@section('content')
@section('css')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: middle;
        }

        thead th {
            background-color: #343a40;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .report-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
@endsection



<div class="container-fluid">
    <div class="report-header">
        <h2 class="report-title">Payments Report</h2>
        <a href="{{ route('monthly.payment.report', $customer->id) }}" class="btn btn-success">
            <i class="fas fa-file-excel mr-1"></i> Export to Excel
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2" class="align-middle">Transaction Date</th>
                    <th rowspan="2" class="align-middle">User</th>
                    <th rowspan="2" class="align-middle">Customer ID</th>
                    <th rowspan="2" class="align-middle">Customer Name</th>
                    <th colspan="3" class="text-center">Link Payments</th>
                    <th colspan="3" class="text-center">Cash Payments</th>
                    <th colspan="3" class="text-center">Card Payments</th>
                </tr>
                <tr>
                    <!-- Link Payments -->
                    <th>Euro</th>
                    <th>USD</th>
                    <th>TL</th>

                    <!-- Cash Payments -->
                    <th>Euro</th>
                    <th>USD</th>
                    <th>TL</th>

                    <!-- Card Payments -->
                    <th>Euro</th>
                    <th>USD</th>
                    <th>TL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentsGrouped as $date => $payments)
                    @php
                        // Initialize totals for each payment method and currency
                        $link = ['EUR' => 0, 'USD' => 0, 'TL' => 0];
                        $cash = ['EUR' => 0, 'USD' => 0, 'TL' => 0];
                        $card = ['EUR' => 0, 'USD' => 0, 'TL' => 0];

                        foreach ($payments as $payment) {
                            $type = strtolower($payment->payment_method);
                            $currency = strtoupper($payment->currency ?? 'USD');

                            // Validate currency
                            if (!in_array($currency, ['EUR', 'USD', 'TL'])) {
                                $currency = 'USD';
                            }

                            $amount = $payment->amount;

                            switch ($type) {
                                case 'link':
                                    $link[$currency] += $amount;
                                    break;
                                case 'cash':
                                    $cash[$currency] += $amount;
                                    break;
                                case 'card':
                                    $card[$currency] += $amount;
                                    break;
                            }
                        }
                    @endphp

                    <tr>
                        <td>{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}</td>
                        <td>{{ $payments->first()->user->name ?? 'N/A' }}</td>
                        <td>{{ $payments->first()->custFile->customer->id ?? '-' }}</td>
                        <td>{{ $payments->first()->custFile->customer->name ?? '-' }}</td>

                        <!-- Link Payments -->
                        <td>{{ number_format($link['EUR'], 2) }}</td>
                        <td>{{ number_format($link['USD'], 2) }}</td>
                        <td>{{ number_format($link['TL'], 2) }}</td>

                        <!-- Cash Payments -->
                        <td>{{ number_format($cash['EUR'], 2) }}</td>
                        <td>{{ number_format($cash['USD'], 2) }}</td>
                        <td>{{ number_format($cash['TL'], 2) }}</td>

                        <!-- Card Payments -->
                        <td>{{ number_format($card['EUR'], 2) }}</td>
                        <td>{{ number_format($card['USD'], 2) }}</td>
                        <td>{{ number_format($card['TL'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
