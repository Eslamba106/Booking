<?php

namespace App\Http\Controllers\general;

use App\Models\Countries;
use Throwable;
use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){

    $this->authorize('service_management');


        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_services_status');

            Service::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


            Service::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $services = Service::orderBy("created_at","desc")->paginate(10);
        return view("general.services.all_services", compact("services"  ));
    }

    public function edit($id){
        $this->authorize('edit_service');
        $service = Service::findOrFail($id);
        return view("general.services.edit", compact("service" ));
    }

    public function create(){
        $this->authorize('create_service');

        return view("general.services.create"  );
    }
    public function store(Request $request){
        $this->authorize('create_service');

        try{

            $request->validate([
                'name'              => "required",
                'qty'              => 'nullable|numeric',
                'price'              => 'nullable|numeric',

             ] );
        $service = Service::create([
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,

        ]);
        return redirect()->route('admin.service')->with("success", __('general.added_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }
    public function store_for_any(Request $request){
        $this->authorize('create_service');

        try{

            $request->validate([
                'name'              => "required",
                'qty'              => 'nullable|numeric',
                'price'              => 'nullable|numeric',

             ] );
        $service = Service::create([
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,

        ]);
        return redirect()->back()->with("success", __('general.added_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }
    public function update(Request $request , $id){
        $this->authorize('edit_service');
        $service = Service::findOrFail($id);
        try{
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',  ] );


        $service->update([
            'name' => $request->name,

        ]);

        return redirect()->route('admin.service')->with("success", __( 'general.updated_successfully'));
    } catch (Throwable $e) {
        return redirect()->back()->with("error", $e->getMessage());

    }
    }

    public function destroy($id){
        $this->authorize('delete_service');
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route("admin.service")->with("success", __(   'general.deleted_successfully'));
    }


}
