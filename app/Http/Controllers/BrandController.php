<?php

namespace App\Http\Controllers;
use Session;
use App\Brand;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use App\Http\Requests\BrandStoreRequest;

class BrandController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:brands.index')->only('index');
        $this->middleware('permission:brands.show')->only('show');
        $this->middleware('permission:brands.create')->only('create', 'store');
        $this->middleware('permission:brands.edit')->only('edit', 'update');;
    }


    public function index()
    {
        $brands = Brand::orderBy('id','DESC')->paginate(10);
        return view('brands.index',compact('brands'));
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
    public function store(BrandStoreRequest $request)
    {
    $brand = new Brand;

    if($request->has('frontend')){
        $frontend = 1;
    }else{
        $frontend = 0;
    }


    if($request->hasFile('image')){
        //get form image
        $image = $request->file('image');
        $slug = Str::slug($request['brand_name']);
        $current_date = Carbon::now()->toDateString();
        //get unique name for image
        $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();
        //location for new image
        $thumb_location = public_path('uploads/brand/thumb/'.$image_name);
        $original_location = public_path('uploads/brand/original/'.$image_name);
        //resize image for category and upload temp
        Image::make($image)->fit(137,44)->save($thumb_location);
        Image::make($image)->save($original_location);
        $brand->image =  $image_name;
     }
     $brand->brand_name = $request['brand_name'];
     $brand->frontend = $frontend;
     $brand->save();

     return $brand->brand_name ." created Successfully";

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        return $brand;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'brand_name' => 'required|unique:brands,brand_name,'.$id,
        ]);

        $brand = Brand::findOrFail ($id);

        if($request->has('frontend')){
            $frontend = 1;
        }else{
            $frontend = 0;
        }

        if($request->hasFile('image')){
            //get form image
            $image = $request->file('image');
            $slug = Str::slug($request['brand_name']);
            $current_date = Carbon::now()->toDateString();
            //get unique name for image
            $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();

            //Delete Old Image
            $old_thumb_location = public_path('uploads/brand/thumb/'.$brand->image);
            $old_original_image_location = public_path('uploads/brand/original/'.$brand->image);
            if (File::exists($old_thumb_location)) {
                File::delete($old_thumb_location);
            }
            if (File::exists($old_original_image_location)) {
                File::delete($old_original_image_location);
            }

            //new location for new image
            $thumb_location = public_path('uploads/brand/thumb/'.$image_name);
            $original_location = public_path('uploads/brand/original/'.$image_name);
            //resize image for category and upload temp
            Image::make($image)->fit(137,44)->save($thumb_location);
            Image::make($image)->save($original_location);
            $brand->image =  $image_name;
         }

        $brand->brand_name = $request['brand_name'];
        $brand->frontend = $frontend;
        $brand->save();
        return $brand->brand_name. " brand updated successfully";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);

        $old_thumb_location = public_path('uploads/brand/thumb/'.$brand->image);
        $old_original_image_location = public_path('uploads/brand/original/'.$brand->image);

        if (File::exists($old_thumb_location)) {
            File::delete($old_thumb_location);
        }
        if (File::exists($old_original_image_location)) {
            File::delete($old_original_image_location);
        }
        $brand->delete();
        Session::flash('delete_success', 'Your Brand Has been Deleted Successfully');
        return redirect()->back();
    }
}
