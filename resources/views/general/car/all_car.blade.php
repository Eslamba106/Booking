@extends('layouts.dashboard')

@section('title', 'Car Bookings Management')

@section('css')
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<!-- DataTables -->
<link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<style>
    .status-badge {
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-confirmed {
        background-color: #d4edda;
        color: #155724;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .status-completed {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .action-btn {
        padding: 5px 10px;
        font-size: 0.85rem;
        margin-right: 5px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .filter-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .dropdown-menu {
        min-width: 100px;
    }

    .dropdown-item {
        padding: 5px 15px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="page-title">Car Bookings Management</h3>
                <a href="{{ route('car.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i> New Booking
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">All Bookings</h4>
                </div>

                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="filter-section mb-4">
                        <form id="filterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_status">Status</label>
                                        <select name="status" id="filter_status" class="form-control">
                                            <option value="">All Statuses</option>
                                            <option value="pending">Pending</option>
                                            <option value="confirmed">Confirmed</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_date">Date Range</label>
                                        <select name="date_range" id="filter_date" class="form-control">
                                            <option value="">All Dates</option>
                                            <option value="today">Today</option>
                                            <option value="this_week">This Week</option>
                                            <option value="this_month">This Month</option>
                                            <option value="next_month">Next Month</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_customer">Customer</label>
                                        <input type="text" name="customer" id="filter_customer" class="form-control" placeholder="Search customer...">
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" id="applyFilter" class="btn btn-primary mr-2">
                                        <i class="fas fa-filter mr-1"></i> Filter
                                    </button>
                                    <button type="button" id="resetFilter" class="btn btn-outline-secondary">
                                        <i class="fas fa-redo mr-1"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Bookings Table -->
                    <div class="table-responsive">
                        <table id="bookingsTable" class="table table-bordered table-hover" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>Pickup Date</th>
                                    <th>Return Date</th>
                                    <th>Total (SAR)</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cars as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->customer->name }}</td>
                                    <td>{{ $booking->category->category }} ({{ $booking->category->model }})</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->arrival_date)->format('d M Y') }} at {{ $booking->arrival_time }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->leave_date)->format('d M Y') }} at {{ $booking->leave_time }}</td>
                                    <td>{{ number_format($booking->total, 2) }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('car.show', $booking->id) }}" class="btn btn-sm btn-info action-btn" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('car.edit', $booking->id) }}" class="btn btn-sm btn-primary action-btn" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('car.updateStatus', $booking->id) }}" method="POST" class="form-inline d-inline-block">
    @csrf
    @method('PUT')
    <div class="form-group">
        <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ $booking->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </div>
</form>

                                        </div>
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
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#bookingsTable').DataTable({
        responsive: true,
        order: [[0, 'desc']],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 6 },
            { responsivePriority: 3, targets: 7 }
        ]
    });

    // Apply filters
    $('#applyFilter').click(function() {
        const status = $('#filter_status').val();
        const dateRange = $('#filter_date').val();
        const customer = $('#filter_customer').val().toLowerCase();

        table.column(6).search(status).draw();

        if (dateRange) {
            const today = new Date();
            table.rows().every(function() {
                const row = this;
                const dateStr = $(row.node()).find('td:eq(3)').text();
                const rowDate = new Date(dateStr);

                let showRow = false;

                switch(dateRange) {
                    case 'today':
                        showRow = rowDate.toDateString() === today.toDateString();
                        break;
                    case 'this_week':
                        const weekStart = new Date(today.setDate(today.getDate() - today.getDay()));
                        const weekEnd = new Date(today.setDate(today.getDate() - today.getDay() + 6));
                        showRow = rowDate >= weekStart && rowDate <= weekEnd;
                        break;
                    case 'this_month':
                        showRow = rowDate.getMonth() === today.getMonth() &&
                                 rowDate.getFullYear() === today.getFullYear();
                        break;
                    case 'next_month':
                        const nextMonth = today.getMonth() + 1;
                        showRow = rowDate.getMonth() === nextMonth &&
                                 rowDate.getFullYear() === today.getFullYear();
                        break;
                }

                if (!showRow) {
                    $(row.node()).hide();
                } else {
                    $(row.node()).show();
                }
            });
        } else {
            table.rows().every(function() {
                $(this.node()).show();
            });
        }

        if (customer) {
            table.column(1).search(customer).draw();
        }
    });

    // Reset filters
    $('#resetFilter').click(function() {
        $('#filterForm')[0].reset();
        table.search('').columns().search('').draw();
        table.rows().every(function() {
            $(this.node()).show();
        });
    });

    // Status change handler
    $('.status-option').click(function(e) {
        e.preventDefault();
        const bookingId = $(this).data('id');
        const newStatus = $(this).data('status');

        if (confirm(`Are you sure you want to change this booking status to ${newStatus}?`)) {
            $.ajax({
                url: `/car/${bookingId}/status`,
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus
                },
                success: function(response) {
                    if (response.success) {
                        // Update status badge
                        const badge = $(`tr:contains('#${bookingId}') .status-badge`);
                        badge.removeClass('status-pending status-confirmed status-cancelled status-completed')
                             .addClass(`status-${newStatus}`)
                             .text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));

                        // Show success message
                        toastr.success('Booking status updated successfully');
                    }
                },
                error: function(xhr) {
                    toastr.error('Error updating booking status');
                }
            });
        }
    });

    // Toastr notifications
    @if(session('success'))
        toastr.success('{{ session('success') }}');
    @endif

    @if(session('error'))
        toastr.error('{{ session('error') }}');
    @endif
});
</script>
@endsection
