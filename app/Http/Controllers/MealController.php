<?php

namespace App\Http\Controllers;


use App\Models\Meals;
use Illuminate\Http\Request;
use Throwable;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meals::latest()->paginate(10);
        return view('general.meals.all_meal',compact('meals'));

    }

    public function create()
    {

        return view('general.meals.create');

    }
    public function store(Request $request){
        $fields = $request->validate([
            'name' => 'string|required'
        ]);
        Meals::create($fields);
        return redirect()->route('meal.index')->with('success', 'Meal  has been successfully added');

    }
       public function store_for_any(Request $request){
        // $this->authorize('create_hotel');

        try{

             $fields = $request->validate([
            'name' => 'string|required'
        ]);
        Meals::create($fields);
        return redirect()->back()->with("success", __('general.added_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }
    public function destroy($id){

        $meal = Meals::findOrFail($id);
        $meal->delete();
        return redirect()->route('meal.index')->with('success', 'Meal  has been successfully deleted');
    }
}
