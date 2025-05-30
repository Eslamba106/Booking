{{-- <table>
    <thead>
        <tr>
            <th>Customer Id</th>
            <th>Customer Driver</th>
            <th>Category</th>
            <th>User</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>N. Days</th>
            <th>Daily Rental Price</th>

            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cars as $car)
            @php
                $total_price = $car->category->price_per_day * $car->days_count;
            @endphp
            <tr>
                <td>{{ $car->customer->id ?? '-' }}</td>
                <td>{{ $car->customer->name ?? '-' }}</td>
                <td>{{ $car->category->category ?? '-' }}</td>
                <td>{{ $car->user->name ?? '-' }}</td>
                <td>{{ $car->arrival_date }}</td>
                <td>{{ $car->leave_date }}</td>
                <td>{{ $car->days_count }}</td>
                <td>{{ $car->category->price_per_day }}</td>

                <td>{{ $total_price }}</td>
            </tr>
        @endforeach
    </tbody>
</table> --}}
<table>
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Customer</th>
            <th>Car Category</th>
            <th>Pickup Date</th>
            <th>Return Date</th>
            <th>Pickup Time</th>
            <th>Return Time</th>
            <th>From Location</th>
            <th>To Location</th>
            <th>Days Count</th>
            <th>Daily Price</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bookings as $booking)
            <tr>
                <td>#{{ $booking->id }}</td>
                <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                <td>{{ $booking->category->category ?? 'N/A' }}</td>
                <td>{{ $booking->arrival_date }}</td>
                <td>{{ $booking->leave_date }}</td>
                <td>{{ $booking->arrival_time }}</td>
                <td>{{ $booking->leave_time }}</td>
                <td>{{ $booking->from_location }}</td>
                <td>{{ $booking->to_location }}</td>
                <td>{{ $booking->days_count }}</td>
                <td>{{ number_format($booking->category->price_per_day ?? 0, 2) }} $</td>
                <td>{{ number_format($booking->total, 2) }} $</td>
                <td>{{ ucfirst($booking->status) }}</td>
                <td>{{ $booking->created_at }}</td>
                <td>{{ $booking->note }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="11" style="text-align: right;"><strong>Grand Total:</strong></td>
            <td><strong>{{ number_format($bookings->sum('total'), 2) }} $</strong></td>
            <td colspan="3"></td>
        </tr>
    </tfoot>
</table>
