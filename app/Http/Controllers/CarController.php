<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarCategory;
use App\Models\Customer;
use App\Models\Tour;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(){
        $cars = Car::with('customer', 'category')->latest()->paginate(10);
        return view('general.car.all_car', compact('cars'));
    }

    public function create()
    {
        $customers = Customer::latest()->get();
        $categories = CarCategory::latest()->get();
        $tours = Tour::latest()->get();
        return view('general.car.create', compact('customers', 'categories','tours'));
    }

    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('cars.show', compact('car'));
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


    public function store(Request $request)
    {
        $fields = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'category_id' => 'required|exists:car_categories,id',
            'arrival_date' => 'required|date',
            'arrival_time' => 'required',
            'leave_date' => 'required|date|after:arrival_date',
            'leave_time' => 'required',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'days_count' => 'required|integer|min:1',

            'total' => 'required|numeric|min:0',
            'tour_id' => 'nullable|exists:tours,id',
            'note' => 'nullable|string'
        ]);

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
            'arrival_date' => 'required|date',
            'arrival_time' => 'required',
            'leave_date' => 'required|date|after:arrival_date',
            'leave_time' => 'required',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'days_count' => 'required|integer|min:1',

            'total' => 'required|numeric|min:0',
            'tour_id' => 'nullable|exists:tours,id',
            'note' => 'nullable|string'
        ]);

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
