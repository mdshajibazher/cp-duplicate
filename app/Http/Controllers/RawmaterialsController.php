<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Product;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class RawmaterialsController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:products.index')->only('index');
        $this->middleware('permission:products.show')->only('show');
        $this->middleware('permission:products.create')->only('create', 'store');
        $this->middleware('permission:products.edit')->only('edit', 'update');
    }


    public function index(){
        $rawmaterials = Product::where('type','raw')->get();
        return view('raw.index',compact('rawmaterials'));
    }

    public function create(){
        $units = Unit::all();
        return view('raw.create',compact('units'));
    }


    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|max:35',
            'price' => 'required',
            'unit' => 'required',
        ]);

        $rawmaterials = new Product;

        $rawmaterials->product_name = $request->name;
        $rawmaterials->price = $request->price;
        $rawmaterials->current_price = $request->price;
        $rawmaterials->discount_price = 0;
        $rawmaterials->category_id = 1;
        $rawmaterials->subcategory_id = 1;
        $rawmaterials->brand_id = 1;
        $rawmaterials->description = ".";
        $rawmaterials->size_id = 1;
        $rawmaterials->unit_id = $request->unit;
        $rawmaterials->type = 'raw';
        $rawmaterials->save();

        Toastr::success('Raw Materials Added Successfully', 'success');
        return redirect()->route('raw.index');
    }

    public function show($id){
         $rawmaterial =  Product::findOrFail($id);
         return view('raw.show',compact('rawmaterial'));
    }

    public function edit($id){
        $rawmaterial =  Product::findOrFail($id);
        $units = Unit::all();
        return view('raw.edit',compact('rawmaterial','units'));

    }

    public function update(Request $request,$id){
        $rawmaterial =  Product::findOrFail($id);
        $rawmaterial->product_name = $request->name;
        $rawmaterial->price = $request->price;
        $rawmaterial->current_price = $request->price;
        $rawmaterial->unit_id = $request->unit;
        $rawmaterial->save();
        Toastr::success('Raw Meterials Updated Successfully', 'success');
        return redirect()->route('raw.index');
    }
}
