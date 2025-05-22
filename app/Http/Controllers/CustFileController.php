<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Broker;
use App\Models\Cancelation;
use App\Models\Car;
use App\Models\Countries;
use App\Models\CustFile;
use App\Models\Customer;
use App\Models\CustomersFile;
use App\Models\CustomersFiles;
use App\Models\Driver;
use App\Models\File;
use App\Models\Hotel;
use App\Models\Meals;
use App\Models\UnitType;
use Carbon\Carbon;
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

        switch($request->date_range) {
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
        $query->whereHas('customer', function($q) use ($request) {
            $q->where('name', 'like', '%'.$request->customer.'%');
        });
    }

    $files = $query->orderBy('created_at', 'desc')->paginate(10);

    if ($request->ajax()) {
        return view('general.car.bookings_table', compact('files'))->render();
    }

    return view('general.cust_files.index', compact('files'));
}

public function create(){
       $customers = Customer::with(['bookings', 'cars'])->get();

    $bookingPrices = Booking::pluck('total', 'id')->toArray();
    $bookingPricesJson = json_encode($bookingPrices);
    $carPrices = Car::pluck('total', 'id')->toArray();
    $carPricesJson = json_encode($carPrices);
          return view('general.cust_files.create', compact('customers','bookingPricesJson','carPricesJson'));
}
    public function store(Request $request){
        $id = Auth::id();

        DB::beginTransaction();
        try {
              $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'booking_id' => 'nullable|array',
            'booking_id.*' => 'exists:bookings,id',
            'car_id' => 'nullable|array',
            'car_id.*' => 'exists:cars,id',
            'total' => 'required|numeric|min:0',
            'paid' => 'nullable|numeric|min:0',
            'remain' => 'required|numeric|min:0'
        ]);

            $file= CustFile::create([
                'customer_id' => $request->customer_id,
                'name' => $request->name ?? null,
                'total' => $request->total,
                'paid' => $request->paid,
                'remain' => $request->remain,
                'user_id'=>$id

            ]);
           if ($request->filled('booking_id')) {
            foreach ($request->booking_id as $bookingId) {
                if ($bookingId) {
                    $file->cust_file_items()->create([
                        'related_id' => $bookingId,
                        'related_type' => Booking::class,
                    ]);
                }
            }
        }


        if ($request->filled('car_id')) {
            foreach ($request->car_id as $carId) {
                if ($carId) {
                    $file->cust_file_items()->create([
                        'related_id' => $carId,
                        'related_type' => Car::class,
                    ]);
                }
            }
        }
            // dd($file);
            DB::commit();
            return redirect()->route('admin.customer')->with('success', __('general.added_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    public function show($id){
        $files = CustFile::where('customer_id', $id)->latest()->paginate();
        return view('general.cust_files.show',compact('files'));
    }


}
