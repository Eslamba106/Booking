<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentExport implements FromView
{
    protected $customerId;

    public function __construct($customerId)
    {
        $this->customerId = $customerId;
    }

    public function view(): View
    {
        $payments = Payment::with(['customer', 'user'])
            ->where('customer_id', $this->customerId)
            ->orderBy('payment_date', 'desc')
            ->get()
            ->groupBy(function ($payment) {
                return $payment->payment_date;
            });

        return view('reports.payment', [
            'paymentsGrouped' => $payments,
        ]);
    }
}
