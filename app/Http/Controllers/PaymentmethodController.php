<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Paymentmethod;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PaymentmethodController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:payment_methods');
    }


    public function index()
    {
        $paymentmethods = Paymentmethod::all();
        return view('paymentmethod.index',compact('paymentmethods'));
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
            'name' => 'required|max:20',
            'ac_number' => 'max: 50',
            'description' => 'required|max: 300',
            'image' => 'required|image',
        ]);

        $paymentmethod = new Paymentmethod;
        if($request->hasFile('image')){
            //get form image
            $image = $request->file('image');
            $slug = Str::slug($request->name);
            $current_date = Carbon::now()->toDateString();
            //get unique name for image
            $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();
            //new location for new image
            $original_location = public_path('uploads/paymentmethod/original/'.$image_name);

           // $resize_location = public_path('uploads/products/resize/'.$image_name);

            //resize image for category and upload temp
            //Image::make($image)->fit(650,450)->save($resize_location);

            Image::make($image)->save($original_location);
            $paymentmethod->image =  $image_name;
         }

        $paymentmethod->name = $request->name;
        $paymentmethod->ac_number = $request->ac_number;
        $paymentmethod->description = $request->description;
        $paymentmethod->save();
        Toastr::success('Paymentmethod  Saved Successfully', 'success');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paymentmethod  $paymentmethod
     * @return \Illuminate\Http\Response
     */
    public function show(Paymentmethod $paymentmethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paymentmethod  $paymentmethod
     * @return \Illuminate\Http\Response
     */
    public function edit(Paymentmethod $paymentmethod)
    {
        return $paymentmethod;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paymentmethod  $paymentmethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paymentmethod $paymentmethod)
    {
        $this->validate($request,[
            'name' => 'required|max:20',
            'ac_number' => 'max: 50',
            'description' => 'required|max: 300',
            'image' => 'image',
        ]);
        if($request->hasFile('image')){
            //get form image
            $image = $request->file('image');
            $slug = Str::slug($request->name);
            $current_date = Carbon::now()->toDateString();
            //get unique name for image
            $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();

            //Delete Old Image
            $old_original_location = public_path('uploads/paymentmethod/original/'.$paymentmethod->image);

            if (File::exists($old_original_location)) {
                File::delete($old_original_location);
            }

            //new location for new image
            $original_location = public_path('uploads/paymentmethod/original/'.$image_name);

            Image::make($image)->save($original_location);
            $paymentmethod->image =  $image_name;
         }

        $paymentmethod->name = $request->name;
        $paymentmethod->ac_number = $request->ac_number;
        $paymentmethod->description = $request->description;
        $paymentmethod->save();
        Toastr::success('Paymentmethod  Updated Successfully', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paymentmethod  $paymentmethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paymentmethod $paymentmethod)
    {
        //
    }
}
