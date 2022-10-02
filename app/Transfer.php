<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $guarded = ['id'];

    public function FromWarehouse(){
        return $this->belongsTo(Warehouse::class,'from_warehouse_id','id');
    }

    public function ToWarehouse(){
        return $this->belongsTo(Warehouse::class,'to_warehouse_id','id');
    }
}
