<?php

namespace App\Http\Controllers;

use App\ProductPurchase;
use App\ProductReturnproduct;
use App\ProductSale;
use App\Rules\IsCapableToTransferStock;
use App\Transfer;
use App\Warehouse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use PDF;
use App\Sale;
use App\Adjust;
use App\Product;
use Carbon\Carbon;
use App\GeneralOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductStockCollections;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:stock.report')->only('stockreport', 'stockreportshow', 'stockreportpdf');
        $this->middleware('permission:stock.display')->only('index');
        $this->middleware('permission:stock.edit')->only('hideFromStock', 'restoreFromStock', 'updateAdjust', 'StoreStockAdjustment');
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    function _generateStock($products, $warehouse_id = false)
    {
        $stockinfo = [];
        foreach ($products as $product) {
            $adjustInitialQuery = Adjust::query();
            $adjustCondition = $adjustInitialQuery->where('product_id', '=', $product->id);
            $adjustInitialQuery->with('transfer.FromWarehouse')->with('transfer.ToWarehouse');
            if ($warehouse_id) {
                $adjustCondition->where('warehouse_id', '=', $warehouse_id);
            }
            $adjustCollection = $adjustCondition->get();
            $increaseAdjustment = $adjustCollection->filter(function ($value, $key) {
                return $value->type == 'increase';
            });
            $decreaseAdjustment = $adjustCollection->filter(function ($value, $key) {
                return $value->type == 'decrease';
            });
            $decreaseAdjustmentQty = count($decreaseAdjustment) > 0 ? $decreaseAdjustment->sum('qty') : 0;
            $increaseAdjustmentQty = count($increaseAdjustment) > 0 ? $increaseAdjustment->sum('qty') : 0;


            $saleInitial = ProductSale::query();
            $saleCondition = $saleInitial->where('product_id', '=', $product->id);
            if ($warehouse_id) {
                $saleCondition->where('warehouse_id', '=', $warehouse_id);
            }
            $saleQty = $saleCondition->sum('qty');
            $freeSaleQty = $saleCondition->sum('free');


            $purchaseInitial = ProductPurchase::query();
            $purchaseProductCondition = $purchaseInitial->where('product_id', '=', $product->id);
            if ($warehouse_id) {
                $purchaseProductCondition->where('warehouse_id', '=', $warehouse_id);
            }
            $purchaseProductQty = $purchaseProductCondition->sum('qty');


            $returnProductInitial = ProductReturnproduct::query();
            $returnProductCondition = $returnProductInitial->where('product_id', '=', $product->id);
            if ($warehouse_id) {
                $returnProductCondition->where('warehouse_id', '=', $warehouse_id);
            }
            $returnProductQty = $returnProductCondition->sum('qty');


            $stock = (($purchaseProductQty + $returnProductQty) - ($saleQty + $freeSaleQty)) + ($increaseAdjustmentQty + $decreaseAdjustmentQty);
            array_push($stockinfo, [
                'product_id' => $product->id,
                'increase' => $increaseAdjustmentQty,
                'decrease' => $decreaseAdjustmentQty,
                'sale' => $saleQty,
                'free' => $freeSaleQty,
                'return' => $returnProductQty,
                'stock' => $stock,
                ]);
        }

        return $stockinfo;
    }

    public function _getStockQtyByProductID($product_id, $warehouse_id = false)
    {
        $adjustInitialQuery = Adjust::query();
        $adjustCondition = $adjustInitialQuery->where('product_id', '=', $product_id);
        if ($warehouse_id) {
            $adjustCondition->where('warehouse_id', '=', $warehouse_id);
        }
        $adjustCollection = $adjustCondition->get();
        $increaseAdjustment = $adjustCollection->filter(function ($value, $key) {
            return $value->type == 'increase';
        });
        $decreaseAdjustment = $adjustCollection->filter(function ($value, $key) {
            return $value->type == 'decrease';
        });
        $decreaseAdjustmentQty = count($decreaseAdjustment) > 0 ? $decreaseAdjustment->sum('qty') : 0;
        $increaseAdjustmentQty = count($increaseAdjustment) > 0 ? $increaseAdjustment->sum('qty') : 0;


        $saleInitial = ProductSale::query();
        $saleCondition = $saleInitial->where('product_id', '=', $product_id);
        if ($warehouse_id) {
            $saleCondition->where('warehouse_id', '=', $warehouse_id);
        }
        $saleQty = $saleCondition->sum('qty');
        $freeSaleQty = $saleCondition->sum('free');


        $purchaseInitial = ProductPurchase::query();
        $purchaseProductCondition = $purchaseInitial->where('product_id', '=', $product_id);
        if ($warehouse_id) {
            $purchaseProductCondition->where('warehouse_id', '=', $warehouse_id);
        }
        $purchaseProductQty = $purchaseProductCondition->sum('qty');


        $returnProductInitial = ProductReturnproduct::query();
        $returnProductCondition = $returnProductInitial->where('product_id', '=', $product_id);
        if ($warehouse_id) {
            $returnProductCondition->where('warehouse_id', '=', $warehouse_id);
        }
        $returnProductQty = $returnProductCondition->sum('qty');

        $stock = (($purchaseProductQty + $returnProductQty) - ($saleQty + $freeSaleQty)) + ($increaseAdjustmentQty + $decreaseAdjustmentQty);
        return $stock;
    }

    public function date_sort_asc($a, $b)
    {
        return strtotime($a->date) - strtotime($b->date);
    }

    public function date_sort_desc($a, $b)
    {
        return strtotime($b->date) - strtotime($a->date);
    }

    public function getProductStockHistory(Request $request, $product_id, $warehouse_id = false)
    {
        $adjusts_is_not_transfer = DB::table('adjusts')
            ->when($warehouse_id, function ($q) use ($warehouse_id) {
                $q->where('warehouse_id', '=', $warehouse_id);
            })
            ->where('adjusts.is_transfer',false)
            ->where('product_id', '=', $product_id)
            ->join('warehouses', 'adjusts.warehouse_id', '=', 'warehouses.id')
            ->select('adjusts.id', 'adjusts.notes', 'adjusts.is_transfer','adjusts.adjusted_at as date', 'adjusts.qty', 'warehouses.name as warehouse_name', 'warehouses.id as warehouse_id')
            ->addSelect(DB::raw("'Stock Adjustments' as type"))
            ->addSelect(DB::raw("'' as transfer_to_warehouse_id"))
            ->addSelect(DB::raw("'' as transfer_from_warehouse_id"))
            ->addSelect(DB::raw("false as editable"))
            ->get();

        $adjusts_is_transfer = DB::table('adjusts')
            ->when($warehouse_id, function ($q) use ($warehouse_id) {
                $q->where('warehouse_id', '=', $warehouse_id);
            })
            ->where('adjusts.is_transfer',true)
            ->where('product_id', '=', $product_id)
            ->join('transfers','adjusts.transfer_id','=','transfers.id')
            ->join('warehouses','adjusts.warehouse_id', '=', 'warehouses.id')
            ->select('adjusts.id', 'adjusts.notes', 'adjusts.is_transfer','adjusts.adjusted_at as date', 'adjusts.qty', 'warehouses.name as warehouse_name', 'warehouses.id as warehouse_id','transfers.from_warehouse_id as transfer_from_warehouse_id','transfers.to_warehouse_id as transfer_to_warehouse_id')
            ->addSelect(DB::raw("'Stock Transfer' as type"))
            ->addSelect(DB::raw("false as editable"))
            ->get();

        $adjusts = $adjusts_is_not_transfer->merge($adjusts_is_transfer);



        //            $increase = [];
        //            $decrease = [];
        //            if(count($adjusts) > 0){
        //                $increase = $adjusts->filter(function ($value, $key) {
        //                    return $value->qty >= 0;
        //                });
        //                $decrease = $adjusts->filter(function ($value, $key) {
        //                    return $value->qty < 0;
        //                });
        //
        //            }

        $sales = DB::table('product_sale')
            ->when($warehouse_id, function ($q) use ($warehouse_id) {
                $q->where('warehouse_id', '=', $warehouse_id);
            })
            ->where('product_sale.product_id', '=', $product_id)
            ->join('users', 'product_sale.user_id', '=', 'users.id')
            ->join('warehouses', 'product_sale.warehouse_id', '=', 'warehouses.id')
            ->select('product_sale.id', 'product_sale.sales_at as date', 'product_sale.qty', 'users.name', 'warehouses.name as warehouse_name', 'warehouses.id as warehouse_id')
            ->addSelect(DB::raw("'Product Sales' as type"))
            ->addSelect(DB::raw("false as editable"))
            ->addSelect(DB::raw("false as is_transfer"))
            ->addSelect(DB::raw("'' as notes"))
            ->get();


        $frees = DB::table('product_sale')
            ->when($warehouse_id, function ($q) use ($warehouse_id) {
                $q->where('warehouse_id', '=', $warehouse_id);
            })
            ->where('product_sale.product_id', '=', $product_id)
            ->where('product_sale.free', '>', 0)
            ->join('users', 'product_sale.user_id', '=', 'users.id')
            ->join('warehouses', 'product_sale.warehouse_id', '=', 'warehouses.id')
            ->select('product_sale.id', 'product_sale.sales_at as date', 'product_sale.free as qty', 'users.name', 'warehouses.name as warehouse_name', 'warehouses.id as warehouse_id')
            ->addSelect(DB::raw("'Product Free Count' as type"))
            ->addSelect(DB::raw("false as editable"))
            ->addSelect(DB::raw("false as is_transfer"))
            ->addSelect(DB::raw("'' as notes"))
            ->get();

        $purchases = DB::table('product_purchase')
            ->when($warehouse_id, function ($q) use ($warehouse_id) {
                $q->where('warehouse_id', '=', $warehouse_id);
            })
            ->where('product_purchase.product_id', '=', $product_id)
            ->join('suppliers', 'product_purchase.supplier_id', '=', 'suppliers.id')
            ->join('warehouses', 'product_purchase.warehouse_id', '=', 'warehouses.id')
            ->select('product_purchase.id', 'product_purchase.purchased_at as date', 'product_purchase.qty', 'suppliers.name', 'warehouses.name as warehouse_name', 'warehouses.id as warehouse_id')
            ->addSelect(DB::raw("'Product Purchases' as type"))
            ->addSelect(DB::raw("false as editable"))
            ->addSelect(DB::raw("false as is_transfer"))
            ->addSelect(DB::raw("'' as notes"))
            ->get();


        $returns = DB::table('product_returnproduct')
            ->when($warehouse_id, function ($q) use ($warehouse_id) {
                $q->where('warehouse_id', '=', $warehouse_id);
            })
            ->where('product_returnproduct.product_id', '=', $product_id)
            ->join('users', 'product_returnproduct.user_id', '=', 'users.id')
            ->join('warehouses', 'product_returnproduct.warehouse_id', '=', 'warehouses.id')
            ->select('product_returnproduct.id', 'product_returnproduct.returned_at as date', 'product_returnproduct.qty', 'users.name', 'warehouses.name as warehouse_name', 'warehouses.id as warehouse_id')
            ->addSelect(DB::raw("'Product Returns' as type"))
            ->addSelect(DB::raw("false as editable"))
            ->addSelect(DB::raw("false as is_transfer"))
            ->addSelect(DB::raw("'' as notes"))
            ->get();


        $mergeData = $sales
            ->merge($purchases)
            ->merge($adjusts)
            ->merge($frees)
            ->merge($returns);
        $mergeData = $mergeData->toArray();

        usort($mergeData, array($this, "date_sort_desc"));
        return $this->paginate($mergeData, $request->per_page ?? 5);
    }

    public function index()
    {
        $hidden_count = Product::where('discontinued', true)->count();
        $products = Product::where('discontinued', false)
            ->orderBy('product_name', 'ASC')
            ->paginate(10);
        $stock_info = $this->_generateStock($products);
        $warehouse_list = Warehouse::get()->toArray();
        $authUserPermissions = Auth::user()->getAllPermissions()->pluck('name')->toArray();
        return view('admin.stock.index', compact('products', 'stock_info', 'hidden_count', 'warehouse_list', 'authUserPermissions'));
    }

    public function getProductWithStock(Request $request)
    {
        $warehouse_id = $request->warehouse_id && $request->warehouse_id !== 'undefined' ? $request->warehouse_id : false;
        $hidden_count = Product::where('discontinued', true)->count();
        $productCollections = Product::where('discontinued', '==', false)
            ->orderBy('product_name', 'ASC')->paginate(10);
        $stockinfo = $this->_generateStock($productCollections, $warehouse_id);
        return ['product_collections' => $productCollections, 'stock_info' => $stockinfo, 'hidden_count' => $hidden_count];
    }

    public function searchProductWithStock($query_field, $query, Request $request)
    {
        $warehouseId = (int)$request->warehouse_id;
        $hidden_count = Product::where('discontinued', true)->count();
        $productCollections = Product::where('discontinued', '==', false)
            ->where($query_field, 'LIKE', "%$query%")->orderBy('product_name', 'ASC')->paginate(10);
        $stockinfo = $this->_generateStock($productCollections, $warehouseId);
        return ['product_collections' => $productCollections, 'stock_info' => $stockinfo, $stockinfo, 'hidden_count' => $hidden_count];
    }

    public function getHiddenItems()
    {
        return Product::where('discontinued', true)->get();
    }

    public function StoreStockAdjustment(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'adjust_type' => 'required',
            'qty' => 'required|integer',
            'adjusted_at' => 'required|date',
            'warehouse_id' => 'required',
            'notes' => 'max:10'
        ]);

        $stockAdjust = new Adjust;
        $stockAdjust->product_id = $request->product_id;
        $stockAdjust->type = $request->adjust_type;
        $stockAdjust->qty = $request->adjust_type == 'decrease' ? -$request->qty : $request->qty;
        $stockAdjust->adjusted_at = $request->adjusted_at;
        $stockAdjust->warehouse_id = $request->warehouse_id;
        $stockAdjust->notes = $request->notes;
        $stockAdjust->save();
        return $stockAdjust::with('product')->find($stockAdjust->id);

    }

    public function purchasehistory($id)
    {
        $product = Product::findOrFail($id);
        $purchase_history = DB::table('product_purchase')->join('products', 'product_purchase.product_id', '=', 'products.id')->join('suppliers', 'product_purchase.supplier_id', '=', 'suppliers.id')->select('product_purchase.*', 'products.product_name', 'suppliers.name')->where('product_id', '=', $id)->orderBy('purchased_at', 'desc')->get();

        return view('admin.stock.purchasehistory', compact('product', 'purchase_history'));
    }

    public function saleshistory($id)
    {
        $product = Product::findOrFail($id);
        $sales_history = DB::table('product_sale')->join('products', 'product_sale.product_id', '=', 'products.id')->join('users', 'product_sale.user_id', '=', 'users.id')->select('product_sale.*', 'products.product_name', 'users.name')->where('product_id', '=', $id)->orderBy('sales_at', 'desc')->get();

        return view('admin.stock.saleshistory', compact('product', 'sales_history'));
    }

    public function returnhistory($id)
    {
        $product = Product::findOrFail($id);
        $return_history = DB::table('product_returnproduct')->join('products', 'product_returnproduct.product_id', '=', 'products.id')->join('users', 'product_returnproduct.user_id', '=', 'users.id')->select('product_returnproduct.*', 'products.product_name', 'users.name')->where('product_id', '=', $id)->orderBy('returned_at', 'desc')->get();

        return view('admin.stock.returnhistory', compact('product', 'return_history'));
    }

    public function orderhistory($id)
    {
        $product = Product::findOrFail($id);
        $sales_history = DB::table('order_product')->join('products', 'order_product.product_id', '=', 'products.id')->join('users', 'order_product.user_id', '=', 'users.id')->select('order_product.*', 'products.product_name', 'users.name')->where('product_id', '=', $id)->orderBy('ordered_at', 'desc')->get();

        return view('admin.stock.orderhistory', compact('product', 'sales_history'));
    }

    public function damagehistory($id)
    {
        $product = Product::findOrFail($id);
        $damage_history = DB::table('damage_product')->join('products', 'damage_product.product_id', '=', 'products.id')->select('damage_product.*', 'products.product_name')->where('product_id', '=', $id)->orderBy('damaged_at', 'desc')->get();

        return view('admin.stock.damagehistory', compact('product', 'damage_history'));
    }

    public function freehistory($id)
    {
        $product = Product::findOrFail($id);
        $free_history = DB::table('product_sale')->join('products', 'product_sale.product_id', '=', 'products.id')->join('users', 'product_sale.user_id', '=', 'users.id')->select('product_sale.*', 'products.product_name', 'users.name')->where('product_sale.product_id', '=', $id)->where('product_sale.free', '>', 0)->orderBy('sales_at', 'desc')->get();

        return view('admin.stock.freehistory', compact('product', 'free_history'));
    }


    public function stockreport()
    {
        return view('admin.stock.report');
    }


    public function stockreportshow(Request $request)
    {
        $request->validate([
            'start' => ['required'],
            'end' => ['required'],
        ]);

        $products = Product::where('discontinued', '==', false)
            ->orderBy('product_name', 'ASC')->get();;
        $stock = [];
        foreach ($products as $pd) {
            $all_qty = $this->_getStockQtyByProductID($pd->id);

            $return_qty = DB::table('product_returnproduct')->where('product_id', '=', $pd->id)->whereBetween('returned_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $purchase_qty = DB::table('product_purchase')->where('product_id', '=', $pd->id)->whereBetween('purchased_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $order_qty = DB::table('order_product')->where('product_id', '=', $pd->id)->whereBetween('ordered_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $sell_qty = DB::table('product_sale')->where('product_id', '=', $pd->id)->whereBetween('sales_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $free_qty = DB::table('product_sale')->where('product_id', '=', $pd->id)->whereBetween('sales_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('free');

            $damage_qty = DB::table('damage_product')->where('product_id', '=', $pd->id)->whereBetween('damaged_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $adjust_qty = DB::table('adjusts')->where('product_id', '=', $pd->id)->whereBetween('adjusted_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $current_date_range_qty = (($return_qty + $purchase_qty) - ($order_qty + $sell_qty + $damage_qty + $free_qty)) + $adjust_qty;

            $prev_qty = $all_qty - $current_date_range_qty;


            $stock[] = ['product_id' => $pd->id, 'product_name' => $pd->product_name, 'prev_qty' => $prev_qty, 'sell_qty' => $sell_qty, 'free_qty' => $free_qty, 'adjust_qty' => $adjust_qty, 'return_qty' => $return_qty, 'purchase_qty' => $purchase_qty, 'order_qty' => $order_qty, 'damage_qty' => $damage_qty, 'current_stock' => $all_qty];
        }


        return view('admin.stock.show', compact('stock', 'request'));
    }


    public function stockreportpdf(Request $request)
    {
        $request->validate([
            'start' => 'required',
            'end' => 'required',
        ]);
        $general_opt = Cache::get('g_opt') ?? GeneralOption::first();;
        $general_opt_value = json_decode($general_opt->options, true);

        $products = Product::where('discontinued', '==', false)
            ->orderBy('product_name', 'ASC')->get();;
        $stock = [];
        foreach ($products as $pd) {
            $all_qty = $this->_getStockQtyByProductID($pd->id);

            $return_qty = DB::table('product_returnproduct')->where('product_id', '=', $pd->id)->whereBetween('returned_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $purchase_qty = DB::table('product_purchase')->where('product_id', '=', $pd->id)->whereBetween('purchased_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $order_qty = DB::table('order_product')->where('product_id', '=', $pd->id)->whereBetween('ordered_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $sell_qty = DB::table('product_sale')->where('product_id', '=', $pd->id)->whereBetween('sales_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $free_qty = DB::table('product_sale')->where('product_id', '=', $pd->id)->whereBetween('sales_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('free');

            $damage_qty = DB::table('damage_product')->where('product_id', '=', $pd->id)->whereBetween('damaged_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $adjust_qty = DB::table('adjusts')->where('product_id', '=', $pd->id)->whereBetween('adjusted_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])->sum('qty');

            $current_date_range_qty = (($return_qty + $purchase_qty) - ($order_qty + $sell_qty + $damage_qty + $free_qty)) + $adjust_qty;

            $prev_qty = $all_qty - $current_date_range_qty;


            $stock[] = ['product_id' => $pd->id, 'product_name' => $pd->product_name, 'prev_qty' => $prev_qty, 'sell_qty' => $sell_qty, 'free_qty' => $free_qty, 'adjust_qty' => $adjust_qty, 'return_qty' => $return_qty, 'purchase_qty' => $purchase_qty, 'order_qty' => $order_qty, 'damage_qty' => $damage_qty, 'current_stock' => $all_qty];
        }


        $pdf = PDF::loadView('admin.stock.stockpdf', compact('stock', 'request', 'general_opt_value'));
        return $pdf->download('Stock Report From' . $request->start . 'to ' . $request->end . '.pdf');
    }

    public function export(Request $request)
    {
        $general_opt = Cache::get('g_opt') ?? GeneralOption::first();
        $general_opt_value = json_decode($general_opt->options, true);
        function currentproductStock($id)
        {
            $sale = DB::table('product_sale')->where('product_id', '=', $id)->sum('qty');
            $free = DB::table('product_sale')->where('product_id', '=', $id)->sum('free');
            $purchase = DB::table('product_purchase')->where('product_id', '=', $id)->sum('qty');
            $order = DB::table('order_product')->where('product_id', '=', $id)->sum('qty');
            $return = DB::table('product_returnproduct')->where('product_id', '=', $id)->sum('qty');
            $damage = DB::table('damage_product')->where('product_id', '=', $id)->sum('qty');
            $adjust_qty = DB::table('adjusts')->where('product_id', '=', $id)->sum('qty');
            $stock = (($return + $purchase) - ($sale + $free + $order + $damage)) + $adjust_qty;
            return $stock;
        }

        $products = Product::where('discontinued', '==', false)->orderBy('product_name', 'ASC')->get();
        $stock = [];
        foreach ($products as $pd) {
            $all_qty = currentproductStock($pd->id);
            $stock[] = ['product_id' => $pd->id, 'product_name' => $pd->product_name, 'current_stock' => $all_qty];
        }

        $pdf = PDF::loadView('admin.stock.stockexport', compact('stock', 'general_opt_value'));
        return $pdf->download('Stock Report' . time() . '.pdf');
    }

    public function dateWiseProduct()
    {
        $products = Product::where('discontinued', false)->get();
        return view('general_report.product_report', compact('products'));
    }

    function getStartAndEndDateStringUsingWeekNumber($week, $year): string
    {
        $ret = "";
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret .= $dto->format('d-M') . ' To ';
        $dto->modify('+6 days');
        $ret .= $dto->format('d-M') . "," . $dto->format('Y');
        return $ret;
    }

    function getFormattedDayString($day, $month_id, $year): string
    {
        return "{$day}-" . getMonthName($month_id) . "-$year";
    }

    public function getFormattedMonthString($month_id, $year): string
    {
        return getMonthName($month_id) . "-$year";
    }

    public function getDateRangeString($filter_type, $item)
    {
        if ($filter_type === 'day') {
            return $this->getFormattedDayString($item->day, $item->month, $item->year);
        } else if ($filter_type === 'month') {
            return $this->getFormattedMonthString($item->month, $item->year);
        } else if ($filter_type === 'week') {
            return $this->getStartAndEndDateStringUsingWeekNumber($item->week, $item->year);
        }
    }

    function chartDataMapping($chart_array, $filter_type)
    {
        return $chart_array->map(function ($item) use ($filter_type) {
            $map_data['date_range_string'] = $this->getDateRangeString($filter_type, $item);
            $map_data['qty'] = $item->qty;
            $map_data['type'] = $item->type;
            return $map_data;
        });
    }

    public function generateProductChartData(Request $request)
    {
        $this->validate($request, [
            'start' => 'required|date',
            'end' => 'required|date',
            'product_id' => 'required|integer',
            'group_by' => 'required',
        ]);


        $sales_chart = DB::table('product_sale')
            ->where('product_id', '=', $request->product_id)
            ->whereBetween('sales_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])
            ->when($request->group_by == 'week', function ($q) {
                $q->select(DB::raw('WEEK(sales_at) as week, MONTH(sales_at) as month, YEAR(sales_at) as year, SUM(qty) as qty'))
                    ->groupBy(DB::raw('YEAR(sales_at), MONTH(sales_at), WEEK(sales_at)'))
                    ->orderBy('week', 'desc');
            })
            ->when($request->group_by == 'day', function ($q) {
                $q->select(DB::raw('WEEK(sales_at) as week,DAY(sales_at) as day, MONTH(sales_at) as month, YEAR(sales_at) as year, SUM(qty) as qty'))
                    ->groupBy(DB::raw('YEAR(sales_at),DAY(sales_at), MONTH(sales_at), WEEK(sales_at)'))
                    ->orderBy('day', 'desc');
            })
            ->when($request->group_by == 'month', function ($q) {
                $q->select(DB::raw('MONTH(sales_at) as month, YEAR(sales_at) as year, SUM(qty) as qty'))
                    ->groupBy(DB::raw('YEAR(sales_at), MONTH(sales_at)'))
                    ->orderBy('month', 'desc');
            })
            ->addSelect(DB::raw("'sales_chart' as type"))
            ->get();

        if (count($sales_chart) > 0) {
            if ($request->group_by == 'week') {
                $sales_chart = $this->chartDataMapping($sales_chart, 'week');
            } else if ($request->group_by == 'month') {
                $sales_chart = $this->chartDataMapping($sales_chart, 'month');
            } else if ($request->group_by == 'day') {
                $sales_chart = $this->chartDataMapping($sales_chart, 'day');
            }
        }

        $return_chart = DB::table('product_returnproduct')
            ->where('product_id', '=', $request->product_id)
            ->whereBetween('returned_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])
            ->when($request->group_by == 'week', function ($q) {
                $q->select(DB::raw('WEEK(returned_at) as week, MONTH(returned_at) as month, YEAR(returned_at) as year, SUM(qty) as qty'))
                    ->groupBy(DB::raw('YEAR(returned_at), MONTH(returned_at), WEEK(returned_at)'))
                    ->orderBy('week', 'desc');
            })
            ->when($request->group_by == 'day', function ($q) {
                $q->select(DB::raw('WEEK(returned_at) as week,DAY(returned_at) as day, MONTH(returned_at) as month, YEAR(returned_at) as year, SUM(qty) as qty'))
                    ->groupBy(DB::raw('YEAR(returned_at),DAY(returned_at), MONTH(returned_at), WEEK(returned_at)'))
                    ->orderBy('day', 'desc');
            })
            ->when($request->group_by == 'month', function ($q) {
                $q->select(DB::raw('MONTH(returned_at) as month, YEAR(returned_at) as year, SUM(qty) as qty'))
                    ->groupBy(DB::raw('YEAR(returned_at), MONTH(returned_at)'))
                    ->orderBy('month', 'desc');
            })
            ->addSelect(DB::raw("'return_chart' as type"))
            ->get();

        if (count($return_chart) > 0) {
            if ($request->group_by == 'week') {
                $return_chart = $this->chartDataMapping($return_chart, 'week');
            } else if ($request->group_by == 'month') {
                $return_chart = $this->chartDataMapping($return_chart, 'month');
            } else if ($request->group_by == 'day') {
                $return_chart = $this->chartDataMapping($return_chart, 'day');
            }
        }

        return ['sale_chart' => $sales_chart, 'return_chart' => $return_chart];
    }

    public function showDateWiseProduct(Request $request)
    {
        $this->validate($request, [
            'start' => 'required|date',
            'end' => 'required|date',
            'product_id' => 'required|integer',
            'group_by' => 'required',
        ]);
        $products = Product::all();
        $sales_history = DB::table('product_sale')->join('products', 'product_sale.product_id', '=', 'products.id')
            ->where('product_id', '=', $request->product_id)->whereBetween('sales_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])
            ->join('users', 'product_sale.user_id', '=', 'users.id')
            ->select('product_sale.sales_at as date', 'product_sale.qty', 'product_sale.price', 'products.product_name', 'users.name as customer_name')
            ->addSelect(DB::raw("'Sales' as type"))
            ->get();


        $return_history = DB::table('product_returnproduct')
            ->where('product_id', '=', $request->product_id)
            ->join('products', 'product_returnproduct.product_id', '=', 'products.id')
            ->join('users', 'product_returnproduct.user_id', '=', 'users.id')
            ->whereBetween('product_returnproduct.returned_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])
            ->select('product_returnproduct.returned_at as date', 'product_returnproduct.qty', 'product_returnproduct.price', 'products.product_name', 'users.name as customer_name')
            ->addSelect(DB::raw("'Returns' as type"))
            ->get();

        $merge_data = $sales_history
            ->merge($return_history);
        $sorted_product_data = $merge_data->sortDesc()->values()->all();
        return view('general_report.show_product_report', compact('sorted_product_data', 'request', 'products'));

    }

    public function exportDateWiseProduct(Request $request)
    {
        $general_opt = Cache::get('g_opt') ?? GeneralOption::first();
        $general_opt_value = json_decode($general_opt->options, true);
        $products = Product::where('discontinued', false)->get();
        $sales_history = DB::table('product_sale')->join('products', 'product_sale.product_id', '=', 'products.id')
            ->where('product_id', '=', $request->product_id)->whereBetween('sales_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])
            ->join('users', 'product_sale.user_id', '=', 'users.id')
            ->select('product_sale.sales_at as date', 'product_sale.qty', 'product_sale.price', 'products.product_name', 'users.name as customer_name')
            ->addSelect(DB::raw("'Sales' as type"))
            ->get();


        $return_history = DB::table('product_returnproduct')
            ->where('product_id', '=', $request->product_id)
            ->join('products', 'product_returnproduct.product_id', '=', 'products.id')
            ->join('users', 'product_returnproduct.user_id', '=', 'users.id')
            ->whereBetween('product_returnproduct.returned_at', [$request->start . " 00:00:00", $request->end . " 23:59:59"])
            ->select('product_returnproduct.returned_at as date', 'product_returnproduct.qty', 'product_returnproduct.price', 'products.product_name', 'users.name as customer_name')
            ->addSelect(DB::raw("'Returns' as type"))
            ->get();

        $merge_data = $sales_history
            ->merge($return_history);
        $sorted_product_data = $merge_data->sortDesc()->values()->all();
        $pdf = PDF::loadView('general_report.export_product_report', compact('sorted_product_data', 'request', 'products', 'general_opt_value'));
        Storage::put('public/productreport/' . 'Product Report from-' . $request->start . '-to-' . $request->end . '.pdf', $pdf->output());
        return $pdf->download('Product Report from ' . $request->start . ' to ' . $request->end . '.pdf');
    }


    public function hideFromStock($id)
    {
        $product = Product::findOrFail($id);
        $product->discontinued = true;
        $product->save();
        return $product;
    }

    public function restoreFromStock($id)
    {
        $product = Product::findOrFail($id);
        $product->discontinued = false;
        $product->save();
        return $product;
    }


    public function updateAdjust(Request $request, $id)
    {
        $this->validate($request, [
            'notes' => 'max:10',
        ]);
        $adjust = Adjust::findOrFail($id);
        $adjust->adjusted_at = $request->adjusted_at;
        $adjust->qty = $request->qty;
        $adjust->warehouse_id = $request->warehouse_id;
        $adjust->notes = $request->notes;
        $adjust->save();
        return $adjust;
    }


    public function getWareHouseStock($warehouse_id)
    {
        $authUserPermissions = Auth::user()->getAllPermissions()->pluck('name')->toArray();
        $hidden_count = Product::where('discontinued', true)->count();
        $products = Product::where('discontinued', false)
            ->orderBy('product_name', 'ASC')
            ->paginate(10);
        $stock_info = $this->_generateStock($products, $warehouse_id);
        return view('warehouse_stock.index', compact('products', 'hidden_count', 'stock_info', 'warehouse_id', 'authUserPermissions'));
    }


    function getWarehouseData(Request $request)
    {
        $warehouse_id =
            ($request->warehouse_id
                && $request->warehouse_id
                !== 'undefined' && !empty($request->warehouse_id)) ? $request->warehouse_id : false;
        $query = Warehouse::query();
        $current = $warehouse_id ? $query->find($warehouse_id) : '';
        $all = Warehouse::all();
        return ['all' => $all, 'current' => $current];
    }

    function stockByWarehouseAndProductId(Request $request)
    {
        $this->validate($request, [
            'warehouse_id' => 'nullable|integer',
            'product_id' => 'required|integer',
        ]);
        return $this->_getStockQtyByProductID($request->product_id, $request->warehouse_id);
    }

    function transferProduct(Request $request)
    {
        $transfer_from_warehouse_id = $request->transfer_from;
        $product_id = $request->product_id;
        $this->validate($request, [
            "product_id" => "required|integer",
            "qty" => ['required', 'integer', new IsCapableToTransferStock($transfer_from_warehouse_id, $product_id)],
            "transferred_at" => "required|date",
            "transfer_from" => "required|integer",
            "transfer_to" => "required|integer",
            "notes" => "nullable",
        ]);

        try {
            DB::beginTransaction();
            $transfer = Transfer::create([
                'from_warehouse_id' => $request->transfer_from,
                'to_warehouse_id' => $request->transfer_to,
                'qty' => $request->qty,
                'notes' => $request->notes ?? 'transfer',
            ]);

            $adjust = Adjust::insert([
                [
                    'is_transfer' => true,
                    'transfer_id' => $transfer->id,
                    'type' => 'decrease',
                    'product_id' => $request->product_id,
                    'qty' => $request->qty - ($request->qty * 2),
                    'adjusted_at' => $request->transferred_at,
                    'notes' => $request->notes ?? '',
                    'warehouse_id' => $request->transfer_from,
                ],
                [
                    'is_transfer' => true,
                    'transfer_id' => $transfer->id,
                    'type' => 'increase',
                    'product_id' => $request->product_id,
                    'qty' => $request->qty,
                    'adjusted_at' => $request->transferred_at,
                    'notes' => $request->notes ?? '',
                    'warehouse_id' => $request->transfer_to,
                ]
            ]);
            DB::commit();
            return $adjust;
        } catch (QueryException $exception) {
            return $exception;
        }

    }
}
