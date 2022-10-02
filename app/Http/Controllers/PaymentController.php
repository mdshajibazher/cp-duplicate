<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{

    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:suppliers.payment.index')->only('index');
        $this->middleware('permission:suppliers.payment.create')->only('create','store');
        $this->middleware('permission:suppliers.payment.edit')->only('edit','update');
        $this->middleware('permission:suppliers.payment.cancel')->only('destroy');
    }


    public function index()
    {
        $payments = Payment::all();
        $suppliers = Supplier::all();
        return view('payment.index', compact('payments','suppliers'));
    }

    public function create()
    {
        //
    }


    public function store(PaymentRequest $request)
    {
        $payment = new Payment;
        $payment->supplier_id = $request->supplier;
        $payment->amount = $request->amount;
        $payment->reference = $request->reference;
        $payment->admin_id = Auth::user()->id;
        $payment->payments_at = $request->payments_at." ".Carbon::now()->toTimeString();
        $payment->save();
        Toastr::success('Payment Saved Successfully', 'success');
        return redirect()->back();

    }


    public function show(Payment $payment)
    {
        //
    }


    public function edit(Payment $payment)
    {
        return $payment;
    }


    public function update(PaymentRequest $request, Payment $payment)
    {
        $payment->amount = $request->amount;
        $payment->supplier_id = $request->supplier;
        $payment->reference = $request->reference;
        $payment->admin_id = Auth::user()->id;
        $payment->payments_at = $request->payments_at." ".Carbon::now()->toTimeString();
        $payment->save();
        Toastr::success('Payment Updated Successfully', 'success');
        return redirect()->back();

    }


    public function destroy(Payment $payment)
    {
        //
    }
}
