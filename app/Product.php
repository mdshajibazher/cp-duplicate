<?php

namespace App;

use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['mfg','exp'];
    protected $fillable = ['product_name', 'price', 'description', 'image'];

    public function stock($id){
        $sell =  DB::table('product_sale')->where('product_id', '=', $id)->sum('qty');
        $free =  DB::table('product_sale')->where('product_id', '=', $id)->sum('free');
        $purchase = DB::table('product_purchase')->where('product_id', '=', $id)->sum('qty');
        $order = DB::table('order_product')->where('product_id', '=', $id)->sum('qty');
        $return = DB::table('product_returnproduct')->where('product_id', '=', $id)->sum('qty');
        $stock = ($purchase+$return) -  ($order+$sell+$free);
        return $stock;
    }



    public function size(){
        return $this->belongsTo('App\Size');
    }

    public function brand(){
        return $this->belongsTo('App\Brand');
    }

}
