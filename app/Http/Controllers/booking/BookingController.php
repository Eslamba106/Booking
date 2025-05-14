<?php

namespace App\Http\Controllers\booking;

use Carbon\Carbon;
use App\Models\Hotel;
use App\Models\Broker;
use App\Models\Driver;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\UnitType;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Cancelation;
use App\Models\Meals;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {

        $this->authorize('booking_management');


        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_bookings_status');

            Booking::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


            Booking::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $bookings = Booking::orderBy("created_at", "desc")->paginate(10);
        return view("general.booking.all_bookings", compact("bookings"));
    }
    public function live_booking(Request $request)
    {

        $this->authorize('booking_management');


        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        $fiveDaysLater = Carbon::today()->addDays(5);
        $today = Carbon::today();

        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_bookings_status');

            Booking::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


            Booking::whereBetween('arrival_date', [$today, $fiveDaysLater])->whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $bookings = Booking::where('arrival_date', '<=', $today)
        ->where('check_out_date', '>=', $today)->where('status' , '!=' ,'cancel')->orderBy("created_at", "desc")->paginate(10);
        return view("general.booking.all_bookings", compact("bookings"));
    }
    public function coming_soon(Request $request)
    {

        $this->authorize('booking_management');


        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        $fiveDaysLater = Carbon::today()->addDays(5);
        $today = Carbon::today()->addDay();

        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_bookings_status');

            Booking::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


            Booking::whereBetween('arrival_date', [$today, $fiveDaysLater])->whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $bookings = Booking::whereBetween('arrival_date', [$today, $fiveDaysLater])->where('status' , '!=' ,'cancel')->orderBy("created_at", "desc")->paginate(10);
        return view("general.booking.all_bookings", compact("bookings"));
    }
    public function show($id){
        $booking = Booking::where('id', $id)->with('booking_details')->first();
        $hotels = Hotel::select('id', 'name')->with('unit_types')->get();
        $unit_types = UnitType::select('id', 'name')->get();
        $brokers = Broker::where('id', $booking->broker_id)->first();
        $drivers = Driver::select('id', 'name')->get();
        $customers = Customer::select('id', 'name')->get();
        return view('general.booking.show', compact("booking", "hotels", "unit_types", "brokers", "drivers", "customers"));

    }
    public function create()
    {
        $this->authorize('create_hotel');
        $cancels = Cancelation::select('period')->get();
        $meals = Meals::select('name')->get();
        $hotels = Hotel::select('id', 'name')->with('unit_types')->get();
        $unit_types = UnitType::select('id', 'name')->get();
        $brokers = Broker::select('id', 'name')->get();
        $drivers = Driver::select('id', 'name')->get();
        $customers = Customer::select('id', 'name')->get();
        $countries = Countries::select('id', 'name' , 'nationality')->get();
        $dail_code_main = Countries::select('id', 'dial_code')->get();
        $date = [
            'hotels' => $hotels,
            'unit_types' => $unit_types,
            'brokers' => $brokers,
            'drivers' => $drivers,
            'customers' => $customers,
            'countries' => $countries,
            'dail_code_main' => $dail_code_main,
            'cancels'=>$cancels,
            'meals'=>$meals
        ];
        return view("general.booking.create", $date);
    }

    public function store(Request $request)
    {
        $this->authorize('create_booking');

        DB::beginTransaction();
        try {
            $request->validate([
                'customer_id' => 'required',
                'arrival_date' => 'required|date',
                'check_out_date' => 'required|date|after:today',
                'days_count' => 'required|integer',
                'canceled_period' => 'required',
                'adults_count' => 'required|integer',
                'childerns_count' => 'nullable|integer',
                'babes_count' => 'nullable|integer',
                'total_person_count' => 'required|integer',
                'hotel_id' => 'required|exists:hotels,id',
                'city' => 'required|string|max:255',
                'booking_no' => 'required|string|max:255',
                'unit_type_id' => 'required',
                'food_type' => 'required|string|max:255',
                'units_count' => 'required|integer',
                'buy_price' => 'required|numeric',
                'price' => 'required|numeric',
                'currency' => 'required|string|max:255',
            ]);
            $booking = Booking::create([
                'customer_id' => $request->customer_id,
                'user_id' => auth()->id(),
                'arrival_date' => $request->arrival_date,
                'check_out_date' => $request->check_out_date,
                'days_count' => $request->days_count,
                'booking_no' => $request->booking_no,
                'hotel_id' => $request->hotel_id,
                'canceled_period' => $request->canceled_period,
                'price'    => $request->price,
                'buy_price' => $request->buy_price,
                'earned' => $request->earn,
                'broker_amount' => $request->broker_amount,
                'currency' => $request->currency,
                'commission_type' => $request->commission_type,
                'commission_percentage' => $request->commission_percentage,
                'commission_night' => $request->commission_night,
                'commission' => $request->commission,
                'commission_amount' => $request->commission_amount,
                'sub_total' => $request->sub_total,
                'broker_id' => $request->broker_id,
                'total' => $request->total,

            ]);
            $booking->booking_details()->create([
                'adults_count' => $request->adults_count ?? 0,
                'babes_count' => $request->babes_count ?? 0,
                'childerns_count' => $request->childerns_count ?? 0,
                'total_person_count' => $request->total_person_count ?? 0,
                'units_count' => $request->units_count ?? 0,
                'food_type' => $request->food_type,
            ]);
            $booking->booking_unit()->create([
                'hotel_id' => $request->hotel_id,
                'unit_type' => $request->unit_type_id,
                'price' => $request->price,
                'currency' => $request->currency,
            ]);
            $booking->service()->create([
                    'name' => $request->name ?? 0,
                    'qyt' => $request->qyt ?? 0,
                    'price' => $request->service_price ?? 0,
            ]);
            // dd($booking);
            DB::commit();
            return redirect()->route('admin.booking')->with('success', __('general.added_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    public function edit($id)
    {
        $this->authorize('create_booking');
        $booking = Booking::where('id', $id)->with('booking_details')->first();
        $hotels = Hotel::select('id', 'name')->with('unit_types')->get();
        $unit_types = UnitType::select('id', 'name')->get();
        $brokers = Broker::select('id', 'name')->get();
        $drivers = Driver::select('id', 'name')->get();
        $customers = Customer::select('id', 'name')->get();
        return view("general.booking.edit", compact("booking", "hotels", "unit_types", "brokers", "drivers", "customers"));
    }
    public function update(Request $request, $id)
    {
        $this->authorize('edit_booking');

        DB::beginTransaction();
        try {
            $request->validate([
                'customer_id' => 'required',
                'arrival_date' => 'required|date',
                'check_out_date' => 'required|date',
                'days_count' => 'required|integer',
                'canceled_period' => 'required|integer',
                'adults_count' => 'required|integer',
                'childerns_count' => 'nullable|integer',
                'babes_count' => 'nullable|integer',
                'total_person_count' => 'required|integer',
                'hotel_id' => 'required|exists:hotels,id',
                'city' => 'required|string|max:255',
                'booking_no' => 'required|string|max:255',
                'unit_type_id' => 'required',
                'food_type' => 'required|string|max:255',
                'units_count' => 'required|integer',
                'buy_price' => 'required|numeric',
                'price' => 'required|numeric',
                'currency' => 'required|string|max:255',
            ]);

            $booking = Booking::findOrFail($id);

            $booking->update([
                'customer_id' => $request->customer_id,
                'user_id' => auth()->id(),
                'arrival_date' => $request->arrival_date,
                'check_out_date' => $request->check_out_date,
                'days_count' => $request->days_count,
                'booking_no' => $request->booking_no,
                'hotel_id' => $request->hotel_id,
                'canceled_period' => $request->canceled_period,
                'price'    => $request->price,
                'buy_price' => $request->buy_price,
                'earned' => $request->earn,
                'broker_amount' => $request->broker_amount,
                'currency' => $request->currency,
                'commission_type' => $request->commission_type,
                'commission_percentage' => $request->commission_percentage,
                'commission_night' => $request->commission_night,
                'commission' => $request->commission,
                'commission_amount' => $request->commission_amount,
                'sub_total' => $request->sub_total,
                'broker_id' => $request->broker_id,
                'total' => $request->total,
                'status' => 'pending',
            ]);

            $booking->booking_details()->update([
                'adults_count' => $request->adults_count ?? 0,
                'babes_count' => $request->babes_count ?? 0,
                'childerns_count' => $request->childerns_count ?? 0,
                'total_person_count' => $request->total_person_count ?? 0,
                'units_count' => $request->units_count ?? 0,
                'food_type' => $request->food_type,
            ]);

            $booking->booking_unit()->update([
                'hotel_id' => $request->hotel_id,
                'unit_type' => $request->unit_type_id,
                'price' => $request->price,
                'currency' => $request->currency,
            ]);
            dd($booking);
            DB::commit();
            return redirect()->route('admin.booking')->with('success', __('general.updated_successfully'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    public function destroy($id)
    {
        $this->authorize('delete_booking');

        DB::beginTransaction();
        try {
            $booking = Booking::findOrFail($id);
            $booking->booking_details()->delete();
            $booking->booking_unit()->delete();
            $booking->delete();
            DB::commit();
            return redirect()->route('admin.booking')->with('success', __('general.deleted_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    public function cancel($id)
    {
        DB::beginTransaction();
        try {
            $booking = Booking::findOrFail($id);
            $booking->update(['status' => 'cancel']);
            DB::commit();
            return redirect()->route('admin.booking')->with('success', __('general.updated_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    public function generateVoucherPdf($id)
{
    $booking = Booking::with('hotel.unit_types', 'customer', 'booking_details')->find($id);

    $pdf = Pdf::loadView('general.booking.voucher_pdf', compact('booking'));

    return $pdf->download('hotel-voucher-' . $booking->id . '.pdf');
}
    public function get_country($id)
    {
        $this->authorize('create_booking');
        $hotel = Hotel::where('id', $id)->select('id', 'country_id', 'city')->with('country')->first();
        // $country = Countries::where('id', $id)->select('id' , 'name')->first();
        return response()->json($hotel);
    }
}
