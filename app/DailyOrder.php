<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyOrder extends Model
{
    protected $fillable = ['date','user_id','references','discount','shipping','amount','admin_id'];
    protected $dates = ['date'];
    //Relationship
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function product(){
        return $this->belongsToMany('App\Product')->withPivot('user_id','qty','price','date','admin_id');
    }
    public function admin(){
        return $this->belongsTo('App\Admin');
    }

}
