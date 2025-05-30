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
use App\Models\Booking;
use App\Models\CustFile;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerController extends Controller
{
    use AuthorizesRequests;
    // public function index(Request $request){

    //     $this->authorize('customer_management');


    //     $ids = $request->bulk_ids;
    //     $now = Carbon::now()->toDateTimeString();
    //     if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
    //         $data = ['status' => $request->status];
    //         $this->authorize('change_customers_status');

    //         Customer::whereIn('id', $ids)->update($data);
    //         return back()->with('success', __('general.updated_successfully'));
    //     }
    //     if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


    //         Customer::whereIn('id', $ids)->delete();
    //         return back()->with('success', __('general.deleted_successfully'));
    //     }

    //     $customers = Customer::orderBy("created_at","desc")->paginate(10);
    //     return view("general.customers.all_customers", compact("customers"  ));
    // }

    public function index(Request $request)
    {
        $this->authorize('customer_management');

        // معالجة العمليات الجماعية (تحديث الحالة / حذف)
        $ids = $request->bulk_ids;

        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $this->authorize('change_customers_status');
            Customer::whereIn('id', $ids)->update(['status' => $request->status]);
            return back()->with('success', __('general.updated_successfully'));
        }

        if ($request->bulk_action_btn === 'delete' && is_array($ids) && count($ids)) {
            Customer::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        // استعلام العملاء مع فلاتر البحث والحالة
        $customers = Customer::query();

        // فلتر البحث (الاسم أو البريد)
        if ($request->filled('search')) {
            $search = $request->search;
            $customers->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // فلتر الحالة (active/disactive)
        if ($request->filled('status')) {
            if ($request->status == 1) {
                $customers->where('status', 'active');
            } elseif ($request->status == 2) {
                $customers->where('status', 'disactive');
            }
        }

        // ترتيب وتحميل النتائج
        $customers = $customers->with('country')->orderBy("created_at", "desc")->paginate(10);

        return view("general.customers.all_customers", compact("customers"));
    }
    public function show($id)
    {


        $customerBookings = Booking::where('customer_id', $id)->latest()->paginate();
        return view('general.customers.customer_booking', compact('customerBookings'));
    }
    public function show_file($id)
    {
        $file = CustFile::with(['customer', 'cust_file_items.related'])
            ->where('customer_id', $id)
            ->latest()
            ->paginate();

        return view('general.cust_files.show', compact('file'));
    }
    public function edit($id)
    {
        $this->authorize('edit_customer');
        $customer = Customer::findOrFail($id);
        $countries = Countries::select('id', 'name', 'nationality')->get();
        $dail_code_main = Countries::select('id', 'dial_code')->get();
        return view("general.customers.edit", compact("customer", "countries", 'dail_code_main'));
    }

    public function create()
    {
        $this->authorize('create_customer');
        $countries = Countries::select('id', 'name', 'nationality')->get();
        $dail_code_main = Countries::select('id', 'dial_code')->get();

        return view("general.customers.create", compact("countries", 'dail_code_main'));
    }
    public function store(Request $request)
    {
        $this->authorize('create_customer');

        try {

            $request->validate([
                'name'              => "required",
                'phone'              => "required|unique:customers",
                'nationality_id'              => "required",
                'email'             => "nullable|unique:customers,email",
            ]);
            $customer = Customer::create([
                'name' => $request->name,
                'phone' =>  $request->phone,
                // 'dial_code' =>  $request->phone_dial_code,
                'email' => $request->email ?? null,
                'country_id' =>  $request->nationality_id,
            ]);
            return redirect()->route('admin.customer')->with("success", __('general.added_successfully'));
        } catch (Throwable $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    public function store_for_any(Request $request)
    {
        $this->authorize('create_customer');

        try {

            $request->validate([
                'name'              => "required",
                'phone'              => "required",
                'nationality_id'              => "required",
                'email'             => "nullable|unique:customers,email",
            ]);
            $customer = Customer::create([
                'name' => $request->name,
                'phone' =>  $request->phone,
                // 'dial_code' =>  $request->phone_dial_code,
                'email' => $request->email ?? null,
                'country_id' =>  $request->nationality_id,
            ]);
            return redirect()->back()->with("success", __('general.added_successfully'));
        } catch (Throwable $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $this->authorize('edit_customer');
        $customer = Customer::findOrFail($id);
        try {
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

            ]);


            $customer->update([
                'name' => $request->name,
                // 'dial_code' =>  $request->phone_dial_code,
                'phone' =>  $request->phone,
                'email' => $request->email ?? null,
                'country_id' =>  $request->nationality_id,
            ]);

            return redirect()->route('admin.customer')->with("success", __('general.updated_successfully'));
        } catch (Throwable $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->authorize('delete_customer');
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route("admin.customer")->with("success", __('general.deleted_successfully'));
    }

    public function payment($id)
    {
        $customer = Customer::findOrFail($id);
        $payments = Payment::with(['customer', 'user'])
            ->where('customer_id', $id)
            ->orderBy('payment_date', 'desc')
            ->get()
            ->groupBy(function ($payment) {
                return $payment->payment_date;
            });

        return view('general.customers.payment', [
            'paymentsGrouped' => $payments,
            'customer' => $customer,
        ]);
    }
    public function accounting($id)
    {
        // $customerid = Customer::findOrFail($id);
        $customer = Customer::with([
            'bookings.booking_details',
            'cars',
            'files'
        ])->findOrFail($id);

        $totalBooking = $customer->bookings->sum('total');
        $totalCar = $customer->cars->sum('total');
        $totalPayments = $customer->files->sum('paid');
        $dueBalance = ($totalBooking + $totalCar) - $totalPayments;

        $customerData = [
            'id' => $customer->id,
            'name' => $customer->name,
            'total_booking' => $totalBooking,
            'total_car' => $totalCar,
            'total_payments' => $totalPayments,
            'due_balance' => $dueBalance,
            'status' => $dueBalance <= 0 ? 'Paid' : 'Due',
            'currency' => $customer->bookings->first()->currency ?? $customer->cars->first()->currency ?? 'USD',
            'last_payment' => $customer->files->max('updated_at'),
            'bookings' => $customer->bookings,
            'cars' => $customer->cars,
            'files' => $customer->files
        ];

        return view('general.customers.acc_report', [
            'customer' => $customerData
        ]);
    }
}
