<?php

namespace App\Http\Controllers;

use App\Supplier;
use Carbon\Carbon;
use App\Supplierdue;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class SupplierdueController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:supplier_due.index')->only('index','show');
        $this->middleware('permission:supplier_due.create')->only('create','store');
        $this->middleware('permission:supplier_due.edit')->only('edit','update');
        $this->middleware('permission:supplier_due.cancel')->only('destroy');
    }


    public function index()
    {
        $suppliers = Supplier::all();
        $suppliersdue =  Supplierdue::all();
        return view('supplierdue.index',compact('suppliers','suppliersdue'));
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
    public function store(Request $request)
    {
        $this->validate($request,[
            'due_at' => 'required|date',
            'supplier' => 'required|numeric',
            'amount' => 'required|numeric',
            'reference' => 'required|max:10',
        ]);

        $sd = new Supplierdue;
        $sd->due_at = $request->due_at." ".Carbon::now()->toTimeString();;
        $sd->supplier_id = $request->supplier;
        $sd->amount = $request->amount;
        $sd->reference = $request->reference;
        $sd->admin_id = Auth::user()->id;
        $sd->save();
        Toastr::success('Due Saved Successfully', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplierdue  $supplierdue
     * @return \Illuminate\Http\Response
     */
    public function show(Supplierdue $supplierdue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplierdue  $supplierdue
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplierdue $supplierdue)
    {
        return $supplierdue;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplierdue  $supplierdue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplierdue $supplierdue)
    {
        $this->validate($request,[
            'due_at' => 'required|date',
            'supplier' => 'required|numeric',
            'amount' => 'required|numeric',
            'reference' => 'required|max:10',
        ]);


        $supplierdue->due_at = $request->due_at." ".Carbon::now()->toTimeString();;
        $supplierdue->supplier_id = $request->supplier;
        $supplierdue->amount = $request->amount;
        $supplierdue->reference = $request->reference;
        $supplierdue->admin_id = Auth::user()->id;
        $supplierdue->save();
        Toastr::success('Due Updated Successfully', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplierdue  $supplierdue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplierdue $supplierdue)
    {
        //
    }
}
