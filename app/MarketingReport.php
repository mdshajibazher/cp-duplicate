<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingReport extends Model
{
    use SoftDeletes;
    protected $dates = ['at'];

    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
