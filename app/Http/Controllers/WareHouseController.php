<?php

namespace App\Http\Controllers;

use App\Warehouse;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class WareHouseController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:warehouse.index')->only('index');
        $this->middleware('permission:warehouse.create')->only('create','store');
        $this->middleware('permission:warehouse.edit')->only('edit','update');
        $this->middleware('permission:warehouse.show')->only('show');
    }
    public function index(){
        $warehouses = Warehouse::orderBy('updated_at','DESC')->get();
        return view('warehouse.index',compact('warehouses'));
    }

    public function create(){
        return view('warehouse.form');
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|max:40|unique:warehouses',
            'in_charge' => 'required|max:30',
            'address' => 'required|max:300',
        ]);

        $warehouse = Warehouse::create($request->all());
        if($warehouse){
            Toastr::success('Warehouse created successfully','Success');
        }
        return redirect()->route('warehouse.index');
    }

    public function edit(Warehouse $warehouse){
        return view('warehouse.form',compact('warehouse'));
    }

    public function update(Request $request,$id){
        $this->validate($request,[
            'name' => 'required|max:40|unique:warehouses,name,'.$id,
            'in_charge' => 'required|max:30',
            'address' => 'required|max:300',
        ]);

        $warehouse = Warehouse::findOrFail($id)->update($request->all());
        if($warehouse){
            Toastr::success('Warehouse updated successfully','Success');
        }
        return redirect()->route('warehouse.index');
    }


}
