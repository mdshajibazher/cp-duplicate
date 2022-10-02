<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $dates = ['purchased_at'];

    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }

    public function product(){
        return $this->belongsToMany('App\Product')->withPivot('price','sales_price','qty','supplier_id','cost','purchased_at','warehouse_id')->withTimestamps();
    }
}
