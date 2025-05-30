<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\Car;
use App\Models\CustFile;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AccountingExport implements FromView
{

    public function View(): View
    {
        return view('reports.accounting', [
            "files" => CustFile::with([
                'customer',
                'user',
                'cust_file_items.related' => function ($morphTo) {
                    $morphTo->morphWith([
                        Booking::class => ['booking_details'],
                        Car::class,
                    ]);
                }
            ])->latest()->get()


        ]);
    }
}
