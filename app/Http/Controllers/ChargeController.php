<?php

namespace App\Http\Controllers;

use App\Charge;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\ChargeUpdateRequest;

class ChargeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:Ecommerce Section');
    }
    
    public function index(){
        $charges = Charge::first();
        return view('admin.charge.index',compact('charges'));
    }
    public function edit($id){
        return Charge::findOrFail($id);
        
    }

    public function update(ChargeUpdateRequest $request,$id){
        $cahrges = Charge::findOrFail($id);
        $cahrges->shipping = $request->shipping;
        $cahrges->vat = $request->vat;
        $cahrges->tax = $request->tax;
        $cahrges->discount = $request->discount;
        $cahrges->save();
        Toastr::success('Charge Information Updated Successfully', 'success');
        return redirect()->back();
    }
}
