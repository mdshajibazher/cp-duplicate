<?php

namespace App\Http\Controllers\Pos;


use App\Cash;
use App\Expense;
use App\GeneralOption;
use App\Http\Resources\ExpenseCollection;
use App\User;
use App\Admin;
use Illuminate\Support\Facades\Cache;
use PDF;
use Carbon\Carbon;
use App\Paymentmethod;
use Illuminate\Http\Request;
use App\Http\Requests\CashRequest;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class CashController extends Controller
{
    public $company_name = "";
    public $company_phone = "";

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:cash.index');
        $this->middleware('permission:cash.create')->only('create', 'store');
        $this->middleware('permission:cash.edit')->only('edit', 'update');
        $this->middleware('permission:cash.approve')->only('approve');
        $this->middleware('permission:cash.cancel')->only('cancel');
        $comapany_information_from_cache = Cache::rememberForever('company_information', function () {
            return \App\Company::first();
        });
        $this->company_name = $comapany_information_from_cache->company_name;
        $this->company_phone = $comapany_information_from_cache->phone;

    }

    public function index()
    {
        $cashes = Cash::take(10)->orderBy('id', 'desc')->get();
        $users = User::where('user_type', 'pos')->where('sub_customer',true)->get();
        $payment_methods = Paymentmethod::all();
        return view('pos.cash.index', compact('users', 'payment_methods', 'cashes'));
    }


    public function result(Request $request)
    {
        $this->validate($request, [
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $users = User::where('user_type', 'pos')->where('sub_customer',true)->get();
        $payment_methods = Paymentmethod::all();

        $cashes = Cash::with('paymentmethod')->whereBetween('received_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->orderBy('received_at', 'asc')->get();
        return view('pos.cash.cashshow', compact('cashes', 'users', 'payment_methods', 'request'));
    }


    public function create()
    {
        //
    }

    public function generateMoneyRecipt($id)
    {
        $general_opt = Cache::get('g_opt') ?? GeneralOption::first();
        $general_opt_value = json_decode($general_opt->options, true);
        $cashData = Cash::with('user')->findOrFail($id);
        //return view('pos.cash.money_recipt', compact('cashData','general_opt_value'));
        $pdf = PDF::loadView('pos.cash.money_recipt', compact('cashData', 'general_opt_value'));
        return $pdf->stream('money_recipt.pdf');
    }

    public function store(CashRequest $request)
    {
        $cash = new Cash;
        $cash->user_id = $request->user;
        $cash->amount = $request->amount;
        $cash->discount = $request->discount;
        $cash->reference = $request->reference;
        $cash->paymentmethod_id = $request->payment_method;
        $cash->posted_by = Auth::user()->name;
        $cash->received_at = $request->received_at . " " . Carbon::now()->toTimeString();
        $cash->save();
        return ['message' => 'Cash Stored Successfully', 'data' => $cash];

    }


    public function show($id)
    {
        $admin = '';
        $cash = Cash::findOrFail($id);
        if (!empty($cash->approved_by)) {
            $admin = Admin::findOrFail($cash->approved_by);
        }
        return view('pos.cash.show', compact('cash', 'admin'));
    }


    public function edit(Cash $cash)
    {
        return $cash;
    }

    public function update(CashRequest $request, Cash $cash)
    {

        $cash->amount = $request->amount;
        $cash->user_id = $request->user;
        $cash->reference = $request->reference;
        $cash->paymentmethod_id = $request->payment_method;
        $cash->discount = $request->discount;
        $cash->posted_by = Auth::user()->name;
        $cash->received_at = $request->received_at . " " . Carbon::now()->toTimeString();
        $cash->status = 0;
        $cash->approved_by = null;
        $cash->save();

        return ['message' => 'Cash updated Successfully', 'data' => $cash];

    }


    public function destroy(Cash $cash)
    {

    }

    public function approve(Request $request, $id)
    {

        $cash = Cash::findOrFail($id);
        if ($cash->status == 1) {
            abort(403, 'Already Approved Please Reload your browser');
        } else {
            $cash->status = 1;
            $cash->approved_by = Auth::user()->id;
            $cash->save();

            $customer_sms_text = "";
            $g_opt = Cache::rememberForever('g_opt', function () {
                return GeneralOption::first();
            });
            $g_opt_value = json_decode($g_opt->options, true);
            $customer_sms_status = 1445;
            $customer_sms_number = $cash->user->phone;
            $customer_sms_alert = $cash->user->sms_alert;
            $max_days_delay_for_allowing_sms = (integer) $g_opt_value['sms_delay_in_days'];
            if ($g_opt_value['customer_cash_approval_notify'] == true && $customer_sms_number != null && $customer_sms_alert == true) {
                if ($cash->received_at->diffInDays(now()) < $max_days_delay_for_allowing_sms) {
                    $customer_sms_text = $cash->user->name . " we received your amount BDT " . $cash->amount . " posting date:  " . $cash->received_at->format('d-M-Y') . " Reference: " . $cash->reference . "  Thanks (" . $this->company_name . ")";
                    $customer_sms_status = sendSMS($customer_sms_text, $customer_sms_number);
                    logSMSInDB($customer_sms_text, $customer_sms_number, $customer_sms_status);
                }else{
                    $customer_sms_status = 1011;
                }
            }
            return ["id" => $id, "smsstatuscode" => $customer_sms_status, "smsstatus" => VisionSmsResponse($customer_sms_status), "customer" => $cash->user->name, "smsbody" => $customer_sms_text];
        }

    }

    public function cancel(Request $request, $id)
    {

        $cash = Cash::findOrFail($id);
        $cash->status = 2;
        $cash->amount = 0;
        $cash->approved_by = Auth::user()->id;
        $cash->save();
        Toastr::success('Cash Canceled Successfully', 'success');
        return redirect()->back();
    }

    public function last10()
    {
        return Cash::with('user', 'paymentmethod')->take(10)->orderBy('id', 'DESC')->get();
    }

    public function datewise(Request $request)
    {
        $this->validate($request, [
            'start' => 'required|date',
            'end' => 'required|date',
        ]);
        $expenses = Cash::with('expensecategory')->whereBetween('expense_date', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->orderBy('expense_date', 'asc')->get();
        return view('cash.datewise', compact('expenses', 'request'));
    }


}
