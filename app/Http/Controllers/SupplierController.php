<?php

namespace App\Http\Controllers;
use Session;
use App\Supplier;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\SupplierStoreRequest;

class SupplierController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:suppliers.index')->only('index','show');
        $this->middleware('permission:suppliers.edit')->only('create', 'store','edit', 'update','destroy');
    }


    public function index()
    {
        $suppliers = Supplier::paginate(10);
        return view('suppliers.index',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierStoreRequest $request)
    {
        $supplier = new Supplier;
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->company = $request->company;
        $supplier->save();
        Toastr::success('Supplier Created Successfully', 'success');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return  Supplier::findOrFail($supplier->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $this->validate($request,[
            'name' => 'required|unique:suppliers,name,'.$supplier->id,
            'company' => 'required',
            'phone' => 'required|unique:suppliers,phone,'.$supplier->id,
            'address' => 'required',
        ]);
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->company = $request->company;
        $supplier->save();
        Toastr::success('Supplier Created Successfully', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        Session::flash('delete_success', 'Your Tags Has been Deleted Successfully');
        return redirect()->back();
    }
}
