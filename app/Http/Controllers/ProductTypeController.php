<?php

namespace App\Http\Controllers;

use App\ProductType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductTypeController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:product_type.index')->only('index');
        $this->middleware('permission:product_type.show')->only('show');
        $this->middleware('permission:product_type.create')->only('create', 'store');
        $this->middleware('permission:product_type.edit')->only('edit', 'update');
    }


    public function index()
    {
        $product_types_eloquent_collections = ProductType::orderBy('id','DESC')->paginate(10);
        return view('product_types.index',compact('product_types_eloquent_collections'));
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
            'name' => 'required|unique:product_types',
            'image' => 'image',
        ]);

        if($request->has('frontend')){
            $frontend = 1;
        }else{
            $frontend = 0;
        }

        $product_types = new ProductType;
        if($request->hasFile('image')){
            //get form image
            $image = $request->file('image');
            $slug = Str::slug($request->name);
            $current_date = Carbon::now()->toDateString();
            //get unique name for image
            $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();
            //location for new image

            $frontend_location = public_path('uploads/product_type/frontend/'.$image_name);
            $original_location = public_path('uploads/product_type/original/'.$image_name);
            //resize image for category and upload temp
            Image::make($image)->fit(285,160)->save($frontend_location);
            Image::make($image)->save($original_location);
            $product_types->image =  $image_name;
        }

        $product_types->name = $request->name;
        $product_types->frontend = $frontend;
        $product_types->save();
        return 'Product Type Stored Successfully';
    }



    public function edit(ProductType $product_types,$id)
    {

        return ProductType::findOrFail($id);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|unique:product_types,name,'.$id,
            'image' => 'image',
        ]);

        if($request->has('frontend')){
            $frontend = 1;
        }else{
            $frontend = 0;
        }

        $product_types = ProductType::find($id);
        if($request->hasFile('image')){
            //get form image
            $image = $request->file('image');
            $slug = Str::slug($request->name);
            $current_date = Carbon::now()->toDateString();
            //get unique name for image
            $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();


            //Delete Old Image

            $old_frontend_image_location = public_path('uploads/product_type/frontend/'.$product_types->image);
            $old_original_image_location = public_path('uploads/product_type/original/'.$product_types->image);

            if (File::exists($old_frontend_image_location)) {
                File::delete($old_frontend_image_location);
            }
            if (File::exists($old_original_image_location)) {
                File::delete($old_original_image_location);
            }



            //location for new image

            $frontend_location = public_path('uploads/product_type/frontend/'.$image_name);
            $original_location = public_path('uploads/product_type/original/'.$image_name);
            //resize image for category and upload temp
            Image::make($image)->fit(285,160)->save($frontend_location);
            Image::make($image)->save($original_location);
            $product_types->image =  $image_name;
        }


        $product_types->name = $request->name;
        $product_types->frontend = $frontend;
        $product_types->save();
        return 'Product Types Updated Successfully';
    }


    public function destroy($id)
    {

    }
}
