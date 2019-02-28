<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ['name','description','image','created_by','updated_by','is_deleted'];

    public function product()
    {
      return $this->hasMany('App\Product');
    }

    public function user()
    {
      return $this->belongsTo('App\User','created_by');
    }
    protected $table="tbl_product_category";

}
