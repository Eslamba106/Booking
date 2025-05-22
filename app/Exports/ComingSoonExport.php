<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ComingSoonExport implements FromView
{
       public function View(): View
    {
        return view('reports.coming', [
            'bookings' =>  Booking::with(['customer', 'hotel', 'booking_details', 'booking_unit', 'broker'])->get(),


        ]);
    }
}
