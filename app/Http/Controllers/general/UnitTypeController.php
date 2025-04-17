<?php

namespace App\Http\Controllers\general;

use App\Models\Countries;
use Throwable;
use Carbon\Carbon;
use App\Models\UnitType; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UnitTypeController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){

        $this->authorize('unit_type_management');


        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_unit_types_status');
          
            UnitType::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }  
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


            UnitType::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $unit_types = UnitType::orderBy("created_at","desc")->paginate(10);
        return view("general.unit_types.all_unit_types", compact("unit_types"  ));
    }

    public function edit($id){
        $this->authorize('edit_unit_type');
        $unit_type = UnitType::findOrFail($id); 

        return view("general.unit_types.edit", compact("unit_type"  ));
    }

    public function create(){
        $this->authorize('create_unit_type'); 
        return view("general.unit_types.create" ,  );
    }
    public function store(Request $request){
        $this->authorize('create_unit_type');
       
        try{
            $request->validate([
                'name'              => "required|unique:unit_types,name", 
             ] );
        $unit_type = UnitType::create([
            'name' => $request->name, 
        ]);
        return redirect()->route('admin.unit_type')->with("success", __('general.added_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }
    public function update(Request $request , $id){
        $this->authorize('edit_unit_type');
        $unit_type = UnitType::findOrFail($id);
        try{
        $validatedData = $request->validate([
            'name' => 'required|string|max:255,unique:unit_types,name,' . $unit_type->id, 
        ] );
       

        $unit_type->update([
            'name' => $request->name,  
        ]);
      
        return redirect()->route('admin.unit_type')->with("success", __( 'general.updated_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }

    public function destroy($id){
        $this->authorize('delete_unit_type');
        $unit_type = UnitType::findOrFail($id);
        $unit_type->delete();
        return redirect()->route("admin.unit_type")->with("success", __(   'general.deleted_successfully'));
    }
 
  
}
