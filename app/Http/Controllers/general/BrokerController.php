<?php

namespace App\Http\Controllers\general;

use App\Models\Countries;
use Throwable;
use Carbon\Carbon;
use App\Models\Broker;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BrokerController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){

        $this->authorize('broker_management');


        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_brokers_status');
          
            Broker::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }  
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


            Broker::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $brokers = Broker::orderBy("created_at","desc")->paginate(10);
        return view("general.brokers.all_brokers", compact("brokers"  ));
    }

    public function edit($id){
        $this->authorize('edit_broker');
        $broker = Broker::findOrFail($id);
        $countries = Countries::select('id', 'name' , 'nationality')->get();

        return view("general.brokers.edit", compact("broker", "countries" ));
    }

    public function create(){
        $this->authorize('create_broker');
        $countries = Countries::select('id', 'name' , 'nationality')->get();
        return view("general.brokers.create" , compact("countries"));
    }
    public function store(Request $request){
        $this->authorize('create_broker');
       
        try{

            $request->validate([
                'name'              => "required",
                'phone'              => "required",
                'nationality_id'              => "required",
                'email'             => "required|unique:brokers,email",
             ] );
        $broker = Broker::create([
            'name' => $request->name,
            'phone' =>  $request->phone,
            'email' => $request->email ?? null,
            'country_id' =>  $request->nationality_id ,
        ]);
        return redirect()->route('admin.broker')->with("success", __('general.added_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }
    public function update(Request $request , $id){
        $this->authorize('edit_broker');
        $broker = Broker::findOrFail($id);
        try{
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'nationality_id' => 'required',
            
            'email' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brokers')->ignore($broker->id),
            ],
           
        ] );
       

        $broker->update([
            'name' => $request->name,
            'phone' =>  $request->phone,
            'email' => $request->email ?? null,
            'country_id' =>  $request->nationality_id , 
        ]);
      
        return redirect()->route('admin.broker')->with("success", __( 'general.updated_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }

    public function destroy($id){
        $this->authorize('delete_broker');
        $broker = Broker::findOrFail($id);
        $broker->delete();
        return redirect()->route("admin.broker")->with("success", __(   'general.deleted_successfully'));
    }
 
  
}
