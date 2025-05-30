<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\Car;
use App\Models\CustFile;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AccountingExport implements FromView
{

    protected $customerId;

    public function __construct($customerId)
    {
        $this->customerId = $customerId;
    }
    public function View(): View
    {
        $customer = Customer::with([
            'bookings.booking_details',
            'cars',
            'files'
        ])->findOrFail($this->customerId);

        $totalBooking = $customer->bookings->sum('total');
        $totalCar = $customer->cars->sum('total');
        $totalPayments = $customer->files->sum('paid');
        $dueBalance = ($totalBooking + $totalCar) - $totalPayments;

        $customerData = [
            'id' => $customer->id,
            'name' => $customer->name,
            'total_booking' => $totalBooking,
            'total_car' => $totalCar,
            'total_payments' => $totalPayments,
            'due_balance' => $dueBalance,
            'status' => $dueBalance <= 0 ? 'Paid' : 'Due',
            'currency' => $customer->bookings->first()->currency ?? $customer->cars->first()->currency ?? 'USD',
            'last_payment' => $customer->files->max('updated_at'),
            'bookings' => $customer->bookings,
            'cars' => $customer->cars,
            'files' => $customer->files
        ];

        return view('reports.accounting', [
            'customer' => $customerData
        ]);
    }
}
