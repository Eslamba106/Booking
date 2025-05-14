@extends('layouts.dashboard')
@section('title')
    {{ __('roles.booking_management') }}
@endsection

@section('content')
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #003b3b; line-height: 1.5; }
        .voucher-container { width: 100%; padding: 30px; }
        .header, .footer { text-align: center; }
        .header img { height: 60px; }
        .title { text-align: center; margin: 20px 0; font-size: 20px; font-weight: bold; }
        .row-flex { display: flex; justify-content: space-between; margin-top: 20px; font-size: 12px; }
        .info-table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .info-table td { padding: 6px 10px; vertical-align: top; }
        .divider { border-top: 1px solid #000; margin: 20px 0; }
        .hotel-address { text-align: center; font-weight: bold; margin-top: 30px; }
        .contact { font-size: 11px; text-align: center; margin-top: 15px; }
    </style>

    <div class="voucher-container">
        <!-- Header -->
        <div class="header">
            <img src="{{ public_path('images/logo.png') }}" alt="Company Logo">
            <div class="row-flex">
                <div>
                    <strong>Guest Name:</strong> {{ $booking->customer->name }}<br>
                    <strong>Phone:</strong> {{ $booking->customer->phone ?? '---' }}<br>
                    <strong>Email:</strong> {{ $booking->customer->email ?? '---' }}
                </div>
                <div style="text-align: right;">
                    <strong>Date:</strong> {{ \Carbon\Carbon::now()->format('F d, Y') }}<br>
                    <strong>Booking Date:</strong> {{ $booking->created_at->format('F d, Y') }}<br>
                    <strong>Supplier name:</strong> {{ $booking->user->name }}<br>
                    <strong>Ref No.:</strong> {{ $booking->booking_no }}
                </div>
            </div>
        </div>

        <!-- Title -->
        <div class="title">HOTEL VOUCHER</div>
        <div class="divider"></div>

        <!-- Booking Info -->
        <table class="info-table">
            <tr>
                <td><strong>Hotel:</strong> {{ $booking->hotel->name }}</td>
            </tr>
            <tr>
                <td><strong>Room Type:</strong> {{ $booking->hotel->unit_types->pluck('name')->join(', ') }}</td>
            </tr>
            <tr>
                <td><strong>Check-in Date:</strong> {{ $booking->arrival_date }}</td>
                <td><strong>Check-in Date:</strong> {{ $booking->check_out_date }}</td>
            </tr>
            <tr>
                <td><strong>Nights:</strong> {{ $booking->days_count }}</td>
                <td><strong>Right to Cancelation:</strong> {{ $booking->canceled_period }}</td>
            </tr>
            <tr>
                <td><strong>No. of Room(s):</strong> {{ $booking->booking_details->units_count }}</td>
            </tr>
            <tr>
                <td><strong>Confirmation No.:</strong> {{ $booking->booking_no }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Special Request:</strong> {{ $booking->special_request ?? '---' }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- Hotel Address -->
        <div class="hotel-address">
            HOTEL ADDRESS:<br>
            {{ $booking->hotel->country->name ?? '---' }},
            {{ $booking->hotel->city ?? '---' }}<br>
            PHONE: {{ $booking->hotel->phone ?? '---' }}
        </div>

        <!-- Footer -->
        <div class="contact">
            <p>hello@endlesstravels.com | www.endlesstravels.me</p>
            <p>+965 22 0 22 555 | @endlesstravels.me</p>

        </div>
        <div class="row-flex" style="text-align: right;">
            <a href="{{ route('admin.booking', $booking->id) }}"
                class="btn btn-primary" title="@lang('download')">{{ __('Back') }} </a>
                <a href="{{ route('booking.voucher.pdf', $booking->id) }}"
                    class="btn btn-primary" title="@lang('download')">{{ __(' Download PDF') }} </a>
        </div>

    </div>



@endsection
