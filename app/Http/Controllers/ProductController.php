<?php

namespace App\Http\Controllers;
use App\ProductType;
use Illuminate\Support\Facades\Cache;
use PDF;
use Session;
use App\Size;
use App\Brand;
use App\Product;
use App\Category;
use Carbon\Carbon;
use App\GeneralOption;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use Symfony\Component\Console\Input\Input;
use Yajra\DataTables\Facades\DataTables;


class ProductController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:products.index')->only('index');
        $this->middleware('permission:products.show')->only('show');
        $this->middleware('permission:products.create')->only('create', 'store');
        $this->middleware('permission:products.edit')->only('edit', 'update');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $imgurl='public/uploads/products/thumb/';
            $productQuery = Product::with('size')
                ->where('type', '!=', 'raw');
               // ->orderBy('product_name');
            $products = Datatables::of($productQuery)
                ->addIndexColumn()
                ->editColumn('image',function($row) use ($imgurl){
                    $img =  '<img src="'.asset($imgurl.$row->image).'"  height="40" />';
                    return $img;
                })
                ->addColumn('action', function($row){
                    $actionbtn='
                        <a href="'.route('products.edit',[$row->id]).'" class="btn btn-info btn-sm edit"><i class="fas fa-edit"></i></a>
                        <a href="'.route('products.destroy',[$row->id]).'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i>
                        </a>';
                    return $actionbtn;
                })
                ->rawColumns(['image','action'])
                ->filter(function ($query) use($request) {
                        $query->where('product_name', 'like', "%" . $request->search['value'] . "%");
                })
                ->make(true);
            return  $products;

        }
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        $sizes = Size::get();
        return view('products.create',compact('brands','sizes'));
    }


    public function store(ProductStoreRequest $request)
    {

    $product = new Product;
    //Product Image Upload
    if($request->hasFile('image')){
        //get form image
        $image = $request->file('image');
        $slug = Str::slug($request->product_name);
        $current_date = Carbon::now()->toDateString();
        //get unique name for image
        $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();
        //location for new image
        $tiny_location = public_path('uploads/products/tiny/'.$image_name);
        $thumb_location = public_path('uploads/products/thumb/'.$image_name);
        $original_location = public_path('uploads/products/original/'.$image_name);
        //resize image for category and upload temp
        Image::make($image)->fit(70,70)->save($tiny_location);
        Image::make($image)->fit(270,330)->save($thumb_location);
        Image::make($image)->save($original_location);
        $product->image =  $image_name;
     }


     if($request->has('onoffswitch')){
         $product->in_stock = $request->onoffswitch;
     }

     $product->product_name = $request->product_name;
     $product->price = 0;
     $product->current_price = 0;
     $product->brand_id = $request->brand;
     $product->description = $request->description;
     $product->size_id = $request->size;
     $product->mfg = $request->mfg;
     $product->exp = $request->exp;
     $product->type = $request->show_in;
     $product->save();

     $productinfo = Product::where('type','ecom')->get();
     $suggestions = [];
     foreach($productinfo as $info){
         $suggestions[] = ['value' => $info->product_name, 'data' => $info->id];
     }

     Storage::disk('public')->put('product.json', "var productJSON=".json_encode($suggestions));
     return 'Product Added Successfully';



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('product_type','brand')->findOrFail($id);
        return view('products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('size')->findOrFail($id);
        $brands = Brand::all();
        $sizes = Size::get();
        return view('products.edit',compact('product','brands','sizes'));
    }


    public function update(Request $request,$id)
    {

        $this->validate($request,[
            'product_name' => 'required|unique:products,product_name,'.$id,
            'brand' => 'required|integer',
            'size' => 'required',
            'image' => 'image',
        ]);


        $product = Product::findOrFail($id);

        if($request->hasFile('image')){
            //get form image
            $image = $request->file('image');
            $slug = Str::slug($request->product_name);
            $current_date = Carbon::now()->toDateString();
            //get unique name for image
            $image_name = $slug."-".$current_date.".".$image->getClientOriginalExtension();

            if($product->image != 'product.jpg'){
            //Delete Old Image
            $old_tiny_location = public_path('uploads/products/tiny/'.$product->image);
            $old_thumb_location = public_path('uploads/products/thumb/'.$product->image);
            $old_original_image_location = public_path('uploads/products/original/'.$product->image);
            if (File::exists($old_tiny_location)) {
                File::delete($old_tiny_location);
            }
            if (File::exists($old_thumb_location)) {
                File::delete($old_thumb_location);
            }
            if (File::exists($old_original_image_location)) {
                File::delete($old_original_image_location);
            }
            }

            //new location for new image
            $tiny_location = public_path('uploads/products/tiny/'.$image_name);
            $thumb_location = public_path('uploads/products/thumb/'.$image_name);
            $original_location = public_path('uploads/products/original/'.$image_name);
            //resize image for category and upload temp
            Image::make($image)->fit(70,70)->save($tiny_location);
            Image::make($image)->fit(270,330)->save($thumb_location);
            Image::make($image)->save($original_location);
            $product->image =  $image_name;
         }

        if(!empty($product->gallery_image)){
        $old_gallery_img_list  = json_decode($product->gallery_image);
        }

          //Gallery Image Upload

        $product->product_name = $request['product_name'];

        if($request->has('onoffswitch')){
            $product->in_stock = $request->onoffswitch;
        }else{
            $product->in_stock = 0;
        }

        $product->description = $request['description'];
        $product->brand_id = $request['brand'];
        $product->mfg = $request->mfg;
        $product->exp = $request->exp;
        $product->size_id = $request['size'];
        $product->type = $request->show_in;
        $product->save();

        $productinfo = Product::where('type','ecom')->get();
        $suggestions = [];
        foreach($productinfo as $info){
            $suggestions[] = ['value' => $info->product_name, 'data' => $info->id];
        }

        Storage::disk('public')->put('product.json', "var productJSON=".json_encode($suggestions));
        Toastr::success('Product Updated Successfully', 'success');
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->deleted_at = now();
        $product->save();
        Session::flash('delete_success', 'Your Product Has been Deleted Successfully');
        return redirect()->back();
    }


    public function export(Request $request){
        $general_opt = Cache::get('g_opt') ?? GeneralOption::first();
        $general_opt_value = json_decode($general_opt->options, true);
        $products = Product::orderBy('product_name','ASC')->get();
        $pdf = PDF::loadView('products.productexport',compact('products','general_opt_value'));
        return $pdf->download('Product Export.'.now().'.pdf');
    }

    public function getProducts(Request $request){
        $search = $request->search;
        if ($search == '') {
            $products = Product::orderby('product_name', 'asc')->select('id', 'product_name','tp')->limit(10)->get();
        } else {
            $products = Product::orderby('product_name', 'asc')->select('id', 'product_name','tp')->where('product_name', 'like', '%' . $search . '%')->limit(150)->get();
        }

        $response = array();
        foreach ($products as $product) {
            $response[] = array(
                "id" => $product->id,
                "text" => $product->product_name,
                "price" => $product->tp,
            );
        }
        return response()->json($response);
    }

    public function getProductById(Request $request){
        $products =  product::where('id',$request->id)->select('id', 'product_name','tp')->get();
        $response = array();
        foreach ($products as $product) {
            $response[] = array(
                "id" => $product->id,
                "text" => $product->name,
                "price" => $product->tp,
            );
        }
        return response()->json($response);
    }
}
