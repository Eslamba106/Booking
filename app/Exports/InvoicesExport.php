<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\invoice\Invoice;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;

class InvoicesExport implements FromView
{

     public function view(): View
    {
          $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;
        return view('reports.mothly_reports', [
            'cars' => Car::with('customer')
            ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->latest()
                ->get(),
        ]);


    }

}
