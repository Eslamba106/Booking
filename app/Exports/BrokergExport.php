<?php

namespace App\Exports;

use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class BrokergExport implements FromView
{



    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $query = Booking::with(['customer', 'hotel', 'booking_details', 'booking_unit', 'broker']);

        if (!empty($this->filters)) {
            if (isset($this->filters['date_from']) && isset($this->filters['date_to'])) {
                $query->whereBetween('arrival_date', [
                    $this->filters['date_from'],
                    $this->filters['date_to']
                ]);
            }

            if (isset($this->filters['broker_id'])) {
                $query->where('broker_id', $this->filters['broker_id']);
            }

            if (isset($this->filters['hotel_id'])) {
                $query->where('hotel_id', $this->filters['hotel_id']);
            }
        }

        $bookings = $query->get();

        return view('reports.broker', [
            'bookings' => $bookings
        ]);
    }
}
