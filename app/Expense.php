<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;
    protected $dates = ['expense_date'];
    public function admin(){
        return $this->belongsTo('App\Admin');
    }
    public function expensecategory(){
        return $this->belongsTo('App\Expensecategory');
    }
}
