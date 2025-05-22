<table>
    <thead>
        <tr>
                          <th>#</th>
                            <th>Agent</th>
                            <th>Customer</th>
                            <th>Phone No</th>
                            <th>Category</th>
                            <th>Hotel</th>
                            <th>Arrival Date</th>
                            <th>Departure Date</th>
                            <th>Nights</th>
                        </tr>
    </thead>
    <tbody>
         @foreach($bookings as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $booking->user->name ?? 'N/A' }}</td>
                            <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                            <td>{{ $booking->customer->phone ?? 'N/A' }}</td>
                            <td>
                                @if($booking->customer->category)
                                    {{ ucfirst($booking->customer->category) }}
                                @else
                                    Standard
                                @endif
                            </td>
                            <td>{{ $booking->hotel->name ?? 'N/A' }}</td>
                            <td>{{ $booking->arrival_date }}</td>
                            <td>{{ $booking->check_out_date }}</td>
                            <td>{{ $booking->days_count }}</td>
                        </tr>
                        @endforeach

    </tbody>
</table>
