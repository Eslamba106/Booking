<?php

namespace App\Exports;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class MonthlyHouse implements FromView
{

    public function View(): view
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return view('reports.monthly_house', [
            'bookings' => Booking::with('booking_details')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->latest()
                ->get(),
        ]);
    }
}
