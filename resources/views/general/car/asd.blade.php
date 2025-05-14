@extends('layouts.dashboard')

@section('title', 'Car Bookings Management')

@section('css')
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<!-- DataTables -->
<link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Toastr -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<style>
    .status-badge {
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .status-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    .status-confirmed {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .status-completed {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .action-btn {
        padding: 5px 10px;
        font-size: 0.85rem;
        margin-right: 5px;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        transform: scale(1.05);
    }

    .status-modal .modal-header {
        border-bottom: none;
        padding-bottom: 0;
    }

    .status-modal .modal-body {
        padding-top: 0;
    }

    .status-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .status-confirm-btn {
        min-width: 100px;
    }

    .status-reason {
        margin-top: 15px;
    }

    .highlight-row {
        animation: highlight 2s ease-out;
    }

    @keyframes highlight {
        0% { background-color: rgba(255, 255, 0, 0.3); }
        100% { background-color: transparent; }
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
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">All Bookings</h4>
                    <div class="badge badge-light">{{ $bookings->count() }} Bookings</div>
                </div>

                <div class="card-body">
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
                                @foreach($bookings as $booking)
                                <tr data-id="{{ $booking->id }}" id="booking-row-{{ $booking->id }}">
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->customer->name }}</td>
                                    <td>{{ $booking->category->category }} ({{ $booking->category->model }})</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->arrival_date)->format('d M Y') }} at {{ $booking->arrival_time }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->leave_date)->format('d M Y') }} at {{ $booking->leave_time }}</td>
                                    <td>{{ number_format($booking->total, 2) }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $booking->status }}"
                                              data-toggle="modal" data-target="#statusModal"
                                              data-booking-id="{{ $booking->id }}"
                                              data-current-status="{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('car.show', $booking->id) }}" class="btn btn-sm btn-info action-btn" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('car.edit', $booking->id) }}" class="btn btn-sm btn-primary action-btn" title="Edit Booking">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-secondary action-btn status-change-btn"
                                                    title="Change Status"
                                                    data-toggle="modal" data-target="#statusModal"
                                                    data-booking-id="{{ $booking->id }}"
                                                    data-current-status="{{ $booking->status }}">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>
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

<!-- Status Update Modal -->
<div class="modal fade status-modal" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Booking Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="bookingId">
                <input type="hidden" id="currentStatus">

                <div class="text-center">
                    <div class="status-icon">
                        <i class="fas fa-car text-primary"></i>
                    </div>
                    <h5>Booking #<span id="modalBookingId"></span></h5>
                    <p>Current status: <span id="currentStatusBadge" class="status-badge"></span></p>
                </div>

                <div class="form-group">
                    <label for="newStatus">Select New Status</label>
                    <select class="form-control" id="newStatus">
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>

                <div class="form-group status-reason" id="cancellationReason" style="display: none;">
                    <label for="reason">Cancellation Reason</label>
                    <textarea class="form-control" id="reason" rows="3" placeholder="Please specify the reason for cancellation..."></textarea>
                </div>

                <div class="form-group status-reason" id="completionNotes" style="display: none;">
                    <label for="notes">Completion Notes</label>
                    <textarea class="form-control" id="notes" rows="3" placeholder="Any notes about the booking completion..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary status-confirm-btn" id="confirmStatusChange">
                    <i class="fas fa-check-circle mr-1"></i> Update Status
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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

    // Status modal handling
    $('#statusModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const bookingId = button.data('booking-id');
        const currentStatus = button.data('current-status');

        $('#bookingId').val(bookingId);
        $('#currentStatus').val(currentStatus);
        $('#modalBookingId').text(bookingId);

        // Set current status badge
        const currentBadge = $('#currentStatusBadge');
        currentBadge.text(currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1));
        currentBadge.removeClass().addClass('status-badge status-' + currentStatus);

        // Set default selection in dropdown
        $('#newStatus').val(currentStatus);

        // Hide all reason fields initially
        $('.status-reason').hide();
    });

    // Show/hide reason fields based on status selection
    $('#newStatus').change(function() {
        const newStatus = $(this).val();

        // Hide all reason fields first
        $('.status-reason').hide();

        // Show relevant fields
        if (newStatus === 'cancelled') {
            $('#cancellationReason').show();
        } else if (newStatus === 'completed') {
            $('#completionNotes').show();
        }
    });

    // Confirm status change
    $('#confirmStatusChange').click(function() {
        const bookingId = $('#bookingId').val();
        const currentStatus = $('#currentStatus').val();
        const newStatus = $('#newStatus').val();
        const reason = $('#reason').val();
        const notes = $('#notes').val();

        // Validate if cancellation reason is provided when status is cancelled
        if (newStatus === 'cancelled' && !reason.trim()) {
            toastr.error('Please provide a cancellation reason');
            return;
        }

        $.ajax({
            url: `/car/${bookingId}/status`,
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                status: newStatus,
                cancellation_reason: reason,
                completion_notes: notes
            },
            beforeSend: function() {
                $('#confirmStatusChange').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Updating...');
            },
            success: function(response) {
                if (response.success) {
                    // Close modal
                    $('#statusModal').modal('hide');

                    // Update status badge in table
                    const badge = $(`#booking-row-${bookingId} .status-badge`);
                    badge.removeClass().addClass(`status-badge status-${newStatus}`)
                         .text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));

                    // Highlight the updated row
                    $(`#booking-row-${bookingId}`).addClass('highlight-row');
                    setTimeout(() => {
                        $(`#booking-row-${bookingId}`).removeClass('highlight-row');
                    }, 2000);

                    // Show success message
                    toastr.success(response.message || 'Booking status updated successfully');

                    // Reset modal fields
                    $('#reason').val('');
                    $('#notes').val('');
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.message || 'Error updating booking status');
            },
            complete: function() {
                $('#confirmStatusChange').prop('disabled', false).html('<i class="fas fa-check-circle mr-1"></i> Update Status');
            }
        });
    });

    // Toastr notifications
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000"
    };

    @if(session('success'))
        toastr.success('{{ session('success') }}');
    @endif

    @if(session('error'))
        toastr.error('{{ session('error') }}');
    @endif
});
</script>
@endsection
