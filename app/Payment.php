<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    

    protected $dates = ['payments_at'];
    
    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }

}
