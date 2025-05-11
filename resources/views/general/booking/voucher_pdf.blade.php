<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Voucher</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #003b3b;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .voucher-container {
            width: 100%;
            padding: 20px 40px;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
        }

        .header img {
            height: 60px;
            display: block;
            margin: 0 auto 10px;
        }

        .row-flex {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 10px;
                }



        .title {
            text-align: center;
            margin: 30px 0 10px;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .divider {
            border-top: 1px solid #003b3b;
            margin: 10px 0 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td {
            padding: 6px 10px;
            vertical-align: top;
            width: 50%;
        }

        .hotel-address {
            text-align: center;
            font-weight: bold;
            margin-top: 30px;
        }

        .contact {
            font-size: 11px;
            text-align: center;
            margin-top: 20px;
            color: #003b3b;
        }
    </style>
</head>
<body>
    <div class="voucher-container">
        <!-- Header -->
        <div class="header">
            <img src="{{ public_path('images/logo.png') }}" alt="Company Logo">

            <div class="row-flex">
                <table style="width: 100%;">
                    <tr>
                        <!-- Left Column -->
                        <td style="width: 50%; text-align: left; vertical-align: top;">
                            <p><strong>Guest Name:</strong> {{ $booking->customer->name }}</p>
                            <p><strong>Phone:</strong> {{ $booking->customer->phone ?? '---' }}</p>
                            <p><strong>Email:</strong> {{ $booking->customer->email ?? '---' }}</p>
                        </td>

                        <!-- Right Column -->
                        <td style="width: 50%; text-align: right; vertical-align: top; padding-right: 20%;">
                            <p><strong>Date        :</strong> {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
                            <p><strong>Booking Date:</strong> {{ $booking->created_at->format('F d, Y') }}</p>
                            <strong>Supplier name:</strong> {{ $booking->user->name }}<br>
                            <p><strong>Ref No.     :</strong> {{ $booking->booking_no }}</p>
                        </td>
                    </tr>
                </table>
            </div>

        </div>


        <!-- Title -->
        <div class="title">HOTEL VOUCHER</div>
        <div class="divider"></div>

        <!-- Booking Info -->
        <table class="info-table">
            <tr>
                <td><strong>Hotel:</strong> {{ $booking->hotel->name }}</td>
                <td><strong>Room Type:</strong> {{ $booking->hotel->unit_types->pluck('name')->join(', ') }}</td>
            </tr>
            <tr>
                <td><strong>Check-in Date:</strong> {{ $booking->arrival_date }}</td>
                <td><strong>Check-out Date:</strong> {{ $booking->check_out_date }}</td>
            </tr>
            <tr>
                <td><strong>Nights:</strong> {{ $booking->days_count }}</td>
                <td><strong>Right to Cancelation:</strong> {{ $booking->canceled_period }}</td>
            </tr>
            <tr>
                <td><strong>No. of Room(s):</strong> {{ $booking->booking_details->units_count }}</td>
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
    </div>
</body>
</html>
