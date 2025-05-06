<?php

namespace App\Http\Controllers\general;

use App\Models\Countries;
use Throwable;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){

        $this->authorize('customer_management');


        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_customers_status');
          
            Customer::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }  
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


            Customer::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $customers = Customer::orderBy("created_at","desc")->paginate(10);
        return view("general.customers.all_customers", compact("customers"  ));
    }

    public function edit($id){
        $this->authorize('edit_customer');
        $customer = Customer::findOrFail($id);
        $countries = Countries::select('id', 'name' , 'nationality')->get();
        $dail_code_main = Countries::select('id', 'dial_code')->get();
        return view("general.customers.edit", compact("customer", "countries" ,'dail_code_main'));
    }

    public function create(){
        $this->authorize('create_customer');
        $countries = Countries::select('id', 'name' , 'nationality')->get();
        $dail_code_main = Countries::select('id', 'dial_code')->get();

        return view("general.customers.create" , compact("countries",'dail_code_main'));
    }
    public function store(Request $request){
        $this->authorize('create_customer');
       
        try{

            $request->validate([
                'name'              => "required",
                'phone'              => "required",
                'nationality_id'              => "required",
                'email'             => "nullable|unique:customers,email",
             ] );
        $customer = Customer::create([
            'name' => $request->name,
            'phone' =>  $request->phone,
            'dial_code' =>  $request->phone_dial_code,
            'email' => $request->email ?? null,
            'country_id' =>  $request->nationality_id ,
        ]);
        return redirect()->route('admin.customer')->with("success", __('general.added_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }
    public function store_for_any(Request $request){
        $this->authorize('create_customer');
       
        try{

            $request->validate([
                'name'              => "required",
                'phone'              => "required",
                'nationality_id'              => "required",
                'email'             => "nullable|unique:customers,email",
             ] );
        $customer = Customer::create([
            'name' => $request->name,
            'phone' =>  $request->phone,
            'dial_code' =>  $request->phone_dial_code,
            'email' => $request->email ?? null,
            'country_id' =>  $request->nationality_id ,
        ]);
        return redirect()->back()->with("success", __('general.added_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }
    public function update(Request $request , $id){
        $this->authorize('edit_customer');
        $customer = Customer::findOrFail($id);
        try{
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'nationality_id' => 'required',
            
            'email' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('customers')->ignore($customer->id),
            ],
           
        ] );
       

        $customer->update([
            'name' => $request->name,
            'dial_code' =>  $request->phone_dial_code,
            'phone' =>  $request->phone,
            'email' => $request->email ?? null,
            'country_id' =>  $request->nationality_id , 
        ]);
      
        return redirect()->route('admin.customer')->with("success", __( 'general.updated_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }

    public function destroy($id){
        $this->authorize('delete_customer');
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route("admin.customer")->with("success", __(   'general.deleted_successfully'));
    }
 
  
}
