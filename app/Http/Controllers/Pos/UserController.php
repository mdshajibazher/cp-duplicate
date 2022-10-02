<?php

namespace App\Http\Controllers\Pos;

use App\Admin;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;
use Session;
use App\User;
use App\Product;
use App\Section;
use App\District;
use App\Division;
use App\GeneralOption;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:mpo_customers.index')->only('index');
        $this->middleware('permission:mpo_customers.edit')->only('edit','update');
        $this->middleware('permission:mpo_customers.create')->only('create','store');
        $this->middleware('permission:mpo_customers.show')->only('show');
        $this->middleware('permission:mpo_customers.delete')->only('destroy');
    }


    public function index()
    {
        $customers = User::where('user_type', 'pos')->where('sub_customer',true)->orderBy('updated_at','desc')->get();
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $divisions = Division::all();
        $sections = Section::where('module', 'inventory')->get();
        return view('customer.create', compact('divisions', 'sections'));
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
            'name' => 'required|string|max:30',
            'phone' => 'required|unique:users',
            'inventory_email' => 'nullable|unique:users',
            'division' => 'required',
            'section' => 'required|integer',
            'address' => 'required|max:500',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->inventory_email = $request->inventory_email;
        $user->phone = $request->phone;
        $user->division_id = $request->division;
        $user->address = $request->address;
        $user->section_id = $request->section;
        $user->sms_alert = $request->sms_alert ?? 0;
        $user->sub_customer = $request->sub_customer;
        $user->sub_customer_json = json_encode($request->sub_customer_json) ?? "";
        $user->password = NULL;
        $user->user_type = 'pos';
        if ($request->has('company')) {
            $user->company = $request->company;
        }
        $user->status = 0;
        $user->save();
        Session::flash('success', 'Customer created successfully');
        return redirect(route('customers.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Product::all();
        $customer = User::findOrFail($id);
        $divisions = Division::all();
        $sections = Section::where('module', 'inventory')->get();
        $pricedata = $customer->pricedata;
        return view('customer.edit', compact('divisions', 'customer', 'products', 'pricedata', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:30',
            'inventory_email' => 'nullable|unique:users,inventory_email,'.$id,
            'phone' => 'nullable|unique:users,phone,'.$id,
            'division' => 'required',
            'section' => 'required',
            'address' => 'required|max:500',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->inventory_email = $request->inventory_email;
        $user->phone = $request->phone;
        $user->division_id = $request->division;
        $user->section_id = $request->section;
        $user->address = $request->address;
        $user->sms_alert = $request->sms_alert ?? 0;
        $user->sub_customer = $request->sub_customer ?? 0;
        $user->sub_customer_json =   $request->sub_customer ?  json_encode($request->sub_customer_json) ?? "" : "";
        if (strlen($request->pricedata) < 6) {
            $user->pricedata = null;
        } else {
            $user->pricedata = $request->pricedata;
        }
        $user->user_type = 'pos';
        if ($request->has('company')) {
            $user->company = $request->company;
        }
        $user->status = 0;
        $user->save();
        Session::flash('success', 'Customer Updated successfully');
        return redirect(route('customers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return false;
    }

    public function export(Request $request)
    {
        $general_opt = Cache::get('g_opt') ?? GeneralOption::first();
        $general_opt_value = json_decode($general_opt->options, true);
        $customers = User::where('user_type', 'pos')->get();
        $pdf = PDF::loadView('customer.export', compact('customers', 'general_opt_value'));
        return $pdf->download('Customer Export' . time() . '.pdf');
    }

    public function getCustomers(Request $request)
    {
        $search = $request->search;
        $customers = User::query();
        if($request->has('pharmacy_customer')){
            $customers->where('sub_customer',false);
        }

        if ($search == '') {
            $customers->select('id', 'name')->orderby('name', 'asc')->limit(150);
        } else {
            $customers->where('name', 'like', '%' . $search . '%')->select('id', 'name')->orderby('name', 'asc')->limit(200);
        }
        $getCustomers = $customers->get();

        $response = array();
        foreach ($getCustomers as $customer) {
            $response[] = array(
                "id" => $customer->id,
                "text" => $customer->name
            );
        }
        return response()->json($response);
    }

    function getCustomersByIds(Request $request){
        $customers =  User::whereIn('id',$request->ids)->get();
        $response = array();
        foreach ($customers as $customer) {
            $response[] = array(
                "id" => $customer->id,
                "text" => $customer->name
            );
        }

        return response()->json($response);
    }

    function getCustomerById(Request $request){
        $customers =  User::where('id',$request->id)->get();
        $response = array();
        foreach ($customers as $customer) {
            $response[] = array(
                "id" => $customer->id,
                "text" => $customer->name
            );
        }
        return response()->json($response);
    }

    public function giveLoginAccess(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);
        $user = User::findOrFail($request->id);
        $checkPhoneAlreadyExist = DB::table('admins')->where('phone',$user->phone)->first();
        if($checkPhoneAlreadyExist){
            Toastr::error('Phone number already exist in admin list try a different number', 'Already Exists');
            return redirect()->back();
        }
        $OTP = rand(1,99).rand(1,99);
        $admin = new Admin;
        $admin->user_id = $request->id;
        $admin->password = Hash::make($OTP);
        $admin->name = $user->name;
        $admin->adminname = Str::slug($request->name);
        $admin->email = $user->email ?? "";
        $admin->phone = $user->phone ?? "";
        $admin->password_changed = false;
        $admin->save();
        $user->login_access = true;
        $user->save();
        $admin->assignRole('Marketing Manager');
        $siteName = config('custom_variable.app_name');
        $text = "{$siteName} OTP Code is $OTP, Thanks";
        $sendstatus = sendSMS($text, $user->phone);
        logSMSInDB($text, $user->phone, $sendstatus);
        Toastr::success('Login Access created Successfully', 'success');
        return redirect()->back();
    }
}
