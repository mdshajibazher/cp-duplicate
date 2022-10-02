<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    
    protected $dates = ['ordered_at','paymented_at','shipped_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function product(){
        return $this->belongsToMany('App\Product')->withPivot('price','qty','user_id','ordered_at')->withTimestamps();
    }

    public function division(){
        return $this->belongsTo('App\Division');
    }

    public function district(){
        return $this->belongsTo('App\District');
    }
    public function area(){
        return $this->belongsTo('App\Area');
    }
    public function paymentmethod(){
        return $this->belongsTo('App\Paymentmethod');
    }
}
