<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prevdue extends Model
{
    protected $dates = ['due_at'];
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function admin(){
        return $this->belongsTo('App\Admin');
    }

}
