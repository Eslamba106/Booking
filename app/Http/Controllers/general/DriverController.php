<?php

namespace App\Http\Controllers\general;

use App\Models\Countries;
use Throwable;
use Carbon\Carbon;
use App\Models\Driver;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DriverController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){

    $this->authorize('driver_management');


        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_drivers_status');
          
            Driver::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }  
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


            Driver::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $drivers = Driver::orderBy("created_at","desc")->paginate(10);
        return view("general.drivers.all_drivers", compact("drivers"  ));
    }

    public function edit($id){
        $this->authorize('edit_driver');
        $driver = Driver::findOrFail($id);
        $countries = Countries::select('id', 'name' , 'nationality')->get();
        $dail_code_main = Countries::select('id', 'dial_code')->get();
        return view("general.drivers.edit", compact("driver", "countries" ,'dail_code_main'));
    }

    public function create(){
        $this->authorize('create_driver');
        $countries = Countries::select('id', 'name' , 'nationality')->get();
        $dail_code_main = Countries::select('id', 'dial_code')->get();

        return view("general.drivers.create" , compact("countries",'dail_code_main'));
    }
    public function store(Request $request){
        $this->authorize('create_driver');
       
        try{

            $request->validate([
                'name'              => "required",
                'phone'              => "required",
                'nationality_id'              => "required",
                'email'             => "nullable|unique:drivers,email",
             ] );
        $driver = Driver::create([
            'name' => $request->name,
            'phone' =>  $request->phone,
            'dial_code' =>  $request->phone_dial_code,
            'email' => $request->email ?? null,
            'country_id' =>  $request->nationality_id ,
        ]);
        return redirect()->route('admin.driver')->with("success", __('general.added_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }
    public function update(Request $request , $id){
        $this->authorize('edit_driver');
        $driver = Driver::findOrFail($id);
        try{
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'nationality_id' => 'required',
            
            'email' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('drivers')->ignore($driver->id),
            ],
           
        ] );
       

        $driver->update([
            'name' => $request->name,
            'dial_code' =>  $request->phone_dial_code,
            'phone' =>  $request->phone,
            'email' => $request->email ?? null,
            'country_id' =>  $request->nationality_id , 
        ]);
      
        return redirect()->route('admin.driver')->with("success", __( 'general.updated_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }

    public function destroy($id){
        $this->authorize('delete_driver');
        $driver = Driver::findOrFail($id);
        $driver->delete();
        return redirect()->route("admin.driver")->with("success", __(   'general.deleted_successfully'));
    }
 
  
}
