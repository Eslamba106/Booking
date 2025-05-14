@extends('layouts.dashboard')

@section('title')
    Booking Details #{{ $booking->id }}
@endsection

@section('css')
<style>
    .booking-details-card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .detail-header {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px 8px 0 0;
        border-bottom: 1px solid #eee;
    }

    .detail-body {
        padding: 20px;
    }

    .detail-row {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-label {
        font-weight: 600;
        color: #555;
    }

    .detail-value {
        font-weight: 500;
    }

    .status-badge {
        font-size: 0.9rem;
        padding: 6px 12px;
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
        margin-right: 10px;
    }

    .car-image {
        width: 100%;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline:before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-item:before {
        content: '';
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #007bff;
    }

    .timeline-date {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 6px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="page-title">Booking Details #{{ $booking->id }}</h3>
                <div>
                    <a href="{{ route('car.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Bookings
                    </a>
                    <a href="{{ route('car.edit', $booking->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i> Edit Booking
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card booking-details-card">
                <div class="detail-header">
                    <h4 class="mb-0">Booking Information</h4>
                </div>
                <div class="detail-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">Booking ID</div>
                                <div class="detail-value">#{{ $booking->id }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Customer Name</div>
                                <div class="detail-value">{{ $booking->customer->name }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Customer Email</div>
                                <div class="detail-value">{{ $booking->customer->email }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Customer Phone</div>
                                <div class="detail-value">{{ $booking->customer->phone ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">Booking Status</div>
                                <div class="detail-value">
                                    <span class="badge badge-pill
                                        @if($booking->status == 'pending') badge-warning
                                        @elseif($booking->status == 'approved') badge-success
                                        @elseif($booking->status == 'rejected') badge-danger
                                        @else badge-info @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Booking Date</div>
                                <div class="detail-value">{{ $booking->created_at->format('d M Y, h:i A') }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Last Updated</div>
                                <div class="detail-value">{{ $booking->updated_at->format('d M Y, h:i A') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card booking-details-card mt-4">
                <div class="detail-header">
                    <h4 class="mb-0">Car & Rental Information</h4>
                </div>
                <div class="detail-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">Car Category</div>
                                <div class="detail-value">{{ $booking->category->category }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Car Model</div>
                                <div class="detail-value">{{ $booking->category->model }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Daily Rate</div>
                                <div class="detail-value">{{ number_format($booking->category->price_per_day, 2) }} $</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">Pickup Date & Time</div>
                                <div class="detail-value">
                                    {{ \Carbon\Carbon::parse($booking->arrival_date)->format('d M Y') }} at {{ $booking->arrival_time }}
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Return Date & Time</div>
                                <div class="detail-value">
                                    {{ \Carbon\Carbon::parse($booking->leave_date)->format('d M Y') }} at {{ $booking->leave_time }}
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Rental Duration</div>
                                <div class="detail-value">
                                    {{ $booking->days_count }} days
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    @endif

    @if(session('error'))
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'OK'
    });
    @endif
</script>
@endsection
