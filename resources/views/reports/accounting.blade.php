<table class="table table-bordered">
    <thead>
        <tr>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Arrival Date </th>
            <th>Departure Date </th>
            <th>User</th>
            <th>Total Hotel Price</th>
            <th>Currency </th>

            <th>Total Car Price </th>
            <th>Advance Payment </th>
            <th>Due Payment </th>
            <th>Status (pay Or debit)</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($files as $file)
    @foreach ($file->cust_file_items as $item)
        @php
            $booking = null;
            $car = null;
            if ($item->related_type === 'App\\Models\\Booking') {
                $booking = $item->related;
                $buyPrice = is_numeric($booking->buy_price) ? $booking->buy_price : 0;
                $daysCount = is_numeric($booking->days_count) ? $booking->days_count : 0;
                $units = $booking->booking_details->units_count ?? 1;
                $commissionTotal = 0;
                $total_broker = 0;

                if ($booking->commission_type == 'percentage') {
                    $percentage = is_numeric($booking->commission_percentage) ? $booking->commission_percentage : 0;
                    $commissionTotal = ($percentage / 100) * $buyPrice * $daysCount * $units;
                } elseif ($booking->commission_type == 'night') {
                    $nightValue = is_numeric($booking->commission_night) ? $booking->commission_night : 0;
                    $commissionTotal = $nightValue * $daysCount * $units;
                }

                if ($booking->broker_amount){
                    $total_broker = $booking->broker_amount * $daysCount * $units;
                }

                $total_price = $buyPrice - $commissionTotal + $total_broker;
            } elseif ($item->related_type === 'App\\Models\\Car') {
                $car = $item->related;
                $car_total = $car->total;
            }
        @endphp

        @if ($booking)
        <tr>
            <td>{{ $file->customer->id ?? '-' }}</td>
            <td>{{ $file->customer->name ?? '-' }}</td>
            <td>{{ $booking->arrival_date }}</td>
            <td>{{ $booking->check_out_date }}</td>
            <td>{{ $file->user->name ?? 'N/A' }}</td>
            <td>{{ number_format($total_price ?? 0, 2) }}</td>
            <td>{{ $booking->currency ?? 'USD' }}</td>
            <td>{{ number_format($car_total?? 0, 2) }}</td>
            <td>{{ number_format($file->paid ?? 0, 2) }}</td>
            <td>{{ number_format($file->remain ?? 0, 2) }}</td>
            <td>
                @if($booking->status == 'completed')
                    <span class="badge bg-success">Paid</span>
                @elseif($booking->status == 'pending')
                    <span class="badge bg-warning text-dark">Due</span>
                @else
                    <span class="badge bg-secondary">Unknown</span>
                @endif
            </td>
        </tr>
        @endif
    @endforeach
@endforeach

    </tbody>
</table>
