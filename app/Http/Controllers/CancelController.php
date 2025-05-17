<?php

namespace App\Http\Controllers;

use App\Models\Cancelation;
use Illuminate\Http\Request;
use Throwable;

class CancelController extends Controller
{
    public function index()
    {
        $cancels = Cancelation::latest()->paginate(10);
        return view('general.cancel.all_cancel', compact('cancels'));

    }
    public function create()
    {
        return view('general.cancel.create');

    }
    public function store(Request $request){
        $fields = $request->validate([
            'period' => 'string|required'
        ]);
        Cancelation::create($fields);
        return redirect()->route('cancel.index')->with('success', 'cancelation period has been successfully added');

    }
        public function store_for_any(Request $request){
        // $this->authorize('create_hotel');

        try{

       $fields = $request->validate([
            'period' => 'string|required'
        ]);
        Cancelation::create($fields);
        return redirect()->back()->with("success", __('general.added_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }
    public function destroy($id){

        $meal = Cancelation::findOrFail($id);
        $meal->delete();
        return redirect()->route('cancel.index')->with('success', 'cancelation period has been successfully deleted');
    }
}
