<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable=['product_color_id','image','created_by','updated_by','is_deleted'];

    public function productColor()
    {
       return $this->belongsTo('App\ProductColor');
    }

    public function user()
    {
      return $this->belongsTo('App\User','created_by');
    }
    protected $table='tbl_product_image';
}
