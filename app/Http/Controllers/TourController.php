<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{

    public function index()
    {
        $tours = Tour::latest()->paginate(10);
        return view('general.tour.all_tour', compact('tours'));
    }
    public function create()
    {

        return view('general.tour.create');

    }
    public function edit($id)
    {
        $tour = Tour::findOrFail($id);
        return view('general.tour.edit' , compact('tour'));

    }
    public function update(Request $request,$id)
    {
        $fields = $request->validate([
            'tour' => 'required|string',

            'price' => 'required|numeric',

        ]);


        $tour = Tour::findOrFail($id);
        $tour->update($fields);

        return redirect()->route('tour.index')->with('success', 'tour created successfully.');
    }
    public function store(Request $request)
    {
        $fields = $request->validate([
            'tour' => 'required|string',

            'price' => 'required|numeric',

        ]);

        Tour::create($fields);

        return redirect()->route('tour.index')->with('success', 'tour created successfully.');
    }


    public function destroy($id)
    {

         try {
        $tour = Tour::findOrFail($id);
        $tour->delete();
        return back()->with('success', 'Deleted: ' . $tour->id);
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
    }
}


