<?php

namespace App\Http\Controllers;

use App\Exports\AccountingExport;
use App\Exports\BrokergExport;
use App\Exports\ComingSoonExport;
use App\Exports\ComissionExport;
use App\Exports\InvoicesExport;
use App\Exports\MonthlyHouse;
use App\Exports\PaymentExport;
use App\Models\Booking;
use App\Models\Broker;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function export(Request $request)
    {
        $filters = $request->only(['status', 'date_from', 'date_to', 'date_range', 'customer']);
        return Excel::download(new InvoicesExport($filters), 'car_report_' . now()->format('Y-m-d') . '.xlsx');
    }

    public function MonthlyHouse(Request $request)
    {
        $filters = $request->only(['customer', 'hotel_id', 'status', 'date_from', 'date_to']);

        // تحديد عنوان التقرير بناءً على الفلترة
        $title = 'Bookings Report';

        if (isset($filters['date_from']) && isset($filters['date_to'])) {
            $title = 'Bookings from ' . $filters['date_from'] . ' to ' . $filters['date_to'];
        } elseif (isset($filters['date_from'])) {
            $title = 'Bookings from ' . $filters['date_from'];
        } elseif (isset($filters['date_to'])) {
            $title = 'Bookings until ' . $filters['date_to'];
        }

        if (isset($filters['hotel_id'])) {
            $hotel = Hotel::find($filters['hotel_id']);
            $title .= $hotel ? ' - ' . $hotel->name : '';
        }

        return Excel::download(new MonthlyHouse($filters, $title), 'bookings_report_' . now()->format('Y-m-d') . '.xlsx');
    }
    public function ComissionExport(Request $request)
    {
        $filters = $request->only([
            'customer',
            'hotel',
            'booking_details',
            'booking_unit',
            'broker',
            'status',
            'date_from',
            'date_to',
            'hotel_id'
        ]);

        return Excel::download(new ComissionExport($filters), 'comission_report_' . now()->format('Y-m-d') . '.xlsx');
    }
    public function AccountingExport($id)
    {
        return Excel::download(new AccountingExport($id), 'accounting_customer_' . $id . '.xlsx');
    }
    public function index()
    {
        $brokers = Broker::all();
        $hotels = Hotel::all();

        $bookings = Booking::with(['customer', 'hotel', 'booking_details', 'booking_unit', 'broker'])
            ->latest()
            ->paginate(20); // أو get() إذا كنت تريد جميع النتائج بدون pagination

        return view('general.brokers.brokershow', compact('brokers', 'hotels', 'bookings'));
    }
    //broker report
    public function filter(Request $request)
    {
        $brokers = Broker::all();
        $hotels = Hotel::all();

        $query = Booking::with(['customer', 'hotel', 'booking_details', 'booking_unit', 'broker']);

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('arrival_date', [$request->date_from, $request->date_to]);
        }

        if ($request->filled('broker_id')) {
            $query->where('broker_id', $request->broker_id);
        }

        if ($request->filled('hotel_id')) {
            $query->where('hotel_id', $request->hotel_id);
        }

        $bookings = $query->latest()->paginate(20);

        return view('general.brokers.all_brokers', compact('brokers', 'hotels', 'bookings'));
    }

    public function BrokergExport(Request $request)
    {
        $filters = $request->only(['date_from', 'date_to', 'broker_id', 'hotel_id']);

        return Excel::download(new BrokergExport($filters), 'broker_report_' . now()->format('Y-m-d') . '.xlsx');
    }

    public function ComingSoonExport(Request $request)
    {
        $filters = $request->only([
            'customer',
            'hotel',
            'booking_details',
            'booking_unit',
            'broker',
            'status',
            'date_from',
            'date_to',
            'hotel_id'
        ]);

        return Excel::download(new ComingSoonExport($filters), 'coming_soon_report_' . now()->format('Y-m-d') . '.xlsx');
    }
    public function PaymentExport($id)
    {
        return Excel::download(new PaymentExport($id), 'payment_report_' . now()->format('Y-m-d') . '.xlsx');
    }
}
