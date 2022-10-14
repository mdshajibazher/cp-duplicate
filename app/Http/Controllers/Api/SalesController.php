<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $orderBy = $request->order_by ?? 'sales_at';
        $orderByDir = $request->order_by_dir ?? 'DESC';
        return Sale::with('user')->withTrashed()->orderBy($orderBy,$orderByDir)->paginate($per_page);
    }
}
