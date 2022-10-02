<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:business.chart');
    }

  public function index(){
      return view('charts.index');
  }

  public function show(Request $request){
    $this->validate($request,[
      'start' => 'required',
      'end' => 'required',
      'type' => 'required',
    ]);
    return view('charts.show',compact('request'));
  }

  public function getChartData(Request $request){
    $sales =  DB::table('sales')
    ->select(DB::raw('MONTH(sales_at) as month, YEAR(sales_at) as year, SUM(amount) as amount'))
    ->whereBetween('sales_at', [$request->start." 00:00:00", $request->end." 23:59:59"])
    ->groupBy(DB::raw('YEAR(sales_at), MONTH(sales_at)'))
    ->get();

    $sales_month_label = [];
    $sales_amount = [];
    foreach($sales as $sale){
        array_push($sales_month_label,getMonthName($sale->month).' '.$sale->year);
        array_push($sales_amount,$sale->amount);
    }
    $sales_data = ['sales_month_label' => $sales_month_label, 'sales_amount' => $sales_amount];



    $cashes =  DB::table('cashes')
    ->select(DB::raw('MONTH(received_at) as month, YEAR(received_at) as year, SUM(amount) as amount'))
    ->whereBetween('received_at', [$request->start." 00:00:00", $request->end." 23:59:59"])
    ->groupBy(DB::raw('YEAR(received_at), MONTH(received_at)'))
    ->get();

    $cashes_month_label = [];
    $cash_amount = [];
    foreach($cashes as $cash){
        array_push($cashes_month_label,getMonthName($cash->month).' '.$cash->year);
        array_push($cash_amount,$cash->amount);
    }
    $cashes_data = ['cashes_month_label' => $cashes_month_label, 'cash_amount' => $cash_amount];


    $return_products =  DB::table('returnproducts')
    ->select(DB::raw('MONTH(returned_at) as month, YEAR(returned_at) as year, SUM(amount) as amount'))
    ->whereBetween('returned_at', [$request->start." 00:00:00", $request->end." 23:59:59"])
    ->groupBy(DB::raw('YEAR(returned_at), MONTH(returned_at)'))
    ->get();

    $return_products_month_label = [];
    $pd_return_amount = [];
    foreach($return_products as $pd_return){
        array_push($return_products_month_label,getMonthName($pd_return->month).' '.$pd_return->year);
        array_push($pd_return_amount,$pd_return->amount);
    }
    $return_products_data = ['return_products_month_label' => $return_products_month_label, 'pd_return_amount' => $pd_return_amount];


    $expenses =  DB::table('expenses')
    ->select(DB::raw('MONTH(expense_date) as month, YEAR(expense_date) as year, SUM(amount) as amount'))
    ->whereBetween('expense_date', [$request->start." 00:00:00", $request->end." 23:59:59"])
    ->groupBy(DB::raw('YEAR(expense_date), MONTH(expense_date)'))
    ->get();

    $expense_month_label = [];
    $expense_amount = [];
    foreach($expenses as $expense){
        array_push($expense_month_label,getMonthName($expense->month).' '.$expense->year);
        array_push($expense_amount,$expense->amount);
    }
    $expenses_data = ['expense_month_label' => $expense_month_label, 'expense_amount' => $expense_amount];

    return ['sales_data'=> $sales_data,'cashes_data' => $cashes_data,'return_products_data' => $return_products_data,'expenses_data' => $expenses_data];

  }




}
