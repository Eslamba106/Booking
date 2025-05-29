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

        ]);
        $files = CustFile::create([
            'customer_id' => $request->customer_id,
            'name' => $request->name,
            'paid' => $request->paid ?? 0,
            'total' => $request->total ?? 0,
            'remain' => $request->remain ?? 0,
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
}
