<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Damage extends Model
{
    use SoftDeletes;

    protected $dates = ['damaged_at'];
    public function product(){
        return $this->belongsToMany('App\Product')->withPivot('qty','damaged_at','warehouse_id')->withTimestamps();
    }

}
