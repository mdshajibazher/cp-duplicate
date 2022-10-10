<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
       return Sale::with('user')->withTrashed()->orderBy('sales_at','DESC')->paginate(10);
    }
}
