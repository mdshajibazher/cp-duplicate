<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['cat_name', 'cat_image'];

    public function product(){

        return $this->hasMany(Product::class,'category_id');
    }

}
