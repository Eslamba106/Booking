@extends('layouts.dashboard')

@section('title')
    {{ __('roles.booking_management') }}
@endsection

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

    .badge-pill {
        font-size: 0.85rem;
        padding: 5px 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="page-title">{{ __('roles.booking_management') }}</h3>
                @can('create_booking')
                <a href="{{ route('admin.booking.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i> {{ __('create') }}
                </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ __('all_bookings') }}</h4>
                </div>

                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="filter-section mb-4">
                        <form id="filterForm" method="GET" action="{{ route('admin.booking') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_status">{{ __('roles.status') }}</label>
                                        <select name="status" id="filter_status" class="form-control">
                                            <option value="">{{ __('all_statuses') }}</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('pending') }}</option>
                                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>{{ __('confirmed') }}</option>
                                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('cancelled') }}</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('completed') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_date">{{ __('date_range') }}</label>
                                        <select name="date_range" id="filter_date" class="form-control">
                                            <option value="">{{ __('all_dates') }}</option>
                                            <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>{{ __('today') }}</option>
                                            <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>{{ __('this_week') }}</option>
                                            <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>{{ __('this_month') }}</option>
                                            <option value="next_month" {{ request('date_range') == 'next_month' ? 'selected' : '' }}>{{ __('next_month') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_customer">{{ __('booking.customer_name') }}</label>
                                        <input type="text" name="customer" id="filter_customer" class="form-control"
                                               placeholder="{{ __('search_customer') }}" value="{{ request('customer') }}">
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" id="applyFilter" class="btn btn-primary mr-2">
                                        <i class="fas fa-filter mr-1"></i> {{ __('filter') }}
                                    </button>
                                    <a href="{{ route('admin.booking') }}" id="resetFilter" class="btn btn-outline-secondary">
                                        <i class="fas fa-redo mr-1"></i> {{ __('reset') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Bulk Actions -->
                    <form action="{{ route('admin.booking.bulk_action') }}" method="POST" id="bulkActionForm">
                        @csrf
                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-inline">
                                <select name="bulk_action" id="bulkAction" class="form-control mr-2">
                                    <option value="">{{ __('bulk_actions') }}</option>
                                    @can('change_bookings_status')
                                    <option value="update_status">{{ __('update_status') }}</option>
                                    @endcan
                                    @can('delete_booking')
                                    <option value="delete">{{ __('delete') }}</option>
                                    @endcan
                                </select>

                                <div id="statusContainer" class="mr-2" style="display: none;">
                                    <select name="status" class="form-control">
                                        <option value="pending">{{ __('pending') }}</option>
                                        <option value="confirmed">{{ __('confirmed') }}</option>
                                        <option value="cancelled">{{ __('cancelled') }}</option>
                                        <option value="completed">{{ __('completed') }}</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('apply') }}</button>
                            </div>
                        </div>

                        <!-- Bookings Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="50"><input type="checkbox" id="selectAll"></th>
                                        <th>{{ __('booking_id') }}</th>
                                        <th>{{ __('booking.customer_name') }}</th>
                                        <th>{{ __('booking.hotel_name') }}</th>
                                        <th>{{ __('pickup_date') }}</th>
                                        <th>{{ __('return_date') }}</th>
                                        <th>{{ __('total') }}</th>
                                        <th>{{ __('roles.status') }}</th>
                                        <th>{{ __('roles.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td><input type="checkbox" name="bulk_ids[]" value="{{ $booking->id }}"></td>
                                        <td>#{{ $booking->id }}</td>
                                        <td>{{ $booking->customer->name }}</td>
                                        <td>{{ $booking->hotel->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->arrival_date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->leave_date)->format('d M Y') }}</td>
                                        <td>{{ number_format($booking->total, 2) }} {{ $booking->currency }}</td>
                                        <td>
                                            <span class="badge badge-pill
                                                @if($booking->status == 'pending') badge-warning
                                                @elseif($booking->status == 'confirmed') badge-success
                                                @elseif($booking->status == 'cancelled') badge-danger
                                                @else badge-info @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @can('edit_booking')
                                                <a href="{{ route('admin.booking.show', $booking->id) }}" class="btn btn-sm btn-info action-btn" title="{{ __('view') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.booking.edit', $booking->id) }}" class="btn btn-sm btn-primary action-btn" title="{{ __('edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan

                                                {{-- @can('delete_booking')
                                                <form action="{{ route('admin.booking.delete', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-confirm" title="{{ __('delete') }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan --}}

                                                @can('edit_booking')
                                                <a href="{{ route('booking.voucher.pdf', $booking->id) }}" class="btn btn-sm btn-secondary action-btn" title="{{ __('PDF') }}">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                @endcan

                                                <a href="{{ route('admin.customer.show', $booking->customer_id) }}" class="btn btn-sm btn-light action-btn" title="{{ __('customer_profile') }}">
                                                    <i class="fas fa-user"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $bookings->appends(request()->query())->links() }}
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
<!-- SweetAlert2 for confirm dialogs -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <script>
$(document).ready(function() {
    // Initialize DataTable without server-side processing since we're using Laravel pagination
    $('table').DataTable({
        responsive: true,
        paging: false, // Disable DataTables pagination since we're using Laravel's
        searching: false, // Disable DataTables search since we have our own filters
        info: false, // Disable "Showing X of Y entries"
        order: [[1, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 8] }
        ]
    });

    // Select all checkbox
    $('#selectAll').click(function() {
        $('input[name="bulk_ids[]"]').prop('checked', this.checked);
    });

    // Show/hide status dropdown based on bulk action selection
    $('#bulkAction').change(function() {
        if ($(this).val() === 'update_status') {
            $('#statusContainer').show();
        } else {
            $('#statusContainer').hide();
        }
    });

    // Delete confirmation for single items
    $('.delete-confirm').click(function(e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: '{{ __("are_you_sure") }}',
            text: '{{ __("you_wont_be_able_to_revert_this") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __("yes_delete_it") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Bulk action form submission
    $('#bulkActionForm').submit(function(e) {
        const action = $('#bulkAction').val();
        const checkedCount = $('input[name="bulk_ids[]"]:checked').length;

        if (!action) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: '{{ __("error") }}',
                text: '{{ __("please_select_an_action") }}'
            });
            return false;
        }

        if (checkedCount === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: '{{ __("error") }}',
                text: '{{ __("please_select_at_least_one_item") }}'
            });
            return false;
        }

        if (action === 'delete') {
            e.preventDefault();
            Swal.fire({
                title: '{{ __("are_you_sure") }}',
                text: '{{ __("you_wont_be_able_to_revert_this") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __("yes_delete_it") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    this.submit();
                }
            });
        }
    });
});
</script> --}}
<script>
    $(document).ready(function() {
    // Initialize DataTable without interfering with Laravel pagination
    $('table').DataTable({
        responsive: true,
        paging: false,
        searching: false,
        info: false,
        order: [[1, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 8] }
        ]
    });

    // Select all checkbox
    $('#selectAll').click(function() {
        $('input[name="bulk_ids[]"]').prop('checked', this.checked);
    });

    // Show/hide status dropdown based on bulk action selection
    $('#bulkAction').change(function() {
        if ($(this).val() === 'update_status') {
            $('#statusContainer').show();
        } else {
            $('#statusContainer').hide();
        }
    });

    // Delete confirmation for single items
    $('.delete-confirm').click(function(e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: '{{ __("are_you_sure") }}',
            text: '{{ __("you_wont_be_able_to_revert_this") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __("yes_delete_it") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Bulk action form submission
   $('#bulkActionForm').submit(function(e) {
    e.preventDefault();

    const action = $('#bulkAction').val();
    const checkedCount = $('input[name="bulk_ids[]"]:checked').length;

    if (!action) {
        Swal.fire('Error', 'Please select an action', 'error');
        return false;
    }

    if (checkedCount === 0) {
        Swal.fire('Error', 'Please select at least one item', 'error');
        return false;
    }

    if (action === 'delete') {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // تغيير طريقة الإرسال إلى POST بدلاً من DELETE
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });
    } else {
        this.submit();
    }
});
});
</script>
@endsection
