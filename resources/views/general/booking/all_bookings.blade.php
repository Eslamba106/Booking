@extends('layouts.dashboard')

@section('title')
    {{ __('roles.booking_management') }}
@endsection

@section('css')
<!-- Font Awesome -->

<!-- DataTables -->

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
    /* تغيير حجم الأيقونات */
.pagination .page-item a {
    font-size: 1rem; /* الحجم المناسب */
    padding: 8px 16px; /* زيادة مساحة الأزرار */
}

/* تخصيص السهم */
.pagination .page-item:first-child a,
.pagination .page-item:last-child a {
    font-size: 1.2rem; /* زيادة حجم الأسهم */
}

/* تغيير الشكل العام للـ pagination */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* تحسين الألوان والحدود */
.pagination .page-item.active a {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.pagination .page-item:hover a {
    background-color: #0056b3;
    border-color: #0056b3;
}

/* تغيير شكل الأسهم */
.pagination .page-item .page-link {
    color: #007bff;
    font-size: 16px;
    font-weight: bold;
}

/* تعديل شكل الأزرار عند التمرير فوقها */
.pagination .page-item:hover .page-link {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
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
                    <h4 class="mb-0">{{ __('All bookings') }}</h4>
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
                                            <option value="">{{ __('roles.status') }}</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('pending') }}</option>
                                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>{{ __('confirmed') }}</option>
                                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('cancelled') }}</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('completed') }}</option>
                                        </select>
                                    </div>
                                </div>
                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_date_from">{{ __('From Date') }}</label>
                                        <input type="date" name="date_from" id="filter_date_from" class="form-control"
                                            value="{{ request('date_from') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_date_to">{{ __('To Date') }}</label>
                                        <input type="date" name="date_to" id="filter_date_to" class="form-control"
                                            value="{{ request('date_to') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="filter_customer">{{ __('booking.customer_name') }}</label>
                                        <input type="text" name="customer" id="filter_customer" class="form-control"
                                               placeholder="{{ __('customer') }}" value="{{ request('customer') }}">
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
                                    <option value="">{{ __('Actions') }}</option>
                                    @can('change_bookings_status')
                                    <option value="update_status">{{ __('update_status') }}</option>
                                    @endcan

                                    <option value="delete">{{ __('delete') }}</option>

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
                                        <th>{{ __('Booking NO') }}</th>
                                        <th>{{ __('booking.customer_name') }}</th>
                                        <th>{{ __('booking.hotel_name') }}</th>
                                        <th>{{ __('Pickup date') }}</th>
                                        <th>{{ __('Return_date') }}</th>
                                        <th>{{ __('Total') }}</th>
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
                   <div class="pagination">
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link" href="{{ $bookings->previousPageUrl() }}">
                <i class="fas fa-arrow-left"></i> Pervious</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="{{ $bookings->nextPageUrl() }}">
                <i class="fas fa-arrow-right"></i> Next
            </a>
        </li>
    </ul>
</div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- DataTables -->

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
    // Toggle status dropdown visibility
    $('#bulkAction').change(function() {
        $('#statusContainer').toggle($(this).val() === 'update_status');
    });

    // Select/Deselect all checkboxes
    $('#selectAll').change(function() {
        $('input[name="bulk_ids[]"]').prop('checked', this.checked);
    });

    // Handle form submission
    $('#bulkActionForm').submit(function(e) {
        e.preventDefault();

        const action = $('#bulkAction').val();
        const selectedCount = $('input[name="bulk_ids[]"]:checked').length;

        // Validate action selection
        if (!action) {
            showAlert('error', 'Error', 'Please select an action to perform');
            return false;
        }

        // Validate at least one item is selected
        if (selectedCount === 0) {
            showAlert('error', 'Error', 'Please select at least one booking');
            return false;
        }

        // Confirm before destructive actions
        if (action === 'delete') {
            confirmAction(
                'Are you sure?',
                'You won\'t be able to recover these bookings!',
                'warning',
                submitBulkAction
            );
        } else {
            submitBulkAction();
        }
    });

    // Submit bulk action via AJAX
    function submitBulkAction() {
        const $submitBtn = $('#applyBulkAction');
        const originalText = $submitBtn.html();

        // Show loading state
        $submitBtn.prop('disabled', true).html(
            '<i class="fas fa-spinner fa-spin"></i> Processing...'
        );

        $.ajax({
            url: $('#bulkActionForm').attr('action'),
            method: 'POST',
            data: $('#bulkActionForm').serialize(),
            success: function(response) {
                if (response.success) {
                    showAlert(
                        'success',
                        'Success',
                        response.message || 'Action completed successfully',
                        true
                    );
                } else {
                    showAlert('error', 'Error', response.message || 'Action failed');
                }
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.message ||
                               'Server communication error';
                showAlert('error', 'Error', errorMsg);
            },
            complete: function() {
                $submitBtn.prop('disabled', false).html(originalText);
            }
        });
    }

    // Helper function to show SweetAlert
    function showAlert(icon, title, text, reload = false) {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            confirmButtonColor: '#3085d6'
        }).then(() => {
            if (reload) location.reload();
        });
    }

    // Helper function for confirmation dialogs
    function confirmAction(title, text, icon, callback) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) callback();
        });
    }
});
</script>
@endsection
