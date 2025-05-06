<?php

namespace App\Http\Controllers\general;

use App\Models\Countries;
use Throwable;
use Carbon\Carbon;
use App\Models\Hotel; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\UnitType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HotelController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){

        $this->authorize('hotel_management');


        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_hotels_status');
          
            Hotel::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }  
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


            Hotel::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $hotels = Hotel::orderBy("created_at","desc")->paginate(10);
        return view("general.hotels.all_hotels", compact("hotels"  ));
    }

    public function edit($id){
        $this->authorize('edit_hotel');
        $hotel = Hotel::findOrFail($id);
        $countries = Countries::select('id', 'name')->get();
        $unit_types = UnitType::select('id', 'name')->get();
        return view("general.hotels.edit", compact("hotel", "countries", "unit_types"));
    }

    public function create(){
        $this->authorize('create_hotel');
        $countries = Countries::select('id', 'name')->get();
        $unit_types = UnitType::select('id', 'name')->get();
        return view("general.hotels.create" , compact("countries" , "unit_types" ));
    }
    public function store(Request $request){
        $this->authorize('create_hotel');
       
        try{

            $request->validate([
                'name'                          => "required",
                'unit_type_ids'                 => "required",
                'country_id'                    => "required", 
             ] );
        $hotel = Hotel::create([
            'name' => $request->name, 
            'city' => $request->city ?? null,
            'hotel_type' => $request->hotel_type ?? null,
            'hotel_rate' => $request->hotel_rate ?? null,
            'country_id' =>  $request->country_id ,
        ]);
        if ($request->has('unit_type_ids')) {
            $hotel->unit_types()->sync($request->unit_type_ids);
        }
        return redirect()->route('admin.hotel')->with("success", __('general.added_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }
    public function store_for_any(Request $request){
        $this->authorize('create_hotel');
       
        try{

            $request->validate([
                'name'                          => "required",
                'unit_type_ids'                 => "required",
                'country_id'                    => "required", 
             ] );
        $hotel = Hotel::create([
            'name' => $request->name, 
            'city' => $request->city ?? null,
            'hotel_type' => $request->hotel_type ?? null,
            'hotel_rate' => $request->hotel_rate ?? null,
            'country_id' =>  $request->country_id ,
        ]);
        if ($request->has('unit_type_ids')) {
            $hotel->unit_types()->sync($request->unit_type_ids);
        }
        return redirect()->back()->with("success", __('general.added_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }
    public function update(Request $request , $id){
        $this->authorize('edit_hotel');
        $hotel = Hotel::findOrFail($id);
        try{
        $validatedData = $request->validate([
              
                'unit_type_ids'                 => "required",
                'country_id'                    => "required", 
              
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('hotels')->ignore($hotel->id),
            ],
           
        ] );
       

        $hotel->update([
            'name' => $request->name, 
            'city' => $request->city  ,
            'hotel_type' => $request->hotel_type  ,
            'hotel_rate' => $request->hotel_rate ,
            'country_id' =>  $request->country_id , 
        ]);
        $hotel->unit_types()->sync($request->unit_type_ids);

        return redirect()->route('admin.hotel')->with("success", __( 'general.updated_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }

    public function destroy($id){
        $this->authorize('delete_hotel');
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return redirect()->route("admin.hotel")->with("success", __(   'general.deleted_successfully'));
    }
 
  
}
