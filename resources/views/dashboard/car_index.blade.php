@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Car Rentals Dashboard</h1>

    <!-- Summary Cards -->
    <div class="row mt-4">
        <!-- Total Bookings -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Car Rentals</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalBookings) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalRevenue) }} {{ config('app.currency') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Monthly Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($currentMonthRevenue) }} {{ config('app.currency') }}</div>
                            <div class="mt-1 text-xs">
                                @if($revenueChange >= 0)
                                    <span class="text-success mr-2">
                                        <i class="fas fa-arrow-up"></i> {{ number_format($revenueChange, 2) }}%
                                    </span>
                                @else
                                    <span class="text-danger mr-2">
                                        <i class="fas fa-arrow-down"></i> {{ number_format(abs($revenueChange), 2) }}%
                                    </span>
                                @endif
                                <span>vs last month</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Monthly Bookings Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Car Rentals</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="monthlyCarBookingsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Status Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Rental Status</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="carStatusChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($statusCounts as $status => $count)
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color: {{ getStatusColor($status) }}"></i> {{ ucfirst($status) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Categories Table -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top Car Categories</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Rentals Count</th>
                                    <th>Total Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topCategories as $category)
                                    <tr>
                                        <td>{{ $category->category->category?? 'Unknown Category' }}</td>
                                        <td>{{ $category->bookings_count }}</td>
                                        <td>
                                            {{ number_format(\App\Models\Car::where('category_id', $category->category_id)->sum('total')) }}
                                            {{ config('app.currency') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    $.get("{{ route('car.dashboard.charts') }}", function(response) {
        // Monthly Car Bookings Chart
        var monthlyCtx = document.getElementById('monthlyCarBookingsChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: response.monthly.map(item => item.label),
                datasets: [{
                    label: "Car Rentals",
                    data: response.monthly.map(item => item.count),
                    backgroundColor: "rgba(54, 185, 204, 0.1)",
                    borderColor: "rgba(54, 185, 204, 1)",
                    borderWidth: 2,
                    pointBackgroundColor: "rgba(54, 185, 204, 1)",
                    pointBorderColor: "#fff",
                    pointRadius: 4,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Car Status Chart
        var statusCtx = document.getElementById('carStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: response.status.map(item => item.status),
                datasets: [{
                    data: response.status.map(item => item.count),
                    backgroundColor: response.status.map(item => getStatusColor(item.status)),
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error loading car chart data:", textStatus, errorThrown);
    });
});

function getStatusColor(status) {
    const colors = {
        'pending': '#f6c23e',
        'approved': '#1cc88a',
        'rejected': '#e74a3b',
        'completed': '#36b9cc'
    };
    return colors[status.toLowerCase()] || '#858796';
}
</script>
@endsection
