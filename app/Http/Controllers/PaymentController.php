<?php

namespace App\Http\Controllers;

use App\Models\CustFile;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request,  $fileId)
    {

        // dd($request->all());
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'currency' => 'required|string|in:USD,EUR,TRY',
        ]);

        $payment = new Payment();
        $payment->cust_file_id = $fileId;
        $payment->payment_date = $request->payment_date;
        $payment->amount = $request->amount;
        $payment->currency = $request->currency;
        $payment->user_id = $request->user_id;
        $payment->customer_id = $request->customer_id;
        $payment->payment_method = $request->payment_method;
        $payment->notes = $request->notes;
        $payment->save();


        $file = CustFile::findOrFail($fileId);
        $file->paid += $request->amount;
        $file->remain = $request->remain;
        $file->total = $request->total;
        $file->save();

        return redirect()->back()->with('success', 'Payment added successfully');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);



        $file = CustFile::where('id', $payment->cust_file_id)->first();



        $file->paid -= $payment->amount;
        $file->remain = max($file->total - $file->paid, 0);
        $file->save();

        $payment->delete();

        return redirect()->back()->with('success', 'Payment deleted successfully');
    }
}
