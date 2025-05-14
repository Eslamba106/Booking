@extends('layouts.dashboard')
@section('title')
    {{ __('Booking Details') }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Booking Details #{{ $booking->booking_no }}</h4>

                <div class="page-title-right">
                    <a href="{{ route('admin.booking') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line align-bottom me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Booking Info -->
        <div class="col-lg-6">


            <div class="card">
                <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">

                    <h5 class="card-title mb-0 text-primary"><i class="ri-hotel-line align-middle me-2"></i><h4 class="mb-0">{{ __('booking.booking_details') }}</h4></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th width="40%">Customer:</th>
                                    <td>{{ $booking->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Arrival Date:</th>
                                    <td>{{ date('d M Y', strtotime($booking->arrival_date)) }}</td>
                                </tr>
                                <tr>
                                    <th>Check-out Date:</th>
                                    <td>{{ date('d M Y', strtotime($booking->check_out_date)) }}</td>
                                </tr>
                                <tr>
                                    <th>Duration:</th>
                                    <td>{{ $booking->days_count }} days</td>
                                </tr>
                                <tr>
                                    <th>Total Price:</th>
                                    <td>{{ number_format($booking->price, 2) }} {{ $booking->currency }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guest Details -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-info bg-opacity-10 border-bottom border-info border-opacity-25">
                    <h5 class="card-title mb-0 text-info"><i class="ri-group-line align-middle me-2"></i><h4 class="mb-0">{{ __('Guest Details') }}</h4></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th width="40%">Adults:</th>
                                    <td>{{ $booking->booking_details->adults_count ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <th>Children:</th>
                                    <td>{{ $booking->booking_details->childerns_count ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <th>Infants:</th>
                                    <td>{{ $booking->booking_details->babes_count ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <th>Total Guests:</th>
                                    <td>{{ $booking->booking_details->total_person_count ?? 0 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Hotel & Unit Info -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-success bg-opacity-10 border-bottom border-success border-opacity-25">
                    <h5 class="card-title mb-0 text-success"><i class="ri-building-line align-middle me-2"></i> <h4 class="mb-0">{{ __('Hotel & Unit Information') }}</h4></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th width="40%">Hotel:</th>
                                    <td>{{ $booking->hotel->name }}</td>
                                </tr>
                                <tr>
                                    <th>Unit Type:</th>
                                    <td>{{ $booking->booking_unit->unit_type }}</td>
                                </tr>
                                <tr>
                                    <th>Meal Plan:</th>
                                    <td>{{ $booking->booking_details->food_type }}</td>
                                </tr>
                                <tr>
                                    <th>Number of Units:</th>
                                    <td>{{ $booking->booking_details->units_count ?? 1 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Services -->
        @if($booking->service)
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning border-opacity-25">
                    <h5 class="card-title mb-0 text-warning"><i class="ri-service-line align-middle me-2"></i> <h4 class="mb-0">{{ __('Additional Services') }}</h4></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th width="40%">Service:</th>
                                    <td>{{ $booking->service->name }}</td>
                                </tr>
                                <tr>
                                    <th>Quantity:</th>
                                    <td>{{ $booking->service->qyt }}</td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td>{{ number_format($booking->service->price, 2) }} {{ $booking->currency }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Financial Summary -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-purple bg-opacity-10 border-bottom border-purple border-opacity-25">
                    <h5 class="card-title mb-0 text-purple"><i class="ri-money-dollar-circle-line align-middle me-2"></i> <h4 class="mb-0">{{ __('Financial Summary') }}</h4></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th width="30%">Subtotal:</th>
                                    <td>{{ number_format($booking->sub_total, 2) }} {{ $booking->currency }}</td>
                                </tr>
                                <tr>
                                    <th>Commission ({{ $booking->commission_type }}):</th>
                                    <td>{{ number_format($booking->commission_amount, 2) }} {{ $booking->currency }}</td>
                                </tr>
                                <tr>
                                    <th>Broker Amount:</th>
                                    <td>{{ number_format($booking->broker_amount, 2) }} {{ $booking->currency }}</td>
                                </tr>
                                <tr>
                                    <th>Total Earned:</th>
                                    <td>{{ number_format($booking->earned, 2) }} {{ $booking->currency }}</td>
                                </tr>
                                <tr class="fw-bold">
                                    <th>Grand Total:</th>
                                    <td>{{ number_format($booking->total, 2) }} {{ $booking->currency }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.booking.edit', $booking->id) }}" class="btn btn-warning">
                    <i class="ri-edit-line align-bottom me-1"></i> Edit Booking
                </a>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                    <i class="ri-close-circle-line align-bottom me-1"></i> Cancel Booking
                </button>
                {{-- <a href="{{ route('admin.booking.invoice', $booking->id) }}" class="btn btn-info">
                    <i class="ri-file-text-line align-bottom me-1"></i> Generate Invoice
                </a> --}}
            </div>
        </div>
    </div>
</div>

<!-- Cancel Booking Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Confirm Cancellation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this booking? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="{{ route('admin.booking.cancel', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Confirm Cancellation</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-header {
        padding: 0.75rem 1.25rem;
    }
    .table th {
        font-weight: 600;
        color: #495057;
    }
    .table td {
        color: #6c757d;
    }
</style>
@endpush
