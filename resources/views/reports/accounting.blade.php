<table class="table table-bordered">
    <thead>
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
