<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarCategory;
use App\Models\Customer;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarController extends Controller
{
public function index(Request $request)
{
    $query = Car::with(['customer', 'category']);


    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }


    if ($request->has('date_from') && $request->date_from != '') {
        $query->whereDate('arrival_date', '>=', $request->date_from);
    }

    if ($request->has('date_to') && $request->date_to != '') {
        $query->whereDate('arrival_date', '<=', $request->date_to);
    }


    if ($request->has('date_range') && $request->date_range != '') {
        $today = Carbon::today();

        switch($request->date_range) {
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


    if ($request->has('customer') && $request->customer != '') {
        $query->whereHas('customer', function($q) use ($request) {
            $q->where('name', 'like', '%'.$request->customer.'%');
        });
    }

    $cars = $query->orderBy('created_at', 'desc')->paginate(10);

    if ($request->ajax()) {
        return view('general.car.bookings_table', compact('cars'))->render();
    }

    return view('general.car.all_car', compact('cars'));
}

    public function create()
    {
        $customers = Customer::latest()->get();
        $categories = CarCategory::latest()->get();
        $tours = Tour::latest()->get();
        return view('general.car.create', compact('customers', 'categories','tours'));
    }


    public function edit($id)
    {
        $car = Car::findOrFail($id);
         $customers = Customer::latest()->get();
        $categories = CarCategory::latest()->get();
        $tours = Tour::latest()->get();

        $data = [
            'car'=>$car,
            'customers'=>$customers,
            'categories'=>$categories,
            'tours'=>$tours,
        ];

        return view('general.car.edit', $data);
    }
    public function show($id)
    {




        $booking = Car::findOrFail($id);


        return view('general.car.show', compact('booking'));
    }


    public function store(Request $request)
    {


        $fields = $request->validate([
           'customer_id' => 'required|exists:customers,id',
        'category_id' => 'required|exists:car_categories,id',
        'arrival_date' => 'required|date|after_or_equal:today',
        'arrival_time' => 'required',
        'leave_date' => 'required|date|after:arrival_date',
        'leave_time' => 'required',
        'from_location' => 'required|string|max:255',
        'to_location' => 'required|string|max:255',
        'days_count' => 'required|integer|min:1',
        // 'car_price' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
        'tour_id' => 'nullable',
        'note' => 'required|string'
        ]);

        //  dd($fields);
        Car::create($fields);

        return redirect()->route('car.index')->with('success', 'Car has been added successfully');
    }

    public function getCategoryPrice($id)
    {
        $category = CarCategory::find($id);
        if (!$category) {
            return response()->json(['car_price' => 0]);
        }

        return response()->json(['car_price' => $category->price_per_day]);
    }

    public function update(Request $request,$id){

        $car = Car::findOrFail($id);
         $fields = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'category_id' => 'required|exists:car_categories,id',
            'arrival_date' => 'required|date|after_or_equal:today',
            'arrival_time' => 'required',
            'leave_date' => 'required|date|after_or_equal:today',
            'leave_time' => 'required',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'days_count' => 'required|integer|min:1',

            'total' => 'required|numeric|min:0',
            'tour_id' => 'nullable|exists:tours,id',
            'note' => 'required|string'
        ]);
        // dd($fields);
        $car->update($fields);

        return redirect()->route('car.index')->with('success', 'Car has been updated successfully');
    }
        public function updateStatus(Request $request, $id)
        {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected',
            ]);

            $car = Car::findOrFail($id);
            $car->status = $request->status;
            $car->save();


            return redirect()->back()->with('success','Status updated successfully');
        }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('car.index')->with('success', 'Car has been successfully deleted');
    }
}
