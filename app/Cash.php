<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $dates = ['received_at'];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function paymentmethod(){
        return $this->belongsTo('App\Paymentmethod');
    }
}
