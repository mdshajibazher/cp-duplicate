<?php

namespace App\Http\Controllers;
use PDF;
use App\Admin;
use App\DailyOrder;
use App\GeneralOption;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class DailyOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:daily_order.index')->only('index');
        $this->middleware('permission:daily_order.show')->only('show');
        $this->middleware('permission:daily_order.create')->only('create', 'store');
        $this->middleware('permission:daily_order.edit')->only('edit', 'update');
        $this->middleware('permission:daily_order.cancel')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $currentUserRole = Auth::user()->roles->pluck('name');
            if(count($currentUserRole) > 0 && $currentUserRole[0] === 'Super Admin'){
                $dailyorderQuery = DailyOrder::query()->with(['product']);
            }else{
                $dailyorderQuery = DailyOrder::query()->where('admin_id',Auth::user()->id)->with(['product']);
            }

            $logs = Datatables::of($dailyorderQuery)
                ->addIndexColumn()
                ->editColumn('id', function ($row) {
                    return "#".$row->id;
                })
                ->editColumn('date', function ($row) {
                    return $row->date->format('d-m-Y');
                })
                ->editColumn('status', function ($row) {
                    return FashiSalesStatus($row->status);
                })

                ->addColumn('customer', function ($row) {
                    return $row->user->name;
                })

                ->addColumn('action', function ($row) {
                    $actionbtn = '<button  onclick="showOrderData('.$row->id.')"    type="buttton"  class="btn btn-info btn-sm edit"><i class="fas fa-eye"></i></button> | <a href="'.route('daily_orders.edit',$row->id).'"  type="buttton"  class="btn btn-warning btn-sm edit"><i class="fas fa-edit"></i></a>';
                    return $actionbtn;
                })
                ->filter(function ($query) use ($request, $dailyorderQuery) {
                  if($request['search']['value']){
                      $userIds = User::where('name', 'like', "%" . $request['search']['value'] . "%")->pluck('id')->toArray();
                      $query->whereIn('user_id', $userIds);
                  }
                })
                ->rawColumns(['action','status'])
                ->make(true);
            return $logs;

        }

        return view('daily_orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('daily_orders.form');
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
            'date' => 'required|date',
            'user_id' => 'required|integer',
            'references' => 'required',
            'shipping' => 'required',
            'discount' => 'required',
            'product_details' => 'required|min:3',
        ]);
        $productDetails = json_decode($request->product_details);
        $productText = "";
        $amount = [];
        foreach ($productDetails as $item) {
            $qty = round($item->qty);
            $price = round($item->price);
            $productText .= "{$item->o_name} = {$qty} x {$price},";
            $amount[] = ($item->qty) * ($item->price);
        }
        $productText = substr($productText, 0, -1);
        $netAmount = array_sum($amount);
        $amount_total = ($netAmount + $request->shipping) - ($request->discount);

        $dailyOrderFormattedRequest = [
            'date' => $request->date,
            'user_id' => $request->user_id,
            'references' => $request->references,
            'discount' => $request->discount,
            'shipping' => $request->shipping,
            'amount' => $amount_total,
            'admin_id' => Auth::user()->id,
        ];

        $dailyOrderInstance = DailyOrder::Create($dailyOrderFormattedRequest);
        $pivotDetails = [];
        foreach ($productDetails as $product) {
            $pivotDetails[] = [
                'daily_order_id' => $dailyOrderInstance->id,
                'user_id' => $dailyOrderInstance->user_id,
                'product_id' => $product->id,
                'qty' => $product->qty,
                'price' => $product->price,
                'date' => $dailyOrderInstance->date,
                'admin_id' => Auth::user()->id
            ];
        }
        $dailyOrderInstance->product()->attach($pivotDetails);

        //sms sending procedure
        $g_opt = Cache::rememberForever('g_opt', function () {
            return GeneralOption::first();
        });
        $g_opt_value = json_decode($g_opt->options, true);
        $sendstatus = 1445;
        if ($g_opt_value['admin_daily_order_created_notify'] == true) {
            $admin_numbers_in_array = \App\Admin::whereIn('id', $g_opt_value['admin_list_daily_order_created_notify'])->pluck('phone')->toArray();
            $numbers_csv_string = (string)implode(",", $admin_numbers_in_array);
            $max_product_character_allowed = (integer)$g_opt_value['max_product_character_allowed'];
            $product_information_character_checked = "";
            if (strlen($productText) < $max_product_character_allowed) {
                $product_information_character_checked = " Products: " . $productText;
            }
            $formattedDate = $dailyOrderInstance->date->format('d-m-Y');
            $text = "New daily order, Date:  {$formattedDate}  ID:#  {$dailyOrderInstance->id}  Customer:   {$dailyOrderInstance->user->name} , {$product_information_character_checked} Amount: {$amount_total} Prepared By:" . Auth::user()->name . "Thanks";
            $sendstatus = sendSMS($text, $numbers_csv_string);
            logSMSInDB($text, $numbers_csv_string, $sendstatus);
        }

        return ['message' => 'Daily order created successfully'];

    }

    /**
     * Display the specified resource.
     *
     * @param \App\DailyOrder $dailyOrder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return  DailyOrder::with('product','user','admin')->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\DailyOrder $dailyOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(Request  $request,$id)
    {
        $dailyOrder = DailyOrder::with('product','user','admin')->findOrFail($id);
        $currentUserRole = Auth::user()->roles->pluck('name');
        if(count($currentUserRole) > 0 && $currentUserRole[0] !== 'Super Admin') {
            if ($dailyOrder->admin_id != Auth::user()->id) {
                abort('403');
            }
        }
        $productJSON = [];
        if(isset($dailyOrder->product)){
            foreach($dailyOrder->product as $product){
                $productNameSpaceRemove = str_replace(' ', '', $product->product_name);
                $productJSON[] = [
                    'o_name' => $product->product_name,
                    'name' => $productNameSpaceRemove,
                    'qty'   => $product->pivot->qty,
                    'price'   => $product->pivot->price,
                    'id'   => $product->id,
                ];
            }
        }
        $productJSON= json_encode($productJSON);
        return view('daily_orders.form', compact('dailyOrder','productJSON'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\DailyOrder $dailyOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyOrder $dailyOrder)
    {
        $this->validate($request, [
            'date' => 'required|date',
            'user_id' => 'required|integer',
            'references' => 'required',
            'shipping' => 'required',
            'discount' => 'required',
            'product_details' => 'required|min:3',
        ]);

        $productDetails = json_decode($request->product_details);
        $productText = "";
        $amount = [];
        foreach ($productDetails as $item) {
            $qty = round($item->qty);
            $price = round($item->price);
            $productText .= "{$item->o_name} = {$qty} x {$price},";
            $amount[] = ($item->qty) * ($item->price);
        }
        $productText = substr($productText, 0, -1);
        $netAmount = array_sum($amount);
        $amount_total = ($netAmount + $request->shipping) - ($request->discount);
        $dailyOrderFormattedRequest = [
            'date' => $request->date,
            'user_id' => $request->user_id,
            'references' => $request->references,
            'discount' => $request->discount,
            'shipping' => $request->shipping,
            'amount' => $amount_total,
            'admin_id' => Auth::user()->id,
        ];
        $dailyOrder->update($dailyOrderFormattedRequest);
        $pivotDetails = [];
        foreach ($productDetails as $product) {
            $pivotDetails[] = [
                'daily_order_id' => $dailyOrder->id,
                'user_id' => $dailyOrder->user_id,
                'product_id' => $product->id,
                'qty' => $product->qty,
                'price' => $product->price,
                'date' => $dailyOrder->date,
                'admin_id' => Auth::user()->id
            ];
        }
        $dailyOrder->product()->detach();
        $dailyOrder->product()->attach($pivotDetails);

        //sms sending procedure
        $g_opt = Cache::rememberForever('g_opt', function () {
            return GeneralOption::first();
        });
        $g_opt_value = json_decode($g_opt->options, true);
        $sendstatus = 1445;
        if ($g_opt_value['admin_daily_order_edited_notify'] == true) {
            $admin_numbers_in_array = \App\Admin::whereIn('id', $g_opt_value['admin_list_daily_order_edited_notify'])->pluck('phone')->toArray();
            $numbers_csv_string = (string)implode(",", $admin_numbers_in_array);
            $max_product_character_allowed = (integer)$g_opt_value['max_product_character_allowed'];

            $product_information_character_checked = "";
            if (strlen($productText) < $max_product_character_allowed) {
                $product_information_character_checked = " Products: " . $productText;
            }
            $formattedDate = $dailyOrder->date->format('d-m-Y');
            $text = "A Daily Order is edited by ,". Auth::user()->name ." Date:  {$formattedDate}  ID:#  {$dailyOrder->id}  Customer:   {$dailyOrder->user->name},Amount: {$amount_total}  {$product_information_character_checked}, Thanks";
            $sendstatus = sendSMS($text, $numbers_csv_string);
            logSMSInDB($text, $numbers_csv_string, $sendstatus);
        }

        return ['message' => 'Daily order Updated successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\DailyOrder $dailyOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyOrder $dailyOrder)
    {
        //
    }

    public function dailyOrderByAdmin(){
        return DailyOrder::with('product','user','admin')->where('admin_id',Auth::user()->id)->orderBy('updated_at','DESC')->get();
    }

    public function approve(Request $request){
        $dailyOrder = DailyOrder::findOrFail($request->id);
        $dailyOrder->status = 1;
        $dailyOrder->approved_by = Auth::user()->id;
        $dailyOrder->save();
        return response()->json(['message' => 'Order approved Successfully','order_data' => $dailyOrder ]);;
    }

    public function generatePDF(Request $request){
        $general_opt = Cache::get('g_opt') ?? GeneralOption::first();
        $general_opt_value = json_decode($general_opt->options, true);
        $dailyOrder = DailyOrder::findOrFail($request->daily_order_id);
        $current_user = User::findOrFail($dailyOrder->user_id);
        if (empty($dailyOrder->approved_by)) {
            $signature = null;
        } else {
            $signature = Admin::where('id', $dailyOrder->approved_by)->select('name', 'signature')->first();
        }
        $pdf = PDF::loadView('daily_orders.invoice', compact('dailyOrder', 'current_user', 'general_opt_value', 'signature'));
        Storage::put('public/daily_order/' . Str::slug($current_user->name) . '-date-' . $dailyOrder->date->format('d-m-Y') . '.pdf', $pdf->output());
        return $pdf->download($current_user->name . ' date: ' . $dailyOrder->date . '.pdf');
    }
}
