<?php

namespace App\Http\Controllers\Pos;

use App\Warehouse;
use Illuminate\Support\Facades\Cache;
use PDF;
use App\User;
use App\Admin;
use App\Product;
use Carbon\Carbon;
use App\GeneralOption;
use App\Returnproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class ReturnproductController extends Controller
{
    public $company_name = "";
    public $company_phone = "";

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:return_invoice.index')->only('index');
        $this->middleware('permission:return_invoice.create')->only('create', 'store');
        $this->middleware('permission:return_invoice.edit')->only('edit', 'update');
        $this->middleware('permission:return_invoice.approve')->only('approve');
        $this->middleware('permission:return_invoice.cancel')->only('destroy');
        $comapany_information_from_cache = Cache::rememberForever('company_information', function () {
            return \App\Company::first();
        });
        $this->company_name = $comapany_information_from_cache->company_name;
        $this->company_phone = $comapany_information_from_cache->phone;
    }


    public function index()
    {
        $returns = Returnproduct::withTrashed('user', 'prouduct')->take(10)->orderBy('id', 'desc')->get();
        return view('pos.return.index', compact('returns'));
    }

    public function result(Request $request)
    {
        $this->validate($request, [
            'start' => 'required|date',
            'end' => 'required|date',
        ]);


        $returns = Returnproduct::where('type', 'pos')->withTrashed('user', 'prouduct')->whereBetween('returned_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->orderBy('returned_at', 'asc')->get();
        return view('pos.return.result', compact('returns', 'request'));
    }


    public function create()
    {
        $users = User::where('user_type', 'pos')->where('sub_customer', true)->get();
        $warehouses = Warehouse::get();
        $products = Product::get();
        return view('pos.return.create', compact('products', 'users', 'warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'return_date' => 'required|date',
            'user_id' => 'required|numeric',
            'discount' => 'required|numeric',
            'carrying_and_loading' => 'required|numeric',
            'product' => 'required',
            'warehouse_id' => 'required',
        ]);

        //Amount calculation
        $products = json_decode($request->product);
        $pdinfo = "";
        $amount = [];
        foreach ($products as $item) {
            $pdinfo .= $item->o_name . " = " . $item->count . ",";
            $amount[] = ($item->count) * ($item->price);
        }
        $netamount = array_sum($amount);
        $amount_total = ($netamount + $request->carrying_and_loading) - ($request->discount);

        $return = new Returnproduct;
        $return->user_id = $request->user_id;
        $return->discount = $request->discount;
        $return->carrying_and_loading = $request->carrying_and_loading;
        $return->amount = $amount_total;
        $return->returned_at = $request->return_date . " " . Carbon::now()->toTimeString();
        $return->returned_by = Auth::user()->name;
        $return->warehouse_id = $request->warehouse_id;
        $return->type = 'pos';
        $return->save();

        $products = json_decode($request->product);
        $product_info = [];
        foreach ($products as $product) {
            $product_info[] = [
                'returnproduct_id' => $return->id,
                'product_id' => $product->id,
                'qty' => $product->count,
                'price' => $product->price,
                'user_id' => $request->user_id,
                'warehouse_id' => $request->warehouse_id,
                'returned_at' => $request->return_date . " " . Carbon::now()->toTimeString()
            ];
        }
        $return->product()->attach($product_info);

        $g_opt = Cache::rememberForever('g_opt', function () {
            return GeneralOption::first();
        });
        $g_opt_value = json_decode($g_opt->options, true);
        $admin_numbers_in_array = \App\Admin::whereIn('id', $g_opt_value['admin_list_return_invoice_created_notify'])->pluck('phone')->toArray();;
        $admin_numbers_csv_string = (string)implode(",", $admin_numbers_in_array);
        $customer_sms_text = "";
        $admin_sms_text = "";
        $admin_sms_status = 1445;
        $customer_sms_status = 1445;


        if ($g_opt_value['customer_return_invoice_created_notify'] == true) {
            $customer_sms_text = $return->user->name . ", your Product Return invoice is created, Date: " . $return->returned_at->format('d-m-Y') . " Return Invoice ID:# " . $return->id . " , Amount: " . $return->amount . " Prepared By:" . Auth::user()->name . "(" . $this->company_name . ")";
            $customer_sms_status = sendSMS($customer_sms_text, $return->user->phone);
            logSMSInDB($customer_sms_text, $return->user->phone, $customer_sms_status);
        }

        if ($g_opt_value['admin_return_invoice_created_notify'] == true) {
            $admin_sms_text = "New Product Return Invoice, Date: " . $return->returned_at->format('d-m-Y') . " Return Invoice ID:# " . $return->id . " Customer: " . $return->user->name . ",  " . $return->user->address . ", Amount: " . $return->amount . " Prepared By:" . Auth::user()->name . " .Please Review the Return Invoice,Thanks";
            $admin_sms_status = sendSMS($admin_sms_text, $admin_numbers_csv_string);
            logSMSInDB($admin_sms_text, $admin_numbers_csv_string, $admin_sms_status);
        }

        Toastr::success('Return Invoice Created Successfully');
        if ($admin_sms_status != 1101) {
            Toastr::error(VisionSmsResponse($admin_sms_status), 'error');
        }
        if ($customer_sms_status == 1101) {
            Toastr::success('An Sms has been send to ' . $return->user->name . ' Phone: ' . $return->user->phone);
        } else {
            Toastr::error(VisionSmsResponse($customer_sms_status), 'error');
        }
        return $return->id;

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $returnDetails = Returnproduct::with('product', 'user')->findOrFail($id);
        if (empty($returnDetails->approved_by)) {
            $signature = null;
        } else {
            $signature = Admin::where('id', $returnDetails->approved_by)->select('name', 'signature')->first();
        }
        return view('pos.return.show', compact('returnDetails', 'signature'));
    }


    public function edit($id)
    {

        $return = Returnproduct::with('product')->findOrFail($id);
        $users = User::where('user_type', 'pos')->where('sub_customer', true)->get();
        $warehouses = Warehouse::get();
        $products = Product::get();
        return view('pos.return.edit', compact('products', 'warehouses', 'users', 'return'));
    }


    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'return_date' => 'required|date',
            'user_id' => 'required|numeric',
            'discount' => 'required|numeric',
            'carrying_and_loading' => 'required|numeric',
            'product' => 'required',
            'warehouse_id' => 'required',
        ]);
        try {
            DB::beginTransaction();
        $return = Returnproduct::findOrFail($id);
        $prev_amount = $return->amount;
        $prev_date = $return->returned_at->toDateString();
        //Amount calculation
        $products = json_decode($request->product);
        $amount = [];
        foreach ($products as $item) {
            $amount[] = ($item->count) * ($item->price);
        }
        $netamount = array_sum($amount);
        $amount_total = ($netamount + $request->carrying_and_loading) - ($request->discount);


        $return->user_id = $request->user_id;
        $return->discount = $request->discount;
        $return->carrying_and_loading = $request->carrying_and_loading;
        $return->amount = $amount_total;
        $return->warehouse_id = $request->warehouse_id;
        $return->returned_at = $request->return_date . " " . Carbon::now()->toTimeString();
        $return->returned_by = Auth::user()->name;
        $return->save();

        DB::table('product_returnproduct')->where('returnproduct_id', '=', $id)->delete();

        $products = json_decode($request->product);
        $product_info = [];
        foreach ($products as $product) {
            $product_info[] = [
                'returnproduct_id' => $return->id,
                'product_id' => $product->id,
                'qty' => $product->count,
                'price' => $product->price,
                'user_id' => $request->user_id,
                'returned_at' => $request->return_date . " " . Carbon::now()->toTimeString(),
                'warehouse_id' => $request->warehouse_id,
            ];
        }

        $return->product()->attach($product_info);

        $customer_sms_text = "";
        $admin_sms_text = "";
        $g_opt = Cache::rememberForever('g_opt', function () {
            return GeneralOption::first();
        });
        $g_opt_value = json_decode($g_opt->options, true);
        $admin_numbers_in_array = \App\Admin::whereIn('id', $g_opt_value['admin_list_return_invoice_edited_notify'])->pluck('phone')->toArray();;
        $admin_numbers_csv_string = (string)implode(",", $admin_numbers_in_array);
        $changed_string = "";
        $current_amount = (float)$return->amount;
        if ($prev_amount !== $current_amount) {
            $changed_string .= "prev. amount: " . round($prev_amount) . " current amount: " . round($current_amount) . " ";
        }

        if ($prev_date !== $return->returned_at->toDateString()) {
            $changed_string .= "prev. date : " . $prev_date . " current date " . $return->returned_at->toDateString() . " ";
        }
        $admin_sms_status = 1445;
        $customer_sms_status = 1445;


        if ($g_opt_value['customer_return_invoice_edited_notify'] == true && !empty($changed_string)) {
            $customer_sms_text = $return->user->name . ", your Product Return invoice is little bit changed.Return Invoice ID:# " . $return->id . " " . $changed_string . " , Total: " . $return->amount . " Prepared By:" . Auth::user()->name . "(" . $this->company_name . ")";
            $customer_sms_status = sendSMS($customer_sms_text, $return->user->phone);
            logSMSInDB($customer_sms_text, $return->user->phone, $customer_sms_status);
        }

        if ($g_opt_value['admin_return_invoice_edited_notify'] == true && !empty($changed_string)) {
            $admin_sms_text = "A return Invoice is edited, Return Invoice ID:# " . $return->id . " Customer: " . $return->user->name . ",  " . $return->user->address . " " . $changed_string . " Prepared By:" . Auth::user()->name . " .Please Review the Return Invoice,Thanks";
            $admin_sms_status = sendSMS($admin_sms_text, $admin_numbers_csv_string);
            logSMSInDB($admin_sms_text, $admin_numbers_csv_string, $admin_sms_status);
        }

        Toastr::success('Return Invoice Created Successfully');
        if ($admin_sms_status != 1101) {
            Toastr::error(VisionSmsResponse($admin_sms_status), 'error');
        }
        if ($customer_sms_status == 1101) {
            Toastr::success('An Sms has been send to ' . $return->user->name . ' Phone: ' . $return->user->phone);
        } else {
            Toastr::error(VisionSmsResponse($customer_sms_status), 'error');
        }

            DB::commit();
            return $return->id;
        } catch (QueryException $exception) {
            return $exception;
        }

    }


    public function destroy($id)
    {
        $returnDetails = Returnproduct::findOrFail($id);
        $returnDetails->return_status = 2;
        $returnDetails->approved_by = Auth::user()->id;
        $returnDetails->deleted_at = now();
        $returnDetails->amount = 0;
        $returnDetails->save();
        $returnDetails->product()->detach();
        Toastr::success('Return cancelled Successfully', 'success');
        return redirect()->route('returnproduct.index');

    }

    public function invoice(Request $request, $id)
    {
        $general_opt = Cache::get('g_opt') ?? GeneralOption::first();
        $general_opt_value = json_decode($general_opt->options, true);
        $returnDetails = Returnproduct::with('product', 'user')->findOrFail($id);
        $current_user = User::findOrFail($returnDetails->user_id);
        if (empty($returnDetails->approved_by)) {
            $signature = '';
        } else {
            $signature = Admin::where('id', $returnDetails->approved_by)->select('name', 'signature')->first();
        }

        $pdf = PDF::loadView('pos.return.invoice', compact('returnDetails', 'current_user', 'general_opt_value', 'signature'));
        return $pdf->download('invoice.pdf');
    }


    public function approve(Request $request, $id)
    {
        $returnproduct = Returnproduct::findOrFail($id);

        if ($returnproduct->return_status == 1) {
            abort(403, 'Return Invoice Already Approved');
        } else {
            $returnproduct->return_status = 1;
            $returnproduct->approved_by = Auth::user()->id;
            $returnproduct->save();
            return ['id' => $returnproduct->id, 'status' => $returnproduct->return_status, 'msg' => 'Return Invoice Approved Successfully'];
        }
    }
}
