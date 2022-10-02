<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Returnproduct extends Model
{
    use SoftDeletes;

    protected $dates = ['returned_at'];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function product(){
        return $this->belongsToMany('App\Product')->withPivot('price','qty','user_id','returned_at','warehouse_id')->withTimestamps();
    }
}
