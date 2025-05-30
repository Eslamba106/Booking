@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ __('Hotel Bookings') }}
@endsection


@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Hotel Bookings Report</h2>

        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title">Filter Options</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('comming.report') }}" method="GET" id="filterForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter_status">{{ __('roles.status') }}</label>
                                <select name="status" id="filter_status" class="form-control">
                                    <option value="">{{ __('roles.status') }}</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        {{ __('pending') }}</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>
                                        {{ __('confirmed') }}</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                        {{ __('cancelled') }}</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        {{ __('completed') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="date_from">From Date</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="date_to">To Date</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter_customer">{{ __('booking.customer_name') }}</label>
                                <input type="text" name="customer" id="filter_customer" class="form-control"
                                    placeholder="{{ __('customer') }}" value="{{ request('customer') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="hotel_id">{{ __('booking.hotel_name') }}</label>
                                <select name="hotel_id" id="hotel_id" class="form-control">
                                    <option value="">{{ __('All Hotels') }}</option>
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}"
                                            {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                            {{ $hotel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                            <button type="button" class="btn btn-success float-right" onclick="exportToExcel()">
                                <i class="fas fa-file-excel"></i> Export to Excel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title">Booking Results</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
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
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                @php
                                    $roomCost = $booking->buy_price ?? 0;
                                    $sellingPrice = $booking->price ?? 0;
                                    $totalCost =
                                        $roomCost *
                                        ($booking->booking_details->units_count ?? 1) *
                                        ($booking->days_count ?? 1);
                                    $totalPrice =
                                        $sellingPrice *
                                        ($booking->booking_details->units_count ?? 1) *
                                        ($booking->days_count ?? 1);
                                    $revenue = $totalPrice - $totalCost;

                                    $commissionAmount = $booking->commission_amount ?? 0;
                                    if ($booking->commission_type == 'percentage') {
                                        $commissionAmount = $totalCost * ($booking->commission_percentage / 100);
                                    } elseif ($booking->commission_type == 'night') {
                                        $commissionAmount =
                                            $booking->commission_night *
                                            ($booking->days_count ?? 1) *
                                            ($booking->booking_details->units_count ?? 1);
                                    }

                                    // dd($commissionAmount);
                                    if ($booking->broker_amount) {
                                        $total_broker =
                                            $booking->broker_amount *
                                            $booking->days_count *
                                            $booking->booking_details->units_count;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $booking->customer->id }}</td>
                                    <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->hotel->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->booking_unit->unit_type ?? 'N/A' }}</td>
                                    <td>{{ $booking->booking_no }}</td>
                                    <td>{{ $booking->arrival_date }}</td>
                                    <td>{{ $booking->check_out_date }}</td>
                                    <td>{{ $booking->days_count }}</td>
                                    <td>{{ $booking->booking_details->units_count ?? 0 }}</td>
                                    <td>{{ number_format($roomCost, 2) }} {{ $booking->currency }}</td>
                                    <td>{{ number_format($totalCost, 2) }} {{ $booking->currency }}</td>


                                    <td>
                                        @if ($booking->commission_type == 'percentage')
                                            {{ $booking->commission_percentage }}%
                                        @elseif($booking->commission_type == 'night')
                                            Per Night ({{ $booking->commission_night }})
                                        @else
                                            Fixed Amount
                                        @endif
                                    </td>

                                    @if ($booking->commission_type == 'percentage')
                                        <td> {{ $booking->commission_percentage }}</td>
                                    @elseif($booking->commission_type == 'per_night')
                                        <td> {{ $booking->commission_night }}</td>
                                    @else
                                    @endif


                                    <td>{{ number_format($commissionAmount, 2) }} {{ $booking->currency }}</td>
                                    <td> {{ $booking->status }}</td>


                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>

                @if ($bookings->hasPages())
                    <div class="mt-3">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // function resetForm() {
        //     document.getElementById('filterForm').reset();
        //     window.location = "{{ route('booking.export.index') }}";
        // }

        function exportToExcel() {

            const form = document.getElementById('filterForm');
            const exportForm = document.createElement('form');
            exportForm.method = 'GET';
            exportForm.action = "{{ route('monthly.comming.report') }}";


            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                const clone = input.cloneNode(true);
                exportForm.appendChild(clone);
            });

            document.body.appendChild(exportForm);
            exportForm.submit();
            document.body.removeChild(exportForm);
        }
    </script>
@endsection
