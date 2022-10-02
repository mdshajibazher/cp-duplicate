<?php

namespace App\Http\Controllers\Pos;

use App\Jobs\SalesInvoiceCreatedJob;
use App\MailLog;
use App\Warehouse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use PDF;
use Session;
use App\Sale;
use App\User;
use App\Admin;
use App\Product;
use Carbon\Carbon;
use App\GeneralOption;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Smsconfig;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    public $company_name = "";
    public $company_phone = "";

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:sales_invoice.index')->only('index');
        $this->middleware('permission:sales_invoice.show')->only('show');
        $this->middleware('permission:sales_invoice.create')->only('create', 'store');
        $this->middleware('permission:sales_invoice.edit')->only('edit', 'update');
        $this->middleware('permission:sales_invoice.approve')->only('approve');
        $this->middleware('permission:sales_invoice.cancel')->only('destroy');
        $comapany_information_from_cache = Cache::rememberForever('company_information', function () {
            return \App\Company::first();
        });
        $this->company_name = $comapany_information_from_cache->company_name;
        $this->company_phone = $comapany_information_from_cache->phone;
    }

    public function index()
    {
        $sales = Sale::withTrashed('user', 'prouduct')->take(10)->orderBy('id', 'desc')->get();
        return view('pos.sale.index', compact('sales'));
    }

    public function result(Request $request)
    {
        $this->validate($request, [
            'start' => 'required|date',
            'end' => 'required|date',
        ]);


        $sales = Sale::withTrashed('user', 'prouduct')->whereBetween('sales_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->orderBy('sales_at', 'asc')->get();
        return view('pos.sale.salesresult', compact('sales', 'request'));
    }


    public function create()
    {
        $users = User::where('user_type', 'pos')->where('sub_customer',true)->get();
        $products = Product::get();
        $warehouses = Warehouse::get();
        return view('pos.sale.create', compact('products', 'users','warehouses'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'sales_date' => 'required|date',
            'user_id' => 'required|numeric',
            'discount' => 'required|numeric',
            'carrying_and_loading' => 'required|numeric',
            'is_condition' => 'required|numeric',
            'product' => 'required',
        ]);

        //Amount calculation
        $products = json_decode($request->product);
        $productTextFoMail = "";
        $subTotal = 0;
        $amount = [];
        foreach ($products as $item) {
            $qty = round($item->count);
            $price = round($item->price);
            $total = $qty * $price;
            if ($item->free > 0) {
                $productTextFoMail .= "<li>{$item->o_name} = {$qty} x {$price} + free= {$item->free}  = {$total}</li>";
            } else {
                $productTextFoMail .= "<li>{$item->o_name} = {$qty} x {$price}  = {$total}</li>";
            }
            $subTotal = $subTotal + $total;
            $amount[] = ($item->count) * ($item->price);
        }
        $productTextFoMail = substr($productTextFoMail, 0, -1);
        $netamount = array_sum($amount);
        $amount_total = ($netamount + $request->carrying_and_loading) - ($request->discount);

        // Start Store process
        $sale = new Sale;
        $sale->user_id = $request->user_id;
        $sale->discount = $request->discount;
        $sale->carrying_and_loading = $request->carrying_and_loading;
        $sale->sales_at = $request->sales_date . " " . Carbon::now()->toTimeString();
        $sale->amount = $amount_total;
        $sale->is_condition = $request->is_condition;
        $sale->condition_amount = $request->condition_amount;
        $sale->sales_status = 0;
        $sale->warehouse_id = $request->warehouse_id;
        $sale->cust_sms = false;
        $sale->d_agent_sms = false;
        $sale->provided_by = Auth::user()->name;
        $sale->save();


        $product_info = [];
        foreach ($products as $product) {
            $product_info[] = [
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'warehouse_id' => $request->warehouse_id,
                'qty' => $product->count,
                'free' => $product->free,
                'price' => $product->price,
                'user_id' => $request->user_id,
                'sales_at' => $request->sales_date . " " . Carbon::now()->toTimeString()
            ];
        }
        //Attach Pivot
        $sale->product()->attach($product_info);

        $g_opt = Cache::rememberForever('g_opt', function () {
            return GeneralOption::first();
        });
        $g_opt_value = json_decode($g_opt->options, true);
        $sendstatus = 1445;

        if ($g_opt_value['admin_sales_invoice_created_notify'] == true) {
            $admin_numbers_in_array = \App\Admin::whereIn('id', $g_opt_value['admin_list_sales_invoice_created_notify'])->pluck('phone')->toArray();
            $numbers_csv_string = (string)implode(",", $admin_numbers_in_array);
            $text = "New Invoice, Date: " . $sale->sales_at->format('d-m-Y') . " Invoice ID:# " . $sale->id . " Customer: " . $sale->user->name . ",  " . $sale->user->address . ", Amount: " . $sale->amount . " Prepared By:" . Auth::user()->name . " .Please Approve the Invoice,Thanks";
            $sendstatus = sendSMS($text, $numbers_csv_string);
            logSMSInDB($text, $numbers_csv_string, $sendstatus);
        }

        if ($g_opt_value['admin_email_sales_invoice_created'] == true) {
            $noficationTo = ['model' => 'App\Admin', 'ids' => $g_opt_value['admin_list_email_sales_invoice_created']];

            $sales_date = $sale->sales_at->format('d-M-Y');
            $prepared_by = Auth::user()->name;
            $prepared_at = $sale->created_at->format('d-M-Y g:i a');

        $conditionBookingText = $sale->is_condition ? "Condition Booking Amount: {$sale->condition_amount}" : "";

        $notificationText =  "Invoice date: {$sales_date} Invoice ID:# {$sale->id} Customer:  {$sale->user->name} , Address: {$sale->user->address}  Prepared By: {$prepared_by} at {$prepared_at}  Please Approve the Invoice,Thanks";

        $amountText = "<li>Subtotal: {$subTotal}</li>
        <li>Discount: {$sale->discount} </li>
        <li> Carrying and loading cost: {$sale->carrying_and_loading} </li>
        <li>  {$conditionBookingText} Total payable amount: {$sale->amount} </li>";

        $notificationDetails = [
            'notificationTo' => $noficationTo,
            'conditionBookingText' => $conditionBookingText,
            'sales_details' => $sale,
            'customer_name' => $sale->user->name,
            'customer_address' => $sale->user->address,
            'notificationText' => $notificationText,
            'amountText' => $amountText,
            'productTextFoMail' => $productTextFoMail,
        ];
        mailNotificationLogger($notificationDetails, '\App\Notifications\notifyAdminSalesInvoiceCreated');
        Session::flash('send_mail_notification');
    }

        if ($sendstatus == 1101) {
            Toastr::success('Invoice Created Successfully');
        } else {
            Toastr::success('Invoice Created Successfully', 'success');
            Toastr::error(VisionSmsResponse($sendstatus), 'Warning');
        }

        return $sale->id;
    }


    public function show($id)
    {
        $sale = Sale::withTrashed()->findOrFail($id);
        if (empty($sale->approved_by)) {
            $signature = null;
        } else {
            $signature = Admin::where('id', $sale->approved_by)->select('name', 'signature')->first();
        }
        if (empty($sale->delivery_marked_by)) {
            $delivered_by = null;
        } else {
            $delivered_by = Admin::where('id', $sale->delivery_marked_by)->select('name')->first();
        }

        return view('pos.sale.show', compact('sale', 'signature', 'delivered_by'));
    }


    public function edit(Sale $sale)
    {
        $users = User::where('user_type', 'pos')->where('sub_customer',true)->get();
        $products = Product::get();
        $warehouses = Warehouse::get();
        return view('pos.sale.edit', compact('products', 'users', 'sale','warehouses'));
    }


    public function update(Request $request, Sale $sale)
    {
        $this->validate($request, [
            'sales_date' => 'required|date',
            'user_id' => 'required|numeric',
            'discount' => 'required|numeric',
            'carrying_and_loading' => 'required|numeric',
            'is_condition' => 'required|numeric',
            'product' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $prev_amount = (float)$sale->amount;
            $prev_date = $sale->sales_at->toDateString();
            $prev_condition_status = $sale->is_condition;

            //Amount calculation
            $products = json_decode($request->product);
            $newProductTextForEmail = "";
            $oldProductTextForEmail = "";
            $oldSubTotal = 0;
            $subTotal = 0;
            $amount = [];
            $product_info = [];

            //for old product
            foreach ($sale->product as $item) {
                $oldQty = round($item->pivot->qty);
                $oldPrice = round($item->pivot->price);
                $oldTotal = $oldQty * $oldPrice;
                if ($item->free > 0) {
                    $oldProductTextForEmail .= "<li>{$item->product_name} = {$oldQty} x {$oldPrice} + free= {$item->free}  = {$oldTotal}</li>";
                } else {
                    $oldProductTextForEmail .= "<li>{$item->product_name} = {$oldQty} x {$oldPrice}  = {$oldTotal}</li>";
                }
                $oldSubTotal = $oldSubTotal + $oldTotal;
            }

            //for new product
            foreach ($products as $item) {
                $product_info[] = [
                    'sale_id' => $sale->id,
                    'product_id' => $item->id,
                    'qty' => $item->count,
                    'free' => $item->free,
                    'price' => $item->price,
                    'user_id' => $request->user_id,
                    'sales_at' => $request->sales_date . " " . Carbon::now()->toTimeString(),
                    'warehouse_id' => $request->warehouse_id,
                ];
                $qty = round($item->count);
                $price = round($item->price);
                $total = $qty * $price;
                if ($item->free > 0) {
                    $newProductTextForEmail .= "<li>{$item->o_name} = {$qty} x {$price} + free= {$item->free}  = {$total}</li>";
                } else {
                    $newProductTextForEmail .= "<li>{$item->o_name} = {$qty} x {$price}  = {$total}</li>";
                }
                $subTotal = $subTotal + $total;
                $amount[] = ($item->count) * ($item->price);
            }

            $netamount = array_sum($amount);
            $amount_total = ($netamount + $request->carrying_and_loading) - ($request->discount);
            $sale->user_id = $request->user_id;
            $sale->discount = $request->discount;
            $sale->carrying_and_loading = $request->carrying_and_loading;
            $sale->sales_at = $request->sales_date . " " . Carbon::now()->toTimeString();
            $sale->sales_status = 0;
            $sale->warehouse_id = $request->warehouse_id;
            $sale->approved_by = null;
            $sale->edited = true;
            $sale->is_condition = $request->is_condition;
            $sale->condition_amount = $request->condition_amount;
            $sale->amount = $amount_total;
            $sale->save();

            DB::table('product_sale')->where('sale_id', '=', $sale->id)->delete();


            $sale->product()->attach($product_info);

            $g_opt = Cache::rememberForever('g_opt', function () {
                return GeneralOption::first();
            });
            $g_opt_value = json_decode($g_opt->options, true);
            $sendstatus = 1445;

            //for tack changes
            $changed_string = "";
            $changed_string_for_email = "";
            $current_amount = (float)$sale->amount;
            if ($prev_amount !== $current_amount) {
                $changed_string .= "prev. amount: " . round($prev_amount) . " current amount: " . round($current_amount) . " ";
                $changed_string_for_email .= "<li>previous amount: " . round($prev_amount) . " current amount: " . round($current_amount) . "</li>";
            }
            if ($prev_date !== $sale->sales_at->toDateString()) {
                $changed_string .= "prev. date : " . $prev_date . " current date " . $sale->sales_at->toDateString() . " ";
                $changed_string_for_email .= "<li>previous Invoice date : {$prev_date} current Invoice date {$sale->sales_at->toDateString() } ";
            }

            if ($prev_condition_status != $sale->is_condition) {
                if ($sale->is_condition) {
                    $changed_string .= "condition booking added.condition amount: {$sale->condition_amount}";
                    $changed_string_for_email .= "<li>condition booking added.condition amount: {$sale->condition_amount} </li>";
                }
            }
            if (!empty($changed_string)) {
                $sale->update(['changes_text' => $changed_string]);
            }
            if ($g_opt_value['admin_sales_invoice_edited_notify'] == true) {
                $admin_numbers_in_array = \App\Admin::whereIn('id', $g_opt_value['admin_list_sales_invoice_edited_notify'])->pluck('phone')->toArray();
                $numbers_csv_string = (string)implode(",", $admin_numbers_in_array);

                $text = "A Invoice Is Edited By " . Auth::user()->name . ", Date: " . $sale->sales_at->format('d-m-Y') . " ID:# " . $sale->id . " Customer: " . $sale->user->name . " " . $changed_string . ". Please Approve,Thanks";
                if (!empty($changed_string)) {
                    $sendstatus = sendSMS($text, $numbers_csv_string);
                    logSMSInDB($text, $numbers_csv_string, $sendstatus);
                }
            }


            if ($g_opt_value['admin_email_sales_invoice_edited'] == true && !empty($changed_string)) {
                $noficationTo = ['model' => 'App\Admin', 'ids' => $g_opt_value['admin_list_email_sales_invoice_edited']];
                $edited_at = Carbon::now()->toDateString();
                $carrying_cost = round($sale->carrying_and_loading);
                $mailText = "A Invoice Is Edited By " . Auth::user()->name . " At {$edited_at} Invoice Date:  {$sale->sales_at->format('d-m-Y')}  ID:#  {$sale->id}  Customer:   {$sale->user->name} Address:  {$sale->user->address},  Please approve the invoice again,Thanks";

                $amountText = "<li>subtotal = {$subTotal}</li><li>discount: {$sale->discount}</li><li>carrying and loading cost: {$carrying_cost}</li><li>current payable amount: $sale->amount</li>";
                $notificationDetails = [
                    'notificationTo' => $noficationTo,
                    'mailText' => $mailText,
                    'salesDetails' => $sale,
                    'customerName' => $sale->user->name,
                    'oldProductText' => $oldProductTextForEmail,
                    'newProductText' => $newProductTextForEmail,
                    'changeStringForEmail' => $changed_string_for_email,
                    'changeString' => $changed_string,
                    'amountText' => $amountText,
                    'oldSubTotal' => $oldSubTotal,
                    'newSubTotal' => $subTotal,
                ];
                if (!empty($changed_string)) {
                    mailNotificationLogger($notificationDetails, '\App\Notifications\notifyAdminSalesInvoiceEdited');
                    Session::flash('send_mail_notification');
                }

            }
            if ($sendstatus == 1101) {
                Toastr::success('Sales Invoice Updated Successfully', 'success');
            } else {
                Toastr::success('Sales Updated Successfully', 'success');
                Toastr::error(VisionSmsResponse($sendstatus), 'error');
            }

            DB::commit();
            return $sale->id;
        } catch (QueryException $exception) {
            return $exception;
        }
    }


    public function destroy(Sale $sale)
    {
        $prev_amount = $sale->amount;
        $sale->deleted_at = now();
        $sale->sales_status = 2;
        $sale->approved_by = Auth::user()->id;
        $sale->amount = 0;
        $sale->save();
        $sale->product()->detach();

        $g_opt = Cache::rememberForever('g_opt', function () {
            return GeneralOption::first();
        });
        $g_opt_value = json_decode($g_opt->options, true);
        $sendstatus = 1445;

        //For Admin SMS
        if ($g_opt_value['admin_sales_invoice_canceled_notify'] == true) {
            $admin_numbers_in_array = \App\Admin::whereIn('id', $g_opt_value['admin_list_sales_invoice_canceled_notify'])->pluck('phone')->toArray();
            $numbers_csv_string = (string)implode(",", $admin_numbers_in_array);
            $text = "Notification: A Invoice is canceled by " . Auth::user()->name . " Customer:  " . $sale->user->name . " invoice ID #" . $sale->id . " Invoice Date: " . $sale->sales_at->toDateString() . " amount: " . $prev_amount . " Thanks (" . $this->company_name . ")";
            $sendstatus = sendSMS($text, $numbers_csv_string);
            logSMSInDB($text, $numbers_csv_string, $sendstatus);
        }

        //For Customer SMS
        if ($g_opt_value['customer_sales_invoice_canceled_notify'] == true) {
            if ($sale->user->phone != null) {
                $numbers = $sale->user->phone;
                $text = $sale->user->name . " your invoice #" . $sale->id . " that was created on " . $sale->sales_at->toDateString() . " amount: " . $prev_amount . " is canceled by " . Auth::user()->name . " for any query call " . $this->company_phone . " (" . $this->company_name . ")";
                $sendstatus = sendSMS($text, $numbers_csv_string);
                logSMSInDB($text, $numbers, $sendstatus);
            }
        }

        Toastr::success('Sales cancelled Successfully', 'success');
        return redirect()->back();
    }

    public function invoice(Request $request, $id)
    {
        $general_opt = Cache::get('g_opt') ?? GeneralOption::first();
        $general_opt_value = json_decode($general_opt->options, true);
        $sale = Sale::findOrFail($id);
        $current_user = User::findOrFail($sale->user_id);
        if (empty($sale->approved_by)) {
            $signature = null;
        } else {
            $signature = Admin::where('id', $sale->approved_by)->select('name', 'signature')->first();
        }


        // return view('pos.sale.invoice', compact('sale', 'current_user', 'general_opt_value', 'signature'));
        $pdf = PDF::loadView('pos.sale.invoice', compact('sale', 'current_user', 'general_opt_value', 'signature'));
        Storage::put('public/invoices/' . Str::slug($current_user->name) . '-date-' . $sale->sales_at->format('d-m-Y') . '.pdf', $pdf->output());
        return $pdf->download($current_user->name . ' date: ' . $sale->sales_at . '.pdf');
    }

    public function approve(Request $request, $id)
    {
        $sale = Sale::with('product')->findOrFail($id);
        if ($sale->sales_status == 1) {
            abort(403, 'Invoice Already Approved');
        } else {
            $sale->sales_status = 1;
            $sale->approved_by = Auth::user()->id;
            $sale->save();

            $g_opt = Cache::rememberForever('g_opt', function () {
                return GeneralOption::first();
            });
            $g_opt_value = json_decode($g_opt->options, true);
            $customer_sms_status = 1011;
            $delivery_agent_sms_status = 1011;
            $delivery_agent_sms_text = "";
            $customer_sms_text = "";
            $max_days_delay_for_allowing_sms = (integer)$g_opt_value['sms_delay_in_days'];
            $max_product_character_allowed = (integer)$g_opt_value['max_product_character_allowed'];
            $is_customer_sms_includes_product_information = (boolean)$g_opt_value['cust_sales_invoice_includes_product'];
            $is_delivery_agent_sms_includes_product_information = (boolean)$g_opt_value['d_agent_sales_invoice_includes_product'];
            $numbers_csv_string = "";

            if ($sale->sales_at->diffInDays(now()) < $max_days_delay_for_allowing_sms) {
                //For sendgin product information
                $product_information = "";
                //check if customer sms includes product information
                foreach ($sale->product as $pd) {
                    if ($pd->pivot->free > 0) {
                        $product_information .= $pd->product_name . " = " . $pd->pivot->qty . "x" . round($pd->pivot->price) . "+ free=" . $pd->pivot->free . ",";
                    } else {
                        $product_information .= $pd->product_name . " = " . $pd->pivot->qty . "x" . round($pd->pivot->price) . ",";
                    }
                }
                $product_information_character_checked = "";
                if (strlen($product_information) < $max_product_character_allowed) {
                    $product_information_character_checked = " Products: " . $product_information;
                }

                $customer_product_text = $is_customer_sms_includes_product_information == true ? $product_information_character_checked : "";
                $delivery_agent_product_text = $is_delivery_agent_sms_includes_product_information ? $product_information_character_checked : "";


                $condition_booking_text = "";
                if ($sale->is_condition == true) {
                    $condition_booking_text = "  and parcel condition amount is " . round($sale->condition_amount);
                }


                //(Delivery Agent Text (check if the invoice is  edited and check already send a sms to Delivery Agent then send sms)
                if ($sale->edited == true && $sale->d_agent_sms == true && $g_opt_value['d_agent_sales_invoice_edited_notify'] == true) {
                    //SMS For Delivery Agent
                    $delivery_agent_sms_text = "A Invoice is Edited ID:#" . $sale->id . " Date: " . $sale->sales_at->format('d-m-Y') . " Customer: " . $sale->user->name . ",  " . $sale->user->address . $delivery_agent_product_text . " Please disregard previous invoice, Thanks";

                } elseif ($g_opt_value['d_agent_sales_invoice_created_notify'] == true) {
                    $delivery_agent_sms_text = "New Invoice ID:#" . $sale->id . " Date: " . $sale->sales_at->format('d-m-Y') . " Customer: " . $sale->user->name . ",  " . $sale->user->address . $condition_booking_text . $delivery_agent_product_text . ". Please Deliver This Product ASAP, Thanks";

                }else{
                    $delivery_agent_sms_status = 1445;
                }

                if (!empty($delivery_agent_sms_text)) {
                    $d_agent_numbers_in_array = \App\Admin::whereIn('id', $g_opt_value['d_agent_list_sales_invoice_notify'])->pluck('phone')->toArray();
                    $numbers_csv_string = (string)implode(",", $d_agent_numbers_in_array);

                    $delivery_agent_sms_status = sendSMS($delivery_agent_sms_text, $numbers_csv_string);
                    logSMSInDB($delivery_agent_sms_text, $numbers_csv_string, $delivery_agent_sms_status);
                    if ($delivery_agent_sms_status == 1101) {
                        DB::table('sales')
                            ->where('id', $sale->id)
                            ->update(['d_agent_sms' => true]);
                    }
                }

                //Customer SMS Text (check if the invoice is  edited and check already send a sms to customer)
                if($g_opt_value['customer_sales_invoice_edited_notify'] == true){
                    if ($sale->edited == true && $sale->cust_sms == true) {
                        //SMS For Customer
                        $customer_sms_text = $sale->user->name . ", your invoice ID#" . $sale->id . " is little bit changed." . $customer_product_text . " your current payable amount: " . round($sale->amount) . $condition_booking_text . ". Prepared By: " . $sale->provided_by . "(" . $this->company_name . ")";
                    } elseif ($g_opt_value['customer_sales_invoice_created_notify'] == true) {
                        $customer_sms_text = $sale->user->name . ", your invoice ID#" . $sale->id . " is created " . $customer_product_text . ". your total payable amount: " . round($sale->amount) . $condition_booking_text . ". Prepared By: " . $sale->provided_by . "(" . $this->company_name . ")";

                    }
                }else {
                    $customer_sms_status = 1445;
                }
                $customer_phone = $sale->user->phone;
                if (!empty($customer_sms_text) && !empty($customer_phone) &&  $sale->user->sms_alert == true) {

                    $customer_sms_status = sendSMS($customer_sms_text, $customer_phone);
                    logSMSInDB($customer_sms_text, $customer_phone, $customer_sms_status);
                    if ($customer_sms_status == 1101) {
                        DB::table('sales')
                            ->where('id', $sale->id)
                            ->update(['cust_sms' => true]);
                    }
                }else{
                    $customer_sms_status = 1445;
                }

            }

            return ['id' => $sale->id, 'cust_sms_status' => VisionSmsResponse($customer_sms_status), 'cust_sms_body' => $customer_sms_text, 'delivery_agent_sms_status' => VisionSmsResponse($delivery_agent_sms_status), 'delivery_agent_sms_body' => $delivery_agent_sms_text, 'msg' => 'Sales Invoice Approved Successfully', 'amount' => $sale->amount, 'delivery_agent_number' => $numbers_csv_string, 'cust_number' => $sale->user->phone, 'cust_name' => $sale->user->name];


        }

    }


    public function delivery(Request $request, $id)
    {

        if ($request->deliverymode === "courier") {
            $this->validate($request, [
                'courier_name' => 'required',
                'booking_amount' => 'required|integer',
                'cn_number' => 'required',
                'delivered_by' => 'required',
                'deliverymode' => 'required',
                'delivery_date' => 'required|date',
                'transportation_expense' => 'required|integer',
            ]);
        } else {
            $this->validate($request, [
                'delivered_by' => 'required',
                'delivery_date' => 'required|date',
                'transportation_expense' => 'required|integer',
            ]);
        }

        $text = "";
        $is_condition_booking = $request->has('is_condition') ? true : false;
        $is_send_sms = $request->has('send_sms') ? true : false;


        $deliveryinfo = ["delivery_date" => $request->delivery_date, "deliverymode" => $request->deliverymode, "is_condition" => $is_condition_booking, "courier_name" => $request->courier_name, "booking_amount" => $request->booking_amount, "cn_number" => $request->cn_number, "condition_amount" => $request->condition_amount, "delivered_by" => $request->delivered_by, "transportation_expense" => $request->transportation_expense];

        $sale = Sale::findOrFail($id);
        $sale->timestamps = false;
        $sale->delivery_status = 1;
        $sale->deliveryinfo = $deliveryinfo;
        $sale->delivery_marked_by = Auth::user()->id;
        $sale->save();
        $sendstatus = 1445;
        $g_opt = Cache::rememberForever('g_opt', function () {
            return GeneralOption::first();
        });
        $g_opt_value = json_decode($g_opt->options, true);
        if ($g_opt_value['admin_sales_invoice_created_notify'] == true && $is_send_sms == true) {
            //Check If User Has Phone Number
            if ($sale->user->phone != null) {
                //If Booked By Courier
                if ($request->deliverymode === "courier") {
                    $condition_booking_text = $is_condition_booking == true ? "(condition booking-" . $request->condition_amount . "Tk)" : "";

                    $text = $sale->user->name . " greetings from " . $this->company_name . " Invoice Date:" . $sale->sales_at->format('d-M-Y') . " Net Amount:" . $sale->amount . "  & your product has been booked On the " . $request->courier_name . " CN Number : " . $request->cn_number . " " . $condition_booking_text . " if You already got the product please disregard this sms Thanks";


                } else {
                    $text = $sale->user->name . " greetings from " . $this->company_name . " Your Product Has Been Delivered To You On the " . $request->deliverymode . "Invoice Date:" . $sale->sales_at->format('d-M-Y') . " Net Amount:" . $sale->amount . " Thanks";
                }

                $number = $sale->user->phone;
                $sendstatus = sendSMS($text, $number);
                logSMSInDB($text, $number, $sendstatus);

                if ($sendstatus == 1101) {
                    return ['id' => $sale->id, 'smsstatus' => $sendstatus, 'msg' => 'Delivery Information Saved Successfully An sms has been sent to ' . $number, 'customer' => $sale->user->name, 'sms' => $text, 'smsnumber' => $number];
                } else {
                    return ['id' => $sale->id, 'customer' => $sale->user->name, 'smsstatus' => $sendstatus, 'msg' => 'Delivery Information Saved Successfully', 'error_code' => VisionSmsResponse($sendstatus)];
                }

            } else {
                return ['id' => $sale->id, 'customer' => $sale->user->name, 'smsstatus' => 1002, 'msg' => 'Delivery Information Saved Successfully', 'error_code' => 'Phone Number Is Empty Please Update The Customer Phone Number'];
            }


        } else {
            return ['id' => $sale->id, 'customer' => $sale->user->name, 'smsstatus' => 1002, 'msg' => 'Delivery Information Saved Successfully', 'error_code' => 'No SMS Sent'];
        }


    }


}
