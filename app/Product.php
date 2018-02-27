<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id','name','release_date','created_by','updated_by','is_deleted'];

    public function productCategory()
    {
      return $this->belongsTo('App\ProductCategory','category_id');
    }

    public function productColor()
    {
        return $this->hasMany('App\ProductColor');
    }

    public function user()
    {
      return $this->belongsTo('App\User','created_by');
    }
    protected $table="tbl_product";
}
