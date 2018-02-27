<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
   protected $fillable=['product_id','color','price','discount','is_deleted','created_by','updated_by'];

    public function product(){
      return $this->belongsTo('App\Product');
    }

    public function productImages()
    {
      return $this->hasMany('App\ProductImage');
    }

    public function user()
    {
      return $this->belongsTo('App\User','created_by');
    }
   protected $table='tbl_product_color';
}
