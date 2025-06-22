<?php

namespace App\Http\Controllers;

use App\Models\Booking;

use App\Models\Car;

use App\Models\CustFile;
use App\Models\CustFileItem;
use App\Models\Customer;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\ClientFileReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CustFileController extends Controller
{
    public function index(Request $request)
    {
        $query = CustFile::with(['customer', 'cust_file_items']);


        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }


        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('create_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('create_at', '<=', $request->date_to);
        }


        if ($request->has('date_range') && $request->date_range != '') {
            $today = Carbon::today();

            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('create_at', $today);
                    break;
                case 'this_week':
                    $query->whereBetween('create_at', [
                        $today->copy()->startOfWeek(),
                        $today->copy()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereBetween('create_at', [
                        $today->copy()->startOfMonth(),
                        $today->copy()->endOfMonth()
                    ]);
                    break;
                case 'next_month':
                    $query->whereBetween('create_at', [
                        $today->copy()->addMonth()->startOfMonth(),
                        $today->copy()->addMonth()->endOfMonth()
                    ]);
                    break;
            }
        }


        if ($request->has('customer') && $request->customer != '') {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer . '%');
            });
        }

        $files = $query->orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            return view('general.car.bookings_table', compact('files'))->render();
        }

        return view('general.cust_files.index', compact('files'));
    }
    public function index_file()
    {

        return view('general.cust_files.createfile', compact('files'));
    }

    public function create_file()
    {
        $customers = Customer::with(['bookings', 'cars'])->get();
        $files = CustFile::with('customer')->get();
        return view('general.cust_files.createfile', compact('customers', 'files'));
    }

    public function store_file(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'name' => 'nullable|string',
            'paid' => 'nullable',
            'remain' => 'nullable',
            'total' => 'nullable',
            'currency' => 'required|string|in:USD,EUR,TRY',

        ]);
        $files = CustFile::create([
            'customer_id' => $request->customer_id,
            'name' => $request->name,
            'paid' => $request->paid ?? 0,
            'total' => $request->total ?? 0,
            'remain' => $request->remain ?? 0,
            'currency' => $request->currency ?? 'USD',
            'user_id' => $request->user_id,
        ]);
        return redirect()->route('show.all.file')->with('message', 'file successfully created');
    }

    public function show_all()
    {
        $files = CustFile::with('customer')->latest()->paginate();
        return view('general.cust_files.show_all', compact('files'));
    }

    public function show_file($id)
    {
        $file = CustFile::find($id);

        $items = CustFileItem::with('related')->where('cust_file_id', $id)->get();


        $bookings = new Collection(
            $items->filter(fn($item) => $item->related_type == Booking::class)->pluck('related')
        );
        $bookings->load(['customer', 'hotel']);

        $cars = new Collection(
            $items->filter(fn($item) => $item->related_type == Car::class)->pluck('related')
        );


        return view('general.cust_files.create', compact('file', 'bookings', 'cars'));
    }


    public function show($id)
    {
        $files = CustFile::where('customer_id', $id)->latest()->paginate();
        return view('general.cust_files.show', compact('files'));
    }

    public function destroy($id)
    {
        $file = CustFile::findOrFail($id);

        $file->delete();
        return redirect()->back()->with('success', 'file has deleted succeffully');
    }

    public function file_report(Request $request)
    {
        // If no filters are applied, show the index page
        if (!$request->has('date_from') && !$request->has('date_to') &&
            !$request->has('currency') && !$request->has('status')) {
            return view('reports.file_report_index');
        }

        $query = CustFile::with(['customer', 'payments']);

        // Apply filters
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->has('currency') && $request->currency != '') {
            $query->where('currency', $request->currency);
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'paid') {
                $query->whereRaw('total <= paid');
            } elseif ($request->status == 'pending') {
                $query->whereRaw('total > paid');
            }
        }

        $files = $query->get();

        // Calculate statistics
        $totalRevenue = $files->sum('total');
        $totalPaid = $files->sum('paid');
        $totalBalance = $totalRevenue - $totalPaid;
        $averageFileValue = $files->count() > 0 ? $totalRevenue / $files->count() : 0;

        // Currency breakdown
        $currencyBreakdown = $files->groupBy('currency')
            ->map(function ($group) {
                return $group->sum('total');
            });

        // Payment status counts
        $paidFilesCount = $files->filter(function ($file) {
            return $file->total <= $file->paid;
        })->count();

        $pendingFilesCount = $files->count() - $paidFilesCount;

        // Currency formatting helper
        $formatCurrency = function($amount, $currency = 'USD') {
            $symbols = [
                'USD' => '$',
                'EUR' => '€',
                'TRY' => '₺'
            ];
            $symbol = $symbols[$currency] ?? $currency;
            return $symbol . ' ' . number_format($amount, 2);
        };

        $data = [
            'files' => $files,
            'totalRevenue' => $totalRevenue,
            'totalPaid' => $totalPaid,
            'totalBalance' => $totalBalance,
            'averageFileValue' => $averageFileValue,
            'currencyBreakdown' => $currencyBreakdown,
            'paidFilesCount' => $paidFilesCount,
            'pendingFilesCount' => $pendingFilesCount,
            'formatCurrency' => $formatCurrency,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
            'currency' => $request->currency,
            'status' => $request->status,
        ];

        if ($request->ajax()) {
            return view('reports.file_report', $data)->render();
        }

        return view('reports.file_report_index', $data);
    }

    public function client_file_report(Request $request, $customerId)
    {
        $customer = Customer::findOrFail($customerId);

        $query = CustFile::with(['customer', 'payments', 'cust_file_items'])
            ->where('customer_id', $customerId);

        // Apply filters
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->has('currency') && $request->currency != '') {
            $query->where('currency', $request->currency);
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'paid') {
                $query->whereRaw('total <= paid');
            } elseif ($request->status == 'pending') {
                $query->whereRaw('total > paid');
            }
        }

        $files = $query->get();

        // Eager load nested polymorphic relationships
        $files->loadMorph('cust_file_items.related', [
            \App\Models\Booking::class => ['hotel', 'broker', 'booking_details', 'booking_unit.unit_type'],
            \App\Models\Car::class => ['category', 'tour.from', 'tour.to'],
        ]);

        // Calculate statistics
        $totalRevenue = $files->sum('total');
        $totalPaid = $files->sum('paid');
        $totalBalance = $totalRevenue - $totalPaid;
        $averageFileValue = $files->count() > 0 ? $totalRevenue / $files->count() : 0;

        // Currency breakdown
        $currencyBreakdown = $files->groupBy('currency')
            ->map(function ($group) {
                return $group->sum('total');
            });

        // Payment status counts
        $paidFilesCount = $files->filter(function ($file) {
            return $file->total <= $file->paid;
        })->count();

        $pendingFilesCount = $files->count() - $paidFilesCount;

        // Get all payments for this customer
        $allPayments = Payment::where('customer_id', $customerId)->get();
        $totalPaymentsReceived = $allPayments->sum('amount');

        // Currency formatting helper
        $formatCurrency = function($amount, $currency = 'USD') {
            $symbols = [
                'USD' => '$',
                'EUR' => '€',
                'TRY' => '₺'
            ];
            $symbol = $symbols[$currency] ?? $currency;
            return $symbol . ' ' . number_format($amount, 2);
        };

        $data = [
            'customer' => $customer,
            'files' => $files,
            'totalRevenue' => $totalRevenue,
            'totalPaid' => $totalPaid,
            'totalBalance' => $totalBalance,
            'totalPaymentsReceived' => $totalPaymentsReceived,
            'averageFileValue' => $averageFileValue,
            'currencyBreakdown' => $currencyBreakdown,
            'paidFilesCount' => $paidFilesCount,
            'pendingFilesCount' => $pendingFilesCount,
            'formatCurrency' => $formatCurrency,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
            'currency' => $request->currency,
            'status' => $request->status,
        ];

        return view('reports.client_file_report', $data);
    }

    public function exportClientFileReport($customerId)
    {
        $customer = \App\Models\Customer::findOrFail($customerId);
        $fileName = 'client_file_report_' . $customer->name . '_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new \App\Exports\ClientFileReportExport($customerId), $fileName);
    }

    public function generate_pdf($id)
    {
        $file = CustFile::findOrFail($id);
        $file->load(['customer', 'payments', 'cust_file_items.related', 'user']);

        // Eager load nested polymorphic relationships correctly
        $file->cust_file_items->loadMorph('related', [
            \App\Models\Booking::class => ['hotel', 'broker', 'booking_details', 'booking_unit.unit_type'],
            \App\Models\Car::class => ['category', 'tour.from', 'tour.to'],
        ]);

        // Get bookings and cars with proper filtering
        $bookings = $file->cust_file_items
            ->where('related_type', 'App\\Models\\Booking')
            ->pluck('related')
            ->filter()
            ->values();

        $cars = $file->cust_file_items
            ->where('related_type', 'App\\Models\\Car')
            ->pluck('related')
            ->filter()
            ->values();

        // Debug: Log detailed information
        Log::info("PDF Generation - File ID: $id");
        Log::info("Total file items: " . $file->cust_file_items->count());
        Log::info("Bookings count: " . $bookings->count());
        Log::info("Cars count: " . $cars->count());

        // Debug: Check booking data

        $pdf = Pdf::loadView('general.cust_files.pdf', [
            'file' => $file,
            'bookings' => $bookings,
            'cars' => $cars
        ]);

        return $pdf->stream('client_file_' . $file->id . '.pdf');
    }
}
