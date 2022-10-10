<?php

namespace App\Http\Controllers\Api;

use App\Cash;
use App\DailyOrder;
use App\Expense;
use App\GeneralOption;
use App\Http\Controllers\Controller;
use App\Returnproduct;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    private $seconds;

    public function __construct()
    {
        $this->seconds = env('CACHE_REMEMBER_IN_SECONDS') ?? 86400;
    }

    public function getDashboardData(){
        $general_opt = Cache::remember('g_opt', $this->seconds, function () {
            return GeneralOption::first();
        });
        $general_opt_value = json_decode($general_opt->options, true);
        $today = now()->toDateString();
        $todays_daily_orders = DailyOrder::whereBetween('date', [$today, $today])->orderBy('date', 'desc')->get();
        $todays_expense = Expense::whereBetween('expense_date', [$today . " 00:00:00", $today . " 23:59:59"])->orderBy('expense_date', 'desc')->get();
        $todays_pos_sales = Sale::with('user')->whereBetween('sales_at', [$today . " 00:00:00", $today . " 23:59:59"])->orderBy('sales_at', 'desc')->get();
        $todays_pos_returns = Returnproduct::with('user')->where('type', 'pos')->whereBetween('returned_at', [$today . " 00:00:00", $today . " 23:59:59"])->orderBy('returned_at', 'desc')->get();
        $todays_pos_cash = Cash::with('user')->whereBetween('received_at', [$today . " 00:00:00", $today . " 23:59:59"])->orderBy('received_at', 'desc')->get();
        $pending_sales = Sale::with('user')->where('sales_status', 0)->orderBy('updated_at', 'DESC')->get();
        $pending_cash = Cash::with('user')->where('status', 0)->orderBy('updated_at', 'DESC')->get();
        $pending_delivery = Sale::with('user')->where('sales_status', 1)->where('delivery_status', 0)->orderBy('id', 'DESC')->paginate(10)->onEachSide(2);
        $pending_returns = Returnproduct::with('user')->where('return_status', 0)->orderBy('updated_at', 'DESC')->get();
        $last_ten_dlv = Sale::with('user')->where('delivery_status', 1)->take(10)->orderBy('id', 'desc')->get();
        $current_month_sale = Sale::whereBetween('sales_at', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount');
        $current_month_cash = Cash::whereBetween('received_at', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount');
        $current_month_return = Returnproduct::whereBetween('returned_at', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount');
        $current_month_expense = Expense::whereBetween('expense_date', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('amount');
        return response()->json([
            'todays_pos_sales' => $todays_pos_sales,
            'todays_pos_cash' => $todays_pos_cash,
            'todays_pos_returns' =>  $todays_pos_returns,
            'todays_daily_orders' => $todays_daily_orders,
            'pending_sales' => $pending_sales,
            'general_opt_value' => $general_opt_value,
            'pending_cash' => $pending_cash,
            'pending_returns' => $pending_returns,
            'pending_delivery' => $pending_delivery,
            'last_ten_dlv' => $last_ten_dlv,
            'current_month_sale' => $current_month_sale,
            'current_month_cash' => $current_month_cash,
            'current_month_return' => $current_month_return,
            'current_month_expense' => $current_month_expense,
            'todays_expense' => $todays_expense,
        ]);
    }
}
