<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    protected $table = 'permissions';


    public function Module(){
        return $this->belongsTo(Module::class,'module_id','id');
    }
}
