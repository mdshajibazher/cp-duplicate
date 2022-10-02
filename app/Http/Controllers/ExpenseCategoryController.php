<?php

namespace App\Http\Controllers;

use App\Expensecategory;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class ExpenseCategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:expense_type.index')->only('index');
        $this->middleware('permission:expense_type.create')->only('create','store');
        $this->middleware('permission:expense_type.edit')->only('edit','update');
        $this->middleware('permission:expense_type.show')->only('show');
        $this->middleware('permission:expense_type.delete')->only('destroy');
    }

    public function index()
    {
        $expensecategories = Expensecategory::all();
        return view('expensecategory.index',compact('expensecategories'));
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
            'name' => 'required|max:30|unique:expensecategories'
        ]);
        $expensecategory = new Expensecategory;
        $expensecategory->name = $request->name;
        $expensecategory->save();
        Toastr::success('Expense Category Saved Successfully', 'success');
        return redirect()->route('expensecategories.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Expensecategory::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'edit_name' => 'required|max:30|unique:expensecategories,name,'.$id
        ]);
        $expensecategory = Expensecategory::findOrFail($id);
        $expensecategory->name = $request->edit_name;
        $expensecategory->save();
        Toastr::success('Expense Category Updated Successfully', 'success');
        return redirect()->route('expensecategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    //    $ex_cat =  Expensecategory::findOrFail($id);
    //    $ex_cat->delete();
    //    return redirect()->back();
    }
}
