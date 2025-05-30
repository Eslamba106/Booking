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
        <a href="{{ route('monthly.Accounting.report', $customer['id']) }}" class="btn btn-success">
            <i class="fas fa-file-excel mr-1"></i> Export to Excel
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">

                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Arrival Date</th>
                    <th>Departure Date</th>
                    <th>User</th>
                    <th>Total Hotel Price</th>
                    <th>Currency</th>
                    <th>Total Car Price</th>
                    <th>Advance Payment</th>
                    <th>Due Payment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customer['bookings'] as $booking)
                    <tr>
                        <td>{{ $customer['id'] }}</td>
                        <td>{{ $customer['name'] }}</td>
                        <td>{{ $booking->arrival_date }}</td>
                        <td>{{ $booking->check_out_date }}</td>
                        <td> {{ $booking->user->name }} </td>
                        <td>{{ number_format($booking->total ?? 0, 2) }}</td>
                        <td>{{ $booking->currency ?? 'USD' }}</td>
                        <td> - </td>
                        <td>{{ number_format($booking->total ?? 0, 2) }}</td>
                        <td>-</td>
                        <td>
                            <span class="badge bg-{{ $customer['status'] == 'Paid' ? 'success' : 'warning' }}">
                                {{ $customer['status'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach

                @foreach ($customer['cars'] as $car)
                    <tr>
                        <td>{{ $customer['id'] }}</td>
                        <td>{{ $customer['name'] }}</td>
                        <td>{{ $car->arrival_date }}</td>
                        <td>{{ $car->leave_date }}</td>
                        <td> {{ $car->user->name }} </td>
                        <td> - </td>
                        <td>{{ $car->currency ?? 'USD' }}</td>
                        <td>{{ number_format($car->total ?? 0, 2) }}</td>
                        <td>{{ number_format($car->total ?? 0, 2) }}</td>
                        <td>-</td>
                        <td>
                            <span class="badge bg-{{ $customer['status'] == 'Paid' ? 'success' : 'warning' }}">
                                {{ $customer['status'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
