@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ __('Car Bookings') }}
@endsection


@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Car Bookings Report</h2>

        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title">Filter Options</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('car.export.index') }}" method="GET" id="filterForm">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="date_from">From Date</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="date_to">To Date</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>

                        <div class="col-md-3">
                            <label for="customer">Customer Name</label>
                            <input type="text" name="customer" class="form-control" placeholder="Customer name"
                                value="{{ request('customer') }}">
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
                            @forelse ($cars as $booking)
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
                            @empty
                                <tr>
                                    <td colspan="18" class="text-center">No bookings found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($cars->hasPages())
                    <div class="mt-3">
                        {{ $cars->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function resetForm() {
            document.getElementById('filterForm').reset();
            window.location = "{{ route('reports.broker') }}";
        }

        function exportToExcel() {

            const form = document.getElementById('filterForm');
            const exportForm = document.createElement('form');
            exportForm.method = 'GET';
            exportForm.action = "{{ route('car.export') }}";


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
