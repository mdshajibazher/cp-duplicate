<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjust extends Model
{
    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function transfer(){
        return $this->belongsTo('App\Transfer');
    }
}
