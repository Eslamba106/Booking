<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Client File PDF</title>
    <style>
        @font-face {
            font-family: 'AlMohanad';
            {{--  src: url('fonts/ae_AlMohanad.ttf') format('truetype');  --}}
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'Helvetica', 'AlMohanad', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            width: 100%;
            overflow: auto;
            margin-bottom: 20px;
        }
        .header .logo {
            float: left;
            width: 200px;
        }
        .header .company-details {
            float: right;
            text-align: right;
        }
        .guest-details {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
        .booking-info {
            float: right;
            text-align: right;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .notes {
            text-align: left;
            direction: ltr;
        }
        .terms {
            font-size: 10px;
            text-align: left;
            direction: ltr;
        }
        .signature {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header" style="width: 100%; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div class="logo" style="flex: 1;">
                    <img src="{{ asset('landingpage/images/logo.png') }}" alt="MaviStay Logo" style="width: 150px;">
                </div>
                <div class="company-details" style="flex: 2; text-align: right; font-size: 14px;">
                    <strong>Company:</strong> Agency Ltd Company<br>
                    <strong>Adresse:</strong> Yeni Yol Cd., 34387 Sisli/Istanbul<br>
                    <strong>TEL:</strong> +90 554 017 22 22 - +90 505 895 52 95
                    <br>
                        <strong>Booking Date:</strong> {{ $file->created_at->format('d/m/Y') }}<br>
                        <strong>Ref No:</strong> {{ $file->id }}<br>
                        <strong>Supplier Name:</strong> {{ $file->user->name ?? 'N/A' }}

                </div>

            </div>

            <div style="width: 100%; display: flex; justify-content: space-between; margin-top: 20px;">
                <div style="width: 48%; text-align: left;" class="guest-details">
                    <strong>Guest Name:</strong> {{ $file->customer->name }}<br>
                    <strong>Phone Number:</strong> {{ $file->customer->phone }}<br>
                    <strong>Email:</strong> {{ $file->customer->email }}
                </div>

            </div>


        <h4>Accommodation reservation details</h4>
        <table>
            <thead>
                <tr>
                    <th>Hotel Name</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Right To Cancellation</th>
                    <th>Rooms</th>
                    <th>Nights</th>
                    <th>Room price</th>
                    <th>Total</th>
                    <th>Selling Currency</th>
                    <th>ROOM Type</th>
                    <th>Meals</th>
                    <th>Conf.no</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->hotel->name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->arrival_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</td>
                        <td>{{ $booking->canceled_period ?? 'N/A' }}</td>
                        <td>{{ $booking->booking_details->units_count ?? 0 }}</td>
                        <td>{{ $booking->arrival_date && $booking->check_out_date ? (new \Carbon\Carbon($booking->check_out_date))->diffInDays(new \Carbon\Carbon($booking->arrival_date)) : 0 }}</td>
                        <td>{{ $booking->price ?? 0 }}</td>
                        <td>{{ $booking->total ?? 0 }}</td>
                        <td>{{ $booking->currency ?? $file->currency }}</td>
                        <td>{{ $booking->booking_unit->unit_type->name ?? 'N/A' }}</td>
                        <td>{{ $booking->booking_details->food_type ?? 'N/A' }}</td>
                        <td>{{ $booking->booking_details->conf_no ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($cars->count() > 0)
        <h4>Car Rental Details</h4>
        <table>
            <thead>
                <tr>
                    <th>Car Type</th>
                    <th>Pickup Date</th>
                    <th>Return Date</th>
                    <th>Pickup Time</th>
                    <th>Return Time</th>
                    <th>From Location</th>
                    <th>To Location</th>
                    <th>Days</th>
                    <th>Daily Price</th>
                    <th>Total Amount</th>
                    <th>Currency</th>

                </tr>
            </thead>
            <tbody>
                @foreach($cars as $car)
                    <tr>
                        <td>{{ $car->category->category ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($car->arrival_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($car->leave_date)->format('d/m/Y') }}</td>
                        <td>{{ $car->arrival_time ?? 'N/A' }}</td>
                        <td>{{ $car->leave_time ?? 'N/A' }}</td>
                        <td>{{ $car->from_location ?? 'N/A' }}</td>
                        <td>{{ $car->to_location ?? 'N/A' }}</td>
                        <td>{{ $car->days_count ?? 0 }}</td>
                        <td>{{ $car->category->price_per_day ?? 0 }}</td>
                        <td>{{ $car->total ?? 0 }}</td>
                        <td>{{ $car->currency ?? $file->currency }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <h4>Account Details</h4>
        <table style="width: 100%;">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <table>
                        <thead>
                            <tr>
                                <th>Account Details</th>
                                <th>USD</th>
                                <th>EUR</th>
                                <th>TRY</th>
                            </tr>
                        </thead>
                        @php
                            // Calculate totals from the actual file items
                            $bookingTotals = $file->cust_file_items
                            ->where('related_type', 'App\\Models\\Booking')
                            ->filter(fn($item) => $item->related)
                            ->groupBy(fn($item) => strtoupper($item->related->currency ?? 'USD'))
                            ->map(fn($group) => $group->sum(fn($item) => $item->related->total ?? 0));

                            $carTotals = $file->cust_file_items
                            ->where('related_type', 'App\\Models\\Car')
                            ->filter(fn($item) => $item->related)
                            ->groupBy(fn($item) => strtoupper($item->related->currency ?? 'USD'))
                            ->map(fn($group) => $group->sum(fn($item) => $item->related->total ?? 0));

                            $paymentTotals = $file->payments->groupBy(function($payment) {
                                return strtoupper(trim($payment->currency ?? 'USD'));
                            })->map(fn($group) => $group->sum('amount'));
                        @endphp
                        <tr>
                            <td>Total Hotels</td>
                            <td style="text-align: right;">{{ number_format($bookingTotals->get('USD', 0), 2) }}</td>
                            <td style="text-align: right;">{{ number_format($bookingTotals->get('EURO', 0), 2) }}</td>
                            <td style="text-align: right;">{{ number_format($bookingTotals->get('TRY', 0), 2) }}</td>
                        </tr>
                        <tr>
                            <td>Car Total</td>
                            <td style="text-align: right;">{{ number_format($carTotals->get('USD', 0), 2) }}</td>
                            <td style="text-align: right;">{{ number_format($carTotals->get('EURO', 0), 2) }}</td>
                            <td style="text-align: right;">{{ number_format($carTotals->get('TRY', 0), 2) }}</td>
                        </tr>
                        <tr>
                            <td>Total Extra Service</td>
                            <td style="text-align: right;">0.00</td>
                            <td style="text-align: right;">0.00</td>
                            <td style="text-align: right;">0.00</td>
                        </tr>
                        <tr>
                            <td>Advanced Payment</td>
                            <td style="text-align: right;">{{ number_format($paymentTotals->get('USD', 0), 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paymentTotals->get('EURO', 0), 2) }}</td>
                            <td style="text-align: right;">{{ number_format($paymentTotals->get('TRY', 0), 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Balance Due</strong></td>
                            <td style="text-align: right;"><strong>{{ number_format($bookingTotals->get('USD', 0) + $carTotals->get('USD', 0) - $paymentTotals->get('USD', 0), 2) }}</strong></td>
                            <td style="text-align: right;"><strong>{{ number_format($bookingTotals->get('EURO', 0) + $carTotals->get('EUR', 0) - $paymentTotals->get('EUR', 0), 2) }}</strong></td>
                            <td style="text-align: right;"><strong>{{ number_format($bookingTotals->get('TRY', 0) + $carTotals->get('TRY', 0) - $paymentTotals->get('TRY', 0), 2) }}</strong></td>
                        </tr>
                        <tr style="background-color: #e6f3ff;">
                            <td><strong>GRAND TOTAL</strong></td>
                            <td style="text-align: right;"><strong>{{ number_format($bookingTotals->get('USD', 0) + $carTotals->get('USD', 0), 2) }}</strong></td>
                            <td style="text-align: right;"><strong>{{ number_format($bookingTotals->get('EURO', 0) + $carTotals->get('EUR', 0), 2) }}</strong></td>
                            <td style="text-align: right;"><strong>{{ number_format($bookingTotals->get('TRY', 0) + $carTotals->get('TRY', 0), 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                </td>
                <td style="width: 40%; vertical-align: top;" class="notes">
                    <strong>The notes</strong><br>
                    The company reserves the right to cancel reservations without notice if the required payment is not received within six hours of notification.
                    @if($file->payments->isEmpty())
                        <div style="border: 2px solid red; color: red; padding: 10px; margin-top: 10px; display: inline-block;">
                            <strong>NO PAYMENTS</strong>
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        <div class="terms">
             <ol>
                <li><strong>Cancellation and Change Policy:</strong> Clients must provide written notice before the hotel's cancellation deadline. Refunds will be issued minus any transfer fees.</li>
                <li><strong>Cancellation Notification:</strong> To validate the cancellation, clients must use the same communication channel through which the booking was confirmed.</li>
                <li><strong>Late Cancellation:</strong> Cancellations made after the free cancellation period will be subject to the hotel's specific cancellation policy.</li>
                <li><strong>Non-Refundable Bookings:</strong> No cancellations or changes are permitted for non-refundable bookings. Payment is required on the day of confirmation.</li>
                <li><strong>Card Refunds:</strong> For payments made by card, refunds will be processed according to the timeline provided by the client's bank.</li>
                <li><strong>Extenuating Circumstances:</strong> In cases of cancellation due to personal emergencies (e.g., death, illness), the cancellation policy will be applied based on the date of the request.</li>
                <li><strong>Same-Day Changes:</strong> No changes or cancellations are accepted on the day of arrival. Any modifications must be requested before the free cancellation period expires.</li>
                <li><strong>Post-Arrival Changes:</strong> The company will act in the client's best interest for any requested changes, extensions, or cancellations after arrival, in accordance with hotel policies.</li>
            </ol>
        </div>

        <div class="signature">
            Signature: _________________________
        </div>
    </div>
</body>
</html>
