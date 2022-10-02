<?php

namespace App\Http\Controllers;

use App\Size;
use Illuminate\Http\Request;


class SizeController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:product_size.index')->only('index');
        $this->middleware('permission:product_size.show')->only('show');
        $this->middleware('permission:product_size.create')->only('create', 'store');
        $this->middleware('permission:product_size.edit')->only('edit', 'update');
    }


    public function index()
    {
        $sizes = Size::orderBy('id','DESC')->get();
        return view('sizes.index',compact('sizes'));
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
            'size_name' => 'required|max:30'
        ]);

        $size = new Size;
        $size->name = $request->size_name;
        $size->type = 'ecom';
        $size->save();

        return 'Size Saved Successfully';

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function edit(Size $size)
    {
        return $size;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'size_name' => 'required|max:30'
        ]);
        $size = Size::findOrFail($id);
        $size->name = $request->size_name;
        $size->type = 'ecom';
        $size->save();
        return 'Size Saved Successfully';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy(Size $size)
    {


    }
}
