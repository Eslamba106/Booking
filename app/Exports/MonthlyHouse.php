<?php

namespace App\Exports;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class MonthlyHouse implements FromView
{

    //     public function View(): view
    //     {
    //         $currentMonth = Carbon::now()->month;
    //         $currentYear = Carbon::now()->year;

    //         return view('reports.monthly_house', [
    //             'bookings' => Booking::with('booking_details')
    //                 ->whereMonth('created_at', $currentMonth)
    //                 ->whereYear('created_at', $currentYear)
    //                 ->latest()
    //                 ->get(),
    //         ]);
    //     }
    // }
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $query = Booking::with(['hotel', 'booking_details', 'booking_unit']);


        if (!empty($this->filters)) {

            if (isset($this->filters['status']) && $this->filters['status'] != '') {
                $query->where('status', $this->filters['status']);
            }


            if (isset($this->filters['date_from']) && $this->filters['date_from'] != '') {
                $query->whereDate('arrival_date', '>=', $this->filters['date_from']);
            }


            if (isset($this->filters['date_to']) && $this->filters['date_to'] != '') {
                $query->whereDate('arrival_date', '<=', $this->filters['date_to']);
            }
            if (isset($this->filters['hotel_id'])) {
                $query->where('hotel_id', $this->filters['hotel_id']);
            }





            if (isset($this->filters['customer']) && $this->filters['customer'] != '') {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->filters['customer'] . '%');
                });
            }
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        return view('reports.monthly_house', [
            'bookings' => $bookings
        ]);
    }
}
