<table>
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
        @foreach($cars as $car)
        @php
            $total_price =$car->category->price_per_day * $car->days_count;
        @endphp
            <tr>
                <td>{{ $car->customer->id ?? '-' }}</td>
                <td>{{ $car->customer->name ?? '-' }}</td>
                <td>{{ $car->category->category ?? '-' }}</td>
                <td>{{ $car->user->name ?? '-' }}</td>
                <td>{{ $car->arrival_date }}</td>
                <td>{{ $car->leave_date}}</td>
                <td>{{ $car->days_count }}</td>
                <td>{{ $car->category->price_per_day }}</td>

                <td>{{ $total_price}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
