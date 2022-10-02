<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplierdue extends Model
{
    protected $dates = ['due_at'];
    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }
}
