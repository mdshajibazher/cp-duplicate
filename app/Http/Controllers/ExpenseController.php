<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Expensecategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ExpenseCollection;

class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:expense.index')->only('index');
        $this->middleware('permission:expense.create')->only('create','store');
        $this->middleware('permission:expense.edit')->only('edit','update');
        $this->middleware('permission:expense.show')->only('show');
        $this->middleware('permission:expense.delete')->only('destroy');
    }


    public function index()
    {
        $expenses = Expense::with('expensecategory')->get();
        return view('expense.index',compact('expenses'));
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
            'expense_date' => 'required|date',
            'amount' => 'required|numeric',
            'expensecategory_id' => 'required|integer',
            'reason' => 'required|max:45',
        ]);
        $expense = new Expense;
        $expense->expense_date = $request->expense_date;
        $expense->amount = $request->amount;
        $expense->reasons = $request->reason;
        $expense->expensecategory_id = $request->expensecategory_id;
        $expense->admin_id = Auth::user()->id;
        $expense->save();
        return "Expense Stored Successfully";
    }



    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Expense::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'expense_date' => 'required|date',
            'amount' => 'required|numeric',
            'expensecategory_id' => 'required|integer',
            'reason' => 'required|max:45',
        ]);
        $expense = Expense::findOrFail($id);
        $expense->expense_date = $request->expense_date;
        $expense->amount = $request->amount;
        $expense->reasons = $request->reason;
        $expense->expensecategory_id = $request->expensecategory_id;
        $expense->admin_id = Auth::user()->id;
        $expense->save();
        return "Expense Updated Successfully";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }

    public function last10(Request $request){
        $admin_id = $request->admin_id;
        $expense_query = Expense::query()->with('expensecategory');
        if($admin_id) {
            $expense_query=    $expense_query->where('admin_id',$request->admin_id);
        }
        $expense_query = $expense_query->take(10)->orderBy('id','DESC')->get();
        return  new ExpenseCollection($expense_query);
    }

    public function datewise(Request $request){
        $this->validate($request,[
            'start' => 'required|date',
            'end' => 'required|date',
        ]);
        $colors =  ["#34495e","#badc58","#16a085","#30336b","#EA2027","#6F1E51","#B53471","#C4E538","#2ecc71","#eb4d4b","#f1c40f","#EE5A24"];
        $expenses = Expense::with('expensecategory')->whereBetween('expense_date', [$request->start." 00:00:00", $request->end." 23:59:59"])->orderBy('expense_date', 'asc')->get();
        return view('expense.datewise',compact('expenses','request','colors'));
    }

    public function datewiseGetMethod($start,$end){
        // $request = ['start' => $start, 'end' => $end];
        $expenses = new ExpenseCollection(Expense::with('expensecategory')->whereBetween('expense_date', [$start." 00:00:00", $end." 23:59:59"])->orderBy('expense_date', 'asc')->get());
        return $expenses;
    }

    public function catlist(){
        return Expensecategory::all();
    }


}
