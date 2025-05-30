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
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $query = Car::with(['customer', 'category', 'user']);


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


            if (isset($this->filters['date_range']) && $this->filters['date_range'] != '') {
                $today = now();

                switch ($this->filters['date_range']) {
                    case 'today':
                        $query->whereDate('arrival_date', $today);
                        break;
                    case 'this_week':
                        $query->whereBetween('arrival_date', [
                            $today->copy()->startOfWeek(),
                            $today->copy()->endOfWeek()
                        ]);
                        break;
                    case 'this_month':
                        $query->whereBetween('arrival_date', [
                            $today->copy()->startOfMonth(),
                            $today->copy()->endOfMonth()
                        ]);
                        break;
                    case 'next_month':
                        $query->whereBetween('arrival_date', [
                            $today->copy()->addMonth()->startOfMonth(),
                            $today->copy()->addMonth()->endOfMonth()
                        ]);
                        break;
                }
            }


            if (isset($this->filters['customer']) && $this->filters['customer'] != '') {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->filters['customer'] . '%');
                });
            }
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        return view('reports.mothly_reports', [
            'bookings' => $bookings
        ]);
    }
}
