<table>
    <thead>
        <tr>
                            <th>Booking #</th>
                            <th>Customer</th>
                            <th>Agent</th>
                            <th>Hotel</th>
                            <th>Room Type</th>
                            <th>Arrival</th>
                            <th>Departure</th>
                            <th>Nights</th>
                            <th>Rooms</th>
                            <th>Room Cost</th>
                            <th>Total Cost</th>
                            <th>Selling Price</th>
                            <th>Total Price</th>
                            <th>Revenue</th>
                            <th>Commission Type</th>
                            <th>Commission</th>

                        </tr>
    </thead>
    <tbody>
          @foreach ($bookings as $booking)
                        @php
                            $roomCost = $booking->buy_price ?? 0;
                            $sellingPrice = $booking->price ?? 0;
                            $totalCost = $roomCost * ($booking->booking_details->units_count ?? 1) * ($booking->days_count ?? 1);
                            $totalPrice = $sellingPrice * ($booking->booking_details->units_count ?? 1) * ($booking->days_count ?? 1);
                            $revenue = $totalPrice - $totalCost;

                            $commissionAmount = $booking->commission_amount ?? 0;
                            if($booking->commission_type == 'percentage') {
                                $commissionAmount = $totalCost * ($booking->commission_percentage / 100) ;
                            } elseif($booking->commission_type == 'night') {
                                $commissionAmount = $booking->commission_night * ($booking->days_count ?? 1)  * ($booking->booking_details->units_count ?? 1);
                            }
                            // dd($commissionAmount);
if($booking->broker_amount){
    $total_broker = $booking->broker_amount * $booking->days_count *$booking->booking_details->units_count;
}


                        @endphp
                        <tr>
                            <td>{{ $booking->booking_no }}</td>
                            <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                            <td>{{ $booking->user->name ?? 'N/A' }}</td>
                            <td>{{ $booking->hotel->name ?? 'N/A' }}</td>
                            <td>{{ $booking->booking_unit->unit_type ?? 'N/A' }}</td>
                            <td>{{ $booking->arrival_date }}</td>
                            <td>{{ $booking->check_out_date }}</td>
                            <td>{{ $booking->days_count }}</td>
                            <td>{{ $booking->booking_details->units_count ?? 0 }}</td>
                            <td>{{ number_format($roomCost, 2) }} {{ $booking->currency }}</td>
                            <td>{{ number_format($totalCost, 2) }} {{ $booking->currency }}</td>
                            <td>{{ number_format($sellingPrice, 2) }} {{ $booking->currency }}</td>
                            <td>{{ number_format($totalPrice, 2) }} {{ $booking->currency }}</td>
                            <td>{{ number_format($revenue, 2) }} {{ $booking->currency }}</td>
                            <td>
                                @if($booking->commission_type == 'percentage')
                                    {{ $booking->commission_percentage }}%
                                @elseif($booking->commission_type == 'night')
                                    Per Night ({{ $booking->commission_night }})
                                @else
                                    Fixed Amount
                                @endif
                            </td>
                            <td>{{ number_format($commissionAmount, 2) }} {{ $booking->currency }}</td>


                        </tr>
                        @endforeach


    </tbody>
</table>
