<?php

namespace App\Http\Controllers;

use App\Division;
use App\Product;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use Session;
class pharmacyCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:pharmacy_customers.index')->only('index');
        $this->middleware('permission:pharmacy_customers.edit')->only('edit','update');
        $this->middleware('permission:pharmacy_customers.create')->only('create','store');
        $this->middleware('permission:pharmacy_customers.show')->only('show');
        $this->middleware('permission:pharmacy_customers.delete')->only('destroy');
    }


    public function index()
    {
        $customers = User::where('user_type', 'pos')->where('sub_customer',false)->orderBy('updated_at','desc')->get();
        return view('customer.pharmacy_index', compact('customers'));
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
        return redirect(route('pharmacy_customers.index'));
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
            'proprietor' => 'max:30',
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
        return redirect(route('pharmacy_customers.index'));
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

}
