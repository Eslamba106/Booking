<?php

namespace App\Http\Controllers;

use App\Models\CarCategory;
use Illuminate\Http\Request;

class CarCategoryController extends Controller
{
     public function index(){
        $car_category = CarCategory::select('id','category','price_per_day','car_number','model')->latest()->paginate(10);
        return view('general.carcategory.all_category', compact('car_category'));
    }
      public function create()
    {

        return view('general.carcategory.create');

    }
       public function edit($id)
    {
        $category = CarCategory::findOrFail($id);
        return view('general.carcategory.edit',compact('category'));

    }
      public function store(Request $request)
    {
        $fields = $request->validate([
           'category' => 'required|string',
            'car_number' => 'required',
            'model' => 'required',
         'price_per_day' => 'required|numeric',

        ]);

        CarCategory::create($fields);

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }
      public function update(Request $request,$id)
    {
        $fields = $request->validate([
           'category' => 'required|string',
            'car_number' => 'required',
            'model' => 'required',
         'price_per_day' => 'required|numeric',

        ]);

        $category = CarCategory::findOrFail($id);
        $category->update($fields);

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

   public function getCategoryPrice($id)
{

 $category = CarCategory::findOrFail($id);
    return response()->json(['price' => $category->car_price]);
}     public function destroy($id){

        $meal = CarCategory::findOrFail($id);
        $meal->delete();
        return redirect()->route('category.index')->with('success', 'category  has been successfully deleted');
    }
}
